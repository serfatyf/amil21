<?php

include "config.php";

include "header.php";


if (isset($_GET['menu'])){
	switch($_GET['menu']) {
		case 'activites': include "activites.php"; break;
		case 'organisations': include "organisations.php"; break;
		case 'inscription': include "inscription.php"; break;
		case 'activite': include "activite.php";break;
		case 'connexion': include "connexion.php"; break;
		case 'log_test': include "log_test.php"; break;
		case "orga_logged": include "orga_logged.php"; break;
		case 'ajout_act': include "ajout_act.php"; break;
		case 'orga2': include "orga2.php"; break;
	default: include "accueil.php";
	}
}
else 
include "accueil.php";
// include "footer.php";

?>