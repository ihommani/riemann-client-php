<?php

class RiemannTcpListenerStub
{
    private $socket;

    public function listen()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);

        // Bind the socket to an address/port
        if(false === socket_bind($this->socket, 'localhost', 0)) {
            throw new RuntimeException('Could not bind to address');
        }

        // Start listening for connections
        socket_listen($this->socket);

        socket_set_nonblock($this->socket);
    }

    public function stop()
    {
        @socket_close($this->socket);
    }

    public function getSocketPort()
    {
        socket_getsockname($this->socket, $socket_address, $socket_port);

        return $socket_port;
    }
}