<?php

namespace jr\ooapi;

/**
 * Class Config
 *
 * config
 * * api-url
 * * credential-directory
 *
 * @see config/ooapi.ini
 * @package jr\ooapi
 */

class Config
{
    private $config = [];

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__.'/../config/ooapi.ini');
    }

    public function getApiUrl(): string
    {
        return $this->config['url'];
    }
}