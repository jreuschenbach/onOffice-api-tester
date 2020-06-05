<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Config;

/**
 * @covers \jr\ooapi\Config
 */

class ConfigTest extends TestCase
{
    public function testGetApiUrl(): void
    {
        $pConfig = new Config('config/ooapi.ini');
        $this->assertIsString($pConfig->getApiUrl());
        $this->assertStringStartsWith('https://api.onoffice.de/api', $pConfig->getApiUrl());
        $this->assertIsString($pConfig->getCredentialDir());
    }
}
