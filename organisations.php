<?php
include "config.php";

include "header.php";


$orga = array();



$connexion_stmt = new BDD();
$sql = "SELECT id_orga, nom_orga, adresse, presentation_orga, logo FROM organisation"; 
$connexion_stmt->prepare($sql);
$result = $connexion_stmt->execute(); 
foreach ($result as $value) {	
	
	echo "<a href='organisation.php?id=".$value['id_orga']."'> ".$value['nom_orga'] ."</a>";
	echo "<p>".$value['adresse'].$value['presentation_orga']."</p>" ;
 
}


include "footer.php";



