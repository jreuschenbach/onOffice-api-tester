<?php

namespace jr\ooapi;
use jr\ooapi\dataObjects\RequestValues;

/**
 * Class Hmac
 *
 * Create HMAC for onOffice-API
 *
 * @see https://apidoc.onoffice.de
 * @package jr\ooapi
 */

class Hmac
{
    public function create(RequestValues $requestValues): string
    {
        $fields['accesstoken'] = $requestValues->getCredentials()->getToken();
        $fields['actionid'] = $requestValues->getAction()->getId();
        $fields['identifier'] = $requestValues->getAction()->getIdentifier();
        $fields['resourceid'] = $requestValues->getResource()->getId();
        $fields['secret'] = $requestValues->getCredentials()->getSecret();
        $fields['timestamp'] = $requestValues->getTimestamp();
        $fields['type'] = $requestValues->getResource()->getType();

        $parameters = $requestValues->getParameters();
        ksort($parameters);

        $parametersBundled = json_encode($parameters);
        $fieldsBundled = implode(',', $fields);
        $hmac = md5($requestValues->getCredentials()->getSecret().md5($parametersBundled.','.$fieldsBundled));
        return $hmac;
    }
}