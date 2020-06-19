# onOffice-api-tester
test-suite for onOffice API

**Table of Contents**
* [Requirements](#requirements)
* [Installation](#installation)
* [ooapi.ini](#ooapiini)
* [gui](#gui)
* [Command-Line-Version](#Command-Line-Version)
* [ooapitest.php](#ooapitestphp)

# Requirements
* PHP >= 7.2
* Linux / OSX

# Installation
git clone
composer install #dev-mode
composer install --no-dev #op-mode

# ooapi.ini
In config/ooapi.ini you can:
* select the onOffice-API-URL

## gui
* call public/index.html in browser

## Command-Line-Version

#### ooapitest.php
usage: 
* php ooapitest.php -f /path-to-file-with-json -t token -s secret
* php ooapitest.php -j '{json-string}' -t token -s secret

json-string must be the complete action-tag, example: 
<pre> {"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","resourceid":"resource-id","resourcetype":"estate","identifier":"","timestamp":1589567897,"hmac":"88462bce11c5c47fb738dba64a36ba00","parameters":{"data":["Id", "kaufpreis", "lage"]}}</pre>