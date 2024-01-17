<?php
namespace BlogMvc\Models;

/** Class UserManager **/
class UserManager {

    private \PDO $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    //Methode qui retourne la bdd
    public function getBdd(): \PDO {
        return $this->bdd;
    }

    //Methode qui retourne l'auteur d'id $id
    public function getById(string $id): array|bool {
        $stmt = $this->bdd->prepare("SELECT * FROM login_motdepasse WHERE Id_auteur = ?");
            $stmt->execute(array(
                $id
            ));
            return $stmt->fetch();
    }

    //Methode qui retourne l'auteur de nom $username
    public function find(string $username): array|bool {
        $stmt = $this->bdd->prepare("SELECT * FROM login_motdepasse WHERE Login LIKE ?");
        $stmt->execute(array(
            $username
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"BlogMvc\Models\User");

        return $stmt->fetch();
    }

    //Methode qui retourne tous les users de la bdd
    public function all(): array {
        $stmt = $this->bdd->query('SELECT * FROM login_motdepasse');

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Todo\Models\User");
    }

    //Methode qui insere un nouvel user avec un mot de passe $password
    public function store(string $password): void {
        $stmt = $this->bdd->prepare("INSERT INTO login_motdepasse(Id_auteur, Login, Motdepasse) VALUES (UUID(), ?, ?)");
        $stmt->execute(array(
            $_POST["username"],
            $password
        ));
    }
}