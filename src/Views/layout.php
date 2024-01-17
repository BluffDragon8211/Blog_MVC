<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>— ToDoList —</title>
    <script src="https://kit.fontawesome.com/c1d0ab37d6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <header>
        <nav>
            <?php
                //Affiche une nav avec des options differentes suivant le login
                if (!isset($_SESSION["user"]["username"])) {
                    ?>
                        <a href="/" class="logo">LOGO</a>
                        <div class="hoverLink">
                            <a href="/" class="icon"><i class="fas fa-home"></i></a>
                            <p class="hidden">Accueil</p>
                        </div>

                        <div class="hoverLink">
                            <a href="/login" class="icon"><i class="fas fa-user-tie"></i></a>
                            <p class="hidden">Login</p>
                        </div>
                    <?php
                } else {
            ?>
                <a href="/" class="logo">LOGO</a>
                <div class="hoverLink">
                    <a href="/" class="icon"><i class="fas fa-home"></i></a>
                    <p class="hidden">Accueil</p>
                </div>

                <div class="hoverLink">
                    <a href="/insert/" class="icon"><i class="fas fa-plus"></i></a>
                    <p class="hidden">Ajouter</p>
                </div>

                <div class="hoverLink">
                    <p class="icon"><i class="fas fa-user"></i></p>
                    <p class="hidden"><?php echo $_SESSION["user"]["username"]; ?></p>
                </div>

                <div class="hoverLink">
                    <a href="/logout" class="icon"><i class="fas fa-power-off"></i></a>
                    <p class="hidden">Logout</p>
                </div>
            <?php
                }
            ?>
        </nav>
    </header>

    <main>
        <?php echo $content;/*Affiche les vues*/?>
    </main>
</body>
</html>
<?php
unset($_SESSION['error']);
unset($_SESSION['old']);
