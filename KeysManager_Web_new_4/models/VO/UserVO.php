<?php
class UserVO
{
    private static $statusType = array("Student"=>"Etudiant","Staff"=>"Personnel","Outsider"=>"Externe");

    // PRIMARYKEY
    protected $enssatPrimaryKey; //32 bits
    // Parametres
    protected $urlidentifier; //code apogee ou harpege, selon $status
    protected $username;
    protected $name;
    protected $surname;
    protected $phone;
    protected $status; //Etudiant, Exterieur, personel
    protected $email;

    // PRIMARYKEY
    public function setId($id) {
        $this->enssatPrimaryKey = $id;
    }
    public function getId() {
        return $this->enssatPrimaryKey;
    }

    // Parametres
    public function setUrlidentifier($id) {
        $this->urlidentifier = $id;
    }
    public function getUrlIdentifier() {
        return $this->urlidentifier;
    }

    public function setUsername($username) {
        $this->username = $username;
    }
    public function getUsername() {
        return $this->username;
    }

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }
    public function getSurname() {
        return $this->surname;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }
    public function getPhone() {
        return $this->phone;
    }

    public function setStatus($status) {
        if(array_key_exists($status, self::$statusType)) {
          $this->status = $status;
        } else {
          throw new RuntimeException('Le type de status ' . $status . ' est inexistant.');
        }
    }
    public function getStatus() {
        return $this->status;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }

    public function getStatusCollection() {
      return self::$statusType;
    }
}
