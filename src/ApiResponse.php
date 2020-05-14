<?php

namespace jr\ooapi;

class ApiResponse
{
    /** @var object */
    private $response = null;

    public function __construct($response)
    {
        $this->response = json_decode($response);
    }

    public function getCode()
    {
        return $this->response->status->code;
    }

    public function getErrorCode()
    {
        return $this->response->status->errorcode;
    }

    public function getMessage()
    {
        return $this->response->status->message;
    }

    public function getResults()
    {
        return $this->response->response->results;
    }
}