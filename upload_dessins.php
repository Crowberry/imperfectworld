<?php 

/*-----------------------------------------------UPLOAD DESSINS ADMIN -----------------------------------*/

    //multiple selection on passe par un table qui va récupérer tous les fichiers avant de les process
    $fileUpload = $_FILES["dessinUpload"];
    $files = array();
    
    //on crée une boucle pour rentrer tous les résultats dans l'array
    if (is_array($fileUpload)) {
        foreach ($fileUpload as $key => $fichier) {
           foreach ($fichier as $keyF => $vFichier) {
                if (!array_key_exists($keyF, $files))
                    $files[$keyF] = array();
                    $files[$keyF][$key] = $vFichier;
            }
        }    
    }
    
    //on prépare un tableau d'extensions valide
	$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png', 'JPG' );
    
    //pour chaque fichier retourné
    foreach ($files as $file) {
        $document = new Upload($file);
        $extension_fichier = get_ext($file);; //extension du fichier 

        if (in_array($extension_fichier, $extensions_valides)) { //on compare extension du fichier avec extensions autorisées
            //on récupère la largeur hauteur de l'image pour pouvoir faire sa miniature à 40%
            list($width, $height) = getimagesize ($file['tmp_name']);
            $miniature = $document;
            $favoris = $document;
            if ($document->uploaded) {
                //on crée la miniature affichée dans la mosaique
                $miniature->image_resize    = true;
                $miniature->image_y         = ($height * (40 / 100));
                $miniature->image_x         = ($width * (40 / 100));
                $miniature->file_overwrite = true;
                $miniature->Process('dessins/miniatures'); 

                //on crée la miniature pour les favoris
                $favoris->image_resize    = true;
                $favoris->image_ratio_fill     = true;
                $favoris->image_y         = 65;
                $favoris->image_x         = 65;
                $favoris->file_overwrite = true;
                $favoris->Process('dessins/favoris'); 

                //on place l'image dans le bon dossier
                $document->file_overwrite = true;
                $document->Process('dessins/'); 
            
                if ($document->processed) {
                    echo "<p class='act_reussi'>Votre image a bien été uploadée : )</p>";
                    $document->clean();
                }
                else {
                    echo "<p class='error_message'>Une erreur est survenue (halbatar!)</p>";
                }
            }
        }
        else if ($extension_fichier == "") {
            echo "<p class='error_message'>Vous n'avez pas sélectionné de fichier : (</p>";
        }
        else {
            echo "<p class='error_message'>Votre fichier n'est pas au bon format : (</p>";
        }
        unset($document);
    } 

?>