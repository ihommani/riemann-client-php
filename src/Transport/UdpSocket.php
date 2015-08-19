<?php

namespace Trademachines\Riemann\Transport;



class UdpSocket implements TransportInterface
{
    /** @var string */
    protected $host;

    /** @var int */
    protected $port;

    /** @var resource */
    protected $socket;

    /**
     * If the socket is not created, no exception is raised.
     *
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $remoteSocket = sprintf('udp://%s:%s', $host, $port);
        $this->socket = @stream_socket_client($remoteSocket, $errno, $errorMessage);

        if ($this->socket) {
            stream_set_blocking($this->socket, 0);
        }
    }

    /**
     * @return bool
     */
    public function isOpen()
    {
        return is_resource($this->socket);
    }

    /**
     * Close the socket
     */
    public function close()
    {
        if ($this->isOpen()) {
            fclose($this->socket);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write($data)
    {
        if (!$this->isOpen()) {
            return false;
        }

        return fwrite($this->socket, $data);
    }
}