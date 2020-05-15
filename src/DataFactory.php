<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\Resource;

class DataFactory
{
    public function createActionFromString($jsonString)
    {
        $json = json_decode($jsonString);

        return new Action($json->actionid);
    }

    public function createResourceFromString($jsonString)
    {
        $json = json_decode($jsonString);

        return new Resource($json->resourceid, $json->resourcetype);
    }

    public function createParametersFromString($jsonString)#
    {
        $json = json_decode($jsonString);

        return (array) $json->parameters;
    }
}