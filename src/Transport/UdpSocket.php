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
     * @param $host
     * @param $port
     */
    public function __construct($host, $port)
    {
        $remoteSocket = sprintf('udp://%s:%s', $host, $port);
        $this->socket = @stream_socket_client($remoteSocket, $errno, $errorMessage);

        if ($this->socket == false) {
            throw new \UnexpectedValueException(sprintf('Socket not created!: %s', $errorMessage));
        }

        stream_set_blocking($this->socket, 0);
    }

    /**
     * Close the socket
     */
    public function close()
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write($data)
    {
        if (!is_resource($this->socket)) {
            throw new \LogicException('The socket is closed!');
        }

        fwrite($this->socket, $data);
    }
}