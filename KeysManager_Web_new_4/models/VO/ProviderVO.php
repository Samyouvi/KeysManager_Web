<?php
class ProviderVO
{
    // PRIMARYKEY
    protected $id_provider;
    // Parametres
    protected $username;
    protected $name;
    protected $surname;
    protected $phone;
    protected $office;
    protected $email;

    // PRIMARYKEY
    public function setId($id) {
        $this->id_provider = $id;
    }
    public function getId() {
        return $this->id_provider;
    }

    // Parametres
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

    public function setOffice($office) {
        $this->office = $office;
    }
    public function getOffice() {
        return $this->office;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
}
