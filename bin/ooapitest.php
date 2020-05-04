<?php

namespace jr\ooapi;
include('../vendor/autoload.php');
define('LF', "\n");

$config = new Config('../config/ooapi.ini');
$apiRequest = new ApiRequest($config);
$apiResponse = $apiRequest->send();

echo 'answer from onOffice API:'.LF
    .'Status-Code: '.$apiResponse->getCode().LF
    .'Error-Code: '.$apiResponse->getErrorCode().LF
    .'Message: '.$apiResponse->getMessage().LF.LF;