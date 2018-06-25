<?php
class KeyVO
{
    public static $keyType = array("Simple"=>"Clé","Partiel"=>"Passe Partiel","Total"=>"PasseTotal");

    // PRIMARYKEY
    protected $id_key;
    // FOREIGNKEYS
    protected $id_keychain;
    protected $id_provider;
    // Parametres
    protected $nbr_exemplaires;
    protected $type; //Clef ou Passe Partiel ou Passe Total

    // PRIMARYKEY
    public function setId($id) {
        $this->id_key = $id;
    }
    public function getId() {
        return $this->id_key;
    }

    // FOREIGNKEYS
    public function setIdKeychain($id) {
      $this->id_keychain = $id;
    }
    public function getIdKeychain() {
      return $this->id_keychain;
    }

    public function setIdProvider($id) {
      $this->id_provider = $id;
    }
    public function getIdProvider() {
      return $this->id_provider;
    }

    // Parametres
    public function setNbrExemplaires($nbr_exemplaires) {
      $this->nbr_exemplaires = $nbr_exemplaires;
    }
    public function getNbrExemplaires() {
        return $this->nbr_exemplaires;
    }

    public function setType($type) {
      if(array_key_exists($type, self::$keyType)) {
        $this->type = $type;
      } else {
        throw new RuntimeException('Le type de clef ' . $type . ' est inexistant.');
      }
    }
    public function getType() {
        return $this->type;
    }
}
