<?php namespace pMutex;

class MutexException extends \Exception
{
    /** @var string|integer - ID for shared resource */
    protected $lockId = null;

    public function __construct($lockId)
    {
        $this->lockId = $lockId;
        parent::__construct("Unable to get access to the shared resource with lockId = '{$lockId}'");
    }

    public function getLockId()
    {
        return $this->lockId;
    }
}
