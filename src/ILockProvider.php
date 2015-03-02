<?php namespace pMutex;

interface ILockProvider
{
    public function __construct($lockId);

    public function acquire($isNeedWait = false);

    public function release();

    public function getLockId();
}
