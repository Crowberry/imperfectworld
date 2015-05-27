<?php

    //menu qu'on affiche si l'utilisateur est loggé

    //dossier avatar
    $dossier = 'avatar/';
    //on récupère toutes les données de l'utilisateur
    $query = "SELECT * 
                FROM users
                WHERE username = :username";

    $preparedStatement = $connexion->prepare($query);
    $preparedStatement->execute(array(':username' => $user));
    //on en sort un tableau avec toutes les données
    $result = $preparedStatement->fetch();
    //on rentre les valeurs sorties dans des variables
    $id = $result['id'];
    $usernameInit = $result['username'];
    $emailInit = $result['email'];
    $mdpInit = $result['mdp'];
    $avatar = $dossier.$result['avatar']; //on indique le chemin complet de l'image
    $statut = $result['statut'];
    $last_co = $result['last_co'];

    //on entre dans les super globale le statut et l'id de l'utilisateur
    $_SESSION['statut'] = $statut;
    $_SESSION['id'] = $id; // l'id est rappelé en début d'index


?>
<div class='col-xs-6 col-md-12'>
    <section id="profil">
        <img src="<?php echo $avatar;?>" alt="Ton image de profil">
        <?php 
            //on inclut le formulaire qui permet à l'utilisateur d'uploader son avatar
            include 'form_avatar.php';
            include 'upload_avatar.php';
        ?>
        
    </section>
    <section id="mon_compte">
        <ul>
        <?php 
            //on vérifie si on est sur la page d'accueil ou sur une page dessin
            if ($_GET['dessin'] == '') {
                $lien_image = '';
            }
            else {
                $lien_image = 'dessin='.$image.'&&';
            }

            //on fait apparaitre un bouton qui permet la modification du lien et qui renvoie à la page en cours
            echo "<li><a href='index.php?".$lien_image."act=update' class='hidden-sm'>Voir / modifier tes données</a></li>";

            //si l'utilisateur a cliqué sur le bouton d'update
            if ($_GET['act'] == "update") {
                //on inclut le formulaire qui permet l'update des données de l'utilisateur
                include 'form_update.php';
            }

        ?>

        <!-- on appelle deux boutons qui permettent de se déconnecter ou de supprimer son compte -->
        <!-- une vérification jquery est faite avant la suppression d'un compte -->
        <li><a href="logout.php">Te déconnecter</a></li>
        <li><a href="" id="delete">Supprimer ton compte</a></li>
        </ul>
    </section>
</div>
<div class='col-xs-6 col-md-12'>
    <section id="mes_fav">
        <h3>Ceux que tu as aimé :</h3>
        <ul>
            <?php 
                //on affiche les favoris (ou non) de l'utilisateur
                include "show_mes_favs.php";
            ?>
        </ul>
    </section>

    <section id="mes_hist" class="clear">
        <h3>Ceux où tu as écris :</h3>
        <ul>
            <?php  
                //on affiches les dessins dans lesquels l'utilisateur a écrit (ou non) une histoire
                include "show_mes_hist.php";
            ?>
        </ul>
    </section>
</div>