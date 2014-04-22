<?php
include "config.php";

//include "header.php";

if (isset($_POST["pseudo"])) {
	$pseudo=$_POST["pseudo"];
	$connexion_stmt = new BDD();
	$sql = "SELECT id_membre FROM membre WHERE pseudo= ?";
	$bind="s";
	$arr= array($pseudo); //echo "arr:"; var_dump($arr);	
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); //echo "result:"; var_dump($result);
}

else if (isset($_POST["mail"])) {
	$mail=$_POST["mail"];
	$connexion_stmt = new BDD();
	$sql = "SELECT id_membre FROM membre WHERE mail= ?";
	$bind="s";
	$arr= array($mail); //echo "arr:"; var_dump($arr);	
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); //echo "result:"; var_dump($result);
}

if(count($result)>0)
	echo "doublon";

else
	echo "unique";

?> 