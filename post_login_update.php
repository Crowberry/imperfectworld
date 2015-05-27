<?php 
    //traitement des post pour la création, connection, et modification d'un compte

    //on prépare un tableau d'erreurs pour les forms
    $errors = array();
    $image = $_GET['dessin'];

/*------------------------------- INSCRIPTION___________________________________________________________________________________*/
    if(count($_POST['inscription']) > 0){
        //on récupère les valeurs rentrées dans le form
        $username = trim(strip_tags($_POST['username']));
        $email = trim(strip_tags($_POST['email']));
        $mdp = trim(strip_tags($_POST['mdp']));
        //on dit l'heure à laquelle l'utilisateur a fait cette action
        $last_co = $date;
        
        //Préparation des messages d'erreur, on vérifie si les champs sont bien remplis
        
        if($_POST['username'] == ''){
            $errors['username'] = "<p class='error_message'>Eh! Tu n'as pas indiqué ton nom d'utilisateur!</p>";
        }
        if($_POST['mdp'] == ''){
            $errors['mdp'] = "<p class='error_message'>Tu n'as pas entré de mot de passe.</p>";
        }
        if(is_valid_email($email) == false){
            $errors['email'] = "<p class='error_message'>Cette adresse e-mail est invalide.</p>";
        }

        
        //On compare le pseudo et l'email rentré par l'utilisateur avec ceux de la banque de donnée
        //on prépare un tableau avec les deux valeurs de l'utilisateur à rechercher dans la bdd
        $compare = array($username, $email);
        //Récupération du pseudo et de l'email dans la bdd
        $query = "  SELECT username, email
                    FROM users
                    WHERE username = :username || email = :email
                    LIMIT 2";
        $preparedStatement = $connexion->prepare($query);
        $preparedStatement->execute(array(
                                    ':username' => $username,
                                    ':email' => $email
                                    ));
        $result = $preparedStatement->fetchAll();

        //Si le tableau retourne un résultat, donc que l'email ou user existe déjà
        if(!empty($result)){
            //si l'email et/ou le pseudo est dans le premier tableau retourné
            $compare_rech = array_intersect($result[0], $compare);
            if(in_array($username, $compare_rech)) {
                $errors['username_pris'] = "<p class='error_message'>Oups! Ce nom d'utilisateur est déjà utilisé par un autre utilisateur.</p>";
            }
            if(in_array($email, $compare_rech)) {
                $errors['email_pris'] = "<p class='error_message'>Cette adresse e-mail est déjà associée à un compte.</p>";
            }
            
            //on vérifie si un deuxième tableau existe, et on vérifie si l'email est déjà là 
            if(array_key_exists(1, $result) == true){
                $compare_rech = array_intersect($result[1], $compare);
                if(in_array($username, $compare_rech)) {
                $errors['username_pris'] = "<p class='error_message'>Oups! Ce nom d'utilisateur est déjà utilisé par un autre utilisateur.</p>";
                }
                if(in_array($email, $compare_rech)){
                    $errors['email_pris'] = "<p class='error_message'>Cette adresse e-mail est déjà associée à un compte.</p>";
                }
            }
        //si le tableau retourné est vide, et qu'il n'y a pas de message d'erreur  
        }
        else if(count($errors) == 0){
            
        
           //envoyer le message de confirmation
           $mdp_crypte = preg_replace('/[a-zA-Z0-9]/', '*', $mdp);
           $line1 = "Ton compte sur 'An Imperfect World' a bien été créé :";
           $line2 = "Ton nom d'utilisateur : ".$username;
           $line3 = "Ton adresse e-mail : ".$email." (sans blague)";
           $line4 = "Ton mot de passe : ".$mdp_crypte." (toi seul le connais)";
           $line5 = "Merci pour l'attention que tu portes à ce projet :) .";
           $line6 = "On se revoit sur http://manuel-ortiz.com/imperfectworld/ .";
           $line7 = "Crowberry";
           $message = $line1."\r\n\r\n".$line2."\r\n".$line3."\r\n".$line4."\r\n\r\n".$line5."\r\n".$line6."\r\n\r\n".$line7;   
           $sujet = "An imperfect world / création de compte";
           $resultEmail = mail($email, $sujet, $message);

           //si l'email est envoyé
           if($resultEmail){

            //on entre ces informations dans la bdd
            $query = "INSERT
                    INTO users (username, mdp, email, avatar, statut, last_co)
                    VALUE (:username, :mdp, :email, :avatar, :statut, :last_co)";
            //Executer écriture
            $params = array(
                        ':username' => $username,
                        ':mdp' => $mdp,
                        ':email' => $email,
                        ':avatar' => 'avatar_original.jpg',
                        ':statut' => 'visit',
                        ':last_co' => $last_co
                    );
            $preparedStatement = $connexion->prepare($query);
            $preparedStatement->execute($params);
                $_SESSION['logged'] = 'ok';
                $_SESSION['user'] = $username;
                if ($_GET['dessin'] == '') {
                    header('location: index.php');
                }
                else{
                    header('location: index.php?dessin='.$image);
                }
                exit();
           }
        }
    }



