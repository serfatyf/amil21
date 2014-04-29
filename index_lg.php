<?php
include "config.php";

include "header.php";

	// facilite l'ajout d'une nouvelle langue
$public = array('fr' =>'Tout public' ,'en' =>'Every public' );
$type = array('fr' =>  'Toutes', 'en' => 'All');

	// initialisation des tableaux pour eviter les erreurs
$textes = array() ;
$type_act =array();
$public_vise = array();
$texte = array();
	
	////////////////////////////////////////////////////////////////////////////
	
		// le texte de présentation
echo "<div id='present'>";
$connexion= new BDD(false);			
$connexion->requete("SELECT * FROM  textes WHERE langue='". $_SESSION['langue'] ."'");
$textes = $connexion->retourne_tableau();
foreach ($textes as $value) 
	$texte[$value['use']] = $value['texte'];
echo "<div id='presentation' >". nl2br($texte['presentation']) . "</div>";
	
?>
</div>
 <form method="GET" id="barre_recherche" action="<?php echo "activites.php"; ?>" /> 
<?php

		// on fait le select "activités" de la barre de recherche
$connexion->requete("SELECT id_typeact, type_lg FROM type_act
						INNER JOIN type_affich ON id_typeact = id_typeaffich_type
					WHERE langue='". $_SESSION['langue'] ."'"); 		
	  
$type_act = $connexion->retourne_tableau(); 
echo $texte['type_act'];
echo "<select id='activites' name='type'>\n";
echo "\t<option value='1'>".$type[$_SESSION['langue']]." </option>\n";
foreach ($type_act as $value) {
	echo "\t<option value='". $value['id_typeact'] ."'> " . $value['type_lg'] ." </option>\n";
}
echo "</select>\n";


		// on fait le select "public visé" de la barre de recherche
$connexion->requete("SELECT id_publicvise, public_lg FROM public_vise 
						INNER JOIN public_affich ON id_publicvise= id_publicaffich_public 
					WHERE langue='". $_SESSION['langue'] ."'");  
$public_vise = $connexion->retourne_tableau(); 
echo $texte['public'];
echo "<select id='public' name='public'>\n";
echo "\t<option value='1'><span>".$public[$_SESSION['langue']] ."</span> </option>\n";
foreach ($public_vise as $value) {
	echo "\t<option value='". $value['id_publicvise'] ."'> " . $value['public_lg'] ." </option>\n";
}
echo "</select>\n";

?>
<input type="submit"  id="recherche" value="Rechercher" />
<?php 
include "footer.php";