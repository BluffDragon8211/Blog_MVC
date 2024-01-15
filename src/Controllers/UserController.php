<?php
    namespace BlogMvc\Controllers;

    use BlogMvc\Models\UserManager;
    use BlogMvc\Validator;
    class UserController {
        private $manager;
        private $validator;

        public function __construct() {
            $this->manager = new UserManager();
            $this->validator = new Validator();
        }

        public function showLogin() {
            require VIEWS . 'Auth/login.php';
        }

        public function showRegister() {
            require VIEWS . 'Auth/register.php';
        }

        public function logout()
        {
            session_start();
            session_destroy();
            header('Location: /login/');
        }

        public function register() {
            $this->validator->validate([
                "username"=>["required", "min:3", "alphaNum"],
                "password"=>["required", "min:6", "alphaNum", "confirm"],
                "passwordConfirm"=>["required", "min:6", "alphaNum"]
            ]);
            $_SESSION['old'] = $_POST;

            if (!$this->validator->errors()) {
                $res = $this->manager->find($_POST["username"]);

                if (empty($res)) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $this->manager->store($password);

                    $_SESSION["user"] = [
                        "id" => $this->manager->getBdd()->lastInsertId(),
                        "username" => $_POST["username"]
                    ];
                    header("Location: /");
                } else {
                    $_SESSION["error"]['username'] = "Le username choisi est déjà utilisé !";
                    header("Location: /register");
                }
            } else {
                header("Location: /register");
            }
        }

        public function login() {
            $this->validator->validate([
                "username"=>["required", "min:3", "max:9", "alphaNum"],
                "password"=>["required", "min:6", "alphaNum"]
            ]);

            $_SESSION['old'] = $_POST;

            if (!$this->validator->errors()) {
                $res = $this->manager->find($_POST["username"]);

                if ($res && password_verify($_POST['password'], $res->getMotdepasse())) {
                    $_SESSION["user"] = [
                        "id" => $res->getId_auteur(),
                        "username" => $res->getLogin()
                    ];
                    header("Location: /");
                } else {
                    $_SESSION["error"]['message'] = "Une erreur sur les identifiants";
                    header("Location: /login");
                }
            } else {
                header("Location: /login");
            }
        }
    }
?>