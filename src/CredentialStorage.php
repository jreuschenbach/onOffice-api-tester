<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\interfaces\Encrypter;
use jr\ooapi\MissingCredentialFileException;

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

        file_put_contents($this->baseDir.'/ooapi_credentials', $fileContent);
    }

    private function loadFile(): string
    {
        $pathCredentialFile = $this->baseDir.'/ooapi_credentials';

        if (!file_exists($pathCredentialFile))
        {
            throw new MissingCredentialFileException('missing file');
        }

        $fileContent = file_get_contents($pathCredentialFile);

        if ($this->isEncryptionEnabled())
        {
            $fileContent = $this->encrypter->decrypt($fileContent);
        }

        return $fileContent;
    }

    private function isEncryptionEnabled(): bool
    {
        return $this->encrypter instanceof Encrypter;
    }
}