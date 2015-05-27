<?php 
	//afficher les histoires où l'utilisateur a écrit
	
	//on sélectionne les toutes les images où l'utilisateur est enregistré pour y avoir écrit une histoire
	$query_meshist = "SELECT image 
			            FROM histoires
			            WHERE auteur = :auteur";

    $preparedStatement = $connexion->prepare($query_meshist);
    $preparedStatement->execute(array(':auteur' => $userid));
    $result_meshist = $preparedStatement->fetchAll();

    //on crée un tableau qui récupère les valeurs uniques, le tableau original pouvant avoir plusieurs fois la même image retenue
    $unique_meshist = array_unique($result_meshist, SORT_REGULAR);

    //si il y a effectivement des histoires associées à son compte
    if (!empty($unique_meshist)) {
    	//pour chaque résultat onn affiche un li avec le lien vers l'image contenant la miniature du dessin en question
    	foreach ($unique_meshist as $his) {
	    	$img = $his['image'];
	    	echo "<li>
	    			<a href='index.php?dessin=".$img."'><img src='dessins/favoris/".$img."'></a>
	    		</li>";
	    }
    }
    else {
    	//si il n'y a aucune histoire, on le dit
    	echo "<li>Tu n'as raconté encore aucune histoire.</li>";
    }

    
    

?>