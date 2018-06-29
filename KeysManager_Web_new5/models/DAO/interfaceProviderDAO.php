<?php

interface interfaceProviderDAO
{
  public static function getInstance();
	public function getProviders();
	public function getProviderById($id_provider);
	public function setProvider($provider_object);
	public function delProvider($id_provider);
	public function getProviderIdWithUsername($username);
	public function getProviderIdsWithName($name);
	public function getProviderIdsWithSurname($surname);
	public function getProviderIdWithPhone($phone);
	public function getProviderIdsWithOffice($office);
	public function getProviderIdWithEmail($email);
	public function toString();
  //private function saveProvider();
}

?>
