<?php
include "config.php";

include "header.php";
// echo "sessions:";  var_dump($_SESSION);
// echo "get:"; var_dump($_GET);
$textes = array() ;
$type_act =array();
$public_vise = array();
$texte = array();

if (isset($_GET['login']))		//utile?
	unset($_SESSION['login']);
// if (isset($_POST['recherche'])) echo "tu as choisi ".$_POST['activites']."et ".$_POST['public'] ;
// else {
$connexion= new BDD(false);			// le texte de présentation
$connexion->requete("SELECT * FROM  textes WHERE langue='". $_SESSION['langue'] ."'");
$textes = $connexion->retourne_tableau();
foreach ($textes as $value) 
	$texte[$value['use']] = $value['texte'];
echo "<div id='presentation' >". nl2br($texte['presentation']) . "</div>";
	
?>
 <form method="get" id="barre_recherche" action="<?php echo "activites.php"; ?>" /> 
<?php
		// on fait le select "activités" de la barre de recherche
$connexion->requete("SELECT * FROM type_act"); 		
	  
$type_act = $connexion->retourne_tableau(); /*var_dump($type_act)*/;
echo "<select id='activites' name='type'>\n";
echo "\t<option value='1'> Toutes </option>\n";
foreach ($type_act as $value) {
	echo "\t<option value='". $value['id_typeact'] ."'> " . $value['type_affich'] ." </option>\n";
}
echo "</select>\n";

		// on fait le select "public visé" de la barre de recherche
$connexion->requete("SELECT * FROM public_vise");  
$public_vise = $connexion->retourne_tableau(); //var_dump($public_vise);
echo '<select id="public" name="public">';
echo "\t<option value='1'> Tout public </option>\n";
foreach ($public_vise as $value) {
	echo '\t<option value="'. $value["id_publicvise"] .'"> ' . $value["public_affich"] .' </option>\n';
}
echo '</select>';

?>
 <script>
$(function() {
$.datepicker.setDefaults( $.datepicker.regional[ "" ] );
$( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
});
</script>

<!-- 	<label for="date">Date</label>
	<input type="text" id="datepicker" name="date" /> -->
	<input type="submit"  id="recherche" value="Rechercher" />
</form>

