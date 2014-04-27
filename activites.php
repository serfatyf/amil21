<?php
include "config.php";

include "header.php";

$result=array();
$activite=array();
$dates = array();

	// facilite l'ajout d'une nouvelle langue
$publics = array('fr' =>'Tout public' ,'en' =>'Every public' );
$types = array('fr' =>  'Toutes', 'en' => 'All'); 

	// tableaux des jours et mois en francais
$jours = array( "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
$mois = array (1=>"Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");


if (isset($_GET['type']))	// si on a choisi un type (qui correspond à un nombre) 
	$type =	$_GET['type'];	// le type est le nbr choisi
else $type = '1';			// sinon le type est 1, qui correspond à la recherche "tous types" 

if (isset($_GET['public']))		// idem pour le public
	$public =	$_GET['public'];
else $public = '1';

	//on prend les infos pour faire les boutons de selection de type d'activite
$connexion = new BDD(false);
$connexion->requete("SELECT id_typeact, type_lg FROM type_act
						INNER JOIN type_affich ON id_typeact = id_typeaffich_type
					WHERE langue='". $_SESSION['langue'] ."'"); 		/*on recupere pour cela la table des types d'activites*/
$type_act = $connexion->retourne_tableau(); 

	//ici on prend les infos pour faire les "li" de selection du public visé
$connexion->requete("SELECT id_publicvise, public_lg FROM public_vise 
						INNER JOIN public_affich ON id_publicvise= id_publicaffich_public 
					WHERE langue='". $_SESSION['langue'] ."'");
$public_vise = $connexion->retourne_tableau(); 

?>
<div id="btn_activite">		<!-- boutons "activités" -->
<a href="activites.php?type=1&public= <?php echo $public; ?> "><span <?php if ($type=='1') echo 'class="checked"'; ?>> <?php echo $types[$_SESSION['langue']]; ?> </span></a>
<?php 
foreach ($type_act as $value) {		// pr chaque bouton, hors 'tous' puisque fait au dessus, si il est cliqué il prend class='checked', synonyme de coloration 
?>
	<a href="activites.php?type=<?php echo $value['id_typeact']; ?>&public=<?php echo $public; ?>"><span <?php if ($type==$value['id_typeact']) echo 'class="checked"'; ?>><?php echo $value['type_lg']; ?></span></a>
<?php

}
 ?>
</div>

		
<div id="aside1">	<!-- li "public visé" -->
	<div id="age">Ages</div>
	<ul>
		<li>
			<a href="activites.php?type=<?php echo $type;?>&public=1"> <?php echo $types[$_SESSION['langue']]; ?> </a> 
		</li>
		<!-- <label for="tout"> <input type="radio" id="tout" <?php if ($public=="1") echo 'checked'; ?>/>
			<a href="activites.php?type=<?php echo $type;?>&public=1"> <?php echo $types[$_SESSION['langue']]; ?></label> </a> -->
<?php 
foreach ($public_vise as $value) {		// pr chaque radio, hors 'tous' puisque fait au dessus, si il est cliqué il est checké
?>
		<!-- <label for="<?php echo $value['id_publicvise'] ?>" > <input type="radio" id="<?php echo $value['id_publicvise'];?>" <?php if ($public==$value['id_publicvise']) echo "checked"; ?> /> -->
		<li>
			<a href="activites.php?type=<?php echo $type;?>&public=<?php echo $value['id_publicvise']; ?>"><span <?php if ($public==$value['id_publicvise']) echo 'class="checked"'; ?>>  <?php echo $value['public_lg']; ?></span></label></a>
		</li>	
<?php
}
?>
	</ul>
</div>
<?php 
// requete renvoyant le choix d'activite fait par l'utilisateur
	$connexion_stmt = new BDD();

	$bind = "";
	$sql = "SELECT id_act, type, titre, date_act , id_act_typeact, id_typeact, nom_orga, public FROM  act 
					INNER JOIN public_vise ON id_publicvise=id_act_publicvise
	 				INNER JOIN type_act  ON id_typeact = id_act_typeact
	 				INNER JOIN organisation ON id_act_orga = id_orga  
	 		WHERE date_act>=CURRENT_DATE()";
	
	if ($type != "1") {		// si ce n'est pas "toutes", c'est qu'on a choisi un type d'activites
		$sql .= " AND id_typeact = ? ";		// on met donc une condition a la requete
		$bind .= "i";					  // et on rajoute une condition de bind
		if($public != "1"){	// si on a choisi aussi un public
			$sql .= " AND id_publicvise = ? ";			  // on rajoute la condition ds la requete
			$bind .= "i";
		}
	}				// si on arrive ici, c'est qu'on n'avait pas choisi un type d'activite
	
	elseif ($public != "1"){		// meme chose qu'avant pour le public
		$sql .= " AND public= ? ";
		$bind .= "i";
	}
	$sql .= "ORDER BY date_act ASC";
	
	$arr= array($type,$public); 
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 

	if ($result == []){
		echo "<div id='no_result'> Il n'y a actuellement pas d'activités de prévues avec ces conditions de recherche.<br/>";
		echo "Essayez avec une autre recherche, çà vous donnera peut-être des idées</di";
	}
	else {
		$date_actuelle = "";
		echo "<div id='act'>";
		foreach ($result as $value) { 		
		
				// création de la date
			$tab_dates = explode('-', $value['date_act']); 
			$time = mktime(0,0,0, $tab_dates[1], $tab_dates[2], $tab_dates[0]);/*echo "time";var_dump($time);*/

				//affichage des activites, par date
			if ($value['date_act'] != $date_actuelle) {
				
				echo $date = $jours[date('w', $time)]." ".date('j', $time)." ".$mois[date('n', $time)]." ".date('Y', $time)."\n";
				
				
				$date_actuelle = $value['date_act'];
			}
			echo "\t<p><a href='activite.php?id=".$value['id_act']."' id=".$value['id_typeact']." >".$value['titre']."</a></p> \n";;	
			
		}echo "</div>";
	}

			//echo "<p>organisé par: " . $value['nom_orga'] ."</p>";
 		
 		// $i=0; echo $dates[0]; $date_actuelle = $dates[0]; var_dump($date_actuelle);
 		// for ($i=1; $i<count($result); $i++){
 		// 	if ($result['date_act'] == $date_actuelle)
 		// 		echo $result['titre'];
 		// 	else {
 		// 		echo $dates[$i];

 		// 	} 
 				
 		// }}
 		// while ($i< count($dates)){
 		// 	echo $date = $jours[date('w', $time)]." ".date('j', $time)." ".$mois[date('n', $time)]." ".date('Y', $time);
 		// 	while ($dates[$i+1] == $dates[$i]){
 		// 		echo "<a href='activite.php?id=".$value['id_act']."' >";	
 		// 		echo $value['titre']."</a> ";
 		// 		echo "<p>organisé par: " . $value['nom_orga'] ."</p>";
 		// 		$i++;		
 		// 	}
 		// }
 	//}


