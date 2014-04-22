<?php
include "config.php";

//include "header.php";

if (isset($_POST["pseudo"])) {
	$pseudo=$_POST["pseudo"];
	$connexion_stmt = new BDD();
	$sql = "SELECT id_membre FROM membre WHERE pseudo= ?";
	$bind="s";
	$arr= array($pseudo); 
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 
}

if (isset($_POST["mail_mb"])) {
	$mail_mb=$_POST["mail_mb"];
	$connexion_stmt = new BDD();
	$sql = "SELECT id_membre FROM membre WHERE mail= ?";
	$bind="s";
	$arr= array($mail_mb);  	
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 
}

if (isset($_POST["nom_orga"])) {
	$nom_orga=$_POST["nom_orga"];
	$connexion_stmt = new BDD();
	$sql = "SELECT id_orga FROM organisation WHERE nom_orga= ?";
	$bind="s";
	$arr= array($nom_orga);  	
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 
}

if (isset($_POST["mail_orga"])) {
	$mail_orga=$_POST["mail_orga"];
	$connexion_stmt = new BDD();
	$sql = "SELECT id_membre FROM membre WHERE mail_secretaire= ?";
	$bind="s";
	$arr= array($mail_orga);  	
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 
}



if(count($result)>0)
	echo "doublon";

else
	echo "unique";

