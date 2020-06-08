<?php

namespace jr\ooapi\api;
use Symfony\Component\HttpClient\NativeHttpClient;
use jr\ooapi\dataObjects\RequestValues;

/**
 * Class ApiRequest
 *
 * send requests to onOffice-API
 *
 * @package jr\ooapi
 */

class ApiRequest
{
    /** @var string */
    private $apiUrl = '';

    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function send(RequestValues $requestValues): ApiResponse
    {
        $httpClient = new NativeHttpClient();
        $apiRequestJson = new ApiRequestJson();
        $hmac = new Hmac();
        $json = $apiRequestJson->build($requestValues, $hmac->create($requestValues));
        $options['body'] = $json;
        $response = $httpClient->request('POST', $this->apiUrl, $options);
        return new ApiResponse($response->getContent());
    }
}