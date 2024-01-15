<?php
    ob_start();
?>
<form action="/insert/" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <p>Titre: <input type="text" name="titre" value="" autocomplete="off"></p>
    <span class="error"><?php echo error("titre");?></span>
    <br />
    <p>Commentaire: <textarea name="commentaire" cols="100" rows="10" autocomplete="off" value=""></textarea>
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