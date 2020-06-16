#!/usr/bin/php
<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\cli\PasswordReader;

include(__DIR__.'/../vendor/autoload.php');

$passwordReader = new PasswordReader();

$token = $passwordReader->read('Token: ');
$secret = $passwordReader->read('Secret: ');
$password = $passwordReader->read('Password (needed to reload credentials): ');

try
{
    $credentials = new Credentials($token, $secret);
    $config = new Config();
    $credentialStorage = new CredentialStorage($config->getCredentialDir());
    $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
    $credentialStorage->save($credentials);

    echo 'credentials stored encrypted...'.PHP_EOL;
}
catch (EmptyPasswordException $exception)
{
    echo 'password must not be empty'.PHP_EOL;
}
