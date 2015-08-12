<?php

use Trademachines\Riemann\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    protected $client;

    protected function tearDown()
    {
        // the property is used only in order to prevent the destructor to be called during the test
        unset($this->client);
    }

    public function testFlush()
    {
        $socketMock = $this->getSocketMock();

        $this->client = new Client($socketMock);
        $this->client->sendEvent();
        $this->client->flush();
    }

    public function testFlushDoNotWriteIfNoEvent()
    {
        $socketMock = $this->getSocketMock(0);

        $this->client = new Client($socketMock);
        $this->client->flush();
    }

    public function testFlushOnDestruction()
    {
        $socketMock = $this->getSocketMock(1);

        $this->client = new Client($socketMock);
        $this->client->sendEvent();
        unset($this->client);
    }

    public function testFlushCalledIfMaxEventsIsReached()
    {
        $socketMock = $this->getSocketMock(1);

        $this->client = new Client($socketMock);
        $this->client->setFlushAfter(2);
        $this->client->sendEvent();
        $this->client->sendEvent();
    }

    public function testFlushNotCalledIfMaxEventsIsNotReached()
    {
        $socketMock = $this->getSocketMock(0);

        $this->client = new Client($socketMock);
        $this->client->setFlushAfter(2);
        $this->client->sendEvent();
    }

    public function testSocketWriteNotCalledIfActiveIsFalse()
    {
        $socketMock = $this->getSocketMock(0);

        $this->client = new Client($socketMock);
        $this->client->setActive(false);
        $this->client->sendEvent();
        $this->client->flush();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getSocketMock($called = 1)
    {
        $socketMock = $this->getMockBuilder('Trademachines\Riemann\Transport\UdpSocket')
            ->disableOriginalConstructor()
            ->setMethods(['write'])
            ->getMock();

        $socketMock->expects($this->exactly($called))
            ->method('write');

        return $socketMock;
    }
}
