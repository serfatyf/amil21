<?php
include "config.php";
include "header.php";

// if ( isset($_SESSION['genre']) && $_SESSION['genre'] == 'orga'
// 	&& isset($_SESSION['nom_orga']) && isset($_SESSION['id_orga'])) {
// $id_orga = $_SESSION['id_orga']; 
$id_orga="";	//a regler selon les sesssons
	echo "<h1> Mes informations </h1>";
	$connexion = new BDD(false);	//rajouter age et date de naissance, presentation
	$connexion->requete ("SELECT nom_orga, presentation_orga, nom_president, mail_president, tel_president, mail_secretaire, nom_secretaire, adresse, ville, departement FROM organisation WHERE id_orga = $id_orga ");
	
	$result = $connexion->retourne_tableau(); echo "result:"; var_dump($result);
		
	if(count($result) == 0) {
		echo "il n'existe pas de fiche d'organisation ici";
	}
	// else if (isset($_POST['envoyer'])){
	// 	$sql = " UPDATE organisation SET nom_orga = ?, presentation_orga = ? ,  nom_president = ? , mail_president = ?, tel_president=?, nom_secretaire=?, mail_secretaire=?, adresse=?, ville=?, departement=? WHERE id_orga = $aid_orga ";
	// 	$bind = "ssssssssss";
	// 	$arr= array($_POST['nom_orga'], $_POST['presentation_orga'], $_POST['nom_president'], $_POST['mail_president'], $_POST['tel_president'], $_POST['nom_secretaire'], $_POST['mail_secretaire'], $_POST['adresse'], $_POST['ville'], $_POST['departement'], ); echo "arr:"; var_dump($arr);
	// 	$connexion_stmt->prepare($sql,$bind); 
	// 	$result = $connexion_stmt->execute($arr); echo "result2:"; var_dump($result);
	// 	echo "il y a eu ".$result." changements ds la bdd";
	// }
	else {
?>

<form method="post" action="">

<label for="nom_orga">Nom de l'organisation: </label>
	<input type="text" id="nom_orga" name="nom_orga" value="<?php echo $result[0]['nom_orga'] ?>" />
<label for="presentation_orga"> Présentation: </label>
	<form method="post" action="" id="presentation_orga" >
    	<textarea><?php echo $result[0]['presentation_orga'] ?></textarea>
	</form>
<label for="nom_president">Nom du Président: </label>
	<input type="text" id="nom_president" name="nom_president" value="<?php echo $result[0]['nom_president'] ?>" />
<label for="mail_president">Mail du Président: </label>
	<input type="text" id="mail_president" name="mail_president" value="<?php echo $result[0]['mail_president'] ?>" />
<label for="tel_president">Téléphone du Président: </label>
	<input type="text" id="tel_president" name="tel_president" value="<?php echo $result[0]['tel_president'] ?>" />
<label for="nom_secretaire">Nom du Secrétaire: </label>
	<input type="text" id="nom_secretaire" name="nom_secretaire" value="<?php echo $result[0]['nom_secretaire'] ?>" />
<label for="mail_secretaire">Mail du Secrétaire: </label>
	<input type="text" id="mail_secretaire" name="mail_secretaire" value="<?php echo $result[0]['mail_secretaire'] ?>" />
<label for="adresse">Adresse: </label>
	<input type="text" id="adresse" name="adresse" value="<?php echo $result[0]['adresse'] ?>" />
<label for="ville">Ville: </label>
	<input type="text" id="ville" name="ville" value="<?php echo $result[0]['ville'] ?>" />
Département: <label for="06"> 06 </label>
	<input type="radio" id="06" name="departement" value="06" <?php if ($result[0]['departement']=="06") echo "checked" ?>  /> 
			<label for="83">	83 </label>
	<input type="radio" id="83" name="departement" value="83" <?php if ($result[0]['departement']=="83") echo "checked" ?>  /> 
<input type="submit" value="Envoyer" name="envoyer" />
</form>

<?php 
	}
//}

if (isset($_POST['envoyer'])){
	$connexion_stmt = new BDD();
	$sql = " UPDATE organisation SET nom_orga = ?, presentation_orga = ? ,  nom_president = ? , mail_president = ?, tel_president=?, nom_secretaire=?, mail_secretaire=?, adresse=?, ville=?, departement=? WHERE id_orga = $id_orga ";
	$bind = "sssssssssi";
	$arr= array($_POST['nom_orga'], $_POST['presentation_orga'], $_POST['nom_president'], $_POST['mail_president'], $_POST['tel_president'], $_POST['nom_secretaire'], $_POST['mail_secretaire'], $_POST['adresse'], $_POST['ville'], $_POST['departement'], ); echo "arr:"; var_dump($arr);
	$connexion_stmt->prepare($sql,$bind); 
	$result = $connexion_stmt->execute($arr); echo "result2:"; var_dump($result);
	echo "il y a eu ".$result." changements ds la bdd";
}