<!-- formulaire qui permet à l'utilisateur d'updater ses infos -->

<?php 
    //on rappelle la methode pour que les autres post n'interfèrent pas
    include "post_login_update.php" ?>


<section id="modification">
   <h4>Mes données utilisateurs :</h4>
    <form  method="post" enctype="multipart/form-data">
        <ol>
            <li>
                <label for="username_mo">Nouveau nom :</label><br>
                <input type="text" value="<?php echo $usernameInit ?>" name="username_mo"/><br>
                <?php 
                    echo message_erreur($errors, 'username_mo');
                    if($errors['username_mo_pris'] != ''){
                        echo $errors['username_mo_pris'];
                    }
                ?>
            </li>
            <li>
                <label for="email_mo">Nouvel e-mail :</label><br>
                <input type="text" value="<?php echo $emailInit ?>" name="email_mo"/><br>
                    <?php 
                    echo message_erreur($errors, 'email_mo');
                    if($errors['email_mo_pris'] != ''){
                        echo $errors['email_mo_pris'];                        
                    }
                ?>
            </li>
            <li>
                <label for="mdp_mo">Nouveau mot de passe :</label><br>
                <input type="password" value="<?php echo $mdpInit ?>" name="mdp_mo"/><br>
                    <?php echo message_erreur($errors, 'mdp_mo') ?>
            </li>
            <li>
                <input type="submit" class="btn btn-primary" value="enregistrer" name="update"/>
            </li>
             <?php 
                //on affiche le message de réussite se lon variable de l'url
                if ($_GET['update'] == "yes") {
                    echo "<li class='clear'><p class='act_reussi'>Tes modifications ont bien été prises en compte, easy.</p><li>";
                }
            ?>
            <li><a href="index.php" class="fermer">Fermer</a></li>
           
        </ol>
    </form>
    <!--end form data-->
</section>
<!--end section-->