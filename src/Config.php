<?php

namespace jr\ooapi;

class Config
{
    private $_config = [];

    public function __construct($iniFile)
    {
        $this->_config = parse_ini_file($iniFile);
    }

    public function getApiUrl(): string
    {
        return $this->_config['url'];
    }

    public function getCredentialDir(): string
    {
        return $this->_config['credential_dir'];
    }
}