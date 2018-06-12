<?php
class UserVO
{
    public static $statusType = array("Student"=>"Etudiant","Staff"=>"Personnel","Outsider"=>"Externe");

    // PRIMARYKEY
    protected $enssatPrimaryKey; //32 bits
    // Parametres
    protected $ur1identifier; //code apogee ou harpege, selon $status
    protected $username;
    protected $name;
    protected $surname;
    protected $phone;
    protected $status; //Etudiant, Exterieur, personel
    protected $email;

    // PRIMARYKEY
    public function setEnssatPrimaryKey($id) {
        $this->enssatPrimaryKey = $id;
    }
    public function getEnssatPrimaryKey() {
        return $this->enssatPrimaryKey;
    }

    // Parametres
    public function setUr1Identifier($id) {
        $this->ur1identifier = $id;
    }
    public function getUrlIdentifier() {
        return $this->ur1identifier;
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
}
