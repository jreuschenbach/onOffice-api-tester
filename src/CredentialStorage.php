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

    /** @var string */
    private $baseDir = '';

    /** @var Encrypter */
    private $encrypter = null;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function save(Credentials $credentials): void
    {
        $content = $credentials->getToken().self::SEPARATOR.$credentials->getSecret();
        $this->writeFile($content);
    }

    public function load(): Credentials
    {
        $credentialString = $this->loadFile();
        $fileElements = explode(self::SEPARATOR, $credentialString);

        return new Credentials($fileElements[self::INDEX_TOKEN], $fileElements[self::INDEX_SECRET]);
    }

    public function delete(): void
    {
        if ($this->isSomethingStored())
        {
            unlink($this->pathCredentialFile());
        }
    }

    public function isSomethingStored(): bool
    {
        return file_exists($this->pathCredentialFile());
    }

    public function activateEncryption(Encrypter $encrypter): void
    {
        $this->encrypter = $encrypter;
    }

    private function writeFile($credentialString): void
    {
        $fileContent = $credentialString;

        if ($this->isEncryptionEnabled())
        {
            $fileContent = $this->encrypter->encrypt($fileContent);
        }

        file_put_contents($this->pathCredentialFile(), $fileContent);
    }

    private function loadFile(): string
    {
        if (!file_exists($this->pathCredentialFile()))
        {
            throw new MissingCredentialFileException('missing file');
        }

        $fileContent = file_get_contents($this->pathCredentialFile());

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

    private function pathCredentialFile()
    {
        return $this->baseDir.'/ooapi_credentials';
    }
}