<?php
include "config.php";
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
    	//$_SESSION['genre'] = "membre";
    		$_SESSION['sexe'] = $result[0]['sexe'];
    		header('location:mon_compte.php');
    	}
    	else {
    		echo "reesasayez";
    	}

    	
    }
    else { 	
    	$sql = "SELECT login, id_orga, mdp FROM organisation WHERE `login`=?";
  		$arr = array($_POST['login']);
  		$bind ="s";
  		$connexion_stmt->prepare($sql,$bind); 
  		$result2 = $connexion_stmt->execute($arr);		
  		if (!empty($result2)) {		// si il y a une reponse, c'est que celui qui a cliqué est un membre
    		if ($result2[0]['mdp']==$_POST['mdp']) {
    			$_SESSION['pseudo'] = $result2[0]['login'];	// on ouvre les sessions utiles
    			$_SESSION['id_membre'] = $result2[0]['id_orga'];
    	//$_SESSION['genre'] = "membre";
    			header('location:mon_compte.php');
    		}
    		else {
    			echo "reesasayez";
    		}
    	} else{ echo "reessayez"; }
    }
}
include "header.php";

echo "GET:";  var_dump($_GET);
echo "sessions:"; var_dump($_SESSION);
echo "POST"; var_dump($_POST);
$arr = array();

//if (isset($_SESSION['id_membre']) || isset($_SESSION['id_orga'])){}
?>


<div id="inscription" >
	<!-- <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"    -->
		<button id="btn_orga"> Organisation </button>
	</form> 
	<!-- <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"  -->
		<button id="btn_membre"> Membre </button>
	</form> 

		

<?php 
if (/*isset($_POST['btn_membre'])
	&&*/ isset($_POST['inscrip_membre'])
	&& !empty($_POST['pseudo'])
	&& !empty($_POST['mail'])
	&& !empty($_POST['mdp'])
	&& !empty($_POST['mdp2'])
	&& $_POST['mdp'] == $_POST['mdp2']) {
	echo"TEST<br/>";
//	$pseudo = $_POST["pseudo"]; echo "pseudo:";var_dump($pseudo);
//	$sexe = $_POST["sexe"];		
	if ($_POST["sexe"] == "homme") 
		$sexe = 0;	 
	else $sexe= 1;
//	$mail = $_POST["mail"];	echo "mail:";var_dump($mail);	
//	$mdp = $_POST["mdp"];	echo "mdp:";var_dump($mdp);
	
	$connexion_stmt = new BDD();
	$sql = "INSERT INTO membre (pseudo, sexe, mail, mdp) VALUES (?,?,?,?)";
	$bind ="siss";
	$arr = array($_POST['pseudo'], $sexe, $_POST['mail'], $_POST['mdp']);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); echo"result:";var_dump($result);
	
	if ( $result != 0 ) {
    	$_SESSION['pseudo'] = $result[0]['pseudo'];
    	$_SESSION['id_membre'] = $connexion_stmt->get_last_id();
    	$_SESSION['sexe'] = $result[0]["membre"];
    }
}

else {
?>
	<form method="POST" action="inscription.php" id="formu_membre" >
		<label for="homme"> Homme </label><input type="radio" name="sexe" value="homme" id="homme"  <?php if(((isset($_POST['sexe']) and $_POST['sexe']=="homme")) or !isset($_POST['civilite'])) echo "checked"; ?> />
		<label for="femme"> Femme </label><input type="radio" name="sexe" value="femme" id="femme" <?php if(((isset($_POST['sexe']) and $_POST['sexe']=="femme"))) echo "checked"; ?> /> 
			<span class="erreur"></span> <br/>
	
		<label for="pseudo"> Pseudonyme: </label><input type="text" name="pseudo" id="pseudo" placeholder="au moins 3 caractères"  <?php if(isset($_POST['pseudo']) and !empty($_POST['pseudo'])) echo 'value="'.$_POST['pseudo'].'"/>'; else echo '/>' ?> 
			<span class="erreur"></span><br/>
		<label for="mail_mb"> Mail: </label><input type="text" name="mail" id="mail_mb" placeholder="un mail valide" <?php if(isset($_POST['mail']) and !empty($_POST['mail'])) echo 'value="'.$_POST['mail'].'"/>'; else echo '/> '; ?> 
			<span class="erreur"> </span><br/>
		<label for="mdp_mb"> Mot de passe: </label><input type="password" name="mdp" id="mdp_mb" />  
			<span class="erreur"> </span><br/>
		<label for="mdp2_mb"> Confirmation du mot de passe: </label> <input type="password" name="mdp2" id="mdp2_mb" /> 
			<span class="erreur"> </span><br/>
 		<input type="button" value="M'inscrire" name="inscrip_membre" id="inscrip_membre" />
		
	</form>
<?php
}


