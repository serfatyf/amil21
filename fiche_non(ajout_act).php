<?php 
include "config.php";

include "header.php";

// if (isset($_SESSION['user'])) {

?>	

<!-- <h1> Nouvelle activité	</h1>
<h2> Vous pouvez utiliser ces boutons pour tous les champs texte</h2>

<form method="post" action="#">		<!-- utile ?  -->
	<!-- <input type="button" id="bold" value="bold" />
	<input type="button" id="italic" value="italic" />
	
</form> --> 
<div>
	Titre: <input type="text" id="title" size="100" placeholder="présentation concise de l'activité"> 
	<div id="age">
	Tranche d'age:
<?php 
	$connexion = new BDD();
	$connexion->requete("SELECT * FROM public_vise");  //on recupere la table public_visé
	$public_vise = $connexion->retourne_tableau();
	// var_dump($public_vise);
	foreach ($public_vise as $value){
//		$age[$value['public']] = $Public[$value['public']];  a priori pas utile, mais je garde a tt hasard
	 	echo "<label for='". $value['public'] ."'>" . $value['public_affich'] ."<input type='radio' id='". $value['public'] ."' name='". $value['public'] ."' /></label> "; 
	}
	 		
	
?>	
<!-- 	<label for="famille"> Famille <input type="checkbox" id="famille" name="famille" /></label>
		<label for="enfants"> Enfants <input type="checkbox" id="enfants" name="enfants" /></label>
		<label for="ja"> 20-40 <input type="checkbox" id="ja" name="ja" /></label>
		<label for="va"> 40-60 <input type="checkbox" id="va" name="va" /></label>
		<label for="seniors"> Seniors <input type="checkbox" id="seniors" name="seniors" /></label>
--> </div>
	<div id="type">
		Type d'activité:
<?php 
	$connexion = new BDD();
	$connexion->requete("SELECT * FROM type_act");  //on recupere la table type_act
	$type_act = $connexion->retourne_tableau();
	foreach ($type_act as $value){
	 	echo "<label for='". $value['type'] ."'>" . $value['type_affich'] ."<input type='radio' id='". $value['type'] ."' name='". $value['type'] ."' /></label> "; 
	}
?>
		<!-- <label for="resto"> Restaurant <input type="radio" id="resto" value="resto" name="type" /></label>
		<label for="culture"> Culture <input type="radio" id="culture" value="culture" name="type" /></label>
		<label for="conf"> Conférences <input type="radio" id="conf" value="conf" name="type" /></label>
		<label for="sport"> Plein air / sport <input type="radio" id="sport" value="sport" name="type" /></label>
		<label for="tout"> Tous types <input type="radio" id="tout" value="tout" name="type" /></label> -->
	</div>
	<label for="act"> Présentation: 
		<textarea id="act" rows="10" cols="40" placeholder="la présentation de l'activité qui paraitra lorsque les membres seront connectés">
		</textarea>
	</label>
</div>
