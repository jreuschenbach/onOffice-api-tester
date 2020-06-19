# onOffice-api-tester
test-suite for onOffice API

**Table of Contents**
* [Requirements](#requirements)
* [Installation](#installation)
* [ooapi.ini](#ooapiini)
* [GUI](#gui)
* [Command-Line-Version](#Command-Line-Version)
* [ooapitest.php](#ooapitestphp)

# Requirements
* PHP >= 7.2
* Linux / OSX

# Installation
```bash
$ git clone
$ composer install #dev-mode
$ composer install --no-dev #op-mode
```

# ooapi.ini

To avoid unnecessary code configuration, this library provides a configuration file.
 
In the `config/ooapi.ini` the onOffice-API-URL configured.

## GUI
This library comes with a basic user interface where custom JSON data
can be entered.

Just call `public/index.html` in the browser.

## Command-Line-Version

#### ooapitest.php

Beside the [GUI](#gui) this library can be used via console.

`$ php bin/ooapitest.php -f /path-to-file-with-json -t token -s secret`

`$ php bin/ooapitest.php -j '{json-string}' -t token -s secret`

The `json-string` MUST be the complete action-tag, example: 
<pre> {"actionid":"urn:onoffice-de-ns:smart:2.5:smartml:action:read","resourceid":"resource-id","resourcetype":"estate","identifier":"","timestamp":1589567897,"hmac":"88462bce11c5c47fb738dba64a36ba00","parameters":{"data":["Id", "kaufpreis", "lage"]}}</pre>

Have a look at the [official API documentation](https://apidoc.onoffice.de/)
for more information.