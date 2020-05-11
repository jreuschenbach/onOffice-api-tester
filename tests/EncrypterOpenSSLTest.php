<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\EncrypterOpenSSL;

class EncrypterOpenSSLTest extends TestCase
{
    const PASSWORD = 'test-password';

    public function testInstance()
    {
        $this->assertInstanceOf(EncrypterOpenSSL::class, new EncrypterOpenSSL(self::PASSWORD));
    }

    public function testEncrypt()
    {
        $pEncrypter = new EncrypterOpenSSL(self::PASSWORD);
        $encrypted = $pEncrypter->encrypt('test string');
        $this->assertNotEquals('test string', $encrypted);
    }

    public function testDecrypt()
    {
        $pEncrypter = new EncrypterOpenSSL(self::PASSWORD);
        $encryptedString = $pEncrypter->encrypt('test string');
        $this->assertEquals('test string', $pEncrypter->decrypt($encryptedString));

    }
}
