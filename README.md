# riemann-client-php

[![Build Status](https://travis-ci.org/trademachines/riemann-client-php.svg)](https://travis-ci.org/trademachines/riemann-client-php)

Simple PHP client for [Riemann](http://riemann.io/) 

## Usage

```php
$socket = new UdpSocket('127.0.0.1', 5555);

$client = new Client($socket);
$client->sendEvent([
    'host' => 'tm',
    'service' => 'loader',
    'metrics' => 1,
    'attributes' => [
        [ 'key' => 'source', 'value' => 'my source'],
    ]
]);

// By default the data will be really send to riemann once 20 events have been queued
// You can still send the data manually by calling:
$client->flush();

// Or by changing the threshold:
$client->setFlushAfter(5);

```


## Installation

### Composer

You can install this package with [composer](https://getcomposer.org/), simply add "trademachines/riemann-client-php" to your composer.json file.

```javascript
{
    "require": {
        "trademachines/riemann-client-php": "dev-master"
    }
}
```

## TODO
 * TCP Transport
 * UDP Packet size control
