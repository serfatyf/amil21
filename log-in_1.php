<div>
	<label for="orga"> Vous êtes une organisation:</label>
		<input type="radio" name="qui" id="orga" value="orga" />
    <label for="membre"> vous êtes un membre ou un futur membre:</label>
    	<input type="radio" name="qui" id="membre" value="membre" />
</div>

<div>
<form method="POST" action="">  
<?php 
	if (isset($_POST['qui'])){
		if (isset($_POST['membre']))
    		echo "<p> Je suis déjà membre AM-IL</p>"
    <p> <sup>*</sup><label for="login"> Adresse mail </label><input type="text" id="login" name="login" <?php if (isset($_POST["login"])) echo "value='".$_POST["login"]."'"; ?> />  </p>
    <p> <sup>*</sup><label for="mdp"> Mot de passe </label><input type="password" id="mdp" name="mdp" />  </p>
    <p> <input type="submit" value="Connexion" name="connexion_membre" /> </p>
    <p> <a href="/register_false.php"> Mot de passse oublié?</a> </p>
</form>
<p> OU </p>
<form method="POST" action="">
    <p> Je m'inscris </p>
    <p><sup>*</sup>Sexe:<label for="homme"> <input type="radio" id="homme" name="sexe" value="Homme" />Homme:</label>
    <label for="femme"> <input type="radio" id="femme" name="sexe" value="Femme" />Femme</label></p>
    <p> <label for="pseudo"> Pseudo </label><input type="text" id="pseudo" name="pseudo" <?php if (isset($_POST["pseudo"])) echo "value='".$_POST["pseudo"]."'"; ?> />  </p>
    <p> <label for="prenom"> Prénom </label><input type="text" id="prenom" name="prenom" <?php if (isset($_POST["prenom"])) echo "value='".$_POST["prenom"]."'"; ?> />  </p>
    <p> <sup>*</sup><label for="login"> Adresse mail </label><input type="text" id="login" name="login" <?php if (isset($_POST["login"])) echo "value='".$_POST["login"]."'"; ?> />  </p>
    <p> <sup>*</sup><label for="mdp"> Mot de passe </label><input type="password" id="mdp" name="mdp" />  </p>
    <p> <sup>*</sup><label for="mdp2"> Confirmer votre mot de passe </label> <input type="password" id="mdp2" name="mdp2" /> </p>
