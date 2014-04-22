
<div>
	<p> 
		<a href="orga.php?id="<?php . echo $_SESSION['user']; . ?>"/activites_passees.php"  >Voir les activités passées
			<img src="ico_conference.png" alt="anciennes sorties" />
		</a> 
	</p>

	<p>
		<a href="#">Modifier les informations sur l'organisation 
			<img src="ico_resto.png" alt="modifier fiche" />
		</a>
	</p>

	<p>
		<a href="orga.php?id="<?php . echo $_SESSION['user']; . ?>"/ajout_act.php">Ajouter une activité 
			<img src="ico_sport.png" alt="ajouter" />
		</a>
	</p>

</div>

<?php 

$connexion = new BDD();
$connexion->requete("SELECT act.`id`, `titre`, `date_act`, `heure_act` FROM act 
					INNER JOIN organisation ON organisation.id=id_organisation
					WHERE organisation.id=1"/*. $_POST['id']."*/);
$activites = $connexion->retourne_tableau();
		echo "<pre> activites:";print_r($activites); echo "</pre><br/>";

foreach ($activites as $value) {		
	echo "<p><a href='index.php?menu=activite&id=".$value["id"]."'>". $value["titre"]." le ".$value["date_act"]." à " . $value["heure_act"]." </a></p>"; 
}





?>
