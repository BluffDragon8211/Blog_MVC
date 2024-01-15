<?php
namespace BlogMvc\Models;

/** Class UserManager **/
class UserManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getBdd()
    {
        return $this->bdd;
    }

    public function getById($id) {
        $stmt = $this->bdd->prepare("SELECT * FROM login_motdepasse WHERE Id_auteur = ?");
            $stmt->execute(array(
                $id
            ));
            return $stmt->fetch();
    }

    public function find($username) {
        $stmt = $this->bdd->prepare("SELECT * FROM login_motdepasse WHERE Login LIKE ?");
        $stmt->execute(array(
            $username
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"BlogMvc\Models\User");

        return $stmt->fetch();
    }

    public function all() {
        $stmt = $this->bdd->query('SELECT * FROM login_motdepasse');

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Todo\Models\User");
    }

    public function store($password) {
        $stmt = $this->bdd->prepare("INSERT INTO login_motdepasse(Id_auteur, Login, Motdepasse) VALUES (UUID(), ?, ?)");
        $stmt->execute(array(
            $_POST["username"],
            $password
        ));
    }
}