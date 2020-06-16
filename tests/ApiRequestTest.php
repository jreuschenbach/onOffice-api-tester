<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Config;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\api\ApiResponse;
use jr\ooapi\dataObjects\RequestWithAuthInfos;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\Request;

/**
 * @covers \jr\ooapi\api\ApiRequest
 * @uses \jr\ooapi\Config
 * @uses \jr\ooapi\dataObjects\Credentials
 * @uses \jr\ooapi\dataObjects\Action
 * @uses \jr\ooapi\dataObjects\Resource
 * @uses \jr\ooapi\dataObjects\RequestWithAuthInfos
 * @uses \jr\ooapi\Hmac
 * @uses \jr\ooapi\ApiResponse
 * @uses \jr\ooapi\ApiRequestJson
 * @uses \jr\ooapi\dataObjects\Request
 */

class ApiRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $config = new Config('config/ooapi.ini');
        $apiRequest = new ApiRequest();
        $credentials = new Credentials('token', 'secret');
        $resource = new Resource(1, 'address');
        $action = new Action('read');
        $request = new Request($action, $resource, []);
        $requestValues = new RequestWithAuthInfos($credentials, $request, 0);

        $apiResponse = $apiRequest->send($config->getApiUrl(), $requestValues);
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
        $this->assertEquals(400, $apiResponse->getCode());
    }
}
