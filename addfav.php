<?php
	//ajouter les favoris dans la bdd
	
	//si l'url renvoyé par le clique du bouton fav est yes
	if ($_GET['fav'] == 'yes') {
		//on entre dans la bdd le nom de l'image concerné, l'id de l'utilisateur qui l'a fait, et quand (utile surement un jour pour cette dernière)
		$query = "INSERT
                    INTO favoris (image, user, date_fav)
                    VALUE (:image, :user, :date_fav)";
        //Executer écriture
        $params = array(
                    ':image' => $image,
                    ':user' => $userid,
                    ':date_fav' => $date
                );
        $preparedStatement = $connexion->prepare($query);
        $preparedStatement->execute($params);

        //on renvoie à la page du dessin
        header('location: index.php?dessin='.$image);
        exit();

	}
	else if ($_GET['fav'] == 'no') {
		//si "no", on enlève le favori de la bdd
		$query = "  DELETE 
		            FROM favoris
		            WHERE user = :user && image = :image";

		$preparedStatement = $connexion->prepare($query);
		$preparedStatement->execute(array(
                                ':user' => $userid,
                                ':image' => $image
                                ));

		//on renvoie à la page du dessin
		header('location: index.php?dessin='.$image);
        exit();
	}

?>