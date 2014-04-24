<?php
include "config.php";

include "header.php";

$icones_act=array();
$activite=array();

if (isset($_GET['type']))	// si on a choisi un type (qui correspond à un nombre) 
	$type =	$_GET['type'];	// le type est le nbr choisi
else $type = '1';			// sinon le type est 1, qui correspond à la recherche "tous types" 

if (isset($_GET['public']))		// idem pour le public
	$public =	$_GET['public'];
else $public = '1';


// requete renvoyant le choix d'activite fait par l'utilisateur
if (isset($type) && isset($public)){		// C'EST FORCEMENT SET VU QUE TU LUI DONNE UNE VALEUR AU DESSUS ... INUTILE DONC
	$connexion_stmt = new BDD();

	$bind = "";
	$sql = "SELECT id_act, type, titre, date_act , id_act_typeact, nom_orga, public FROM  act 
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

	foreach ($result as $value) { 		
		echo "<a href='activite.php?id=".$value['id_act']."' >";	
		echo $value['titre']."</a> ";
		echo "<p>organisé par: " . $value['nom_orga'] ."</p>";
 	}


//on va faire les boutons de selection de type
$connexion = new BDD(false);
$connexion->requete("SELECT * FROM type_act"); 		/*on recupere pour cela la table des types d'activites*/
$type_act = $connexion->retourne_tableau(); echo "type_act";var_dump($type_act);

//ici on va faire les radio de selection du public visé
$connexion->requete("SELECT * FROM public_vise");
$public_vise = $connexion->retourne_tableau(); 


?>
<div>
<a href="activites.php?type=1&public=<?php echo $public; ?>"><span <?php if ($type=='1') echo ' class="checked"'; ?>>Tous types</span></a>
<?php foreach ($type_act as $value) {		// pr chaque bouton, hors 'tous' puisque fait au dessus, si il est cliqué il prend class='checked', synonyme de coloration ?>
	<a href="activites.php?type=<?php echo $value['id_typeact']; ?>&public=<?php echo $public; ?>"><span <?php if ($type==$value['id_typeact']) echo 'class="checked"'; ?>><?php echo $value['type_affich']; ?></span></a>
<?php } ?>
</div>

		
<div id="aside1">
<a href="activites.php?type=1&public=<?php echo $public; ?>"><span <?php if ($type=='1') echo ' class="checked"'; ?>>Toute la famille</span></a>
<?php foreach ($public_vise as $value) {		// pr chaque bouton, hors 'tous' puisque fait au dessus, si il est cliqué il prend class='checked', synonyme de coloration ?>
	<a href="activites.php?type=<?php echo $type; ?>&public=<?php echo $value['id_publicvise']; ?>"><span <?php if ($public==$value['id_publicvise']) echo 'class="checked"'; ?>><?php echo $value['public_affich']; ?></span></a>
<?php } ?>
</div>

<?php 

}

?>
