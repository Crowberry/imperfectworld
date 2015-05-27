<!-- formulaire pour se connecter, qui va être traité avec post_login_update -->

<section>
    <form method="post">
        <ol>
            <li>
                <label for="username_co">Nom d'utilisateur ou e-mail :</label><br>
                <input type="text" value="<?php echo $username_co ?>" name="username_co"/><br>
                <?php echo message_erreur($errors, 'username_co'); ?>
            </li>
            <li>

                <label for="mdp_co">Mot de passe :</label><br>
                <input type="password" value="<?php echo $mdp_co ?>" name="mdp_co"/><br>
                <?php 
                    echo message_erreur($errors, 'mdp_co');
                    if($errors['rate'] != ''){
                        echo $errors['rate'];
                    }
                ?>
            </li>
            <li>
                <input class="btn btn-primary" type="submit" name="connexion" value="Se connecter"/>
            </li>
        </ol>
    </form>
</section>