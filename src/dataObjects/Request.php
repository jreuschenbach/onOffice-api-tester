<?php

namespace jr\ooapi\dataObjects;

/**
 * Class Request
 *
 * data-object for all request-data
 *
 * @package jr\ooapi\dataObjects
 *
 */

class Request
{
    private $_action = null;
    private $_resource = null;
    private $_parameters = null;

    public function __construct(Action $action, Resource $resource, array $parameters)
    {
        $this->_action = $action;
        $this->_resource = $resource;
        $this->_parameters = $parameters;
    }

    public function getAction(): Action
    {
        return $this->_action;
    }

    public function getResource(): Resource
    {
        return $this->_resource;
    }

    public function getParameters(): array
    {
        return $this->_parameters;
    }
}