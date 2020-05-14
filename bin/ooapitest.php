<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Resource;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\RequestValues;

include(__DIR__.'/../vendor/autoload.php');

$passwordReader = new PasswordReader();
$password = $passwordReader->read('Password (to reload stored credentials)');

$config = new Config(__DIR__.'/../config/ooapi.ini');

$credentialStorage = new CredentialStorage($config->getCredentialDir());
$credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
$credentials = $credentialStorage->load();

$resource = new Resource('', 'estate');
$action = new Action('urn:onoffice-de-ns:smart:2.5:smartml:action:read');
$requestValues = new RequestValues($credentials, $resource, $action, [], time());

$apiRequest = new ApiRequest($config);
$apiResponse = $apiRequest->send($requestValues);

echo 'answer from onOffice API:'.PHP_EOL
    .'Status-Code: '.$apiResponse->getCode().PHP_EOL
    .'Error-Code: '.$apiResponse->getErrorCode().PHP_EOL
    .'Message: '.$apiResponse->getMessage().PHP_EOL
    .'Results: '.json_encode($apiResponse->getResults()).PHP_EOL.PHP_EOL;