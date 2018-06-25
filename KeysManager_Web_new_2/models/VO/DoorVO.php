<?php
class DoorVO
{
    // PRIMARYKEY
    protected $id_door;
    // FOREIGNKEYS
    protected $id_serrure;
    protected $id_room;
    protected $id_lock;
    // Parametres
    protected $length_lock;
    protected $name;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_door = $id;
    }
    public function getId() {
        return $this->id_door;
    }

    // FOREIGNKEYS
    public function setIdSerrure($id) {
        $this->id_serrure = $id;
    }
    public function getIdSerrure() {
        return $this->id_serrure;
    }

    public function setIdRoom($id) {
        $this->id_room = $id;
    }
    public function getIdRoom() {
        return $this->id_room;
    }

    public function setIdLock($id) {
        $this->id_lock = $id;
    }
    public function getIdLock() {
        return $this->id_lock;
    }

    // Parametres
    public function setLengthLock($length) {
        $this->length_lock = $length;
    }
    public function getLengthLock() {
        return $this->length_lock;
    }

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
}
