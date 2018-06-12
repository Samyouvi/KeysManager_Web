<?php

interface interfaceKeyDAO
{

    // Singleton
    public static function getInstance();

    public function getKeys();

    public function getkeyByEnssatPrimaryKey($enssatPrimaryKey);

    public function getInfosWithId($id_key);
}

?>
