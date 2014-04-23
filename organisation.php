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
if (isset($_SESSION['pseudo'])) {
	$connexion_stmt = new BDD();
	$sql = "SELECT nom_orga, mail_president, tel_president, mail_secretaire, adresse, presentation_orga, ville, departement, logo, nom_president FROM organisation 
				WHERE id_act=?"; 
	$bind = "i";
	$arr= array($_GET["id_act"]); echo "arr:"; var_dump($arr);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);
}

?>