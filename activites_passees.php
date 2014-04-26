<?php 
include "config.php";

include "header.php";

if ( isset($_SESSION['pseudo']) && isset($_SESSION['id_membre'])) { 
	
	$connexion_stmt = new BDD();
	$sql ="";
	$bind =""; 
	$arr = array();
	$connexion_stmt->prepare($arr);
	$result = $connexion_stmt->execure;
	("SELECT * FROM act 
					WHERE id_organisation =". $_SESSION['user'] ." AND date_act< CURRENT_DATE");
	$activites_passees = retourne_tableau();


}

