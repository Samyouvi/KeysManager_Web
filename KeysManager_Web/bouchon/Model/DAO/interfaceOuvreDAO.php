<?php

interface interfaceOuvreDAO
{

    // Singleton
    public static function getInstance();

    public function getOuvres();

    public function getIdsWithIdLock($id_lock);
}

?>
