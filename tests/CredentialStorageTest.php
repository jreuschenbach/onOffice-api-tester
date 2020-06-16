<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\CredentialStorage;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\Config;
use jr\ooapi\EncrypterOpenSSL;

/**
 * @covers \jr\ooapi\CredentialStorage
 * @uses \jr\ooapi\Config
 * @uses \jr\ooapi\EncrypterOpenSSL
 * @uses \jr\ooapi\dataObjects\Credentials
 */

class CredentialStorageTest extends TestCase
{
    const PASSWORD = 'test';

    /** @var string */
    private $testDir = '';

    protected function setUp(): void
    {
        $config = new Config();
        $this->testDir = $config->getCredentialDir().'/test-ooapi-'.rand(0, 1000000000);

        mkdir($this->testDir);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testDir.'/ooapi_credentials'))
        {
            unlink($this->testDir.'/ooapi_credentials');
        }

        rmdir($this->testDir);
    }

    public function testSave(): void
    {
        $credentials = $this->createCredentials();
        $storage = new CredentialStorage();
        $storage->activateEncryption(new EncrypterOpenSSL(self::PASSWORD));
        $storage->save($this->testDir, $credentials);

        $fileContentEncrypted = file_get_contents($this->testDir);

        $this->assertFileExists($this->testDir.'/ooapi_credentials');
        $this->assertStringNotContainsString('testToken', $fileContentEncrypted);
        $this->assertStringNotContainsString('testSecret', $fileContentEncrypted);
    }

    public function testLoad(): void
    {
        $credentials = $this->createCredentials();
        $storage = new CredentialStorage();
        $storage->activateEncryption(new EncrypterOpenSSL(self::PASSWORD));
        $storage->save($this->testDir, $credentials);
        $credentials = $storage->load($this->testDir);

        $this->assertEquals('testToken', $credentials->getToken());
        $this->assertEquals('testSecret', $credentials->getSecret());
    }

    public function testFailedLoading(): void
    {
        $storage = new CredentialStorage();

        $this->expectException('jr\ooapi\MissingCredentialFileException');
        $storage->load($this->testDir);
    }

    public function testWrongPassword(): void
    {
        $credentials = $this->createCredentials();
        $storageWrite = new CredentialStorage();
        $storageWrite->activateEncryption(new EncrypterOpenSSL('password'));
        $storageWrite->save($this->testDir, $credentials);

        $storageRead = new CredentialStorage();
        $storageRead->activateEncryption(new EncrypterOpenSSL('anotherPassword'));
        $this->expectException('jr\ooapi\DecryptCredentialsException');
        $storageRead->load($this->testDir);
    }

    public function testCredentialsStored(): void
    {
        $storage = new CredentialStorage();
        $this->assertFalse($storage->isSomethingStored($this->testDir));
        $storage->save($this->testDir, $this->createCredentials());
        $this->assertTrue($storage->isSomethingStored($this->testDir));
    }

    public function testDeleteCredentials(): void
    {
        $storage = new CredentialStorage();
        $storage->save($this->testDir, $this->createCredentials());
        $this->assertTrue($storage->isSomethingStored($this->testDir));
        $storage->delete($this->testDir);
        $this->assertFalse($storage->isSomethingStored($this->testDir));
    }

    private function createCredentials(): Credentials
    {
        return new Credentials('testToken', 'testSecret');
    }
}
