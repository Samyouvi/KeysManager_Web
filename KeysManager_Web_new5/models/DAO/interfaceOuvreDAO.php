<?php

interface interfaceOuvreDAO
{
  public static function getInstance();
	public function getOuvres();
	public function getOuvreById($id_ouvre);
	public function setOuvre($ouvre_object);
	public function delOuvre($id_ouvre);
	public function getOuvreIdsWithKeyId($id_key);
	public function getOuvreIdsWithLockId($id_lock);
	public function toString();
  //private function saveOuvre();
}

?>
