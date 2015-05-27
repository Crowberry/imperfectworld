<?php 
	//afficher les favoris de l'utilisateur

	//on récupère les images que l'utilisateur a mis en favoris
	$query_mesfavs = "SELECT image 
			            FROM favoris
			            WHERE user = :user";

    $preparedStatement = $connexion->prepare($query_mesfavs);
    $preparedStatement->execute(array(':user' => $userid));
    $result_mesfavs = $preparedStatement->fetchAll();
    
    //si l'user a effectivement des favoris
    if (!empty($result_mesfavs)) {
    	//pour chaque résultat, on affiche le li a avec la miniature correspondant au dessin
    	foreach ($result_mesfavs as $fav) {
	    	$img = $fav['image'];
	    	echo "<li>
	    			<a href='index.php?dessin=".$img."'><img src='dessins/favoris/".$img."'></a>
	    		</li>";
	    }
    }
    else {
    	//sinon, on lui dit qu'il n'a pas de favoris
    	echo "<li>Tu n'as encore aucun favori.</li>";
    }

    
    

?>