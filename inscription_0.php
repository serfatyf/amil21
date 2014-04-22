<?php
include "config.php";

include "header.php";

echo "GET:";  var_dump($_GET);
echo "sessions:"; var_dump($_SESSION);
echo "POST"; var_dump($_POST);
$arr = array();
?>
<div id="inscription" >
	<!-- <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >  -->
		<button id="btn_orga"> Organisation </button>
	<!-- </form> 
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >  -->
		<button id="btn_membre"> Membre </button>
	<!-- </form> -->

		

<?php 
		
		/////inscription des organisations

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
	
	if ( $result != 0 ) {	//si il n'y a pas d'erreur, c'est que la fiche est entrée en bdd
    	$_SESSION['login'] = $result[0]['login'];	// on ouvre donc les sessions utiles
    	$_SESSION['id_membre'] = $connexion_stmt->get_last_id();
    	$_SESSION['genre'] = "membre";
    }
}

else {		//formulaire d'inscription des organisations
?>
	<form method="POST" action="inscription.php" id="formu_membre" >
		<label for="homme"> Homme </label><input type="radio" name="sexe" value="homme" id="homme"  <?php if(((isset($_POST['sexe']) and $_POST['sexe']=="homme")) or !isset($_POST['civilite'])) echo "checked"; ?> />
		<label for="femme"> Femme </label><input type="radio" name="sexe" value="femme" id="femme" <?php if(((isset($_POST['sexe']) and $_POST['sexe']=="femme"))) echo "checked"; ?> /> 
			<span class="erreur"></span> <br/>
	
		<label for="pseudo"> Pseudonyme: </label><input type="text" name="pseudo" id="pseudo" placeholder="au moins 3 caractères"  <?php if(isset($_POST['pseudo']) and !empty($_POST['pseudo'])) echo 'value="'.$_POST['pseudo'].'"/>'; else echo '/>' ?> 
			<span class="erreur"></span><br/>
		<label for="mail"> Mail: </label><input type="text" name="mail" id="mail" placeholder="un mail valide" <?php if(isset($_POST['mail']) and !empty($_POST['mail'])) echo 'value="'.$_POST['mail'].'"/>'; else echo '/> '; ?> 
			<span class="erreur"> </span><br/>
		<label for="mdp"> Mot de passe: </label><input type="password" name="mdp" id="mdp" />  
			<span class="erreur"> </span><br/>
		<label for="mdp2"> Confirmation du mot de passe: </label> <input type="password" name="mdp2" id="mdp2" /> 
			<span class="erreur"> </span><br/>
 		<input type="submit" value="M'inscrire" name="inscrip_membre" id="inscrip_membre" />
		
	</form>
<?php
}
	//////////////inscription des membres

if (/*isset($_POST['btn_orga'])
	&&*/ isset($_POST['inscrip_orga'])
	&& !empty($_POST['nom_orga'])  
	&& !empty($_POST['mail']) 
	&& !empty($_POST['mdp']) 
	&& !empty($_POST['mdp2'])
	&& $_POST['mdp'] == $_POST['mdp2'] ) {

//	$pseudo = $_POST["pseudo"]; echo "pseudo:";var_dump($pseudo);
//	$mail = $_POST["mail"];	echo "mail:";var_dump($mail);	
//	$mdp = $_POST["mdp"];	echo "mdp:";var_dump($mdp);
	
	$connexion_stmt = new BDD();
	$sql = "INSERT INTO organisation (nom_orga, mail, mdp) VALUES (?,?,?)";
	$bind ="sss";
	$arr = array($_POST['nom_orga'], $_POST['mail'], $_POST['mdp']);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); //echo"result:";var_dump($result);
	
	if ($result != 0) {		
    	$_SESSION['login'] = $result[0]['login'];
    	$_SESSION['id_orga'] = $connexion_stmt->get_last_id();
    	$_SESSION['genre'] = "orga";
    }
}

