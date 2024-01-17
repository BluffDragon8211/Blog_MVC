<?php
    ob_start();
    //Boucle sur tous les articles de la bdd (le tableau qui a été return)
    foreach ($articles as $article) {
        ?>
            <article>
                <h2><?=$article->getTitre();?></h2>
                <?php
                    //Cree un DateTime depuis la string de la bdd...
                    $date = new DateTime($article->getDate());
                ?>
                <p><?=/*Pour avoir la methode format()*/$date->format("d-m-Y");?></p>
                <p>Auteur: <?=$article->getAuteurName();?></p>
                <img src="<?=IMAGES.$article->getImage();?>" alt="Image <?=$article->getImage();?>">
                <p><?=$article->getDescription();?></p>
                <?php
                    //Verifie le login
                    if(isset($_SESSION["user"])) {
                        //Si oui est-ce que c'est le même auteur ?
                        if($_SESSION["user"]["id"] === $article->getAuteur()) {
                            //Si oui affiche les boutons de modification et suppression
                            ?>
                                <div>
                                    <a href="/update/<?=$article->getId()?>" class="icon yellow"><i class="fas fa-pen"></i></a>
                                    <a href="/delete/<?=$article->getId()?>" class="icon red"><i class="fas fa-trash"></i></a>
                                </div>
                            <?php
                        }
                    }
                ?>
            </article>
        <?php
    }
?>
<?php
    $content = ob_get_clean();
    require VIEWS . 'layout.php';
?>