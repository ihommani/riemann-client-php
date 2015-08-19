<?php


use \Trademachines\Riemann\Transport\UdpSocket;

class UdpSocketTest extends PHPUnit_Framework_TestCase
{
    public function testWriteIfSocketClosedReturnFalse()
    {
        $socket = new UdpSocket('localhost', 0);
        $socket->close();
        $this->assertEquals(false, $socket->write('something'));
    }

    public function testCreationFailedRaiseException()
    {
        new UdpSocket('43', -5);
    }

    public function testIsOpen()
    {
        $socket = new UdpSocket('localhost', 0);
        $this->assertEquals($socket->isOpen(), true);
    }

    public function testIsOpenIfSocketClosedReturnFalse()
    {
        $socket = new UdpSocket('localhost', 0);
        $socket->close();
        $this->assertEquals($socket->isOpen(), false);
    }
}
