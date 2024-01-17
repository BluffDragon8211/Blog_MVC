<?php
namespace BlogMvc\Models;

/** Class User **/
class User {

    private string $Id_auteur;//Unique Id
    private string $Login;
    private string $Motdepasse;

    //accesseurs
    public function getId_auteur(): string {
        return $this->Id_auteur;
    }
    
    public function getLogin(): string {
        return $this->Login;
    }

    public function getMotdepasse(): string {
        return $this->Motdepasse;
    }

    public function setId_auteur(int $id) {
        $this->Id_auteur = $id;
    }

    public function setLogin(string $username) {
        $this->Login = $username;
    }

    public function setMotdepasse(string $password) {
        $this->Motdepasse = $password;
    }
}