<?php

namespace jr\ooapi\dataObjects;

class RequestValues
{
    /** @var Credentials */
    private $credentials = null;

    /** @var Resource */
    private $resource = null;

    /** @var int */
    private $timestamp = 0;

    /** @var array */
    private $parameters = [];

    /** @var Action */
    private $action = null;

    public function __construct(Credentials $credentials, Resource $resource, Action $action, array $parameters, int $timestamp)
    {
        $this->resource = $resource;
        $this->action = $action;
        $this->parameters = $parameters;
        $this->timestamp = $timestamp;
        $this->credentials = $credentials;
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }
}