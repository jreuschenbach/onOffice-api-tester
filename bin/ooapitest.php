#!/usr/bin/php
<?php

namespace jr\ooapi;
use jr\ooapi\cli\PasswordReader;

include(__DIR__.'/../vendor/autoload.php');

$jsonString = null;

if (count($argv) == 3)
{
    $flag = $argv[1];
    $source = $argv[2];

    if ($flag == '-f' && file_exists($source))
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
        .'# php ooapitest.php -f file (file must exist!)'.PHP_EOL
        .'# php ooapitest.php -s json-strong'.PHP_EOL
        .'# see Readme.md for details'.PHP_EOL.PHP_EOL;
    die();
}

try
{
    $passwordReader = new PasswordReader();
    $password = $passwordReader->read('Password (to reload stored credentials)');

    $apiTester = new OnOfficeApiTester();
    $apiResponse = $apiTester->send($jsonString, $password);

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
catch (DecryptCredentialsException $exception)
{
    echo 'error while reading stored credentials / maybe wrong password to decrypt'.PHP_EOL;
}
catch (JsonParseException $exception)
{
    echo 'json-parse-error / please make sure the given json-string is correct'.PHP_EOL
        .'see Readme.md for details'.PHP_EOL;
}

