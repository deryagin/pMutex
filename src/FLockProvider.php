<?php namespace pMutex;

class FlockProvider implements ILockProvider
{
	/** @var string|integer - ID for shared resource */
	protected $lockId = '';

	/** @var string - full path fo the lock-file */
	protected $filePath = '';

	/** @var resource - the opened lock-file */
	protected $lockFile = null;

	public function __construct($lockId, $tmpDir = '')
	{
		$this->lockId = $lockId;
		$tmpDir = ($tmpDir ?: sys_get_temp_dir());
		$this->filePath = "{$tmpDir}/flock.{$this->lockId}";
		$this->lockFile = fopen($this->filePath, 'c');
	}

	public function __destruct()
	{
		flock($this->lockFile, LOCK_UN);
		fclose($this->lockFile);
	}

	public function acquire($isNeedWait = false)
	{
		$lockType = ($isNeedWait ? LOCK_EX : LOCK_EX | LOCK_NB);
		return flock($this->lockFile, $lockType);
	}

	public function release()
	{
		return flock($this->lockFile, LOCK_UN);
	}

	public function getLockId()
	{
		return $this->lockId;
	}

	public function getFilePath()
	{
		return $this->filePath;
	}
}

