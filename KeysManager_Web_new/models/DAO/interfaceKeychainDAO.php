<?php

interface interfaceKeychainDAO
{
  public static function getInstance();
	public function getKeychains();
	public function getKeychainById($id_keychain);
	public function setKeychain($keychain_object);
	public function delKeychain($id_keychain);
	public function getKeychainIdsWithEnssatPrimaryKey($enssat_primary_key);
	public function getKeychainIdsWithCreationDate($creation_date);
	public function getKeychainIdsWithDestructionDate($destruction_date);
	public function getKeychainIdsWithStatus($status);
	public function toString();
}

?>
