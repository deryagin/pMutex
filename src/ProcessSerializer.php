<?php namespace pMutex;

class ProcessSerializer
{
    /** @var ILockProvider */
    protected $lockProvider = null;

    /** @var \Closure - runs definded reaction if getting lock was failed */
    protected $failCallback = null;

    /** @var float - default waitSeconds time in seconds */
    protected $waitSeconds = 10.0;

    /** @var integer - default halt time in microseconds */
    protected $sleepMicrosec = 1;

    public function __construct(ILockProvider $lockProvider)
    {
        $this->lockProvider = $lockProvider;
    }

    public function runAction(\Closure $action)
    {
        $startTime = microtime(true);
        while (true)
        {
            $isLocked = $this->lockProvider->acquire($isExclusive = true);
            if ($isLocked)
            {
                $result = $action();
                $this->lockProvider->release();
                return $result;
            }

            usleep($this->sleepMicrosec);

            $pastInterval = microtime(true) - $startTime;
            if ($this->waitSeconds < $pastInterval)
            {
                return $this->notifyAboutFail();
            }
        }
    }

    public function setFailCallback(\Closure $failCallback)
    {
        $this->failCallback = $failCallback;
        return $this;
    }

    public function setWaitSeconds($waitSeconds)
    {
        $this->waitSeconds = $waitSeconds;
        return $this;
    }

    public function setSleepMicrosec($sleepMicrosec)
    {
        $this->sleepMicrosec = $sleepMicrosec;
        return $this;
    }

    protected function notifyAboutFail()
    {
        if ($this->failCallback)
        {
            return $this->failCallback();
        }
        throw new MutexException($this->lockProvider->getLockId());
    }
}
