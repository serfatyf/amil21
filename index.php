<?php
include "config.php";

include "header.php";


	// initialisation des tableaux pour eviter les erreurs
$textes = array() ;
$type_act =array();
$public_vise = array();
$texte = array();


$connexion= new BDD(false);			// le texte de présentation
$connexion->requete("SELECT * FROM  textes WHERE langue='". $_SESSION['langue'] ."'");
$textes = $connexion->retourne_tableau();
foreach ($textes as $value) 
	$texte[$value['use']] = $value['texte'];
echo "<div id='presentation' >". nl2br($texte['presentation']) . "</div>";
	
?>

 <form method="GET" id="barre_recherche" action="<?php echo "activites.php"; ?>" /> 
<?php

		// on fait le select "activités" de la barre de recherche
$connexion->requete("SELECT id_typeact, type_affich FROM type_act"); 		
	  
$type_act = $connexion->retourne_tableau(); 
echo "<select id='activites' name='type'>\n";
echo "\t<option value='1'>Tout </option>\n";
foreach ($type_act as $value) {
	echo "\t<option value='". $value['id_typeact'] ."'> " . $value['type_affich'] ." </option>\n";
}
echo "</select>\n";


		// on fait le select "public visé" de la barre de recherche
$connexion->requete("SELECT id_publicvise, public_affich FROM public_vise");
$public_vise = $connexion->retourne_tableau();  
echo "<select id='public' name='public'>\n";
echo "\t<option value='1'>Tous </option>\n";
foreach ($public_vise as $value) {
	echo "\t<option value='". $value['id_publicvise'] ."'> " . $value['public_affich'] ." </option>\n";}
echo "</select>\n";

?>
<input type="submit"  id="recherche" value="Rechercher" />
<?php 
include "footer.php";