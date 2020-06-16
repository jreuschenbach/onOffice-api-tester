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

    /** @var int */
    private $timestamp = 0;

    /** @var Request */
    private $request = null;

    public function __construct(Credentials $credentials, Request $request, int $timestamp)
    {
        $this->timestamp = $timestamp;
        $this->credentials = $credentials;
        $this->request = $request;
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
        return $this->request->getParameters();
    }

    public function getAction(): Action
    {
        return $this->request->getAction();
    }

    public function getResource(): Resource
    {
        return $this->request->getResource();
    }
}