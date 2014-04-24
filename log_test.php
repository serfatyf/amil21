<?php

// fichier appelé par activite.php et organisation.php en ajax

include "config.php";

if (isset($_GET['pseudo'])){
	$connexion_stmt = new BDD();
	$sql = "SELECT pseudo, id_membre, mdp, sexe FROM membre WHERE `pseudo`=?";
	$arr = array($_GET['pseudo']);
	$bind ="s";
	$connexion_stmt->prepare($sql,$bind); 
	$result = $connexion_stmt->execute($arr);
	if (!empty($result)) {		// si il y a une reponse, c'est que celui qui a cliqué est un membre
   		if ($result[0]['mdp'] == $_GET['mdp']) {		// ici on verifie qu'alors son mdp est le bon
   			$_SESSION['pseudo'] = $result[0]['pseudo'];	// on ouvre les sessions utiles
   			$_SESSION['id_membre'] = $result[0]['id_membre'];
 			$_SESSION['sexe'] = $result[0]['sexe'];
 			echo "succes";
 		}

 		else  echo "erreur";

 	}

	else { 	

 		$sql = "SELECT login, id_orga, mdp FROM organisation WHERE `login`=?";
  		$arr = array($_GET['pseudo']);
  		$bind ="s";
  		$connexion_stmt->prepare($sql,$bind); 
  		$result2 = $connexion_stmt->execute($arr);		
  		if (!empty($result2)) {		// si il y a une reponse, c'est que celui qui a cliqué est un membre
    		if ($result2[0]['mdp']==$_GET['mdp']) {	// si le mdp correspond au mdp entré
    			$_SESSION['pseudo'] = $result2[0]['login'];	// on ouvre les sessions utiles
    			$_SESSION['id_membre'] = $result2[0]['id_orga'];
    			echo "succes";
 			}
 			else echo "erreur";
 		}
 		//else echo "erreur";
 		}
	
}
    