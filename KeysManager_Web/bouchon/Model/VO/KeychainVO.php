<?php
class KeychainVO
{
    // PRIMARYKEY
    protected $id_keychain;
    // FOREIGNKEYS
    protected $enssatPrimaryKey;
    // Parametres
    protected $creationDate;
    protected $destructionDate;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_keychain = $id;
    }
    public function getId() {
        return $this->id_keychain;
    }

    // FOREIGNKEYS
    public function setEnssatPrimaryKey($id) {
        $this->enssatPrimaryKey = $id;
    }
    public function getEnssatPrimaryKey() {
        return $this->enssatPrimaryKey;
    }

    // Parametres
    public function setCreationDate($date)
    {
      $this->creationDate=$date;
    }
    public function getCreationDate()
    {
      return $this->creationDate;
    }

    public function setDestructionDate($date)
    {
      $this->destructionDate=$date;
    }
    public function getDestructionDate()
    {
      return $this->destructionDate;
    }
}
