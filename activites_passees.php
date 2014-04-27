<?php 
include "config.php";

include "header.php";

if ( isset($_SESSION['pseudo']) && isset($_SESSION['id_membre'])) { 
	
	$connexion_stmt = new BDD();
	$sql ="SELECT titre, presentation_act, nom_orga, lieu_act, date_act, photo_act, pseudo, prenom, nom, sexe, photo FROM act 
				INNER JOIN participant ON id_act = id_participant_act
				INNER JOIN membre ON id_membre = id_paticipant_membre
				INNER JOIN organisation ON id_act_orga = id_orga
			WHERE date_act<CURRENT_DATE() AND id_participant_act = ? 
			ORDER BY date_act DESC"; // de la + recente à la + ancienne
	$bind ="i"; 
	$arr = array($_SESSION['id_membre']);
	$connexion_stmt->prepare($arr);
	$result = $connexion_stmt->execure; 

	if ($result == 0)
		echo "Je n'ai pour l'instant participé à aucune activité";
	else {
		foreach ($result as $value) {
			echo $value['titre'];
			echo "<span id='organise'>Organisé par: </span>".$value['nom_orga'];
			echo "<span id='liste> Liste des participants: </span>" ;
		}

	}
}
	