$(document).ready(function() {
   
   //validation avant suppression de compte
	$( "#delete" ).click(function() {
	  	var r = confirm("Tu es sur le point de supprimer ton compte et toutes ses données. Tu tiens vraiment à le faire?");
		if (r == true) {
			$(this).attr( "href", 'delete.php' );
		}
	});

	//afficher le menu d'inscription et de presentation en responsive
	

	$( "span#apropos" ).click(function() {
	  	$( "div.presentation" ).toggleClass( "retour_normal" );
	});

	$( "span#show_compte" ).click(function() {
	  	$( "div#menu" ).toggleClass( "retour_normal" );
	});

	



});


