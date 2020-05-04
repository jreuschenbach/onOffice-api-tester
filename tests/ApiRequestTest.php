<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Config;
use jr\ooapi\ApiRequest;

class ApiRequestTest extends TestCase
{
    public function testInstance(): void
    {
        $config = new Config('config/ooapi.ini');
        $this->assertInstanceOf(ApiRequest::class, new ApiRequest($config));
    }

    public function testRequest(): void
    {
        $apiDefaultAnswer = '{"status":{"code":500,"errorcode":"Syntax error","message":"Unknown error occured"},"response":{"results":[]}}';
        $config = new Config('config/ooapi.ini');
        $apiRequest = new ApiRequest($config);
        $this->assertEquals($apiDefaultAnswer, $apiRequest->send());
    }
}
