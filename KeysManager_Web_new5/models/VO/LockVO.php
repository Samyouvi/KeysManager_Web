<?php
class LockVO
{
    // PRIMARYKEY
    protected $id_lock;
    // FOREIGNKEYS
    protected $id_provider;
    // Parametres
    protected $length;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_lock = $id;
    }
    public function getId() {
        return $this->id_lock;
    }

    // FOREIGNKEYS
    public function setIdProvider($id) {
      $this->id_provider = $id;
    }
    public function getIdProvider() {
      return $this->id_provider;
    }

    // Parametres
    public function setLength($length) {
        $this->length = $length;
    }
    public function getLength() {
        return $this->length;
    }
}
