<?php
include "config.php";

include "header.php";

if (isset($_SESSION['type'])) {
	$stmt = $connexion->get_stmt();
	mysqli_stmt_prepare($stmt,"SELECT titre, presentation_act, date_fin_inscription, ville_act, departement_act,
	  lieu_act, lieu_rdv, date_act, heure_act, heure_rdv, heure_fin, photo, date_parution FROM act WHERE id=?");
	mysqli_stmt_bind_param($stmt, "i", $id);
	$id = $_SESSION['id'];   //ou "$_GET['" . id . "']";
	mysqli_stmt_execute($stmt);
	$activite = mysqli_stmt_get_result($stmt);
	while ($row = mysqli_fetch_assoc($activite)) {
		foreach ($row as $value) {
			if (!empty($value) )		
				echo "$value <br/>";
			}
		}
	}
else {
?>
<div id="connect"> Vous êtes inscrit mais pas connecté... vous ne pouvez donc pas voir la fiche demandée
	<label for="login"> Login: <input type="text" id="login" /> </label>
	<label for="mdp"> Mot de passe: <input type="password" id="mdp" /> </label>
	<button id="button" />
</div>
<p> Vous n'êtes pas inscrit... cliquez sur le lien suivant:</p>
<a href="log_test.php"> INSCRIPTION </a>
<?php } 	




// if (!isset($_SESSION['connected']))
// 	include "log.php";

// else {

// 	if (isset($_GET['id'] )) {

		





// var_dump( $activite = mysqli_fetch_assoc($stmt));

// echo $activite;
// $activite = mysqli_stmt_bind_result($stmt, )

// mysqli_stmt_bind_result($stmt, $id, $NomP, $SalaireP);
// $connexion->requete("SELECT * FROM act WHERE id=".$_GET['id']);
// $activite = $connexion->retourne_tableau();

// echo "<pre>";print_r($activite); echo "</pre><br/>";

// foreach ($activite as $act){
// 
?>
<script src="jquery.js"></script>	<!-- appel a jquery qui se trouve ds mes fichiers -->
<!-- <script src="mon_script.js"></script>    si je veux externaliser le script ci-dessous -->
$(document).ready(function(){
	$("#button").click (function() {
		$.post("log.php"), 
		{ login: $("#login").val,   mdp: $("mdp").val },

		{ function(data) { if (data =='ok') 
							window.reload;
						   else alert ("erreur de login ou de mot de passe");
						  }
	  	}
	}
}