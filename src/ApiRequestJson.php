<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestValues;

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
        $action->actionId = $requestValues->getAction()->getId();
        $action->resourceId = $requestValues->getResource()->getId();
        $action->resourceType = $requestValues->getResource()->getType();
        $action->identifier = $requestValues->getAction()->getIdentifier();
        $action->timestamp = $requestValues->getTimestamp();
        $action->hmac = $hmac;

        $parameters = (object)$requestValues->getParameters();
        $action->parameters = $parameters;
        return $action;
    }
}