<?php

namespace Trademachines\Riemann;

trait RiemannAwareTrait
{
    /**
     * @var Client
     */
    protected $riemannClient;

    /**
     * @param Client $riemannClient
     */
    public function setClient(Client $riemannClient)
    {
        $this->riemannClient = $riemannClient;
    }
}