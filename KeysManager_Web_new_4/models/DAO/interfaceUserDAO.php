<?php

interface interfaceUserDAO
{
  public static function getInstance();
	public function getUsers();
	public function getUserById($id_user);
	public function setUser($user_object);
	public function delUser($id_user);
	public function getUserIdWithUrlidentifier($ur1identifier);
	public function getUserIdWithUsername($username);
	public function getUserIdsWithName($name);
	public function getUserIdsWithSurname($surname);
	public function getUserIdWithPhone($phone);
	public function getUserIdsWithKeyId($status);
	public function getUserIdWithEmail($email);
	public function toString();
  //public function saveUser();
}

?>
