<?php
    ob_start();
    foreach ($articles as $article) {
        ?>
            <article>
                <h2><?=$article->getTitre();?></h2>
                <p><?=$article->getDescription();?></p>
                <img src="<?=IMAGES.$article->getImage();?>" alt="Image <?=$article->getImage();?>">
            </article>
        <?php
    }
?>
<?php
    $content = ob_get_clean();
    require VIEWS . 'layout.php';
?>