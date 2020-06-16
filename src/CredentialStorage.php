<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\Encrypter;

/**
 * Class CredentialStorage
 *
 * Store api-credentials in a file / encrypted, if encryption is enabled
 *
 * @package jr\ooapi
 */

class CredentialStorage
{
    const INDEX_TOKEN = 0;
    const INDEX_SECRET = 1;
    const SEPARATOR = ':';

    /** @var Encrypter */
    private $encrypter = null;


    public function save($baseDir, Credentials $credentials): void
    {
        $content = $credentials->getToken().self::SEPARATOR.$credentials->getSecret();
        $this->writeFile($baseDir, $content);
    }

    public function load($baseDir): Credentials
    {
        $credentialString = $this->loadFile($baseDir);
        $fileElements = explode(self::SEPARATOR, $credentialString);

        return new Credentials($fileElements[self::INDEX_TOKEN], $fileElements[self::INDEX_SECRET]);
    }

    public function delete($baseDir): void
    {
        if ($this->isSomethingStored($baseDir))
        {
            unlink($this->pathCredentialFile($baseDir));
        }
    }

    public function isSomethingStored($baseDir): bool
    {
        return file_exists($this->pathCredentialFile($baseDir));
    }

    public function activateEncryption(Encrypter $encrypter): void
    {
        $this->encrypter = $encrypter;
    }

    private function writeFile($baseDir, $credentialString): void
    {
        $fileContent = $credentialString;

        if ($this->isEncryptionEnabled())
        {
            $fileContent = $this->encrypter->encrypt($fileContent);
        }

        file_put_contents($this->pathCredentialFile($baseDir), $fileContent);
    }

    private function loadFile($baseDir): string
    {
        if (!file_exists($this->pathCredentialFile($baseDir)))
        {
            throw new MissingCredentialFileException('missing file');
        }

        $fileContent = file_get_contents($this->pathCredentialFile($baseDir));

        if ($this->isEncryptionEnabled())
        {
            $fileContent = $this->encrypter->decrypt($fileContent);

            if ($fileContent === '')
            {
                throw new DecryptCredentialsException();
            }
        }

        return $fileContent;
    }

    private function isEncryptionEnabled(): bool
    {
        return $this->encrypter instanceof Encrypter;
    }

    private function pathCredentialFile($baseDir)
    {
        return $baseDir.'/ooapi_credentials';
    }
}