<?php
    namespace BlogMvc\Models;

    class ArticleManager{
        private \PDO $bdd;

        public function __construct() {
            $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
            $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        //Methode qui retourne un tableau de tous les articles stockés en bdd et du nom de leur auteur
        public function getAll(): array {
            $stmt = $this->bdd->query("SELECT Id, Titre, Description, Image, Date, Auteur, Login AS AuteurName FROM blog_poo JOIN login_motdepasse ON blog_poo.Auteur = login_motdepasse.Id_auteur ORDER BY Date DESC,Auteur,Titre");
            return $stmt->fetchAll(\PDO::FETCH_CLASS,"BlogMvc\Models\Article");
        }

        //Methode qui retourne un tableau associatif avec les infos sur l'article d'id $id ou false si il n'est pas trouvé
        public function getById(int $id): array|bool {
            $stmt = $this->bdd->prepare("SELECT * FROM blog_poo WHERE Id = ?");
            $stmt->execute(array(
                $id
            ));
            return $stmt->fetch();
        }

        //Methode qui retourne l'id le plus grand + 1 de la bdd
        public function maxId(): int {
            $stmt = $this->bdd->query("SELECT MAX(Id) AS Id FROM blog_poo");
            $blogid = $stmt->fetch();
            return $blogid["Id"] + 1;
        }

        //Methode qui insere en bdd le nouvel article avec le nom d'image preparé pour insertion
        public function store(string $imgname): void {
            $stmt = $this->bdd->prepare("INSERT INTO blog_poo (Titre, Description, Image, Date, Auteur) VALUES (?,?,?,?,?)");
            $stmt->execute(array(
                $_POST["titre"],
                $_POST["commentaire"],
                $imgname,
                date("Y-m-d"),
                $_SESSION["user"]["id"]
            ));
        }

        //Methode de supression d'article avec l'id $id
        public function delete(int $id): void {
            $stmt = $this->bdd->prepare("DELETE FROM blog_poo WHERE Id = ? AND Auteur = ?");
            $stmt->execute(array(
                $id,
                $_SESSION["user"]["id"]
            ));
        }

        //Methode de modification d'article (avec le nom d'image prepare pour modification) dont l'auteur a pour id celui stocké en session
        public function update(string $imgname): void {
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