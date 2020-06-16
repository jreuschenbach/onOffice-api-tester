<?php

namespace jr\ooapi\dataObjects;

/**
 * Class RequestValues
 *
 * data-object for api-request-values
 *
 * @package jr\ooapi\dataObjects
 */

class RequestWithAuthInfos
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

    public function __construct(Credentials $credentials, Request $request, int $timestamp)
    {
        $this->resource = $request->getResource();
        $this->action = $request->getAction();
        $this->parameters = $request->getParameters();
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