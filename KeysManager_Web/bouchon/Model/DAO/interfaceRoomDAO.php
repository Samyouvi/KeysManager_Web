<?php

interface interfaceRoomDAO
{

    // Singleton
    public static function getInstance();

    public function getRooms();

    public function getIdWithName($room_name);
}

?>
