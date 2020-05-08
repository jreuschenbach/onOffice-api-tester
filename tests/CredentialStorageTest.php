<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\CredentialStorage;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\Config;

class CredentialStorageTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(CredentialStorage::class, new CredentialStorage(''));
    }

    public function testSave()
    {
        $config = new Config('config/ooapi.ini');
        $baseDir = $config->getCredentialDir();
        $credentials = $this->createCredentials();
        $storage = new CredentialStorage($baseDir);
        $storage->save($credentials);

        $this->assertFileExists($baseDir.'/ooapi_credentials');
        $this->assertEquals('testToken:testSecret', file_get_contents($baseDir.'/ooapi_credentials'));
    }

    public function testLoad()
    {
        $config = new Config('config/ooapi.ini');
        $baseDir = $config->getCredentialDir();
        $credentials = $this->createCredentials();
        $storage = new CredentialStorage($baseDir);
        $storage->save($credentials);
        $credentials = $storage->load();

        $this->assertEquals('testToken', $credentials->token);
        $this->assertEquals('testSecret', $credentials->secret);
    }

    private function createCredentials()
    {
        return new Credentials('testToken', 'testSecret');
    }
}
