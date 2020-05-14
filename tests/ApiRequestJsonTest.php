<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\ApiRequestJson;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\RequestValues;

class ApiRequestJsonTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(ApiRequestJson::class, new ApiRequestJson());
    }

    public function testBuild()
    {
        $credentials = new Credentials('token', 'secret');
        $resource = new Resource(1, 'address');
        $action = new Action('read', 'identifier');
        $parameters = ['paramKey' => 'paramValue'];
        $requestValues = new RequestValues($credentials, $resource, $action, $parameters, 0);
        $hmac = 'hmac-test';

        $requestJson = new ApiRequestJson();
        $json = $requestJson->build($requestValues, $hmac);
        $this->assertIsString($json);
        $this->assertStringContainsString('"token":"token"', $json);
        $this->assertStringContainsString('"request":', $json);
        $this->assertStringContainsString('"actions":', $json);
        $this->assertStringContainsString('"actionId":"read"', $json);
        $this->assertStringContainsString('"resourceId":"1"', $json);
        $this->assertStringContainsString('"resourceType":"address"', $json);
        $this->assertStringContainsString('"identifier":"identifier"', $json);
        $this->assertStringContainsString('"timestamp":0', $json);
        $this->assertStringContainsString('"hmac":"hmac-test', $json);
        $this->assertStringContainsString('"parameters":', $json);
        $this->assertStringContainsString('"paramKey":"paramValue"', $json);
    }
}
