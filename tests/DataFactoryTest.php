<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\DataFactory;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\api\JsonParseException;

/**
 * @covers \jr\ooapi\DataFactory
 * @uses \jr\ooapi\dataObjects\Action
 * @uses \jr\ooapi\dataObjects\Resource
 */

class DataFactoryTest extends TestCase
{
    const JSON = '{"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","resourceid":"resource-id","resourcetype":"estate","identifier":"","timestamp":1589567897,"hmac":"88462bce11c5c47fb738dba64a36ba00","parameters":{"data":["Id", "kaufpreis", "lage"]}}';

    public function testCreateRequestFromString(): void
    {
        $dataFactory = new DataFactory();
        $request = $dataFactory->createRequestFromString(self::JSON);

        $this->checkAction($request->getAction());
        $this->checkResource($request->getResource());
        $this->checkParameters($request->getParameters());
    }

    public function checkAction(Action $action): void
    {
        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals('urn:onoffice-de-ns:smart:2.5:smartml:action:read', $action->getId());
        $this->assertEquals('', $action->getIdentifier());
    }

    public function checkResource(Resource $resource): void
    {
        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals('resource-id', $resource->getId());
        $this->assertEquals('estate', $resource->getType());
    }

    public function checkParameters(array $parameters): void
    {
        $this->assertIsArray($parameters);
        $this->assertCount(1, $parameters);
        $this->assertArrayHasKey('data', $parameters);
        $this->assertCount(3, $parameters['data']);
        $this->assertEquals(['Id', 'kaufpreis', 'lage'], $parameters['data']);
    }

    public function testJsonParseErrorsParameters(): void
    {
        $dataFactory = new DataFactory();
        $this->expectException(JsonParseException::class);
        $dataFactory->createRequestFromString('');
    }
}
