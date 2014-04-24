<?php
include "config.php";

include "header.php";
// if(isset($_POST['deco'])){
// 	unset($_SESSION['login']);
// 	unset($_SESSION['id_membre']);
// 	unset($_SESSION['type']);
// }
// echo "POST:";  var_dump($_POST);
// echo "sessions:"; var_dump($_SESSION);
// echo "GET:";  var_dump($_GET);

$icones_act=array();
$activite=array();
//et le tableau des icones; celui là + !!
// if (isset($_GET['recherche'])){
// $connexion = new BDD(false);
// $connexion->requete("SELECT * FROM type_act");  //on recupere la table type_act
// $type_act = $connexion->retourne_tableau();
// foreach ($type_act as $value){
// 	if (file_exists('ico_'.$value['type'].'.png'))  // on crée le tableau des icones, si elles existent
// 		$icones_act[$value['id_typeact']] =  'ico_'.$value['type'].'.png';
// }
// // fin de l'inutile (?)
// 				// echo "<pre> type_act:";print_r($type_act); echo "</pre><br/>";
// 				// echo "<pre> icones_act:";print_r($icones_act); echo "</pre><br/>";


// 	$connexion_stmt = new BDD();

// 	$bind = "";
// 	$sql = "SELECT   id_act, type, titre, date_act , id_act_typeact, nom_orga, public FROM  act 
// 					INNER JOIN public_vise ON id_publicvise=id_act_publicvise
// 	 				INNER JOIN type_act  ON id_typeact = id_act_typeact
// 	 				INNER JOIN organisation ON id_act_orga = id_orga  AND date_act>=CURRENT_DATE()";
	
// 	if ($_GET['activites'] != "toutes") {		// si ce n'est pas "toutes", c'est qu'on a choisi un type d'activites
// 		$sql .= " WHERE type = ? ";		// on met donc une condition a la requete
// 		$bind .= "s";					  // et on rajoute une condition de bind
// 		if($_GET['public'] != "tous"){	// si on a choisi aussi un public
// 			$sql .= " AND public= ? ";			  // on rajoute la condition ds la requete
// 			$bind .= "s";
// 		}
// 	}				// si on arrive ici, c'est qu'on n'avait pas choisi un type d'activite
	
// 	elseif ($_GET['public'] != "tous"){		// meme chose qu'avant pour le public
// 		$sql .= " WHERE public= ? ";
// 		$bind .= "s";
// 	}
// 	$sql .= "ORDER BY date_act ASC";
	
// echo "act<br>";var_dump($_GET['activites']);
// echo "bind<br>";	var_dump(($bind));
// echo "public<br>";	var_dump($_GET['public']);
// echo "sql<br>";	var_dump($sql);

// 	$arr= array($_GET["activites"],$_GET['public']); echo "arr:"; var_dump($arr);
// 	$connexion_stmt->prepare($sql,$bind);
// 	$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);


//if (isset($_GET['recherche'])){



if (isset($_GET['type']))	// si on a choisi un type (qui correspond à un nombre) 
	$type =	$_GET['type'];	// le type est le nbr choisi
else $type = '1';			// sinon le type est 1, qui correspond à la recherche "tous types" 

if (isset($_GET['public']))		// idem pour le public
	$public =	$_GET['public'];
else $public = '1';



// if (isset($type) && isset($public)){

// 	$connexion = new BDD(false);
// 	$connexion->requete("SELECT * FROM type_act");  //on recupere la table type_act
// 	$type_act = $connexion->retourne_tableau();
// 	foreach ($type_act as $value){
// 		if (file_exists('ico_'.$value['type'].'.png'))  // on crée le tableau des icones, si elles existent
// 			$icones_act[$value['id_typeact']] =  'ico_'.$value['type'].'.png';
// 	}
// fin de l'inutile (?)
				// echo "<pre> type_act:";print_r($type_act); echo "</pre><br/>";
				// echo "<pre> icones_act:";print_r($icones_act); echo "</pre><br/>";

	// requete renvoyant le choix d'activite fait par l'utilisateur
if (isset($type) && isset($public)){
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
	
// echo "act:";var_dump($_GET['type']);
// echo "bind:";	var_dump(($bind));
// echo "public:";	var_dump($_GET['public']);
// echo "sql:";	var_dump($sql);

	$arr= array($type,$public); echo "arr:"; var_dump($arr);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);
//}

	foreach ($result as $value) { 
		
		echo "<a href='activite.php?id=".$value['id_act']."' >";
		
		echo $value['titre']."</a> ";
		echo "<p>organisé par: " . $value['nom_orga'] ."</p>";
 	}

