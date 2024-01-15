<?php
    namespace BlogMvc\Models;

    class ArticleManager{
        private $bdd;

        public function __construct() {
            $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
            $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function getAll() {
            $stmt = $this->bdd->query("SELECT * FROM blog_poo");
            return $stmt->fetchAll(\PDO::FETCH_CLASS,"BlogMvc\Models\Article");
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
    }
?>