else {		//formulaire d'inscription des membres

?>

	<form method="POST" id="formu_orga" action="inscription.php" >
			<label for="nom_orga"> Nom de l'organisation: </label><input type="text" name="nom_orga" id="nom_orga" placeholder="votre organisation"/> 
				<span class="erreur"></span><br/>
			<label for="mail"> Mail: </label><input type="text" name="mail" id="mail" placeholder="un mail valide svp"/> 
				<span class="erreur"></span><br/>
			<label for="mdp"> Mot de passe: </label><input type="password" name="mdp" id="mdp" /> 
				<span class="erreur"></span><br/>
			<label for="mdp2"> Confirmation du mot de passe:  </label><input type="password" name="mdp2" id="mdp2" /> 
				<span class="erreur"></span><br/>
			<input type="submit" value="Inscription" name="inscrip_orga" />
	</form>

</div>

<div id="connexion" >
<?php 
if (isset($_POST['connexion']) && !empty($_POST['login']) && !empty($_POST['mdp'])){
	
	$connexion_stmt = new BDD();
		// on regarde d'abord dans la table membres, la + grande
	$sql = "SELECT pseudo, id_membre/*, mdp*/, sexe FROM membre WHERE `pseudo`=? AND `mdp`=?";
  	$arr = array($_POST['login'], $_POST['mdp']);
  	$bind ="ss";
  	$connexion_stmt->prepare($sql,$bind); 
  	$result = $connexion_stmt->execute($arr);	
  	if (count($result)>0) {		// si il y a une reponse, c'est que celui qui a cliqué est un membre
    	$_SESSION['pseudo'] = $result[0]['pseudo'];	// on ouvre les sessions utiles
    	$_SESSION['id_membre'] = $result[0]['id_membre'];
    	$_SESSION['genre'] = "membre";
    	$_SESSION['sexe'] = $result[0]['sexe'];
    }
    else { 	// sinon on recherche dans la base des organisations (+ petite)
    	$sql = "SELECT login, id_orga, /*mdp,*/ FROM organisation WHERE `login`=? AND `mdp`=?";
  		$arr = array($_POST['login'], $_POST['mdp']);
  		$bind ="ss";
  		$connexion_stmt->prepare($sql,$bind); 
 		$result = $connexion_stmt->execute($arr);
		if (count($result)>0) {		// si il y a une reponse, c'est que celui qui a cliqué est une organisation
    		$_SESSION['login'] = $result[0]['login'];
    		$_SESSION['id_membre'] = $result[0]['id_membre'];
    		$_SESSION['genre'] = "orga";
    		$_SESSION['nom_orga'] = $result[0]['nom_orga'];
    	}
    	else echo "Vous avez du vous tromper quelque part, réessayez!";
    }
}
else {
?>
	<form method="POST" id="connexion" action="inscription.php" >
		<label for="login" > Login/ Pseudo: </label> <input type="text" name="login" id="login" /> 
			<span class="erreur"></span><br/>
		<label for="mdp"> Mot de passe: </label> <input type="password" name="mdp" id="mdp" />
			<span class="erreur"></span><br/>
		<input type="submit" value="Connexion" name="connexion" />	
	</form>
}

</div>
<!-- if (isset($_POST['inscrip_orga'])){
	
	if (isset($_POST["nom_orga"]) && isset($_POST["login"]) && isset($_POST["mail"]) && isset($_POST["mdp"])) {
		$nom_orga = $_POST["nom_orga"];
		$login = $_POST["login"];
		$mail = $_POST["mail"];
		$mdp = $_POST["mdp"];
	}

	$connexion_stmt = new BDD();
	$sql = "INSERT INTO organisation (nom_orga, login, mail, mdp) VALUES (?,?,?,?)";
	$bind ="ssss";
	$arr = array($nom_orga, $login, $mail, $mdp); 	
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); 
	
	if (count($result) == 1) {
    	$_SESSION['login'] = $result[0]['login'];
    	$_SESSION['id_orga'] = $result[0]['id_orga'];
    	$_SESSION['type'] = "organisation";
    }}
}

