<div>
	<p> 
		<a href="#">Je veux voir les activités auxquelles j'ai participées
			<img src="ico_conference.png" alt="anciennes sorties" />
		</a> 
	</p>

	<!-- <p>	
		<a href="#">Je veux modifier les informations sur l'organisation 
			<img src="ico_resto.png" alt="modifier fiche" />
		</a>
	</p>

	<p>
		<a href="#">Je veux ajouter une activité 
			<img src="ico_sport.png" alt="ajouter" />
		</a>
	</p>
 -->
</div>

<?php 

$connexion = new BDD();
$connexion->requete("SELECT `titre`, `date_act`, `heure_act` FROM act 
					INNER JOIN organisation ON participant.id=id_participant
					WHERE participant.id=1"/*. $_POST['id']."*/);
$activites = $connexion->retourne_tableau();
		echo "<pre> activites:";print_r($activites); echo "</pre><br/>";

foreach ($activites as $value) {		
	echo "<p><a href='#'>". $value["titre"]." le ".$value["date_act"]." à " . $value["heure_act"]." </a></p>"; 
}
