<?php

interface interfaceMasterkeyDAO
{
  public static function getInstance();
	public function getMasterkeys();
	public function getMasterkeyById($id_masterkey);
	public function setMasterkey($masterkey_object);
	public function delMasterkey($id_masterkey);
	public function toString();
}

?>
