<!-- on affiches tous les dessins de manière aléatoire dans le main index -->

<ol class="dessins">
    <?php 
        $dossier = 'dessins/'; //on indique le dossier où sont les dessins
        $files = scandir('./' . $dossier); //on récupère un tableau avec toutes les infos des images de ce dossier
        $dossier_miniature = $dossier."miniatures/"; //on indique le dossier des miniatures
        $order = array(); //on prépare un tableau qui permettra de sortir les images de manière aléatoire

        
        //pour chaque file trouvé
        foreach ($files as $k => $f) {
            //on vérifie qu'on récupère bien les images et non autre type de fichier
            if ($f != '..' && $f != '.' && $f != 'miniatures' && $f !="favoris") { 
                //on rentre des li dans le tableau order
                $order[$k] = "<li><a href='index.php?dessin=".$f."'><span class='cover'><span>Voir<br>et<br>écrire</span></span><img src='".$dossier_miniature.$f."'></a></li>";
            }
        }

        shuffle($order); // on sort le dossier de manière aléatoire (le shaker)

        //pour chaque case d'order
        foreach ($order as  $li) {
            echo $li; //on affiche les li
        }

    ?>

</ol>