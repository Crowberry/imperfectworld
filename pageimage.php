<?php 
	//template lorsqu'on est sur une page avec un dessin et histoires
	
	//on selectionne toutes les informations relatives aux histoires racontées sur ce dessin
	$query_hist = "SELECT * 
                FROM histoires
                WHERE image = :image";

    $preparedStatement = $connexion->prepare($query_hist);
    $preparedStatement->execute(array(':image' => $image));
    
    $result_hist = $preparedStatement->fetchAll();

?>



<section class="col-md-12 pageImage">

	<img class="le_dessin" src="dessins/<?php echo $image?>" alt="un très bô dessin du grand Manu" />

	<div class="col-md-8 col-md-offset-2 pageImage">

		<?php 
			//on inclut le bouton favoris, qui change selon si l'image est déjà dans les favoris ou non
			include "show_fav_button.php"; 
		?>
		<a href="index.php" id="mosaic">Retour à la gallerie</a>
		<?php
			//si l'utilisateur est connecté, on affiche un cham pour qu'il puisse raconter une histoire
			if ($_SESSION['logged'] == 'ok') {
		?>
				<form method="post">
					<label for="histoire">Raconte son histoire :</label><br>
		            <textarea id="histoire" name="texte"></textarea>
		            <input class="btn btn-primary" type="submit" value="poster" name="histoires"/><br>
		            <?php 
		            	echo message_erreur($errors_hist, 'texte');
	            		
	            		//si l'utilisateur a entré un texte
	            		if ($_GET['send'] == 'yes') {
	            			echo "<p class='merci'>Merci d'avoir contribué à cette petite grande oeuvre :)</p>";
	            		}
	            	?>
				</form>
		<?php
			}
		?>

		<h3>Ce que les gens racontent :</h3>
		<ul class="show_hist">
		<?php 
			//on affiche les histoires racontées sur ce dessin
			include "show_histoire.php";
		?>
		</ul>


		<?php 
			//si l'utilisateur n'est pas connecté, on l'invite à s'identifier pour pouvoir poster
			if ($_SESSION['logged'] == '') { ?>
				
			<p id="seco_image">Pour rajouter vos histoires et/ou enregistrer des favoris, tu dois :</p>
			<div class="col-xs-6">
				<h4>être connecté(e) : </h4>

			<?php
				include 'form_connecter.php';
			?>
			</div>
			<div class="col-xs-6">
				<h4>créer un compte : </h4>
			<?php
				include 'form_inscrire.php'; 
			?>
				</div>
			<?php
				} //fin si session logged
			?>

	</div>


</section>