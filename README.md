# onOffice-api-tester
test-suite for onOffice API

# Requirements
* PHP >= 7.4
* Linux / OSX

## Command-Line-Version

#### credentials.php
Store API-Token and -Secret encrypted

usage: php bin/credentials.php
-> prompt will request token, secret and a password to encrypt

#### ooapitest.php
Requests password from above. Reloads credentials and sends the api-request

work in progeress


#### ooapi.ini
In config/ooapi.ini you can:
* select the onOffice-API-URL
* select the directory to store the credentials (encrypted)
