<?php

namespace Trademachines\Riemann\Transport;

/**
 * Class TcpSocket
 */
class TcpSocket implements TransportInterface
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
        $remoteSocket = sprintf('tcp://%s:%s', $host, $port);
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

        // A TCP connection to Riemann is a stream of messages.
        // Each message is a 4 byte network-endian integer *length*,
        // followed by a Protocol Buffer Message of *length* bytes.
        // http://riemann.io/howto.html#write-a-client

        // unsigned long (always 32 bit, big endian byte order)
        $length = pack("N", strlen($data));

        return @fwrite($this->socket, $length.$data);
    }
}