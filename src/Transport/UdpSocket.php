<?php

namespace Trademachines\Riemann\Transport;



class UdpSocket implements TransportInterface
{
    /** @var string */
    protected $host;

    /** int @var */
    protected $port;

    /**
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * {@inheritdoc}
     */
    public function write($data)
    {
        $remoteSocket = sprintf('udp://%s:%s', $this->host, $this->port);
        $stream = stream_socket_client($remoteSocket, $errno, $errorMessage);

        if ($stream == false) {
            throw new \UnexpectedValueException('Unable to connect!');
        }

        stream_set_blocking($stream, 0);

        fwrite($stream, $data);
        fclose($stream);
    }
}