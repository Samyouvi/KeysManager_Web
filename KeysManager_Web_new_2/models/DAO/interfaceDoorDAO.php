<?php

interface interfaceDoorDAO
{
  public static function getInstance();
  public function getDoors();
  public function getDoorById($id_door);
  public function setDoor($door_object);
  public function delDoor($id_door);
  public function getDoorIdsWithSerrureId($id_serrure);
  public function getDoorIdsWithRoomId($id_room);
  public function getDoorIdWithLockId($id_lock);
  public function getDoorIdsWithName($name);
  public function getDoorIdsWithLengthLock($length_lock);
  public function toString();
  //private function saveDoor();
}

?>