if (/*isset($_POST['btn_orga'])
	&&*/ isset($_POST['inscrip_orga'])
	&& !empty($_POST['nom_orga'])  
	&& !empty($_POST['mail']) 
	&& !empty($_POST['mdp']) 
	&& !empty($_POST['mdp2'])
	&& $_POST['mdp'] == $_POST['mdp2'] ) {
print_r($_POST);
//	$pseudo = $_POST["pseudo"]; echo "pseudo:";var_dump($pseudo);
//	$mail = $_POST["mail"];	echo "mail:";var_dump($mail);	
//	$mdp = $_POST["mdp"];	echo "mdp:";var_dump($mdp);
	
	$connexion_stmt = new BDD();
	$sql = "INSERT INTO organisation (nom_orga, mail_secretaire, mdp) VALUES (?,?,?)";
	$bind ="sss";
	$arr = array($_POST['nom_orga'], $_POST['mail'], $_POST['mdp']);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); //echo"result:";var_dump($result);
	
	if ($result != 0) {
    	$_SESSION['nom_orga'] = $result[0]['nom_orga'];
    	$_SESSION['id_orga'] = $connexion_stmt->get_last_id();
    	//$_SESSION['genre'] = "orga";
    }
}

else {

?>

	<form method="POST" id="formu_orga" action="inscription.php" >
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



 
?>	<div id='connexion'>
	<form method="POST" id="connexion" action="inscription.php" >
		<label for="login" > Login/ Pseudo: </label> <input type="text" name="login" id="login" /> 
			<span class="erreur"></span><br/>
		<label for="mdp"> Mot de passe: </label> <input type="password" name="mdp" id="mdp" />
			<span class="erreur"></span><br/>
		<input type="submit" value="Connexion" name="connexion" />	
	</form>

</div>


<?php 



?>
<script type="text/javascript">
	$(document).ready(function() {
	// si le JS est actif, on cache le formulaire des organisations 
		$("#formu_orga").load().hide();
	
	// choix du formulaire inscription membre ou organisation
		$("#btn_membre").click(function(){
			$("#formu_orga").hide();
			$("#formu_membre").show();
		});
		$("#btn_orga").click(function(){
			$("#formu_membre").hide();
			$("#formu_orga").show();
		});
		$('#inscrip_membre').click(function() {
		var name= ($(this).attr("name"));
		var erreur= $(this).html(".erreur");
		if($("#pseudo").val() == "") { erreur.html("veuillez entrer un pseudo"); }         //... ou ce que tu veux d'autre comme message
		if($("#mail_mb").val== "") { alert("2");/*erreur("veuillez entrer un mail"); */}
		//....
 			$.ajax({
                     type:"POST",
                     url:"verif_doublons_mb.php",
                     data:"nom_orga="+$("#nom_orga").val(),
                     success:function(data){
                         if (data=="doublon") {
                              $('.erreur').html("cette organisation existe deja");
                         }
                         else {
                            $.ajax({
			                    type:"POST",
			                    url:"verif_doublons_mb.php",
			                    data:"mail_mb="+$("#mail").val(),
			                    success:function(data){
			                         if (data=="doublon") {
			                              $('.erreur').html("ce mail existe deja");
			                         }
			                         else {
			                             $("#formu_membre").submit();
			                         }
                     			}
                 			});
                         }
                     }
            });
		});
	});
</script>