/*----------------------------------------------------------CONNEXION---------------------------------------------------------------------------*/

    if(count($_POST['connexion']) > 0){
        //on récupère les données du formulaire
        $username_co = trim(strip_tags($_POST['username_co']));
        $mdp_co = trim(strip_tags($_POST['mdp_co']));
        

        //on vérifie que les champs sont bien remplis
        if($_POST['username_co'] == ''){
            $errors['username_co'] = "<p class='error_message'>Tu n'as pas tapé de nom d'utilisateur!</p>";
        }
        if($_POST['mdp_co'] == ''){
            $errors['mdp_co'] = "<p class='error_message'>Tu as oublié de rentrer ton mot de passe.";
        } 
        
        //on vérifie si le le nom d'utilisateur ET son mot de passe sont bien à la même ligne dans la bdd
        $query = "SELECT username, mdp
                    FROM users
                    WHERE username = :username || email = :username && mdp = :mdp";
        $preparedStatement = $connexion->prepare($query);
        $preparedStatement->execute(array(':username' => $username_co,':mdp' => $mdp_co));
        $result = $preparedStatement->fetch();
        
        //si le tableau retourné est correctement rempli
        if(!empty($result)){
            //on log la session
            $_SESSION['logged'] = 'ok';
            $_SESSION['user'] = $result['username'];
            if ($_GET['dessin'] == '') {
                header('location: index.php');
            }
            else{
                header('location: index.php?dessin='.$image);
            }
            exit();
        }
        //sinon, c'est que le mot de passe ou l'username est incorrect
        else if(count($errors) < 1){
            $errors['rate'] = "<p class='error_message'>Ton email et/ou ton mot de passe est incorrect, désolé.</p>";
        }
    }



