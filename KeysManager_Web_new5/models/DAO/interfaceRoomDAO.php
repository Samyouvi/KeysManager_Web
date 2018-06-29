<?php

interface interfaceRoomDAO
{
  public static function getInstance();
	public function getRooms();
	public function getRoomById($id_room);
	public function setRoom($room_object);
	public function delRoom($id_room);
	public function getRoomIdWithName($name);
	public function toString();
  //private function saveRoom();
}

?>
