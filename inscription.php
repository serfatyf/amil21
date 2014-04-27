<?php
include "config.php";
require_once('verif_doublons.php');
	$arr = array();
	// connexion, on verifie ds la table "membre" puis ds la table "organisation"
if (isset($_POST['connexion']) && !empty($_POST['login']) && !empty($_POST['mdp'])){
	
	$connexion_stmt = new BDD();
		// on regarde d'abord dans la table membres, la + grande
	$sql = "SELECT pseudo, id_membre, sexe, mdp FROM membre WHERE `pseudo`=?";
  	$arr = array($_POST['login']);
  	$bind ="s";
  	$connexion_stmt->prepare($sql,$bind); 
  	$result = $connexion_stmt->execute($arr);	
  	if (!empty($result)) {		// si il y a une reponse, c'est que celui qui a cliqué est un membre
    	if ($result[0]['mdp']==$_POST['mdp']) {
    		$_SESSION['pseudo'] = $result[0]['pseudo'];	// on ouvre les sessions utiles
    		$_SESSION['id_membre'] = $result[0]['id_membre'];
       		$_SESSION['sexe'] = $result[0]['sexe'];
    		header('location:mon_compte.php');
    	}
    	else {
    		header('location:inscription.php?again=1');
    	}

    	
    }
    else { 	
    	$sql = "SELECT login, id_orga, mdp, nom_orga FROM organisation WHERE `login`=?";
  		$arr = array($_POST['login']);
  		$bind ="s";
  		$connexion_stmt->prepare($sql,$bind); 
  		$result2 = $connexion_stmt->execute($arr);		
  		if (!empty($result2)) {		// si il y a une reponse, c'est que celui qui a cliqué est un membre
    		if ($result2[0]['mdp']==$_POST['mdp']) {
    			$_SESSION['pseudo'] = $result2[0]['login'];	// on ouvre les sessions utiles
    			$_SESSION['id_orga'] = $result2[0]['id_orga'];
    			$_SESSION['nom_orga'] = $result2[0]['nom_orga'];
    			header('location:mon_compte.php');
    		}
    		else {
    			header('location:inscription.php?again=1');
    		}
    	} else{     		
    		header('location:inscription.php?again=1');
 		}
    }
}
include "header.php";
/*
echo "GET:";  var_dump($_GET);
echo "sessions:"; var_dump($_SESSION);
echo "POST"; var_dump($_POST);
*/

//if (isset($_SESSION['id_membre']) || isset($_SESSION['id_orga'])){}
?>


