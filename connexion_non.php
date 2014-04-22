<?php
// $nom_site = "AM-IL.fr";

include "config.php";

include "header.php";

$login = "";
$mdp = "";

if(isset($_POST['connexion'])) {
    if(isset($_POST['login']))
        $login = $_POST['login'];
    if(isset($_POST['mdp']))
        $mdp = $_POST['mdp'];
} 
 
if(isset($_SESSION['login']))
    $logged = $_SESSION['login'];
else
    $logged = false;


$connexion= new BDD();
$stmt = $connexion->get_stmt();

// puis je faire, au lieu de faire le if ci dessus, faire le if ds la requete, puisque tt est identique sauf la table étudiée? 
    //SELECT * FROM ".if (isset($_POST['orga']) echo "organisation; else echo "membre"; ." WHERE login=? AND mdp=?");
    
    mysqli_stmt_prepare($stmt,"SELECT * FROM organisation WHERE login=? AND mdp=?");    
    mysqli_stmt_bind_param($stmt,'ss', $_POST['login'], $_POST['mdp']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt)== 1){   // si une ligne est trouvée, c'est que login et mdp correspondent
        $logged = true;                      // on se loggue
        $_SESSION['login'] = true;
        
        $_SESSION['user'] = array();
        mysqli_stmt_bind_result($stmt, $nom_orga, $mdp); 
        while (mysqli_stmt_fetch($stmt)) {
            $_SESSION['user']/*['nom_orga']*/ = $nom_orga;
        }
        echo  " Vous etes connecté pour l'organisation " . $_SESSION['user'];
    } 
    else {
        if(isset($_POST['connexion'])) {
            ?>
            <script type='text/javascript'> document.getElementById("vide").innerHTML='Echec de connexion'; </script> 
            <?php
        }
    }
?>
<form method="POST" action="logged.php">  
    <p> Mon organisation est déjà inscrite</p>
    <p> <sup>*</sup><label for="login"> Adresse mail </label><input type="text" id="login" name="login" <?php if (isset($_POST["login"])) echo "value='".$_POST["login"]."'"; ?> />  </p>
    <p> <sup>*</sup><label for="mdp"> Mot de passe </label><input type="password" id="mdp" name="mdp" />  </p>
    <p> <input type="submit" value="Connexion" name="connexion_orga" /> </p>
    <p> <a href="/register_false.php"> Mot de passse oublié?</a> </p>
</form>
