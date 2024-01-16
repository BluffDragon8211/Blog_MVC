<?php
    ob_start();
?>
<h2>Ajouter un article</h2>
<form action="/insert/" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <p>Titre: <input type="text" name="titre" value="<?=old("titre");?>" autocomplete="off"></p>
    <span class="error"><?php echo error("titre");?></span>
    <br />
    <p>Commentaire: <textarea name="commentaire" cols="100" rows="10" autocomplete="off" value="<?=old("commentaire");?>"></textarea>
    <span class="error"><?php echo error("commentaire");?></span>
    <br />
    <p>Image: <input type="file" name="img" value="" required></p>
    <span class="error"><?php echo error("img");?></span>
    <br />
    <input type="submit" name="ok" value="Envoyer">
</form>
<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';