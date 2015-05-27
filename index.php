<?php
    // Report all errors except E_NOTICE   
    error_reporting(E_ALL ^ (E_NOTICE /*| E_WARNING*/));
    include 'database.php'; //appel pdo

    $user = $_SESSION['user']; // définition des variables user et userid
    $userid = $_SESSION['id'];

    //toutes ces fonctions appellent un header à la fin de leurs actions
    //être sur qu'elle soient en haut et non après un écho
    include 'function.inc.php'; //fonctions utiles
    include 'class.upload.php'; //class upload de fichier
    include 'post_login_update.php'; //methode pour traiter l'inscription connexion et update compte
    include 'post_histoire.php'; //methode pour traiter l'ajout d'histoire
    include 'addfav.php'; // methode pour ajouter aux favoris

    //si l'utilisateur n'est pas connecté
    if($_SESSION['logged'] == ''){
        $template = 'non_logged.php'; //affichage du menu inscription/connexion
        $camarade = 'Camarade'; //Préparer message de salut
    }
    //sinon
    else{
        $template = 'logged.php'; //affiche le menu du compte
        $camarade = $user; //on salut le visiteur connecté
    }

    $date_copyright = date("Y");

?>

<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <title>imperfect world</title>
    <link type="text/css" rel="stylesheet" href="inc/css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="inc/css/style.css">
    <script type="text/javascript" src="inc/js/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="inc/js/main.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

    <link rel="icon" type="image/png" href="favicon.png" />
    
    
</head>

<body>
    <div class ="col-xs-12 header">
        <h1><a href="index.php">An imperfect world<br><span id="logo"></span></a></h1>
        
    </div>
    <div class="col-xs-12 col-md-3 col-lg-2" id="menu">
        <span id="show_compte"></span>
        <h2>Bienvenue <span><?php echo $camarade ?><span></h2>
            <?php 
                include $template; //on inclut le menu
            ?>
    </div>

   <div class="col-xs-11 col-md-9 col-lg-8 main">
        <?php 
            //on appelle de formulaire pour rajouter des dessins si l'utilisateurs est admin
            // le fichier qui traitera l'upload est appelé dans logged.php
            if ($_SESSION['statut'] == 'admin') {
             ?>

                <form id="postadmin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                    <label for="dessinUpload">Salut admin! Upload des trucs :</label><br>
                    <input type="file" id="dessinUpload" multiple="multiple" name="dessinUpload[]" /><br>
                    <input type="submit" value="upload">
                </form>
                
            <?php 
                include 'upload_dessins.php';
            }//fin if session admin

            // si on est sur une page avec un dessin
            if ($_GET['dessin'] == '') {
                include "dessins.php";
                $top = 'index.php';
            }
            //sinon on inclut tous les dessins
            else {
                include "pageimage.php";
                $top = 'index.php?dessin='.$_GET['dessin'];
            }

            
        ?>
   </div>


   <div class="col-xs-9 col-lg-2 presentation">
        <?php
        //on inclut le texte de présentation
            include 'presentation.php' 
        ?>
   </div>

   <?php 
        //on affiche un bouton de rtour vers le haut
        echo "<div class='col-xs-12'><a href='".$top."' class='top'>top</a></div>";
   ?>

   <div class="col-xs-12 footer">
        <ul class='left'>
        <li>Merci à <a href="https://twitter.com/pixeline">Alexandre Plennevaux</a><br>et <a href="https://twitter.com/garith">François Therasse</a> pour avoir partagé leur savoir en php.</li>
        <li>Projet réalisé dans le cadre <a href="https://dwm.re/">DWM</a>.</li>
        </ul>
        <ul class='right'>
        <?php 
            echo "<li>&copy; ".$date_copyright." <a href='manuel-ortiz.com'>Manu</a></li>";
        ?>
        
            <li class="right"><a href="https://twitter.com/Crowberry64">Twitter</a></li>
            <li class="clear right"><a href="https://fr-fr.facebook.com/pages/Crowberry/172759882728">Facebook</a></li>
        </ul>
   </div>
</body>
</html>
