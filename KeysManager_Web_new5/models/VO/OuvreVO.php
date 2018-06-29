<?php
class OuvreVO
{
    // PRIMARYKEY
    protected $id_ouvre;
    // FOREIGNKEYS
    protected $id_lock;
    protected $id_key;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_ouvre = $id;
    }
    public function getId() {
        return $this->id_ouvre;
    }

    // FOREIGNKEYS
    public function setIdLock($id) {
        $this->id_lock = $id;
    }
    public function getIdLock() {
        return $this->id_lock;
    }

    public function setIdKey($id) {
        $this->id_key = $id;
    }
    public function getIdKey() {
        return $this->id_key;
    }
}
