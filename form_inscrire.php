<!-- form pour que l'utilisateur se crée un compte  -->

<section>
    <form method="POST">
        <ol>
            <li>
                <label for="username">Entre ton nom d'utilisateur :</label><br>
                <input type="text" value="<?php echo $username ?>" name="username"/><br>
                <?php 
                    echo message_erreur($errors, 'username');
                    echo message_erreur($errors, 'username_pris');
                ?>
            </li>
            <li>
                <label for="email">Précise ton adresse e-mail :</label><br>
                <input type="text" value="<?php echo $email ?>" name="email"/><br>
                <?php 
                    echo message_erreur($errors, 'email'); 
                    if($errors['email_pris'] != ''){
                        echo $errors['email_pris'];                        
                    }
                 ?>
            </li>
            <li>
                <label for="mdp">Choisis un mot de passe</label><br>
                <input type="password" value="<?php echo $mdp ?>" name="mdp"/><br>
                <?php echo message_erreur($errors, 'mdp') ?>
            </li>
            <li>Un e-mail contenant tes données te sera envoyé.</li>
            <li>
                <input class="btn btn-primary" type="submit" name="inscription"/>
            </li>
        </ol>
    </form>
</section>