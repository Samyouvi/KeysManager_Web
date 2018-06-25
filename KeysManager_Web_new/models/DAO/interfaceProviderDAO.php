<?php

interface interfaceProviderDAO
{
  public static function getInstance();
	public function getProviders();
	public function getProviderById($id_provider);
	public function setProvider($provider_object);
	public function delProvider($id_provider);
	public function getProviderIdsWithUsername($username);
	public function getProviderIdsWithName($name);
	public function getProviderIdsWithSurname($surname);
	public function getProviderIdsWithPhone($phone);
	public function getProviderIdsWithOffice($office);
	public function getProviderIdsWithEmail($email);
	public function toString();
}

?>
