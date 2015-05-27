<?php
	//suppression d'un compte

	include 'database.php';

	$id = $_SESSION['id'];

	//on supprime son avatar dans le dossier avatar
	$query = "SELECT avatar 
	        FROM users
	        WHERE id = :id
	        LIMIT 1";

	$preparedStatement = $connexion->prepare($query);
	$preparedStatement->execute(array(':id' => $id));

	$result = $preparedStatement->fetch();
	$avatar = $result['avatar'];

	//on vérifie qu'il ne s'agit pas de l'avatar par défaut
	if ( $avatar != 'avatar_original.png') {
		unlink('avatar/'.$avatar);
		unlink('avatar_min/'.$avatar);
	}

	//on supprimes ses favoris dans la dbb
	$query = "  DELETE 
	            FROM favoris
	            WHERE user = :user";

	$preparedStatement = $connexion->prepare($query);
	$preparedStatement->execute(array(':user' => $id));

	//on sort son index des histoires (mais on les garde quand même)
	$query = "  UPDATE histoires
	            SET auteur = :supressed
	            WHERE auteur = :auteur ";
	$params = array(
	            ':supressed' => 0,
	            ':auteur' => $id
	        );
	$preparedStatement = $connexion->prepare($query);
	$preparedStatement->execute($params);

	//on supprime le compte de l'utilisateur
	$query = "  DELETE 
	            FROM users
	            WHERE id = :id";

	$preparedStatement = $connexion->prepare($query);
	$preparedStatement->execute(array(':id' => $id));

	//on appelle enfin le logout pour réinitialiser la session
	include 'logout.php';

?>