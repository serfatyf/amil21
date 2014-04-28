<?php
include "config.php";
include "header.php";

// echo "GET:";  var_dump($_GET);
// echo "sessions:"; var_dump($_SESSION);
// echo "POST"; var_dump($_POST);

	//si on est connecté en tant qu'organisation
if ( isset($_SESSION['nom_orga']) && isset($_SESSION['id_orga'])) {
$id_orga = $_SESSION['id_orga'];
?>
<header class="haut"> 
	<h1> Mon compte </h1>
	<a href="fiche_orga?id= <?php echo "'".$id_orga."'" ?> .php"> Changer la fiche de présentation de l'organisation </a>
	<a href="#"> Voir les anciennes activités proposées</a>
	<a href="ajout_act.php"> Ajouter une activité </a>
</header>


	<h1> Liste des activités proposées actuellement</h1>
<section>
<?php 
	$connexion = new BDD(false);
	$connexion->requete( "SELECT DISTINCT id_act, titre, presentation_orga, date_fin_inscription, date_act, heure_act, id_act_typeact FROM act
							INNER JOIN type_act ON id_act = id_act_typeact
							INNER JOIN participant ON id_act = id_participant_act
							INNER JOIN organisation ON id_act_orga = id_orga
						WHERE date_act >= CURRENT_DATE() AND id_act_orga = $id_orga");
	// $bind = "i";
	// $arr= array($_POST["id_orga"]); 
	// $connexion_stmt->prepare($sql,$bind); 
	$activite = $connexion->retourne_tableau(); 
	if(count($activite) == 0) {
		echo "Pas d'activité proposée actuellement";
	}
	else {
?>

		
		<ul>
			<?php 
				foreach ($activite as $value) { 
					
					echo "<li>";
					echo $value['titre'];
					echo "<a href='activite.php?id=".$value['id_act']."' > Voir </a>";
					echo "<a href='ajout_act.php?id=".$value['id_act']."' > Modifier </a>";
					echo "</li>";
 				}

	echo "</ul>";
		 
	}
echo "</section>";	

	
}
	// si on est connecté en tant que membre
if ( isset($_SESSION['pseudo']) && isset($_SESSION['id_membre'])) { 

$id_membre = $_SESSION['id_membre'];
?>
<header class="haut"> 
	<h1> Mon compte </h1>
	<a href="#"> Changer mon profil </a>
	<a href="activites_passees.php"> Voir les activités auxquelles j'ai participé</a>
</header>

<section>

<!-- NON -->
	<!-- <h1> Liste des activités proposées actuellement</h1> -->
<?php 
	$connexion = new BDD(false);
	$connexion->requete( "SELECT DISTINCT id_act, titre, presentation_act, date_fin_inscription, date_act, heure_act, id_act_typeact, nom_orga FROM act
							LEFT JOIN type_act ON id_act = id_act_typeact
							LEFT JOIN participant ON id_act = id_participant_act
							LEFT JOIN organisation ON id_orga = id_act_orga
						WHERE date_act >= CURRENT_DATE() AND id_participant_membre = $id_membre ");
	// $bind = "i"; 
	// $arr= array($_POST["id_orga"]); 
	// $connexion_stmt->prepare($sql,$bind); 
	$activite = $connexion->retourne_tableau(); var_dump($activite);
	if(count($activite) == 0) {
		echo "Je ne suis inscrit"; if ($_SESSION['sexe']=="1") echo "e";
		echo " à aucune activité actuellement";
	}
	else {
?>

	<h1> Liste des activités auxquelles je suis inscrit <?php if ($_SESSION['sexe']=="1") echo "e"; ?> </h1>
	<ul>
		<?php 
						
			foreach ($activite as $value) { 
				echo "<li>";
				echo $value['titre'];
				echo "<p>organisé par: " . $value['nom_orga'] ."</p>";
				echo "<a href='activite.php?id=".$value['id_act']."' > Voir </a>";
		 	}

		?>
	</ul>

<?php 
}}