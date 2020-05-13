<?php

namespace jr\ooapi\dataObjects;

class Credentials
{
    private $token = '';
    private $secret = '';

    public function __construct(string $token, string $secret)
    {
        $this->token = $token;
        $this->secret = $secret;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}