// $connexion->requete("SELECT  act.`id`, `id_type_act`, `titre`, `type`, `nom_orga`, `public`, `date_act`
// 				 FROM  act 
// 					INNER JOIN public_vise ON public_vise.id=act.id_public_vise
// 					INNER JOIN type_act ta ON ta.id = act.id_type_act
// 					INNER JOIN organisation ON act.id_organisation = organisation.id
// 					WHERE id_type_act = '{$_POST['activites']}'");
// echo $connexion;
// $activites = $connexion->retourne_tableau();

// 				echo "<pre> activites:";print_r($activites); echo "</pre><br/>";
 
// 				 echo "<pre> icones_act:";print_r($icones_act); echo "</pre><br/>";	
// if (mysqli_stmt_num_rows($stmt) > 0){		// si il y a des activités dans la base
//  	foreach($activites as $activite)  {
// 				// echo "<pre> activite[id_type_act]:";print_r($activite["id_type_act"]); echo "</pre><br/>";
// 	// $icones_act[$activite['id_type_act']] = $activite['type'];
// 		echo " <img src='".$icones_act[$activite['id_type_act']]."' alt='".$activite['type']."'  />";
// 	// echo '<a href="index.php?menu=activite">'.$activite["titre"].'</a><br>';
// 		//if (isset($_POST['rechercher'])){
// 		echo "<a href='index.php?menu=activite&id=".$activite['id']." ' ";
// 		echo ">".$activite['titre']."<p id='organisateur'> organisé par ". $activite['nom_orga']."</p></a><br/>";
		 
	//}
 //}	
 //else echo "Désolé mais les organisations de la régions ne sont pas assez actives; il n'y a aucune activité de prévue actuellement";


		//on va faire les boutons de selection de type
$connexion = new BDD(false);
$connexion->requete("SELECT * FROM type_act"); 		/*on recupere pour cela la table des types d'activites*/
$type_act = $connexion->retourne_tableau(); echo "type_act";var_dump($type_act);


?>
<div>
<form method="GET" action=" <?php echo 'activites.php' ?>" >
	
		<!-- si type=1, cad pr le choix de 'tous', le bouton correspondant prend sa classe -->
	<button id="1" name="type" value="1" <?php if ($type=='1') echo " class='checked'" ?> >Tous types</button></form>
<?php 
		// pr chaque bouton, hors 'tous' puisque fait au dessus,
			// si il est cliqué il prend class='checked', synonyme de coloration
	foreach ($type_act as $value) {
		
		echo "\t<form method='GET' action='activites.php'>"; 
		echo "<button id='". $value['id_typeact'] ."' name='type' value='". $value['id_typeact'] ."'";
		if ($value['id_typeact'] == $type) echo " class='checked'";
		else echo ">";
		echo $value['type_affich'] ." </button></form>\n";
	}
 ?>
</div>

		
<div id="aside1">
	<p> Filtres supplémentaires</p>
<?php
		//ici on va faire les radio de selection du public visé
$connexion->requete("SELECT * FROM public_vise");
$public_vise = $connexion->retourne_tableau(); 
?>	
	<p> <label for="famille"> <input type="radio" name="public" value="famille" id="famille" /> Toute la famille</label></p>
<?php 

	foreach ($public_vise as $value) {				// on fait le select "public visé" de la barre de recherche
		echo "<p> <label for='". $value['public'] ."'><input type='radio' name='public' value='". $value["public"] ."' id='". $value["public"] ."'>" .$value['public_affich'] . "</label></p>";
	}
?>
</div>

<!-- 	si
<script type="text/javascript">
	$(document).ready(function() {
			 // inutile puisqu'on passe par GET 
	  //   $("button").click(function() {
			// $("button").each(function(el){
			// 	if (el.hasclass('checked'))
			// 		el.removeClass('checked');
			// });
			// $(this).addClass('checked');
			// )
	    		// fin de l'inutile
			$.ajax({
				"type":"GET",
				"url":"log_test.php",
				"data":"type="+$("#activites")+$("#public").val(),
				success:function(data) {
					if (data=='succes') {
						 window.location.reload();
					} 
					else {
						alert ("erreur dans le login ou le mot de passe");
					}
				}
			});
		});
	//});
</script>
 --> <!-- <div id="aside2">
	<p>	<label for="06"> <input type="radio" name="departement" value="06" id="06" /> Alpes-Maritimes</label></p>
	<p>	<label for="83"> <input type="radio" name="departement" value="83" id="83" /> Var</label></p>
</div> 
<div>	
	<p>
		<input type="submit" name="valide" value="Filtrer" />
	</p>
</div>
</form> -->	 
<?php 

//include "footer.php";
}
// }} 
// else {

// 	include "index.php";
// }
?>
