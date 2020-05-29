<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\EncrypterOpenSSL;

class EncrypterOpenSSLTest extends TestCase
{
    const PASSWORD = 'test-password';

    public function testInstance(): void
    {
        $this->assertInstanceOf(EncrypterOpenSSL::class, new EncrypterOpenSSL(self::PASSWORD));
    }

    public function testEncrypt(): void
    {
        $pEncrypter = new EncrypterOpenSSL(self::PASSWORD);
        $encrypted = $pEncrypter->encrypt('test string');
        $this->assertNotEquals('test string', $encrypted);
    }

    public function testDecrypt(): void
    {
        $pEncrypter = new EncrypterOpenSSL(self::PASSWORD);
        $encryptedString = $pEncrypter->encrypt('test string');
        $this->assertEquals('test string', $pEncrypter->decrypt($encryptedString));
    }

    /**
     * test if two encrypt-calls with the same value and password create different encrypted strings
     */

    public function testIv(): void
    {
        $pEncrypter = new EncrypterOpenSSL(self::PASSWORD);
        $encryptedFirstCall = $pEncrypter->encrypt('test');
        $encryptedSecondCall = $pEncrypter->encrypt('test');
        $this->assertNotEquals($encryptedFirstCall, $encryptedSecondCall);

        $encryptElementsFirstCall = explode(':', $encryptedFirstCall);
        $encryptElementsSecondCall = explode(':', $encryptedSecondCall);
        $this->assertNotEquals($encryptElementsFirstCall[0], $encryptElementsSecondCall[0]);
    }

    public function testEmptyPassword(): void
    {
        $this->expectException('jr\ooapi\EmptyPasswordException');
        new EncrypterOpenSSL('');
    }
}
