<?php
class RoomVO
{
    // PRIMARYKEY
    protected $id_room;
    // Parametres
    protected $name;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_room = $id;
    }
    public function getId() {
        return $this->id_room;
    }

    // Parametres
    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
}
