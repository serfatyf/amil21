<?php 
include "config.php";

include "header.php";

if ( isset($_SESSION['nom_orga']) && isset($_SESSION['id_orga'])) {
//	&& isset($_SESSION['genre']) && $_SESSION['genre'] == 'orga'

if (isset($_POST['ajout'])) {
	$connexion_stmt = new BDD();
	$sql = "INSERT INTO act (titre, id_act_publicvise, id_act_typeact, presentation_act, date_act, heure_act, duree, lieu_act, ville_act, departement_act, lieu_rdv, heure_rdv) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$bind ="ssssssssssssi";
	//$result_type = array($_POST['type'] - $nb_public);
	$arr = array($_POST['titre'], $_POST['public'], $_POST['type'], $_POST['area'], $_POST['date'], $_POST['heure_act'], $_POST['duree'], $_POST['adresse_act'], $_POST['ville'], $_POST['departement'], $_POST['adresse_rdv'], $_POST['heure_rdv'], $_SESSION['id_orga']);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 
	if ($result == 0){
		echo "Désolé mais une erreur s'est produite dans la création de votre fiche d'activité";
		echo "<a href='mon_compte.php'> Retour à mon compte </a>";
	} 
	else { 
		echo "bravo, une activité de plus à votre actif.";	
		echo "<a href='mon_compte.php'> Retour à mon compte </a>";
	}
}
else {
?>	


<h1> Nouvelle activité	</h1>

<form method="post" action="mon_compte.php" enctype="multipart/form-data" >		 
	<div>
		Titre: <input type="text" id="titre" name="titre" size="100" placeholder="paraîtra à tous les visiteurs"> 
		<div id="age">
			Public visé:
			<label for="tout"> Tout public <input type="radio" id="tout" name="public" /> </label>
		<?php 
			$connexion = new BDD(false);
			$connexion->requete("SELECT * FROM public_vise");  //on affiche la liste des publics avec des boutons radio
			$public_vise = $connexion->retourne_tableau();
			$i = 1;
			foreach ($public_vise as $value){
	 			echo "<label for='". $value['id_publicvise'] ."'>" . $value['public_affich'] ."</label><input type='radio' id='". $value['id_publicvise'] ."' value='". $value['id_publicvise'] ."' name='public' /> "; 
	 			$i++;
			}
			$nb_public = $i;
		?>	
		</div>
		<div id="type">
			Type d'activité:
			<label for="toutes"> Toutes <input type="radio" id="toutes" name="type" /> </label>
		<?php 
			$connexion->requete("SELECT * FROM type_act");  //on affiche la liste des familles d'activites avec des radio
			$type_act = $connexion->retourne_tableau();
			$i += 1;
			foreach ($type_act as $value){
				$i++;
	 			echo "<label for='". $i/*+$value['id_typeact']*/ ."'>" . $value['type_affich'] ."</label><input type='radio' id='". $i/*+$value['id_typeact']*/ ."' value='". $value['id_typeact'] ."' name='type' /> "; 
			}
		?>
		</div>
		<label for="act"> Présentation: 
			<textarea id="elm1" name="area"></textarea>
			 
		</label><br/>
		<label for="date">Date: </label><input type="text" id="date" name="date" placeholder="jj/mm/AAAA" size="50" > <br/>
		<label for="heure">Heure: </label><input type="text" id="heure" name="heure_act" size="50" > 
		<label for="duree">Durée approximative: </label><input type="text" id="duree" name="duree" size="50" > <br/>
		<p> Lieu de l'activité </p>
		<label for="adresse">Adresse: </label><input type="text" id="adresse" name="adresse_act" size="50" > <br/>
		<label for="ville">Ville: </label><input type="text" id="ville" name="ville" size="50" > 
		Département: <select name="departement">
						<option value="06"> 06 </option>
						<option value="83"> 83 </option>
					 </select>
		<p> Rendez-vous </p>
		<label for="heure">Heure: </label><input type="text" id="heure" name="heure_rdv" size="50" > <br/>
		<label for="adresse">Adresse: </label><input type="text" id="adresse" name="adresse_rdv" size="50" > <br/>

		<input type="submit" name="ajout" value="Ajouter" />
</form>
			
<?php 

}