<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\dataObjects\Credentials;

/**
 * @covers \jr\ooapi\dataObjects\Credentials
 */

class CredentialsTest extends TestCase
{
    public function testCredentials(): void
    {
        $credentials = new Credentials('testToken', 'testSecret');

        $this->assertEquals('testToken', $credentials->getToken());
        $this->assertEquals('testSecret', $credentials->getSecret());
    }
}
