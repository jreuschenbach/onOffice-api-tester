<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestWithAuthInfos;
use jr\ooapi\api\ApiRequest;
use jr\ooapi\api\ApiResponse;
use jr\ooapi\dataObjects\Credentials;

/**
 * Class OnOfficeApiTester
 *
 * main-class / "business logic"
 *
 * @package jr\ooapi
 */

class OnOfficeApiTester
{
    private $apiRequest = null;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function send($jsonString, Credentials $credentials): ApiResponse
    {
        $config = new Config();

        $dataFactory = new DataFactory();
        $request = $dataFactory->createRequestFromString($jsonString);
        $requestValues = new RequestWithAuthInfos($credentials, $request, time());

        return $this->apiRequest->send($config->getApiUrl(), $requestValues);
    }
}