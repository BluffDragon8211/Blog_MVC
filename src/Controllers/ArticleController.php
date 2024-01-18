<?php
    namespace BlogMvc\Controllers;

    use BlogMvc\Models\ArticleManager;
    use BlogMvc\Validator;
    class  ArticleController{
        private ArticleManager $manager;
        private Validator $validator;
    
        public function __construct() {
            $this->manager = new ArticleManager();
            $this->validator = new Validator();
        }

        //Methode pour appeler la vue insert mais seulement si on est logué, sinon redirige vers le login
        public function showInsert(): void {
            if(isset($_SESSION["user"]["id"])) {
                require VIEWS."Blog/insert.php";
            } else {
                require VIEWS."Auth/login.php";
            }
        }

        //Même chose que showInsert mais pour l'update en récupérant l'id de l'article dans l'url
        public function showUpdate(int $id): void {
            if(isset($_SESSION["user"]["id"])) {
                //Récupère les infos d'un article (Titre, Image...) en passant l'id
                $article = $this->manager->getById($id);
                require VIEWS."Blog/update.php";
            } else {
                require VIEWS."Auth/login.php";
            }
        }

        //Methode qui récupère tous les articles en bdd et retourne un tableau d'articles avant d'appeler la vue
        public function showAllArticles(): void {
            $articles = $this->manager->getAll();
            require VIEWS."Blog/affiche.php";
        }

        //Methode d'insertion d'article
        public function create(): void {
            //Tester le login et rediriger si besoin
            if (!isset($_SESSION["user"]["username"])) {
                header("Location: /login");
                die();
            }
            //Proteger le titre et commentaire
            $_POST["titre"] = escape($_POST["titre"]);
            $_POST["commentaire"] = escape($_POST["commentaire"]);
            //Valider les champs
            $this->validator->validate([
                "titre"=>["required", "min:2", "max:50", "alphaSpaceAccent"],
                "commentaire"=>["required", "min:2"]
            ]);
            //Stocker en old
            $_SESSION['old'] = $_POST;
    
            if (!$this->validator->errors()) {
                //Si validé preparer l'image pour insertion
                $imgid = $this->manager->maxId();
                $imgname = $imgid.$_FILES["img"]["name"];
                //Stocker l'image dans le dossier images
                move_uploaded_file($_FILES["img"]["tmp_name"], "../public/images/".$imgname);
                //Inserer l'article en bdd en passant le nom d'image pret pour insertion
                $this->manager->store($imgname);
                //Aller à l'affichage
                header("Location: /");
            } else {
                //Si pas validé retour à l'insertion
                header("Location: /insert/");
            }
        }

        //Methode de supression d'articles
        public function delete(int $id): void {
            //Récupère les infos d'un article en passant l'id
            $article = $this->manager->getById($id);
            //Vérifie si l'article existe
            if(isset($article)) {
                //Verifie si le mot de passe est correct
                if($article["Auteur"] === $_SESSION["user"]["id"]) {
                    //Suprime l'image du dossier images si elle existe
                    if(file_exists("../public/images/".$article["Image"])) {
                        unlink("../public/images/".$article["Image"]);
                    }
                    //Suprimme l'article en bdd
                    $this->manager->delete($id);
                }
            }
            //Redirige vers l'affichage
            header("Location: /");
        }

        //Methode de modification d'articles
        public function update(): void {
            //Verifie le login et redirige si besoin
            if (!isset($_SESSION["user"]["username"])) {
                header("Location: /login");
                die();
            }
            //Protege le titre et le commentaire
            $_POST["titre"] = escape($_POST["titre"]);
            $_POST["commentaire"] = escape($_POST["commentaire"]);
            //Valide les champs
            $this->validator->validate([
                "titre"=>["required", "min:2", "max:50", "alphaSpaceAccent"],
                "commentaire"=>["required", "min:2"]
            ]);
            //Stocke en old
            $_SESSION['old'] = $_POST;
    
            if (!$this->validator->errors()) {
                //Si validé récuperer l'ancien nom d'image
                $imgname = $_POST["imgname"];
                if(strlen($_FILES["img"]["name"]) > 0) {
                    //Si nouvelle image suprimme l'ancienne si elle existe
                    if(file_exists("../public/images/".$imgname)) {
                        unlink("../public/images/".$imgname);
                    }
                    //Prepare la nouvelle image pour insertion
                    $imgid = $this->manager->maxId();
                    $imgname = $imgid.$_FILES["img"]["name"];
                    //Stocke l'image dans le dossier images
                    move_uploaded_file($_FILES["img"]["tmp_name"], "../public/images/".$imgname);
                }
                //Modifie l'article en bdd en passant le nom d'image pret pour insertion
                $this->manager->update($imgname);
                //Redirige vers l'affichage
                header("Location: /");
            } else {
                //Si pas validé retour à la modification en passant l'id
                header("Location: /update/".$_POST["articleId"]);
            }
        }
    }
?>