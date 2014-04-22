<?php
/*	$utilisateurs = array(
		array('login' => 'login', 'mdp' => 'mdp'),
		array('login' => 'toto', 'mdp' => 'titi'));
*/	
	$login = "";
	$mdp = "";

	if(isset($_POST['validelogin'])) {
		if(isset($_POST['login']))
			$login = $_POST['login'];
		if(isset($_POST['mdp']))
			$mdp = $_POST['mdp'];
	} 

	if(isset($_SESSION['login']))
		$checklogin = $_SESSION['login'];
	else
		$checklogin = false;

	$maconnexion = new BDD();
	$stmt = $maconnexion->get_stmt();
	stmt_prepare($stmt,"SELECT * FROM membres WHERE `mail`= ? AND ``");
	mysqli_stmt_bind_param($stmt, "s", $nom);
	$nom="D%";

	mysqli_stmt_execute($stmt);

	mysqli_stmt_bind_result($stmt, $id, $NomP, $SalaireP);


	if($login == 'login' && $mdp == 'mdp') {
		echo "<b>Bonjour utilisateur $login</b>\n";
		$checklogin=true;
		$_SESSION['login'] = true;
	} else if(isset($_POST['validelogin'])) {
	?><script type='text/javascript'> document.getElementById("vide").innerHTML='Echec de connexion'; </script> <?php
	}

	if(!$checklogin) {
?>
	<div id="conteneur_accueil">
	<p>Entrer login et mot de passe</p>
	<form method='post' action='<?php echo $_SERVER['PHP_SELF'];?>'>
		<div class="input">
			<label for="input1">identifiant  : </label><input type="text" name='login' id="input1"/>
		</div>
		<div class="input">
			<label for="input2"> mot de passe : </label><input type="password" name='mdp' id="input2"/>
		</div>
		<input type='submit' name='validelogin' value='Soumettre' id="submit1">
		<div id="vide"></div>
	</form>
	<form method="POST" action="index.php">
	<input type='submit' name='retour' value="Retour à  m:l'accueil" id="submit2"/>
	</form>
	</div>

</body>
</html>
<?php
	exit(0);
	}
?>
