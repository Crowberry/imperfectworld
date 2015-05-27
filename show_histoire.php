<?php 
	//on affiche toutes les histoire racontées sur ce dessin 
	
	//depuis pageimage, on récupère le tableau des histoires
	//s'il est rempli, donc qu'il y a des histoires
	if (!empty($result_hist)) {
		//pour chaque résultat retourné
		foreach ($result_hist as $key => $hist) {
			
			//on récupère dans des variables les informations qui nous intéressent
			$id = $hist['id']; 
			$texte = $hist['texte']; 
			$auteur = $hist['auteur']; 
			$date_hist = $hist['date_hist'];

			//on récupère l'user et son avatar lié à ladite histoire
			$query = "SELECT avatar, username
	            FROM users
	            WHERE id = :id
	            LIMIT 1";

		    $preparedStatement = $connexion->prepare($query);
		    $preparedStatement->execute(array(':id' => $auteur));
		    
		    $result = $preparedStatement->fetch();

		    //on récupère les informations dans des var
		    $avatar = $result['avatar'];
		    $username = $result['username'];

		    //on prépare un p pour savoir si l'utilisateur qui a posté ladite histoire n'a pas supprimé son compte
		    if (!empty($result)) {
		    	//s'il existe toujours, on affiche qui c'est
		    	$postepar = "<p class='auteur'><span>Posté par</span> : ".$username."<img src='avatar_min/".$avatar."'></p>";
		    }
		    else {
		    	//s'il n'existe plus, on le dit
		    	$postepar = "<p class='auteur noexist'><span>Celui qui a posté n'existe plus</span></p>";
		    }

		    
		    //on affiche le li avec l'histoire, par qui et quand elle a été postée
		    //on lui donne un id correspondant à son id de bdd pour faire une ancre au moment du post
			echo "<li id='panN".$id."'>
					<p class='pan_hist'>".$texte."</p>"
					.$postepar.
					"<p class='date_post'><span>Le</span> : ".$date_hist."</p>
				</li>";
		}
	}
	else {
		//si aucune histoire n'a été écrite, on le dit
		echo "<li class='no_hist'>Personne n'a encore posté d'histoire pour ce dessin.<br>Soit la première personne à le faire :)</li>";
	}

	


?>