<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;

include(__DIR__.'/../vendor/autoload.php');

$passwordReader = new PasswordReader();

$token = $passwordReader->read(('Token: ');
$secret = $passwordReader->read('Secret: ');
$password = $passwordReader->read('Password (needed to reload credentials): ');

$credentials = new Credentials($token, $secret);
$config = new Config(__DIR__.'/../config/ooapi.ini');
$credentialStorage = new CredentialStorage($config->getCredentialDir());
$credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
$credentialStorage->save($credentials);