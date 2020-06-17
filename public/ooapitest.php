<?php

namespace jr\ooapi;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\api\JsonParseException;

include(__DIR__.'/../vendor/autoload.php');

$jsonString = array_key_exists('request', $_POST) ? $_POST['request'] : null;
$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;
$response = null;

try
{
    if ($password === null)
    {
        throw new \Exception('missing password');
    }

    $config = new Config();
    $credentialStorage = new CredentialStorage();
    $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
    $credentials = $credentialStorage->load($config->getCredentialDir());

    $apiTester = new OnOfficeApiTester(new ApiRequest());
    $apiResponse = $apiTester->send($jsonString, $credentials);

    $message = 'answer from onOffice API:'.PHP_EOL
        .'Status-Code: '.$apiResponse->getCode().PHP_EOL
        .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
        .'Message: '.$apiResponse->getMessage().PHP_EOL;

    $response = $apiResponse->getResults();
}
catch (MissingCredentialFileException $exception)
{
    $message = 'missing credential-file / enter api-token, api-secret and a password for encryption';
}
catch (JsonParseException $exception)
{
    $message = 'json-parse-error / please make sure the given json-string is correct';
}
catch (DecryptCredentialsException $exception)
{
    $message = 'error while reading stored credentials / maybe wrong password to decrypt';
}
catch (EmptyPasswordException $exception)
{
    $message = 'please enter a password';
}
catch (\Exception $exception)
{
    $message = $exception->getMessage();
}

echo json_encode([
    'message' => $message,
    'response' => $response[0],
]);

