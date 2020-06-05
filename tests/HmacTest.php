<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Hmac;
use jr\ooapi\dataObjects\RequestValues;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\dataObjects\Action;

class HmacTest extends TestCase
{
    public function testCreate(): void
    {
        $credentials = new Credentials('token', 'secret');
        $resource = new Resource('1', 'type');
        $action = new Action('action', 'identifier');
        $parameters = ['paramKey' => 'paramValue'];
        $requestValues = new RequestValues($credentials, $resource, $action, $parameters, 100);
        $hmac = new Hmac();

        $this->assertEquals('7e0bb4b6ceb4b3cff609524e416f2ac3', $hmac->create($requestValues));
    }
}
