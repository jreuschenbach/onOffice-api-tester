<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Credentials;

include(__DIR__.'/../vendor/autoload.php');

$token = array_key_exists('token', $_POST) ? $_POST['token'] : null;
$secret = array_key_exists('secret', $_POST) ? $_POST['secret'] : null;
$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;

$message = null;

try
{
    if (is_string($token) && is_string($secret) && is_string($password))
    {
        $credentials = new Credentials($token, $secret);
        $config = new Config();
        $credentialStorage = new CredentialStorage();
        $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
        $credentialStorage->save($config->getCredentialDir(), $credentials);

        $message = 'api-credentials stored encrypted...';
    }
    else
    {
        $message = 'please enter token and secret';
    }
}
catch (EmptyPasswordException $exception)
{
    $message = 'password must not be empty';
}

echo json_encode(['message' => $message]);

