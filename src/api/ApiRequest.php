<?php

namespace jr\ooapi\api;
use Symfony\Component\HttpClient\NativeHttpClient;
use jr\ooapi\dataObjects\RequestWithAuthInfos;

/**
 * Class ApiRequest
 *
 * send requests to onOffice-API
 *
 * @package jr\ooapi
 */

class ApiRequest
{
    public function send(string $apiUrl, RequestWithAuthInfos $requestValues): ApiResponse
    {
        $httpClient = new NativeHttpClient();
        $apiRequestJson = new ApiRequestJson();
        $hmac = new Hmac();
        $json = $apiRequestJson->build($requestValues, $hmac->create($requestValues));
        $options['body'] = $json;
        $response = $httpClient->request('POST', $apiUrl, $options);
        return new ApiResponse($response->getContent());
    }
}