<div id="inscription" >
<?php
if(count($_POST)==0) {	//si on n'a pas cliqué, on rend les 2 boutons orga et membre pr le choix du formu d'inscription

?>
	<form method="post" action=""> 
		<input type="submit" name="organisation" value="Organisation" id="btn_orga">
	</form> 
	<form method="post" action="">
		<input type="submit" name="membre" value="Membre" id="btn_membre">
	</form> 
	<div id='again'>
<?php
	if(isset($_GET['again']))
		echo "<p>Echec de connexion</p>";

			// ainsi que le formu de connexion
?>
	<form method="POST" id="connexion" action="" >
		<label for="login" > Login/ Pseudo: </label> <input type="text" name="login" id="login" /> 
			<span class="erreur"></span><br/>
		<label for="mdp"> Mot de passe: </label> <input type="password" name="mdp" id="mdp" />
			<span class="erreur"></span><br/>
		<input type="submit" value="Connexion" name="connexion" />	
	</form>

</div>
<?php
} else { // sinon on a cliqué
 	
 	// soit sur membre
if ( isset($_POST['inscrip_membre'])
	&& !empty($_POST['pseudo'])
	&& !empty($_POST['mail'])
	&& !empty($_POST['mdp'])
	&& !empty($_POST['mdp2'])
	&& $_POST['mdp'] == $_POST['mdp2']) {
	echo"test.<br/>";
//	$pseudo = $_POST["pseudo"]; echo "pseudo:";var_dump($pseudo);
//	$sexe = $_POST["sexe"];		
//	$mail = $_POST["mail"];	echo "mail:";var_dump($mail);	
//	$mdp = $_POST["mdp"];	echo "mdp:";var_dump($mdp);

	$connexion_stmt = new BDD();

	if(!doublon_membre()) {

		$sql = "INSERT INTO membre (pseudo, sexe, mail, mdp) VALUES (?,?,?,?)";
		$bind ="siss";
		$arr = array($_POST['pseudo'], $_POST['sexe'], $_POST['mail'], $_POST['mdp']);
		$connexion_stmt->prepare($sql,$bind);
		$result = $connexion_stmt->execute($arr); echo"result:";var_dump($result);

//ERREUR		//if ( $result != 0 ) {
			// $_SESSION['pseudo'] = $result[0]['pseudo'];
			// $_SESSION['id_membre'] = $connexion_stmt->get_last_id();
			// $_SESSION['sexe'] = $result[0]["membre"];
		//}
	} else
		$_POST['membre'] = "ok";
}

if(isset($_POST['membre'])) {
?>
	<form method="POST" action="" id="formu_membre" >
		<label for="homme"> Homme </label><input type="radio" name="sexe" value="0" id="homme"  <?php if(((isset($_POST['sexe']) and $_POST['sexe']=="homme")) or !isset($_POST['civilite'])) echo "checked"; ?> />
		<label for="femme"> Femme </label><input type="radio" name="sexe" value="1" id="femme" <?php if(((isset($_POST['sexe']) and $_POST['sexe']=="femme"))) echo "checked"; ?> /> 
			<span class="erreur"></span> <br/>
	
		<label for="pseudo"> Pseudonyme: </label><input type="text" name="pseudo" id="pseudo" placeholder="au moins 3 caractères"  <?php if(isset($_POST['pseudo']) and !empty($_POST['pseudo'])) echo 'value="'.$_POST['pseudo'].'"/>'; else echo '/>' ?> 
			<span class="erreur"></span><br/>
		<label for="mail_mb"> Mail: </label><input type="text" name="mail" id="mail_mb" placeholder="un mail valide" <?php if(isset($_POST['mail']) and !empty($_POST['mail'])) echo 'value="'.$_POST['mail'].'"/>'; else echo '/> '; ?> 
			<span class="erreur"> </span><br/>
		<label for="mdp_mb"> Mot de passe: </label><input type="password" name="mdp" id="mdp_mb" />  
			<span class="erreur"> </span><br/>
		<label for="mdp2_mb"> Confirmation du mot de passe: </label> <input type="password" name="mdp2" id="mdp2_mb" /> 
			<span class="erreur"> </span><br/>
 		<input type="submit" value="M'inscrire" name="inscrip_membre" id="inscrip_membre" />
		
	</form>
<?php
}


if ( isset($_POST['inscrip_orga'])
	&& !empty($_POST['nom_orga'])
	&& !empty($_POST['pseudo'])  
	&& !empty($_POST['mail']) 
	&& !empty($_POST['mdp']) 
	&& !empty($_POST['mdp2'])
	&& $_POST['mdp'] == $_POST['mdp2'] ) {
//	$pseudo = $_POST["pseudo"]; echo "pseudo:";var_dump($pseudo);
//	$mail = $_POST["mail"];	echo "mail:";var_dump($mail);	
//	$mdp = $_POST["mdp"];	echo "mdp:";var_dump($mdp);
	
	$connexion_stmt = new BDD();

	if(!doublon_orga()) {

		$sql = "INSERT INTO organisation (nom_orga, mail_secretaire, mdp, login) VALUES (?,?,?,?)";
		$bind ="ssss";
		$arr = array($_POST['nom_orga'], $_POST['mail'], $_POST['mdp'], $_POST['pseudo']);
		$connexion_stmt->prepare($sql,$bind);
		$result = $connexion_stmt->execute($arr); echo"result:";var_dump($result);
	
//ERREUR		if ($result != 0) {
		//	$_SESSION['nom_orga'] = $result[0]['nom_orga'];
		//	$_SESSION['id_orga'] = $connexion_stmt->get_last_id();
    	//	$_SESSION['pseudo'] = $result[0]['pseudo'];
		//}
	} else
		$_POST['organisation'] = "ok";
}

if (isset($_POST['organisation'])) {

?>

	<form method="POST" id="formu_orga" action="" >
			<label for="nom_orga"> Nom de l'organisation: </label><input type="text" name="nom_orga" id="nom_orga" placeholder="votre organisation"/> 
				<span class="erreur"></span><br/>
			<label for="pseudo"> Pseudo </label> <input type="text" name="pseudo" id="pseudo" placeholder="ce pseudo servira à la connexion"/> <br/>
			<label for="mail_orga"> Mail: </label><input type="text" name="mail" id="mail_orga" placeholder="un mail valide svp"/> 
				<span class="erreur"></span><br/>
			<label for="mdp_orga"> Mot de passe: </label><input type="password" name="mdp" id="mdp_orga" /> 
				<span class="erreur"></span><br/>
			<label for="mdp2_orga"> Confirmation du mot de passe:  </label><input type="password" name="mdp2" id="mdp2_orga" /> 
				<span class="erreur"></span><br/>
			<input type="button" value="Inscription" name="inscrip_orga" />
	</form>

</div>


<?php

}

}
?>
