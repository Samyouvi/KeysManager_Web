<?php

interface interfaceUserDAO
{
  public static function getInstance();
	public function getUsers();
	public function getUserById($id_user);
	public function setUser($user_object);
	public function delUser($id_user);
	public function getUserIdsWithUrlidentifier($ur1identifier);
	public function getUserIdsWithUsername($username);
	public function getUserIdsWithName($name);
	public function getUserIdsWithSurname($surname);
	public function getUserIdsWithPhone($phone);
	public function getUserIdsWithKeyId($status);
	public function getUserIdsWithEmail($email);
	public function toString();
}

?>
