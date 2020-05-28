<?php

namespace jr\ooapi;

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

    $apiTester = new OnOfficeApiTester();
    $apiResponse = $apiTester->send($jsonString, $password);

    $message = 'answer from onOffice API:'.PHP_EOL
        .'Status-Code: '.$apiResponse->getCode().PHP_EOL
        .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
        .'Message: '.$apiResponse->getMessage().PHP_EOL;

    $response = $apiResponse->getResults();
}
catch (MissingCredentialFileException $exception)
{
    $message = 'missing credential-file / call credentials.php first'
        .'see Readme.md for details';
}
catch (JsonParseException $exception)
{
    $message = 'json-parse-error / please make sure the fiven json-string is correct'
        .'see Readme.md for details';
}
catch (DecryptCredentialsException $exception)
{
    $message = 'error while reading stored credentials / maybe wrong password to decrypt';
}
catch (\Exception $exception)
{
    $message = $exception->getMessage();
}

echo json_encode([
    'message' => $message,
    'response' => $response[0],
]);

