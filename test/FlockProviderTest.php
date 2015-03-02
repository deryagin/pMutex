<?php namespace pMutex;

class FlockProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var FlockProvider */
    protected $flockProvider = null;

    public function setUp()
    {
        $this->flockProvider = new FlockProvider('unittest', '/var/tmp');
    }

    public function tearDown()
    {
        $this->flockProvider->release();
        unset($this->flockProvider);
    }

    public function test_acquire_GettingLock_ReturnsTrue()
    {
        $lockFile = fopen($this->flockProvider->getFilePath(), 'a');
        $this->assertTrue($this->flockProvider->acquire());
        $this->assertFalse(flock($lockFile, LOCK_EX | LOCK_NB));
    }

    public function test_acquire_RejectingLock_ReturnsFalse()
    {
        $this->flockProvider->acquire();
        $otherProvider = new FlockProvider('unittest', '/var/tmp');
        $this->assertFalse($otherProvider->acquire());
    }

    public function test_release_GettingUnlock_ReturnsTrue()
    {
        $this->flockProvider->acquire();
        $this->assertTrue($this->flockProvider->release());
    }

    public function test_getLockId_ReturnsLockIdFromConstructor()
    {
        $this->assertEquals('unittest', $this->flockProvider->getLockId());
    }

    public function test_getFilePath_ReturnsLockFileFullPath()
    {
        $this->assertEquals('/var/tmp/flock.unittest', $this->flockProvider->getFilePath());
    }
}
