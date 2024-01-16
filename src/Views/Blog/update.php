<?php
    ob_start();
?>
<h2>Modifier l'article</h2>
<form action="/update/" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <input type="hidden" name="articleId" value="<?=old("articleId") ? old("articleId") :$article["Id"];?>">
    <input type="hidden" name="imgname" value="<?=old("imgname") ? old("imgname") : $article["Image"];?>">
    <p>Titre: <input type="text" name="titre" value="<?= old("titre") ? old("titre"): $article["Titre"];?>" autocomplete="off"></p>
    <span class="error"><?php echo error("titre");?></span>
    <br />
    <p>Commentaire: <textarea name="commentaire" cols="100" rows="10" autocomplete="off" value=""><?=old("commentaire") ? old("commentaire") :$article["Description"];?></textarea>
    <span class="error"><?php echo error("commentaire");?></span>
    <br />
    <p>Image: <input type="file" name="img" value=""></p>
    <span class="error"><?php echo error("img");?></span>
    <br />
    <input type="submit" name="ok" value="Envoyer">
</form>
<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';