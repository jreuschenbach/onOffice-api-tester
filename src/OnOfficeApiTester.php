<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestValues;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\api\ApiResponse;

class OnOfficeApiTester
{
    public function send($jsonString, $password): ApiResponse
    {
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
        return $apiRequest->send($requestValues);
    }
}