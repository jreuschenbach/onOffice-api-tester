<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestValues;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\api\ApiResponse;

/**
 * Class OnOfficeApiTester
 *
 * main-class / "business logic"
 *
 * @package jr\ooapi
 */

class OnOfficeApiTester
{
    public function send($jsonString, $password): ApiResponse
    {
        $config = new Config(__DIR__.'/../config/ooapi.ini');

        $credentialStorage = new CredentialStorage($config->getCredentialDir());
        $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
        $credentials = $credentialStorage->load();

        $dataFactory = new DataFactory();
        $request = $dataFactory->createRequestFromString($jsonString);
        $requestValues = new RequestValues($credentials, $request, time());

        $apiRequest = new ApiRequest();
        return $apiRequest->send($config->getApiUrl(), $requestValues);
    }
}