<?php namespace pMutex;

interface ILockProvider
{
    /**
     * Construct a provider object for a shared resource.
     *
     * @param string|integer $lockId - shared resource ID
     */
    public function __construct($lockId);

    /**
     * Acquires the lock on a shared resource.
     *
     * @param bool $isNeedWait - false, if need't block until the lock is acquired
     * @return boolean - true, if succeed
     */
    public function acquire($isNeedWait = false);

    /**
     * Release the lock on a shared resource.
     *
     * @return boolean - true, if succeed
     */
    public function release();

    /**
     * Returns $lockId, definded in __constructor($lockId).
     *
     * @return string|integer - ID for shared resource
     */
    public function getLockId();
}
