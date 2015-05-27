<?php 
    //entrer les histoires dans la bdd
    
    //déclaration d'un tableau d'erreurs
	$errors_hist = array();
    //on récupère l'image concerné
	$image = $_GET['dessin'];

	if($_POST['histoires']){
		//on récupère le texte du textarea et on tient compte de retours à la ligne
        //on prépare l'id de l'utilisateur et le moment où il fait ça 
		$texte = nl2br(trim(strip_tags($_POST['texte'])));
		$auteur = $_SESSION['id'];
		$date_hist = $date;

		if($_POST['texte'] == ''){
            $errors_hist['texte'] = "<p class='error_message'>Tu n'as conté aucune histoire.</p>";
        }

        //on vérifie si l'histoire rentrée par l'utilisateur n'a pas déjà été racontée
        $query = "SELECT * 
                FROM histoires
                WHERE texte = :texte
                LIMIT 1";

        $preparedStatement = $connexion->prepare($query);
        $preparedStatement->execute(array(':texte' => $texte));
        
        $result = $preparedStatement->fetch();

        //si elle a déjà été racontée
        if (!empty($result)) {
            $errors_hist['texte'] = "<p class='error_message'>Cette histoire à déjà été racontée.</p>";
        }
        //sinon, si il n'y a pas eu d'erreurs
        else if (count($errors_hist) == 0) {
            //on entre dans la bdd l'histoire qui vient d'être racontée
        	$query = "INSERT
                        INTO histoires (texte, auteur, image, date_hist)
                        VALUE (:texte, :auteur, :image, :date_hist)";
            $params = array(
                        ':texte' => $texte,
                        ':auteur' => $auteur,
                        ':image' => $image,
                        ':date_hist' => $date_hist
                    );
            $preparedStatement = $connexion->prepare($query);
            $preparedStatement->execute($params);
            
            //on selection l'id de l'histoire pour pouvoir la mettre en ancre
            $query = "SELECT id
            			FROM histoires
            			WHERE texte = :texte
            			LIMIT 1";

		    $preparedStatement = $connexion->prepare($query);
		    $preparedStatement->execute(array(':texte' => $texte));
		    $result = $preparedStatement->fetch();

		    $id = $result['id'];

            header('location: index.php?dessin='.$image."&&send=yes#panN".$id);
            exit();
        }


    }

?>