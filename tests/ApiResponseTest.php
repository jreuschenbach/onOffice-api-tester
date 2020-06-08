<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\api\ApiResponse;

/**
 * @covers \jr\ooapi\api\ApiResponse
 */

class ApiResponseTest extends TestCase
{
    public function testGetCode(): void
    {
        $apiResponse = $this->createDefaultResponse();
        $this->assertEquals(500, $apiResponse->getCode());
    }

    public function testGetErrorCode(): void
    {
        $apiResponse = $this->createDefaultResponse();
        $this->assertEquals('Syntax error', $apiResponse->getErrorCode());
    }

    public function testGetMessage(): void
    {
        $apiResponse = $this->createDefaultResponse();
        $this->assertEquals('Unknown error occured', $apiResponse->getMessage());
    }

    private function createDefaultResponse(): ApiResponse
    {
        $defaultAnswer = '{"status":{"code":500,"errorcode":"Syntax error","message":"Unknown error occured"},"response":{"results":[]}}';
        return new ApiResponse($defaultAnswer);
    }
}