/*-------------------------------------------------------------------UPDATE------------------------------------------------------------*/

    if(count($_POST['update']) > 0) {
        $username_mo = trim(strip_tags($_POST['username_mo']));
        $email_mo = trim(strip_tags($_POST['email_mo']));
        $mdp_mo = trim(strip_tags($_POST['mdp_mo']));
        $compare_mo = array($username_mo, $email_mo);
        
        //Nettoyage
        if($_POST['username_mo'] == ''){
            $errors['username_mo'] = "<p class='error_message'>Tu dois indiquer un nom.</p>";
        }
        if($_POST['mdp_mo'] == ''){
            $errors['mdp_mo'] = "<p class='error_message'>Tu dois choisir un mot de passe.</p>";
        }        
        if(is_valid_email($email_mo) == false){
            $errors['email_mo'] = "<p class='error_message'>Cet e-mail n'est pas valide</p>";
         }
        
        //Comparaison pseudo
        //Récupérer pseudo
        $query_mo = "  SELECT username, email
                    FROM users
                    WHERE username = :username || email = :email
                    LIMIT 2";
        //Préparer lecture
        $preparedStatement = $connexion->prepare($query_mo);
        $preparedStatement->execute(array(':username' => $username_mo,':email' => $email_mo));
        //Lire
        $result_mo = $preparedStatement->fetchAll();
        //Vérification pseudo-email identique
        if(!empty($result_mo)){
            $compare_rech_mo = array_intersect($result_mo[0], $compare_mo);
            //Deux valeurs dans le même tableau
            if(in_array($username_mo, $compare_rech_mo)){
                //Comparer entre le pseudo initial et modifié
                if($username_mo != $usernameInit){
                    $errors['username_mo_pris'] = "<p class='error_message'>Ce nom est déjà pris :/</p>";
                }
            }
            if(in_array($email_mo, $compare_rech_mo)){
                if($email_mo != $emailInit){
                    
                    $errors['email_mo_pris'] = "<p class='error_message'>Cet e-mail est déjà associé à un compte :o</p>";
                }
            }
            //Deux valeurs dans deux tableaux différents
            //Si deuxième tableau = deux emails identique
            if(array_key_exists(1, $result_mo) == true){
                $compare_rech_mo = array_intersect($result_mo[1], $compare_mo);
                if(in_array($username_mo, $compare_rech_mo)){
                    if($username_mo != $usernameInit){
                        $errors['username_mo_pris'] = "<p class='error_message'>Ce nom est déjà pris :/</p>";
                    }
                }
                if(in_array($email_mo, $compare_rech_mo)){
                    if($email_mo != $emailInit){
                        
                        $errors['email_mo_pris'] = "<p class='error_message'>Cet e-mail est déjà associé à un compte :o</p>";
                    }
                }
            }  
        }
        if(count($errors) == 0){
            //envoyer le message de confirmation
           $mdp_crypte = preg_replace('/[a-zA-Z0-9]/', '*', $mdp_mo);
           $line1 = "Les modifications de ton compte sur 'An Imperfect World' ont bien été prises en compte :";
           $line2 = "Ton nom d'utilisateur : ".$username_mo;
           $line3 = "Ton adresse e-mail : ".$email_mo." (sans blague)";
           $line4 = "Ton mot de passe : ".$mdp_crypte_mo." (toi seul le connais)";
           $line5 = "Merci pour l'attention que tu continues de porter à ce projet :) .";
           $line6 = "On se recroise sur http://manuel-ortiz.com/imperfectworld/ .";
           $line7 = "Crowberry";
           $message = $line1."\r\n\r\n".$line2."\r\n".$line3."\r\n".$line4."\r\n\r\n".$line5."\r\n".$line6."\r\n\r\n".$line7;   
           $sujet = "An imperfect world / modification de compte";
           $resultEmail = mail($email_mo, $sujet, $message);

           //si l'email est envoyé
           if($resultEmail){
                //Si tout va bien (ouf) on update ces nouvelles données
                $query = "  UPDATE users
                            SET username = :username,
                                email = :email,
                                mdp = :mdp
                            WHERE id = :id ";
                $params = array(
                            ':username' => $username_mo,
                            ':email' => $email_mo,
                            ':mdp' => $mdp_mo,
                            ':id' => $id
                        );
                $preparedStatement = $connexion->prepare($query);
                $preparedStatement->execute($params);


                $_SESSION['user'] = $username_mo;
                //on vérifie si on est sur l'accueil ou une page dessin
                //on envoie une var dans l'url pour dire que la modification s'est bien effectuée
                if ($_GET['dessin'] == '') {
                    header('location: index.php?act=update&&update=yes');
                }
                else{
                    header('location: index.php?dessin='.$image."&&act=update&&update=yes");
                }
                exit();
            }
        }
    }



?>