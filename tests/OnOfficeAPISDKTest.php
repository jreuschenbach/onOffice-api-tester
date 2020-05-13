<?php

use PHPUnit\Framework\TestCase;
use onOffice\SDK\onOfficeSDK;

class OnOfficeAPISDKTest extends TestCase
{
    public function testIfIsPresent()
    {
        $this->assertInstanceOf(onOfficeSDK::class, new onOfficeSDK());
    }
}
