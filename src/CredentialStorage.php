<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\interfaces\Encrypter;

class CredentialStorage
{
    const INDEX_TOKEN = 0;
    const INDEX_SECRET = 1;
    const SEPARATOR = ':';

    /** @var string */
    private $_baseDir = '';

    /** @var Encrypter */
    private $_encrypter = null;

    public function __construct($baseDir)
    {
        $this->_baseDir = $baseDir;
    }

    public function save(Credentials $credentials): void
    {
        $content = $credentials->token.self::SEPARATOR.$credentials->secret;
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
        $this->_encrypter = $encrypter;
    }

    private function writeFile($credentialString): void
    {
        $fileContent = $credentialString;

        if ($this->isEncryptionEnabled())
        {
            $fileContent = $this->_encrypter->encrypt($fileContent);
        }

        file_put_contents($this->_baseDir.'/ooapi_credentials', $fileContent);
    }

    private function loadFile(): string
    {
        $fileContent = file_get_contents($this->_baseDir.'/ooapi_credentials');

        if ($this->isEncryptionEnabled())
        {
            $fileContent = $this->_encrypter->decrypt($fileContent);
        }

        return $fileContent;
    }

    private function isEncryptionEnabled(): bool
    {
        return $this->_encrypter instanceof Encrypter;
    }
}