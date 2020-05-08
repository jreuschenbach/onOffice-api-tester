<?php

namespace jr\ooapi\dataObjects;

class Credentials
{
    public $token = '';
    public $secret = '';

    public function __construct($token, $secret)
    {
        $this->token = $token;
        $this->secret = $secret;
    }
}