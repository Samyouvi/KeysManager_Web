<?php

interface interfaceLockDAO
{
  public static function getInstance();
	public function getLocks();
	public function getLockById($id_lock);
	public function setLock($lock_object);
	public function delLock($id_lock);
	public function getLockIdsWithProviderId($id_provider);
	public function getLockIdsWithLengthId($length);
	public function toString();
}

?>
