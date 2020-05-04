<?php

namespace jr\ooapi;

class ApiResponse
{
    /** @var object */
    private $_response = null;

    public function __construct($response)
    {
        $this->_response = json_decode($response);
    }

    public function getCode()
    {
        return $this->_response->status->code;
    }

    public function getErrorCode()
    {
        return $this->_response->status->errorcode;
    }

    public function getMessage()
    {
        return $this->_response->status->message;
    }
}