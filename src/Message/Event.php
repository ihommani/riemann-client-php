<?php

namespace Trademachines\Riemann\Message;

use DrSlump\Protobuf\AnnotatedMessage;

/**
 * Class Event
 */
class Event extends AnnotatedMessage
{
    /** @protobuf(tag=1, type=int64, optional) */
    public $time;

    /** @protobuf(tag=2, type=string, optional) */
    public $state;

    /** @protobuf(tag=3, type=string, optional) */
    public $service;

    /** @protobuf(tag=4, type=string, optional) */
    public $host;

    /** @protobuf(tag=5, type=string, optional) */
    public $description;

    /** @protobuf(tag=7, type=string, repeated) */
    public $tags;

    /** @protobuf(tag=8, type=float, optional) */
    public $ttl;

    /** @protobuf(tag=9, type=message, reference=Trademachines\Riemann\Message\Attribute, repeated) */
    public $attributes;

    /** @protobuf(tag=13, type=sint64, optional) */
    public $metric_sint64;

    /** @protobuf(tag=14, type=double, optional) */
    public $metric_d;

    /** @protobuf(tag=15, type=float, optional) */
    public $metric_f;

    /**
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->time = time();

        parent::__construct();
    }

    /**
     * Fill the event with the specified array values
     *
     * @param array $data
     */
    public function fill(array $data)
    {
        if (!empty($data['metrics'])) {
            $this->setMetrics($data['metrics']);
        }

        foreach ($data as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * @param int|float $metrics
     */
    protected function setMetrics($metrics)
    {
        $this->metric_f = (float) $metrics;
        if (is_int($metrics)) {
            $this->metric_sint64 = $metrics;
        } else {
            $this->metric_d = $this->metric_f;
        }
    }

}