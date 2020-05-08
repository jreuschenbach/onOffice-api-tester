<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;

class CredentialStorage
{
    const INDEX_TOKEN = 0;
    const INDEX_SECRET = 1;
    const SEPARATOR = ':';

    /** @var string */
    private $_baseDir = '';

    public function __construct($baseDir)
    {
        $this->_baseDir = $baseDir;
    }

    public function save(Credentials $credentials): void
    {
        $content = $credentials->token.self::SEPARATOR.$credentials->secret;
        file_put_contents($this->_baseDir.'/ooapi_credentials', $content);
    }

    public function load(): Credentials
    {
        $content = file_get_contents($this->_baseDir.'/ooapi_credentials');
        $fileElements = explode(self::SEPARATOR, $content);

        return new Credentials($fileElements[self::INDEX_TOKEN], $fileElements[self::INDEX_SECRET]);
    }
}