<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\CredentialStorage;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\Config;
use jr\ooapi\EncrypterOpenSSL;

class CredentialStorageTest extends TestCase
{
    const PASSWORD = 'test';

    /** @var string */
    private $_testDir = '';

    protected function setUp(): void
    {
        $config = new Config('config/ooapi.ini');
        $this->_testDir = $config->getCredentialDir().'/test-ooapi-'.rand(0, 1000000000);

        mkdir($this->_testDir);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->_testDir.'/ooapi_credentials'))
        {
            unlink($this->_testDir.'/ooapi_credentials');
        }

        rmdir($this->_testDir);
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(CredentialStorage::class, new CredentialStorage(''));
    }

    public function testSave(): void
    {
        $credentials = $this->createCredentials();
        $storage = new CredentialStorage($this->_testDir);
        $storage->activateEncryption(new EncrypterOpenSSL(self::PASSWORD));
        $storage->save($credentials);

        $fileContentEncrypted = file_get_contents($this->_testDir);

        $this->assertFileExists($this->_testDir.'/ooapi_credentials');
        $this->assertStringNotContainsString('testToken', $fileContentEncrypted);
        $this->assertStringNotContainsString('testSecret', $fileContentEncrypted);
    }

    public function testLoad(): void
    {
        $credentials = $this->createCredentials();
        $storage = new CredentialStorage($this->_testDir);
        $storage->activateEncryption(new EncrypterOpenSSL(self::PASSWORD));
        $storage->save($credentials);
        $credentials = $storage->load();

        $this->assertEquals('testToken', $credentials->getToken());
        $this->assertEquals('testSecret', $credentials->getSecret());
    }

    private function createCredentials(): Credentials
    {
        return new Credentials('testToken', 'testSecret');
    }
}
