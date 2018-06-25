<?php
class KeychainVO
{
  private static $keychainStatus = array("Rendu", "Perdu", "Emprunté", "Archivé");

  // PRIMARYKEY
  protected $id_keychain;
  // FOREIGNKEYS
  protected $enssatPrimaryKey;
  // Parametres
  protected $creationDate;
  protected $destructionDate;
  protected $status;

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

  public function setStatus($status)
  {
    if(in_array($status, self::$keychainStatus)) {
      $this->status = $status;
    } else {
      throw new RuntimeException('Le status de clef ' . $status . ' est inexistant.');
    }
  }
  public function getStatus()
  {
    return $this->status;
  }

  public function getStatusCollection() {
    return self::$keychainStatus;
  }
}
