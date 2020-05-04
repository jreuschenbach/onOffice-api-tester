<?php

namespace jr\ooapi;
use Symfony\Component\HttpClient\NativeHttpClient;

class ApiRequest
{
    /** @var Config */
    private $_config = null;

    public function __construct(Config $config)
    {
        $this->_config = $config;
    }

    public function send(): ApiResponse
    {
        $httpClient = new NativeHttpClient();
        $response = $httpClient->request('POST', $this->_config->getApiUrl());
        return new ApiResponse($response->getContent());
    }
}