<?php
/*	$utilisateurs = array(
		array('login' => 'login', 'mdp' => 'mdp'),
		array('login' => 'toto', 'mdp' => 'titi'));
*/	
include "config.php";

include "header.php";
echo "POST:";  var_dump($_POST);
echo "sessions:"; var_dump($_SESSION);
echo "GET:";  var_dump($_GET);

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

if(isset($_POST['login']) && isset($_POST['mdp'])) {
	$connexion_stmt= new BDD();
  	$sql = "SELECT pseudo, id FROM membre WHERE login=? AND mdp=?";
  	$arr = array($_POST['login'], $_POST['mdp']);
  	$bind ="ss";
  	$connexion_stmt->prepare($sql,$bind);
  	$result = $connexion_stmt->execute($arr);
  	echo "result";var_dump($result);
  	if (count($result)==1) {
    	$checklogin=true;
		$_SESSION['login'] = true;
    	$_SESSION['pseudo'] = $result[0]['pseudo'];
    	$_SESSION['id'] = $result[0]['id'];
    	$_SESSION['type'] = "membre";
    //echo "succes";
  	
		// echo "<b>Bonjour utilisateur $login</b>\n";
		// $checklogin=true;
		// $_SESSION['login'] = true;
	} 
	//else if(isset($_POST['validelogin'])) {
}	
else {
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
	<input type='submit' name='retour' value="Retour à l'accueil" id="submit2"/>
	</form>
	</div>

</body>
</html>
<?php
	exit(0);
	}
?>