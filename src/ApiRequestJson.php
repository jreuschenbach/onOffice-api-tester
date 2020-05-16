<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestValues;

/**
 * Class ApiRequestJson
 *
 * create json-request-string from data-objects
 *
 * @package jr\ooapi
 */

class ApiRequestJson
{
    public function build(RequestValues $requestValues, string $hmac): string
    {
        $json = new \stdClass();
        $json->token = $requestValues->getCredentials()->getToken();

        $request = new \stdClass();
        $json->request = $request;

        $actions = [];
        $action = $this->buildAction($requestValues, $hmac);
        $actions []= $action;
        $request->actions = $actions;

        return json_encode($json);
    }

    private function buildAction(RequestValues $requestValues, string $hmac): \stdClass
    {
        $action = new \stdClass();
        $action->actionid = $requestValues->getAction()->getId();
        $action->resourceid = $requestValues->getResource()->getId();
        $action->resourcetype = $requestValues->getResource()->getType();
        $action->identifier = $requestValues->getAction()->getIdentifier();
        $action->timestamp = $requestValues->getTimestamp();
        $action->hmac = $hmac;

        $parameters = (object)$requestValues->getParameters();
        $action->parameters = $parameters;
        return $action;
    }
}