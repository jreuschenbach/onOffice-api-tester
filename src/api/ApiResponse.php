<?php

namespace jr\ooapi\api;

/**
 * Class ApiResponse
 *
 * parse api-response (json) and provides access to status-values / results
 *
 * @package jr\ooapi
 */

class ApiResponse
{
    /** @var object */
    private $response = null;

    public function __construct($response)
    {
        $this->response = json_decode($response);
    }

    public function getCode(): string
    {
        return $this->response->status->code;
    }

    public function getErrorCode(): string
    {
        return $this->response->status->errorcode;
    }

    public function getMessage(): string
    {
        return $this->response->status->message;
    }

    public function getResults(): array
    {
        return $this->response->response->results;
    }
}