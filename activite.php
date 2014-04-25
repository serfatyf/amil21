<?php
include "config.php"; 

include "header.php";
// if(isset($_POST['deco'])){
// 	unset($_SESSION['login']);
// 	unset($_SESSION['id_membre']);
// 	unset($_SESSION['type']);
// }
echo "POST:";  var_dump($_POST);
echo "sessions:"; var_dump($_SESSION);
echo "GET:";  var_dump($_GET);

if ( ( isset($_SESSION['pseudo']) && isset($_SESSION['id_membre']) && isset($_SESSION['sexe']) )) {
	
	if(!isset($_GET['id'])) {	
		?>
		
		<h2>Impossible de trouver cette activité.</h2>
		
		<?php
	} 
	else {		// fiche de l'acivite, meme si on n'y est pas inscrit (ne marche pas avec INNER!)
		
		$connexion_stmt = new BDD();								//rajouter age et date de naissance, presentation_membre

		if (isset($_POST['inscrip'])) {

			$sql = "SELECT id_participant_membre, titre, presentation_act, date_fin_inscription, ville_act, departement_act, lieu_act, lieu_rdv, date_act, heure_act, duree, photo_act, date_parution, prenom, nom, photo, pseudo FROM act
					LEFT JOIN participant ON id_act = id_participant_act 
					LEFT JOIN membre ON id_participant_membre = id_membre	
					WHERE id_act=?";
	
			$bind = "i";
			$arr= array($_GET["id"]);
			$connexion_stmt->prepare($sql,$bind); 
			$result = $connexion_stmt->execute($arr);

		 	$inscrit = 0;
				//verification si deja inscrit 
		 	for ($i=0; $i<count($result); $i++){
				if ($_SESSION['id_membre'] == $result["$i"]['id_participant_membre']) {
		 			//echo "Vous êtes déjà dans la liste des partipants.";
					$inscrit = 1;
		 		}
		 	}	
		 	
		 	if ($inscrit == 1){
		 		echo "Vous êtes déjà dans la liste des partipants.";
		 	}
		 	
		 	else {
		 			$sql = "INSERT INTO participant (id_participant_act , id_participant_membre) VALUES (?, ?)" ;
			 		$bind = "ii";	
			 		$arr = array($_GET['id'], $_SESSION['id_membre']);echo "array";var_dump($arr);
			 		$arr_prep=	$connexion_stmt->prepare($sql,$bind); 
					$result = $connexion_stmt->execute($arr); 
					
					if ($result==0) 
						echo "erreur dans l'inscription"; 
					
					else echo "bravo, vous êtes inscrit";	

		 	}
		}

	// une activite, ds la table de gauche, doit etre affichée 
		// meme si la table de droite est vide, à savoir si un membre n'y est pas inscrit => LEFT JOIN
		$sql = "SELECT id_participant_membre, titre, presentation_act, date_fin_inscription, ville_act, departement_act, lieu_act, lieu_rdv, date_act, heure_act, duree, photo_act, date_parution, prenom, nom, photo, pseudo FROM act
					LEFT JOIN participant ON id_act = id_participant_act 
					LEFT JOIN membre ON id_participant_membre = id_membre	
				WHERE id_act=?";
	
		$bind = "i";
		$arr= array($_GET["id"]); echo "arr:"; var_dump($arr);
		$connexion_stmt->prepare($sql,$bind); 
		$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);
		if(count($result) > 0) {		// utile? si $_GET['id'] est setté, il y a forcement une act
					
			echo "<h1>".$result[0]['titre']."</h1>" ; 
			echo "<h2>".$result[0]['presentation_act']."</h2>" ; 
			echo $result[0]['date_act'];
			echo "s'inscrire avant le ". $result[0]['date_fin_inscription'];	
			echo $result[0]['lieu_act']; 
			echo "<h2> Liste des participants </h2>";
			?>
			<div id="liste_inscrits">
			<?php 
		// "carte de visite" des inscrits à l'activité
		//		avec la photo si donnée par le membre, ou une icone sexuée (images dans le repertoire 'photos')	
			foreach ($result as $value) {
				if ($value['photo'] != "") {
					echo "<img src='/photos/".$value['photo'] . " alt='photo de ".$identite. "' />";
				}
				// else {
				// 		if ($_SESSION['sexe'] == 0)
				// 			echo "<img src='/photos/ico_homme.png' alt='icone d'un homme' />";
				// 		else echo "<img src='/photos/ico_femme.png' alt='icone d'une femme' />";
				// }
				if ($value['nom'] !="" || $value['prenom'] !="")
					echo ucfirst($value['prenom'])." ".strtoupper($value['nom']);
				else echo ucfirst($value['pseudo']);				

			}
			
		?>
			</div>
		<form action='<?php echo "activite.php?id=".$_GET['id'];?>' method='POST'>
			
			<input type='submit' name='inscrip' value="S'inscrire"/>
		</form>

		<?php
 	
		 	
		 	
		} //?
		
		

		else {
			?>
			<h2>Il n'y a pas d'activité pour cette recherche</h2>
			<?php
		}
	}
} 

// else if ( isset($_SESSION['genre']) && $_SESSION['genre'] == "orga" ) {
// 	if(!isset($_GET['id_act'])) {
// }

else {
	?> 

	<h2>Vous devez être connecté(e) pour avoir des informations sur une activité</h2>
	<p>Pseudo: <input type="text" id="pseudo"/></p>
	<p>Mot de passe: <input type="text" id="mdp" size="10"/></p>
	<p><input type="submit" id="btn_connect" value="Valider"/></p>
	
	<script type="text/javascript">
	$(document).ready(function(){
	    $('#btn_connect').click(function(){
			$.ajax({
				"type":"GET",
				"url":"log_test.php",
				"data":"pseudo="+$("#pseudo").val()+"&mdp="+$("#mdp").val(),
				success:function(data) {
					if (data=='succes') {
						 window.location.reload();
					} else {
						 alert ("erreur dans le pseudo ou le mot de passe");
					}
				}
			});
		});
	});
	</script>

	
	
	
		
<?php
}

