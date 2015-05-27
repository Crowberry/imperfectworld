<?php 
	//on affiche le bouton favoris 
	
	//si l'utilisateur est connecté
	if ($_SESSION['logged'] == 'ok') {

		//on vérifie si le dessin est déjà dans la bdd en le selectionnant
		$query_fav = "  SELECT user, image
			            FROM favoris
			            WHERE user = :user && image = :image
			            LIMIT 1";
	    $preparedStatement = $connexion->prepare($query_fav);
	    $preparedStatement->execute(array(
	                                ':user' => $userid,
	                                ':image' => $image
	                                ));
	    $result_fav = $preparedStatement->fetchAll();

	    //si il y a déjà le dessin enregistré en favoris
	    if(!empty($result_fav)){
	    	//on affiche le bouton en état "actif" avec le lien pour pouvoir l'enlever
	    	$class = 'fav';
	    	echo "<a href='index.php?dessin=".$image."&&fav=no' class='coeur ".$class."'>Ajouter aux favoris</a>";
	    }
	    else {
	    	//on affiche le bouton en état normal avec le lien pour pouvoir l'ajouter
	    	echo "<a href='index.php?dessin=".$image."&&fav=yes' class='coeur'>Ajouter aux favoris</a>";
	    }
	}
	else {
		//si l'utilisateur n'est pas connecté, en l'envoie vers une ancre qui l'invite à s'identifier
		echo "<a href='index.php?dessin=".$image."#seco_image' class='coeur'>Ajouter aux favoris</a>";
	}

	

    
?>

