<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestValues;

include(__DIR__.'/../vendor/autoload.php');

$jsonString = null;

if (count($argv) == 3)
{
    $flag = $argv[1];
    $source = $argv[2];

    if ($flag == '-f')
    {
        $jsonString = file_get_contents($source);
    }
    elseif ($flag == '-s')
    {
        $jsonString = $source;
    }
}

if ($jsonString === null)
{
    echo '# missing source / usage:'.PHP_EOL
        .'# php ooapitest.php -f file'.PHP_EOL
        .'# php ooapitest.php -s json-strong'.PHP_EOL
        .'# see Readme.md for details'.PHP_EOL.PHP_EOL;
    die();
}

try
{
    $passwordReader = new PasswordReader();
    $password = $passwordReader->read('Password (to reload stored credentials)');

    $config = new Config(__DIR__.'/../config/ooapi.ini');

    $credentialStorage = new CredentialStorage($config->getCredentialDir());
    $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
    $credentials = $credentialStorage->load();

    $dataFactory = new DataFactory();
    $resource = $dataFactory->createResourceFromString($jsonString);
    $action = $dataFactory->createActionFromString($jsonString);
    $parameters = $dataFactory->createParametersFromString($jsonString);

    $requestValues = new RequestValues($credentials, $resource, $action, $parameters, time());

    $apiRequest = new ApiRequest($config->getApiUrl());
    $apiResponse = $apiRequest->send($requestValues);

    echo 'answer from onOffice API:'.PHP_EOL
        .'Status-Code: '.$apiResponse->getCode().PHP_EOL
        .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
        .'Message: '.$apiResponse->getMessage().PHP_EOL
        .'Results: '.json_encode($apiResponse->getResults()).PHP_EOL.PHP_EOL;
}
catch (MissingCredentialFileException $exception)
{
    echo 'missing credential-file / call credentials.php first'.PHP_EOL
        .'see Readme.md for details'.PHP_EOL;
}
catch (JsonParseException $exception)
{
    echo 'json-parse-error / please make sure the fiven json-string is correct'.PHP_EOL
        .'see Readme.md for details'.PHP_EOL;
}

