<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\EncrypterOpenSSL;

class EncrypterOpenSSLTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(EncrypterOpenSSL::class, new EncrypterOpenSSL());
    }

    public function testEncrypt()
    {
        $pEncrypter = new EncrypterOpenSSL();
        $encrypted = $pEncrypter->encrypt('test string');
        $this->assertNotEquals('test string', $encrypted);
    }

    public function testDecrypt()
    {
        $pEncrypter = new EncrypterOpenSSL();
        $encryptedString = $pEncrypter->encrypt('test string');
        $this->assertEquals('test string', $pEncrypter->decrypt($encryptedString));

    }
}
