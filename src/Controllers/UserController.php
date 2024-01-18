<?php
    namespace BlogMvc\Controllers;

    use BlogMvc\Models\UserManager;
    use BlogMvc\Validator;
    class UserController {
        private UserManager $manager;
        private Validator $validator;

        public function __construct() {
            $this->manager = new UserManager();
            $this->validator = new Validator();
        }

        //Methode qui appele la vue login si on est pas logué
        public function showLogin(): void {
            if(!isset($_SESSION["user"]["id"])) {
                require VIEWS . 'Auth/login.php';
            } else {
                header("Location: /");
            }
        }

        //Methode qui appelle la vue register si on est pas logué
        public function showRegister(): void {
            if(!isset($_SESSION["user"]["id"])) {
                require VIEWS . 'Auth/register.php';
            } else {
                header("Location: /");
            }
        }

        //Methode qui suprime la session
        public function logout(): void {
            session_start();
            session_destroy();
            header('Location: /login/');
        }

        //Methode pour se register
        public function register(): void {
            //Valide les champs
            $this->validator->validate([
                "username"=>["required", "min:3", "alphaNum"],
                "password"=>["required", "min:6", "alphaNum", "confirm"],
                "passwordConfirm"=>["required", "min:6", "alphaNum"]
            ]);
            //Stocke en old
            $_SESSION['old'] = $_POST;

            if (!$this->validator->errors()) {
                //Si validé recherche d'utilisateur avec le même nom
                $res = $this->manager->find($_POST["username"]);

                if (empty($res)) {
                    //Si pas de même nom cryptage du mot de passe
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    //Insertion du nouvel utilisateur
                    $this->manager->store($password);
                    //Redirection vers le login
                    header("Location: /login/");
                } else {
                    //Si même nom alors erreur
                    $_SESSION["error"]['username'] = "Le username choisi est déjà utilisé !";
                    //Retour vers register
                    header("Location: /register");
                }
            } else {
                //Si pas validé retour vers register
                header("Location: /register");
            }
        }

        //Methode de login
        public function login(): void {
            //Valide les champs
            $this->validator->validate([
                "username"=>["required", "min:3", "max:9", "alphaNum"],
                "password"=>["required", "min:6", "alphaNum"]
            ]);
            //Stocke en old
            $_SESSION['old'] = $_POST;

            if (!$this->validator->errors()) {
                //Si validé chercher si même nom qu'en bdd
                $res = $this->manager->find($_POST["username"]);

                if ($res && password_verify($_POST['password'], $res->getMotdepasse())) {
                    //Si pas même nom stockage des donnés de user en session
                    $_SESSION["user"] = [
                        "id" => $res->getId_auteur(),
                        "username" => $res->getLogin()
                    ];
                    //Redirection affichage
                    header("Location: /");
                } else {
                    //Si même nom erreur
                    $_SESSION["error"]['message'] = "Une erreur sur les identifiants";
                    //Retour login
                    header("Location: /login");
                }
            } else {
                //Si pas validé retour login
                header("Location: /login");
            }
        }
    }
?>