<?php

interface interfaceDoorDAO
{

    // Singleton
    public static function getInstance();

    public function getDoors();

    //public function getIdWithName($name);

    public function getIdLockWithIdRoom($id_room);
}

?>
