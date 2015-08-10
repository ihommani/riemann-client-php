# riemann-client-php

## Usage

```php
$socket = new UdpSocket('127.0.0.1', 5555);

$client = new Client($socket);
$client->sendEvent([
    'host' => 'tm',
    'service' => 'loader',
    'metric' => 1
]);

// By default the data will be really send to riemann once 20 events have been queued
// You can still send the data manually by calling:
$client->flush();

// Or by changing the threshold:
$client->setFlushAfter(5);

```
