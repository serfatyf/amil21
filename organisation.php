<?php 
include "config.php";

include "header.php";

echo "POST:";  var_dump($_POST);
echo "sessions:"; var_dump($_SESSION);
echo "GET:";  var_dump($_GET);


// if (isset($_GET['id'])) {
// $connexion_stmt = new BDD();
// 	$sql = "SELECT nom_orga, mail_president, tel_president, mail_secretaire, adresse, presentation_orga, logo FROM organisation 
// 				WHERE organisation.id=?"; 
// 	$bind = "i";
// 	$arr= array($_GET["id"]); echo "arr:"; var_dump($arr);
// 	$connexion_stmt->prepare($sql,$bind);
// 	$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);
// }
//if (isset($_SESSION['pseudo']) && isset($_SESSION['id_membre'])) {

// 	$connexion_stmt = new BDD();
// 	$sql = "SELECT nom_orga, nom_president, mail_president, tel_president, mail_secretaire, nom_secretaire, adresse, presentation_orga, ville, departement, logo FROM organisation 
// 				WHERE id_orga=?"; 
// 	$bind = "i";
// 	$arr= array($_GET["id"]); //echo "arr:"; var_dump($arr);
// 	$connexion_stmt->prepare($sql,$bind);
// 	$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);


	// membre ou organisation peut voir la fiche d'une organisation quelconque si loggé
if ( ( isset($_SESSION['pseudo']) && isset($_SESSION['id_membre']))) {	
	if(!isset($_GET['id'])) {	
		?><h2>Impossible de trouver cette organisation.</h2><?php
	} 
	else {		// fiche de l'organisation, 
		
		$connexion_stmt = new BDD();								
		$sql = "SELECT nom_orga, nom_president, mail_president, tel_president, nom_secretaire, mail_secretaire, adresse, presentation_orga, ville, departement, logo FROM organisation
				WHERE id_orga=?";
	
		$bind = "i";
		$arr= array($_GET["id"]); //echo "arr:"; var_dump($arr);
		$connexion_stmt->prepare($sql,$bind); 
		$result = $connexion_stmt->execute($arr); //echo "result:"; var_dump($result);
		
		if(count($result) > 0) {
			echo "<h1>".$result[0]['nom_orga']."</h1>" ; 
			echo "<h2>Présidé par:".$result[0]['nom_president']."</h2>" ; 
			echo "<h2>Coordonnées du Président: </h2><br/>";
			echo "Téléphone: ".$result[0]['tel_president'];
			
		}

	}
} 

// else if ( isset($_SESSION['genre']) && $_SESSION['genre'] == "orga" ) {
// 	if(!isset($_GET['id_act'])) {
// }

else {
	?> 

	<h2>Vous devez être connecté(e) pour avoir plus d'informations sur cette organisation</h2>
	<p>Pseudo: <input type="text" id="pseudo"/></p>
	<p>Mot de passe: <input type="text" id="mdp" size="10"/></p>
	<p><input type="button" id="btn_connect" value="Valider"/></p>
	
	<script type="text/javascript">
	$(document).ready(function() {
	    $('#btn_connect').click(function() {
			$.ajax({
				"type":"GET",
				"url":"log_test.php",
				"data":"pseudo="+$("#pseudo").val()+"&mdp="+$("#mdp").val(),
				success:function(data) {
					if (data=='succes') {
						 window.location.reload();
					} else {
						 alert ("erreur dans le pseudo ou le mot de passe");
					}
				}
			});
		});
	});
	</script>
	
	
		
<?php
}


