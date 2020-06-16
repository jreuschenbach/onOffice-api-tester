<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\OnOfficeApiTester;
use jr\ooapi\api\ApiResponse;
use jr\ooapi\CredentialStorage;
use jr\ooapi\api\ApiRequest;

/**
 * Class OnOfficeApiTesterTest
 *
 * @covers \jr\ooapi\OnOfficeApiTester
 * @uses \jr\ooapi\Config
 *
 */

class OnOfficeApiTesterTest extends TestCase
{
    const JSON = '{"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","resourceid":"resource-id","resourcetype":"estate","identifier":"","timestamp":1589567897,"hmac":"88462bce11c5c47fb738dba64a36ba00","parameters":{"data":["Id", "kaufpreis", "lage"]}}';
    const PASSWORD = 'test';

    public function testSend()
    {
        $credentialStorage = $this->createMock(CredentialStorage::class);
        $apiRequest = $this->createMock(ApiRequest::class);

        $tester = new OnOfficeApiTester($credentialStorage, $apiRequest);
        $apiResponse = $tester->send(self::JSON, self::PASSWORD);
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
    }
}
