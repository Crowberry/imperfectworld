<?php
    //fonctions utiles

    //validation de l'email
    function is_valid_email($email){
        return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    }

    //affichage des erreurs
    function message_erreur($errors, $input){
        if($_POST){
            if ($errors[$input] != '') {
                return '<p class="error_message">'.$errors[$input].'</p>';
            }
        }
    }

    //obtenir extension d'une image
    function get_ext($file) {
        return strtolower(substr(strrchr($file['name'], '.'), 1));
    }

?>