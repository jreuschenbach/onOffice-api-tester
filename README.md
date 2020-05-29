# onOffice-api-tester
test-suite for onOffice API

# Requirements
* PHP >= 7.4
* Linux / OSX

# Installation
git clone
composer install #dev-mode
composer install --no-dev #op-mode

# ooapi.ini
In config/ooapi.ini you can:
* select the onOffice-API-URL
* select the directory to store the credentials (encrypted)

## gui
* call public/api-tester.html in browser

## Command-Line-Version

#### credentials.php
Store API-Token and -Secret encrypted

usage: php bin/credentials.php
-> prompt will request token, secret and a password to encrypt

#### ooapitest.php
Requests password from above. Reloads credentials and sends the api-request

usage: 
* php ooapitest.php -f /path-to-file-with-json
* php ooapitest.php -s '{json-string}'

json-string must be the complete action-tag, example: 
<pre> {"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","resourceid":"resource-id","resourcetype":"estate","identifier":"","timestamp":1589567897,"hmac":"88462bce11c5c47fb738dba64a36ba00","parameters":{"data":["Id", "kaufpreis", "lage"]}}</pre>

