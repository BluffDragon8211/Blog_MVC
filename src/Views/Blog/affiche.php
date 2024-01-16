<?php
    ob_start();
    foreach ($articles as $article) {
        ?>
            <article>
                <h2><?=$article->getTitre();?></h2>
                <?php
                    $date = new DateTime($article->getDate());
                ?>
                <p><?=$date->format("d-m-Y");?></p>
                <p>Auteur: <?=$article->getAuteurName();?></p>
                <img src="<?=IMAGES.$article->getImage();?>" alt="Image <?=$article->getImage();?>">
                <p><?=$article->getDescription();?></p>
                <?php
                    if(isset($_SESSION["user"])) {
                        if($_SESSION["user"]["id"] === $article->getAuteur()) {
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