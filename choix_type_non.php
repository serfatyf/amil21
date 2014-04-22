<?php 

if (isset($_GET['recherche'])){

// if (isset($_GET['act']))
// 	$act =	$_GET['act'];
// else $act = '0';

// if (isset($_GET['pb']))
// 	$act =	$_GET['act'];
// else $act = '0';

	$connexion = new BDD(false);
	$connexion->requete("SELECT * FROM type_act");  //on recupere la table type_act
	$type_act = $connexion->retourne_tableau();
	foreach ($type_act as $value){
		if (file_exists('ico_'.$value['type'].'.png'))  // on crée le tableau des icones, si elles existent
			$icones_act[$value['id_typeact']] =  'ico_'.$value['type'].'.png';
	}
// fin de l'inutile (?)
				// echo "<pre> type_act:";print_r($type_act); echo "</pre><br/>";
				// echo "<pre> icones_act:";print_r($icones_act); echo "</pre><br/>";


	$connexion_stmt = new BDD();

	$bind = "";
	$sql = "SELECT   id_act, type, titre, date_act , id_act_typeact, nom_orga, public FROM  act 
					INNER JOIN public_vise ON id_publicvise=id_act_publicvise
	 				INNER JOIN type_act  ON id_typeact = id_act_typeact
	 				INNER JOIN organisation ON id_act_orga = id_orga  AND date_act>=CURRENT_DATE()";
	
	if ($_GET['activites'] != "toutes") {		// si ce n'est pas "toutes", c'est qu'on a choisi un type d'activites
		$sql .= " WHERE type = ? ";		// on met donc une condition a la requete
		$bind .= "s";					  // et on rajoute une condition de bind
		if($_GET['public'] != "tous"){	// si on a choisi aussi un public
			$sql .= " AND public= ? ";			  // on rajoute la condition ds la requete
			$bind .= "s";
		}
	}				// si on arrive ici, c'est qu'on n'avait pas choisi un type d'activite
	
	elseif ($_GET['public'] != "tous"){		// meme chose qu'avant pour le public
		$sql .= " WHERE public= ? ";
		$bind .= "s";
	}
	$sql .= "ORDER BY date_act ASC";
	
echo "act<br>";var_dump($_GET['activites']);
echo "bind<br>";	var_dump(($bind));
echo "public<br>";	var_dump($_GET['public']);
echo "sql<br>";	var_dump($sql);

	$arr= array($_GET["activites"],$_GET['public']); echo "arr:"; var_dump($arr);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);
return "succes";
}
