<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Config;
use jr\ooapi\ApiRequest;
use jr\ooapi\ApiResponse;

class ApiRequestTest extends TestCase
{
    public function testInstance(): void
    {
        $config = new Config('config/ooapi.ini');
        $this->assertInstanceOf(ApiRequest::class, new ApiRequest($config));
    }

    public function testRequest(): void
    {
        $config = new Config('config/ooapi.ini');
        $apiRequest = new ApiRequest($config);
        $apiResponse = $apiRequest->send();
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
        $this->assertEquals(500, $apiResponse->getCode());
    }
}
