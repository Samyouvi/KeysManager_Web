<?php

interface interfaceUserDAO
{

    // Singleton
    public static function getInstance();

    public function getUsers();

    public function getUserByEnssatPrimaryKey($enssatPrimaryKey);

    public function getIdWithRef($userRef);
}

?>
