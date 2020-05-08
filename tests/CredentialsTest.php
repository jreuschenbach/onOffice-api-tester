<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\dataObjects\Credentials;

class CredentialsTest extends TestCase
{
    public function testCredentials()
    {
        $credentials = new Credentials('testToken', 'testSecret');

        $this->assertTrue(property_exists($credentials, 'token'));
        $this->assertTrue(property_exists($credentials, 'secret'));

        $this->assertEquals('testToken', $credentials->token);
        $this->assertEquals('testSecret', $credentials->secret);
    }
}
