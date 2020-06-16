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
        $config = new Config();

        $credentialStorage = new CredentialStorage();
        $credentialStorage->activateEncryption(new EncrypterOpenSSL($password));
        $credentials = $credentialStorage->load($config->getCredentialDir());

        $dataFactory = new DataFactory();
        $request = $dataFactory->createRequestFromString($jsonString);
        $requestValues = new RequestValues($credentials, $request, time());

        $apiRequest = new ApiRequest();
        return $apiRequest->send($config->getApiUrl(), $requestValues);
    }
}