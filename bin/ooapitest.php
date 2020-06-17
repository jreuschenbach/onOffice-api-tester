#!/usr/bin/php
<?php

namespace jr\ooapi;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\dataObjects\Credentials;
use jr\ooapi\api\JsonParseException;
use jr\ooapi\cli\CliArguments;

include(__DIR__.'/../vendor/autoload.php');

$jsonString = null;

$cliArguments = new CliArguments();
$jsonFile = $cliArguments->getByFlag('-f', $argv);
$token = $cliArguments->getByFlag('-t', $argv);
$secret = $cliArguments->getByFlag('-s', $argv);

if ($jsonFile !== null)
{
    $jsonString = file_get_contents($jsonFile);
}
else
{
    $jsonString = $cliArguments->getByFlag('-j', $argv);
}

if ($jsonString === null || $token === null || $secret === null)
{
    echo '# missing source, token or secret / usage:'.PHP_EOL
        .'# php ooapitest.php -f file (file must exist!) -t token -s secret'.PHP_EOL
        .'# php ooapitest.php -j json-string -t token -s secret'.PHP_EOL
        .'# see Readme.md for details'.PHP_EOL.PHP_EOL;
    die();
}

try
{
    $credentials = new Credentials($token, $secret);
    $apiTester = new OnOfficeApiTester(new ApiRequest());
    $apiResponse = $apiTester->send($jsonString, $credentials);

    echo 'answer from onOffice API:'.PHP_EOL
        .'Status-Code: '.$apiResponse->getCode().PHP_EOL
        .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
        .'Message: '.$apiResponse->getMessage().PHP_EOL
        .'Results: '.json_encode($apiResponse->getResults()).PHP_EOL.PHP_EOL;
}
catch (JsonParseException $exception)
{
    echo 'json-parse-error / please make sure the given json-string is correct'.PHP_EOL
        .'see Readme.md for details'.PHP_EOL;
}

