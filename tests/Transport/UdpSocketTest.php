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

    /**
     * @expectedException UnexpectedValueException
     */
    public function testCreationFailedRaiseException()
    {
        new UdpSocket('43', -5);
    }
}
