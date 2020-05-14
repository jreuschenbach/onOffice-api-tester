<?php

namespace jr\ooapi;
use Symfony\Component\HttpClient\NativeHttpClient;
use jr\ooapi\dataObjects\RequestValues;

class ApiRequest
{
    /** @var Config */
    private $config = null;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function send(RequestValues $requestValues): ApiResponse
    {
        $httpClient = new NativeHttpClient();
        $apiRequestJson = new ApiRequestJson();
        $hmac = new Hmac();
        $json = $apiRequestJson->build($requestValues, $hmac->create($requestValues));
        $options['body'] = $json;
        $response = $httpClient->request('POST', $this->config->getApiUrl());

        return new ApiResponse($response->getContent());
    }
}