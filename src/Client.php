<?php

namespace Trademachines\Riemann;

use DrSlump\Protobuf;
use Trademachines\Riemann\Message\Event;
use Trademachines\Riemann\Message\Message;
use Trademachines\Riemann\Transport\TransportInterface;
use Trademachines\Riemann\Transport\UdpSocket;

/**
 * Riemann Client
 */
class Client
{
    /** @var UdpSocket */
    protected $socket;

    /** @var array */
    protected $events = [];

    /** @var int **/
    protected $flushAfter = 20;

    /**
     * @param TransportInterface $socket
     */
    public function __construct(TransportInterface $socket)
    {
        $this->socket = $socket;
    }

    /**
     * Automatically flush before destruction
     */
    public function __destruct()
    {
        $this->flush();
    }

    /**
     * @param int $flushAfter
     */
    public function setFlushAfter($flushAfter)
    {
        $this->flushAfter = $flushAfter;
    }

    /**
     * @param Event $event
     */
    public function send(Event $event)
    {
        $this->events[] = $event;

        if (count($this->events) >= $this->flushAfter) {
            $this->flush();
        }
    }

    /**
     * @param array $eventData
     */
    public function sendEvent(array $eventData = [])
    {
        $event = new Event();
        $event->fill($eventData);

        $this->send($event);
    }

    /**
     * Flush the event queues and send the data
     */
    public function flush()
    {
        if (count($this->events)) {
            $message = new Message();
            $message->events = $this->events;

            $this->socket->write($message->serialize());

            $this->events = [];
        }
    }
}