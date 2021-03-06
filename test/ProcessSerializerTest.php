<?php namespace pMutex;

class ProcessSerializerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ProcessSerializer */
    protected $serializer = null;

    public function setUp()
    {
        $flockProvider = new FlockProvider('unittest', '/var/tmp');
        $this->serializer = new ProcessSerializer($flockProvider);
    }

    public function test_setMethod_InjectValue_ReturnsThis()
    {
        $this->markTestIncomplete();
    }

    public function test_runAction_LockAcquired_RunsAction()
    {
        $this->markTestIncomplete();
    }

    public function test_runAction_ActionDone_ReleasesLock()
    {
        $this->markTestIncomplete();
    }

    public function test_runAction_ActionDone_ReturnsResult()
    {
        $this->markTestIncomplete();
    }

    public function test_runAction_LockRefused_WaitsUntilSeconds()
    {
        $this->markTestIncomplete();
    }

    public function test_runAction_WaitingFinished_ThrowsException()
    {
        $this->markTestIncomplete();
    }
}
