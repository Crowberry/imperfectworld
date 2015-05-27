<!-- formulaire qui permet à l'utilisateur d'uploader son avatar -->

<form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
	<label for='avatar' id="labav">Choisis une image de profil:</label>
	<input type="file" name="avatar" id="avatar"/>
    <?php
        echo message_erreur($errors, 'avatar');
    ?>
    <input type="submit" value="upload" name="upload_av" class='btn btn-primary'/>
</form>