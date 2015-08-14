<?php

namespace Trademachines\Riemann\Transport;

/**
 * Interface TransportInterface
 */
interface TransportInterface
{
    /**
     * @param $data
     *
     * @return int|bool
     */
    public function write($data);
}