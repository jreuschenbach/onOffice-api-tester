<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Config;
use jr\ooapi\ApiRequest;
use jr\ooapi\ApiResponse;
use jr\ooapi\dataObjects\RequestValues;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\dataObjects\Action;

class ApiRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $config = new Config('config/ooapi.ini');
        $apiRequest = new ApiRequest($config->getApiUrl());
        $credentials = new Credentials('token', 'secret');
        $resource = new Resource(1, 'address');
        $action = new Action('read');
        $requestValues = new RequestValues($credentials, $resource, $action, [], 0);

        $apiResponse = $apiRequest->send($requestValues);
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
        $this->assertEquals(400, $apiResponse->getCode());
    }
}
