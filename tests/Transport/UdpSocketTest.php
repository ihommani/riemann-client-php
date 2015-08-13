<?php


use \Trademachines\Riemann\Transport\UdpSocket;

class UdpSocketTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException LogicException
     */
    public function testWriteIfSocketNotOpenRaiseException()
    {
        $socket = new UdpSocket('localhost', 0);
        $socket->close();
        $socket->write('something');
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testCreationFailedRaiseException()
    {
        new UdpSocket('43', -5);
    }
}
