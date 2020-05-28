<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;

include(__DIR__.'/../vendor/autoload.php');

$token = array_key_exists('token', $_POST) ? $_POST['token'] : null;
$secret = array_key_exists('secret', $_POST) ? $_POST['secret'] : null;
$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;

if (is_string($token) && is_string($secret) && is_string($password))
{
    $credentials = new Credentials($token, $secret);
    $config = new Config(__DIR__ . '/../config/ooapi.ini');
    $credentialStorage = new CredentialStorage($config->getCredentialDir());
    $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
    $credentialStorage->save($credentials);

    echo json_encode(['message' => 'api-credentials stored encrypted...']);
}
else
{
    echo json_encode(['message' => $token]);
    //echo json_encode(['message' => 'please enter token, secret and password']);
}

