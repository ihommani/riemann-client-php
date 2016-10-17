<?php

use \Trademachines\Riemann\Transport\TcpSocket;

require_once __DIR__ . '/../Stub/RiemannTcpListenerStub.php';

class TcpSocketTest extends PHPUnit_Framework_TestCase
{
    /** @var RiemannTcpListenerStub */
    private $riemannTcpListenerStub;

    public function setUp()
    {
        $this->riemannTcpListenerStub = new RiemannTcpListenerStub();
        $this->riemannTcpListenerStub->listen();
    }

    public function tearDown()
    {
        $this->riemannTcpListenerStub->stop();
    }

    public function testWriteIfSocketClosedReturnFalse()
    {
        $socket = new TcpSocket('localhost', $this->riemannTcpListenerStub->getSocketPort());
        $socket->close();
        $this->assertEquals(false, $socket->write('something'));
    }

    public function testCreationFailedDoNotRaiseException()
    {
        new TcpSocket('43', -5);
    }

    public function testIsOpen()
    {
        $socket = new TcpSocket('localhost', $this->riemannTcpListenerStub->getSocketPort());
        $this->assertEquals($socket->isOpen(), true);
    }

    public function testIsOpenIfSocketClosedReturnFalse()
    {
        $socket = new TcpSocket('localhost', $this->riemannTcpListenerStub->getSocketPort());
        $socket->close();
        $this->assertEquals($socket->isOpen(), false);
    }
}
