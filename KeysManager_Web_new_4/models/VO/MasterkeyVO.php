<?php
class MasterkeyVO
{
    // PRIMARYKEY
    protected $id_masterkey;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_masterkey = $id;
    }
    public function getId() {
        return $this->id_masterkey;
    }
}
