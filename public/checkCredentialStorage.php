<?php

namespace jr\ooapi;

include(__DIR__.'/../vendor/autoload.php');

$config = new Config(__DIR__ . '/../config/ooapi.ini');
$credentialStorage = new CredentialStorage($config->getCredentialDir());

echo $credentialStorage->isSomethingStored();