<?php
    namespace BlogMvc\Models;

    class ArticleManager{
        private $bdd;

        public function __construct() {
            $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
            $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function getAll() {
            $stmt = $this->bdd->query("SELECT * FROM blog_poo ORDER BY Date DESC,Auteur,Titre");
            return $stmt->fetchAll(\PDO::FETCH_CLASS,"BlogMvc\Models\Article");
        }

        public function getById($id) {
            $stmt = $this->bdd->prepare("SELECT * FROM blog_poo WHERE Id = ?");
            $stmt->execute(array(
                $id
            ));
            return $stmt->fetch();
        }

        public function maxId() {
            $stmt = $this->bdd->query("SELECT MAX(Id) AS Id FROM blog_poo");
            $blogid = $stmt->fetch();
            return $blogid["Id"] + 1;
        }

        public function store($imgname) {
            $stmt = $this->bdd->prepare("INSERT INTO blog_poo (Titre, Description, Image, Date, Auteur) VALUES (?,?,?,?,?)");
            $stmt->execute(array(
                $_POST["titre"],
                $_POST["commentaire"],
                $imgname,
                date("Y-m-d"),
                $_SESSION["user"]["id"]
            ));
        }

        public function delete($id) {
            $stmt = $this->bdd->prepare("DELETE FROM blog_poo WHERE Id = ? AND Auteur = ?");
            $stmt->execute(array(
                $id,
                $_SESSION["user"]["id"]
            ));
        }

        public function update($imgname) {
            $stmt = $this->bdd->prepare("UPDATE blog_poo SET Titre = ?, Description = ?, Image = ?, Date = ? WHERE ID = ? AND AUTEUR = ?");
            $stmt->execute(array(
                $_POST["titre"],
                $_POST["commentaire"],
                $imgname,
                date("Y-m-d"),
                $_POST["articleId"],
                $_SESSION["user"]["id"]
            ));
        }
    }
?>