<?php
	//on appelle notre bdd en pdo
	
	//on démarre une session
    session_start();

    //on appelle notre bdd
    $host = 'manuelorbdd64.mysql.db';
    $dbname = 'manuelorbdd64';
    $userdb = 'manuelorbdd64';
    $password = 'Artemis6423';

	try {
		$connexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $userdb, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (PDOException $e) {
		echo('Error: '.$e->getMessage());
	}

	//on prépare la date qui sera utile par la suite
	$date = date('Y-m-d H:i:s');

?>