if (isset($_POST['connexion'])){
	if (isset($_GET['login']) && isset($_GET['mdp'])){
		$connexion_stmt = new BDD();
  		$sql = "SELECT login, id_membre, mdp FROM membre WHERE `login`=? AND `mdp`=?";
  		$arr = array($_GET['login'], $_GET['mdp']);
  		$bind ="ss";
  		$connexion_stmt->prepare($sql,$bind); 
  		$result = $connexion_stmt->execute($arr);
  //echo "result";var_dump($result);
  		if (count($result)>0) {
    		$_SESSION['login'] = $result[0]['login'];
    		$_SESSION['id_membre'] = $result[0]['id_membre'];
    		$_SESSION['type'] = "membre";
   		}
		else{
   			$sql = "SELECT login, id_orga, mdp FROM organisation WHERE `login`=? AND `mdp`=?";
  			$arr = array($_GET['login'], $_GET['mdp']);
  			$bind ="ss";
  			$connexion_stmt->prepare($sql,$bind); 
  			$result = $connexion_stmt->execute($arr);
  //echo "result";var_dump($result);
			if (count($result)>0) {
	    		$_SESSION['login'] = $result[0]['login'];
    			$_SESSION['id_orga'] = $result[0]['id_orga'];
    			$_SESSION['type'] = "orga";
   			}
   			else echo "erreur de connexion";
		}
	}
}



?>

 -->
<!-- <form method="post" action="" /> -->

<?php	
//}		

//include "log_test.php";

// formulaire de connexion
			
// if (isset($_POST['connexion']) && !( empty($_POST['login']) or empty($_POST['mdp'])) ){

// 	$connexion_stmt = new BDD();
// 	$sql = "SELECT id_membre FROM membre WHERE logi";
// 	$bind ="siss";
// 	$arr = array($_POST['pseudo'], $sexe, $_POST['mail'], $_POST['mdp']);
// 	$connexion_stmt->prepare($sql,$bind);
// 	$result = $connexion_stmt->execute($arr); echo"result:";var_dump($result);
	
// 	if ( $result != 0 ) {
//     	$_SESSION['login'] = $result[0]['login'];
//     	$_SESSION['id_membre'] = get_last_id();
//     	$_SESSION['type'] = "membre";
//     }
// }
// else {		
?>


<!-- <div id="connexion"> 
	<form method="post" action="mon_compte.php" />
		<label for="login"> Login: <input type="text" id="login" /> </label>
		<label for="mdp"> Mot de passe: <input type="password" id="mdp" /> </label>
		<input type="submit" name="connexion"> Connexion </input>
	</form>
</div>
 -->

 
<!-- // 	$(document).ready(function() {
// 		$("#inscrip_membre").click(function() {
// 			var valid = true;
// 			if ($("#pseudo").val() == ""){
// 				$("#pseudo").next(".erreur").show().text("veuillez entrer un pseudo");
// 				valid = false;
// 			}
// 			else if (!$("#pseudo").val().match(/^[a-z0-9_]{3,}$/i)) {
// 			 	$("#pseudo").next(".erreur").show().text("veuillez entrer un pseudo valide");
// 			 	valid=false;
// 			}
// 			else $("#pseudo").next(".erreur").hide();
// 			return valid;	// bloque l'envoi du formulaire si valid == false
// 		});

// 		$("#pseudo").blur(function() {
// 			var valid = true;
// 			$.ajax({
// 				"type":"POST",
// 				"url":"verif_doublons.php",
// 				"data":"pseudo="+$("#pseudo").val(),
// 				success:function(data){
// 					if (data=="doublon") {
// 				//ca ne rentre pas ds le if malgré le fait que verif_doublons renvoie bien 'doublon'
// 						$("#pseudo").next(".erreur").show().text("ce pseudo existe deja");
// 						valid=false;
// 					}
// 					else{ 
// 						$("#pseudo").next(".erreur").hide(); //alert(data);
// 					}
// 				}
				
// 			});

