<?php

namespace jr\ooapi;

class Config
{
    private $config = [];

    public function __construct($iniFile)
    {
        $this->config = parse_ini_file($iniFile);
    }

    public function getApiUrl(): string
    {
        return $this->config['url'];
    }

    public function getCredentialDir(): string
    {
        return $this->config['credential_dir'];
    }
}