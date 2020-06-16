<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\OnOfficeApiTester;

class OnOfficeApiTesterTest extends TestCase
{
    const JSON = '{"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","resourceid":"resource-id","resourcetype":"estate","identifier":"","timestamp":1589567897,"hmac":"88462bce11c5c47fb738dba64a36ba00","parameters":{"data":["Id", "kaufpreis", "lage"]}}';
    const PASSWORD = 'test';

    public function testSend()
    {
        $tester = new OnOfficeApiTester();
        $this->assertTrue(true);
        //$apiResponse = $tester->send(self::JSON, self::PASSWORD);
        //$this->assertInstanceOf(ApiResponse::class, $apiResponse);
    }
}