// 			return valid; // bloque l'envoi du formulaire si valid == false
// 		});		
// 	});
 -->


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
	$("#inscrip_membre").click(function() {
	// tests des differents champs, avec messages différenciés selon le champs
		var valid = true;
		 $("input").focus(function(){
		 	$(this).next(".erreur").hide(); 
		 }); 
		$("input").blur(function() {
			var name= ($(this).attr("name"));
			var erreur= $(this).next(".erreur");		// le span de class erreur apres le champ actif	
	// pseudo non vide, avec au moins 3 caracteres, et non redondant avec un element de la table
			if (name=="pseudo" && $("#pseudo").val() == ""){
		 		erreur.show().text("veuillez entrer un pseudo");
		 		valid = false; 
		 		
			}

			if (name=="pseudo" && !$("#pseudo").val().match(/^[a-zA-Z0-9_]{3,}$/)) {
		  		erreur.show().text("veuillez entrer un pseudo valide");
		 		valid=false;
			}
			else if (name=="pseudo") {
				$.ajax({
					"type":"POST",
					"url":"verif_doublons_mb.php",
					"data":"pseudo="+$("#pseudo").val(),
					success:function(data){
						if (data=="doublon") { 
							erreur.show().text("ce pseudo existe deja"); 
							valid=false;  //alert("pseudod"+valid+"3"+data);
						}
						// else { 
						// 	$("#pseudo").next(".erreur").hide();  //alert("pseudou"+valid+data);
						// }
					}
				});
			}
	// mail non vide, ayant une formulation regexée de mail, non redondante avec table
			if (name=="mail" && $("#mail").val() == ""){
				erreur.show().text("veuillez entrer un mail");
				valid = false;
			
			}
			else if (name=="mail" && !$("#mail").val().match(/^[a-z0-9\._-]+@[a-zA-Z]{2,}\.[a-z]{2,4}$/)) {
		 		erreur.show().text("veuillez entrer un mail valide");
		 		valid=false; 
			}
			else if (name=="mail") {
				$.ajax({
					"type":"POST",
					"url":"verif_doublons_mb.php",
					"data":"mail="+$("#mail").val(),
					success:function(data){
						if (data=="doublon") {	
							erreur.show().text("ce mail existe deja"); 
							valid=false; //alert("maild"+valid+data);
						}
						// else { 
						// 	$("#mail").next(".erreur").hide(); //alert("mailu"+valid+data+"-");
						// }
					}
				});
			}
	// mot de passe de 7 caracteres (regex) et verification par 2e demande, qui doit etre identique
			if (name=="mdp" && !$("#mdp").val().match(/^[a-zA-Z0-9\&é~#'{(\[-è_\^çà)\]°+=}\/\$%*?;:\.]{3,}$/)) {
		 		erreur.show().text("veuillez entrer un mdp correct");
		 		valid=false; 
			}
			if (name=="mdp2" && $("#mdp").val()!= $("#mdp2").val() ){
				erreur.show().text("ces 2 mdp ne sont pas identiques");
				valid = false;	
			}
	// formulaire des organisations
			if (name=="nom_orga" && $("#nom_orga").val() == ""){
		 		erreur.show().text("veuillez entrer le nom de votre organisation");
		 		valid = false; 
			}
			else if (name=="nom_orga" && !$("#nom_orga").val().match(/^[a-zA-Z0-9 ]{3,}$/)) {
		  		erreur.show().text("cette organisation existe-t-elle?");
		 		valid=false;
			}
			else if (name=="nom_orga") {
				$.ajax({
					"type":"POST",
					"url":"verif_doublons_mb.php",
					"data":"pseudo="+$("#pseudo").val(),
					success:function(data){
						if (data=="doublon ") {
							erreur.show().text("cette organisation existe deja");
							valid=false; 
						}
						// else { 
						// 	$("#nom_orga").next(".erreur").hide(); 
						// }
					}
				});
			} 	
			alert(valid);
			return valid;
		   	// pr que ca bloque
		}); 
		 
			//return valid;
		//});	
	});	
</script>