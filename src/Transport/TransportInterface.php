<?php

namespace Trademachines\Riemann\Transport;

/**
 * Interface TransportInterface
 */
interface TransportInterface
{
    /**
     * @param $data
     */
    public function write($data);
}