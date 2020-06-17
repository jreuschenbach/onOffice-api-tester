<?php

namespace jr\ooapi;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\api\JsonParseException;
use jr\ooapi\dataObjects\Credentials;

include(__DIR__.'/../vendor/autoload.php');

$jsonString = array_key_exists('request', $_POST) ? $_POST['request'] : null;
$token = array_key_exists('token', $_POST) ? $_POST['token'] : null;
$secret = array_key_exists('secret', $_POST) ? $_POST['secret'] : null;
$response = null;

try
{
    $credentials = new Credentials($token, $secret);
    $apiTester = new OnOfficeApiTester(new ApiRequest());
    $apiResponse = $apiTester->send($jsonString, $credentials);

    $message = 'answer from onOffice API:'.PHP_EOL
        .'Status-Code: '.$apiResponse->getCode().PHP_EOL
        .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
        .'Message: '.$apiResponse->getMessage().PHP_EOL;

    $response = $apiResponse->getResults();
}
catch (JsonParseException $exception)
{
    $message = 'json-parse-error / please make sure the given json-string is correct';
}
catch (\Exception $exception)
{
    $message = $exception->getMessage();
}

echo json_encode([
    'message' => $message,
    'response' => $response[0],
]);

