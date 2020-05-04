<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\Config;

class ConfigTest extends TestCase
{
    public function testInstance(): void
    {
        $this->assertInstanceOf(Config::class, new Config('config/ooapi.ini'));
    }

    public function testGetApiUrl(): void
    {
        $pConfig = new Config('config/ooapi.ini');
        $this->assertEquals('https://api.onoffice.de/api/latest/api.php', $pConfig->getApiUrl());
    }
}
