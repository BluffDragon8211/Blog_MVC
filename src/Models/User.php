<?php
namespace BlogMvc\Models;

/** Class User **/
class User {

    private $Id_auteur;
    private $Login;
    private $Motdepasse;

    public function getLogin() {
        return $this->Login;
    }

    public function getMotdepasse() {
        return $this->Motdepasse;
    }

    public function getId_auteur() {
        return $this->Id_auteur;
    }

    public function setLogin(String $username) {
        $this->Login = $username;
    }

    public function setMotdepasse(String $password) {
        $this->Motdepasse = $password;
    }

    public function setId_auteur(Int $id) {
        $this->Id_auteur = $id;
    }
}