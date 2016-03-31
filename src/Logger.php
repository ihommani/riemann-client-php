<?php

namespace Trademachines\Riemann;

/**
 * Convenient logger on top of the client.
 */
class Logger
{
    /** @var Client */
    protected $client;

    /** @var string */
    protected $name;

    /** @var string */
    protected $identAttribute;

    /**
     * Logger constructor.
     *
     * @param Client      $client
     * @param string|null $name
     * @param string|null $identAttribute
     */
    public function __construct(Client $client, $name = null, $identAttribute = null)
    {
        $this->client         = $client;
        $this->name           = $name;
        $this->identAttribute = $identAttribute;
    }

    /**
     * @param array $data
     * @param array $attributes
     */
    public function log(array $data, array $attributes = [])
    {
        $eventData = $this->getRiemannEventData($data, $attributes);
        $this->client->sendEvent($eventData);
    }

    protected function getRiemannEventData(array $data, array $attributes)
    {
        $data               = $this->enrichData($data);
        $data['attributes'] = $this->asRiemannAttributes($attributes);

        return $data;
    }

    protected function enrichData(array $data)
    {
        if (!isset($data['host'])) {
            $data['host'] = gethostname();
        }

        if ($service = $this->getService($data)) {
            $data['service'] = $service;
        }

        return $data;
    }

    protected function asRiemannAttributes(array $data)
    {
        $attributes = [];
        foreach ($data as $key => $value) {
            $attributes[] = [
                'key'   => $key,
                'value' => $value,
            ];
        }

        if ($this->name && $this->identAttribute) {
            $attributes[] = [
                'key'   => $this->identAttribute,
                'value' => $this->name,
            ];
        }

        return $attributes;
    }

    private function getService(array $data)
    {
        if (!$this->name || isset($data['service'])) {
            return null;
        }

        return $this->name;
    }
}
