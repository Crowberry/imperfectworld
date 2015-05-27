<?php 
    //methode pour les upload d'avatar 
/*________________________________________________________________AVATAR____________________________________________*/

	if (count($_FILES['avatar']) > 0 ) {

		$document = new Upload($_FILES['avatar']); 
        //on prépare un tableau d'extensions valide
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png', 'JPG' );
        $extension_fichier = get_ext($_FILES['avatar']); //on récupère l'extension du fichier
        //préparer ne nom de l'image complet pour l'updater dans la bdd
        $nameImg = 'avatar'.$id.'.'.$extension_fichier;

        //On vérifie si l'extension est acceptée
        if(in_array($extension_fichier, $extensions_valides)) {
            
            if ($document->uploaded) {
            	//on crée une miniature
        		$miniature = $document;
                $miniature->image_resize    = true;
                $miniature->image_ratio_fill     = true;
                $miniature->image_y         = 30;
                $miniature->image_x         = 30;
                $miniature->file_new_name_body   = 'avatar'.$id;
                $miniature->file_overwrite = true;
                $miniature->Process("avatar_min");

                //on process l'image, on la resize et on la met dans le dossier avatar
                $document->image_resize    = true;
                $document->image_ratio_fill     = true;
                $document->image_y         = 200;
                $document->image_x         = 200;
                $document->file_new_name_body   = 'avatar'.$id;
                $document->file_overwrite = true;
                $document->Process("avatar");


                if ($document->processed) {
                    echo "<p class='act_reussi'>Ton image a bien été uploadée :)<br>(Cela peut prendre un peu de temps pour qu'elle s'affiche)</p>";
                    $document->clean();
                    //update avatar dans la bdd
                    $query = "  UPDATE users
                                SET avatar = :avatar
                                WHERE id = :id";

                    $params = array(":avatar" => $nameImg, ":id" => $id);
                    $preparedStatement = $connexion->prepare($query);
                    $preparedStatement->execute($params);


                }
                else{
                    echo "<p class='error_message'>Il y a eu un problème avec l'upload de ton image, désolé...</p>";
                }
            }
        }
        else if ($extension_fichier == '') {
        	echo "<p class='error_message'>Tu n'as pas sélectionné d'image.</p>";
            
        }else{
           	echo "<p class='error_message'>Ton image n'est pas au bon format, désolé...</p>";
        }
	}


?>