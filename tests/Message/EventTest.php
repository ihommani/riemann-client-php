<?php

use Trademachines\Riemann\Message\Event;

/**
 * Test Event
 */
class EventTest extends PHPUnit_Framework_TestCase
{
    public function testFill()
    {
        $data = [
            'time' => 123456789,
            'state' => 'ok',
            'service' => 'loader',
            'host' => 'tm',
            'description' => 'very interesting description',
            'tags' => [ 'tag', 'tag1' ],
            'ttl' => 600,
            'attributes' => 'data',
            'metric_sint64' => 1,
            'metric_d' => 2,
            'metric_f' => 3,
        ];

        $event = new Event();
        $event->fill($data);

        $this->assertEquals(123456789, $event->time);
        $this->assertEquals('ok', $event->state);
        $this->assertEquals('loader', $event->service);
        $this->assertEquals('tm', $event->host);
        $this->assertEquals('very interesting description', $event->description);
        $this->assertEquals([ 'tag', 'tag1' ], $event->tags);
        $this->assertEquals(600, $event->ttl);
        $this->assertEquals('data', $event->attributes);
        $this->assertEquals(1, $event->metric_sint64);
        $this->assertEquals(2, $event->metric_d);
        $this->assertEquals(3, $event->metric_f);
    }
}
