<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\api\Hmac;
use jr\ooapi\dataObjects\RequestWithAuthInfos;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\Request;

/**
 * @covers \jr\ooapi\api\Hmac
 * @uses \jr\ooapi\dataObjects\Resource
 * @uses \jr\ooapi\dataObjects\Action
 * @uses \jr\ooapi\dataObjects\Credentials
 * @uses \jr\ooapi\dataObjects\RequestWithAuthInfos
 * @uses \jr\ooapi\dataObjects\Request
 */

class HmacTest extends TestCase
{
    public function testCreate(): void
    {
        $credentials = new Credentials('token', 'secret');
        $resource = new Resource('1', 'type');
        $action = new Action('action', 'identifier');
        $parameters = ['paramKey' => 'paramValue'];
        $request = new Request($action, $resource, $parameters);
        $requestValues = new RequestWithAuthInfos($credentials, $request, 100);
        $hmac = new Hmac();

        $this->assertEquals('7e0bb4b6ceb4b3cff609524e416f2ac3', $hmac->create($requestValues));
    }
}
