<?php

interface interfaceKeyDAO
{
  public static function getInstance();
	public function getKeys();
	public function getKeyById($id_key);
	public function setKey($key_object);
	public function delKey($id_key);
	public function getKeyIdsWithKeychainId($id_keychain);
	public function getKeyIdsWithProvider($id_provider);
	public function getKeyIdsWithNbrExemplaires($nbr_exemplaires);
	public function getKeyIdsWithType($type);
	public function toString();
}

?>
