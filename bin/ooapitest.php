#!/usr/bin/php
<?php

namespace jr\ooapi;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\cli\PasswordReader;
use jr\ooapi\api\JsonParseException;
use jr\ooapi\cli\CliArguments;

include(__DIR__.'/../vendor/autoload.php');

$jsonString = null;

$cliArguments = new CliArguments();
$jsonFile = $cliArguments->getByFlag('-f');

if ($jsonFile !== null)
{
    $jsonString = file_get_contents($jsonFile);
}
else
{
    $jsonString = $cliArguments->getByFlag('-j');
}

if ($jsonString === null)
{
    echo '# missing source / usage:'.PHP_EOL
        .'# php ooapitest.php -f file (file must exist!)'.PHP_EOL
        .'# php ooapitest.php -s json-string'.PHP_EOL
        .'# see Readme.md for details'.PHP_EOL.PHP_EOL;
    die();
}

try
{
    $passwordReader = new PasswordReader();
    $password = $passwordReader->read('Password (to reload stored credentials)');

    $config = new Config();

    $credentialStorage = new CredentialStorage();
    $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
    $credentials = $credentialStorage->load($config->getCredentialDir());

    $apiTester = new OnOfficeApiTester($credentials, new ApiRequest());
    $apiResponse = $apiTester->send($jsonString, $credentials);

    echo 'answer from onOffice API:'.PHP_EOL
        .'Status-Code: '.$apiResponse->getCode().PHP_EOL
        .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
        .'Message: '.$apiResponse->getMessage().PHP_EOL
        .'Results: '.json_encode($apiResponse->getResults()).PHP_EOL.PHP_EOL;
}
catch (DecryptCredentialsException $exception)
{
    echo 'error while reading stored credentials / maybe wrong password to decrypt'.PHP_EOL;
}
catch (JsonParseException $exception)
{
    echo 'json-parse-error / please make sure the given json-string is correct'.PHP_EOL
        .'see Readme.md for details'.PHP_EOL;
}

