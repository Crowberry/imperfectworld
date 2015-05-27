<?php 
//déconnection de l'user

session_start();

//effacer les fichiers stockant la session
session_destroy();

//efacer la variable de session
unset($_SESSION);

//redirige le navigaeur vers la page d'acceuil
header('Location: index.php');