<?php namespace pMutex;

class ProcessSerializer
{
    /** @var ILockProvider */
    protected $lockProvider = null;

	/** @var integer - default halt time in microseconds */
	protected $sleepMicrosec = 1;

	/** @var float - default waitSeconds time in seconds  */
	protected $waitSeconds = 10.0;

	/** @var \Closure -  */
	protected $failCallback = null;

    public function __construct(ILockProvider $lockProvider, $sleepMicrosec = 1)
    {
        $this->lockProvider = $lockProvider;
	    $this->sleepMicrosec = $sleepMicrosec;
    }

    public function runAction(\Closure $action, $waiting = 10.0)
    {
        $startTime = microtime(true);
        while (true) {
            $isLocked = $this->lockProvider->acquire($isExclusive = true);
            if ($isLocked) {
                $result = $action();
                $this->lockProvider->release();
                return $result;
            }

            usleep($this->sleepMicrosec);

            $pastInterval = microtime(true) - $startTime;
            if ($waiting < $pastInterval) {
                throw new \Exception("waiting time was expired. Unable to get access to shared resource with id = " . $this->lockProvider->getId());
            }
        }
    }

	public function setWaitingTime()
	{

	}

	public function setFailCallback(\Closure $failAction)
	{

	}
}

