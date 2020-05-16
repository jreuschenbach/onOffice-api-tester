<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\Action;
use jr\ooapi\dataObjects\Resource;

class DataFactory
{
    public function createActionFromString($jsonString): Action
    {
        $json = $this->parseJsonString($jsonString);
        return new Action($json->actionid);
    }

    public function createResourceFromString($jsonString): Resource
    {
        $json = $this->parseJsonString($jsonString);
        return new Resource($json->resourceid, $json->resourcetype);
    }

    public function createParametersFromString($jsonString): array
    {
        $json = $this->parseJsonString($jsonString);
        return (array) $json->parameters;
    }

    private function parseJsonString($jsonString): object
    {
        $json = json_decode($jsonString);

        if ($json === null)
        {
            throw new JsonParseException();
        }

        return $json;
    }
}