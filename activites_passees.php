<?php 
include "config.php";

include "header.php";

if (isset($_SESSION['user'])){

	$connexion = new BDD(false);
	$connexion->requete("SELECT * FROM act 
					WHERE id_organisation =". $_SESSION['user'] ." AND date_act< CURRENT_DATE");
	$activites_passees = retourne_tableau();


}

else include "connexion.php";
?>