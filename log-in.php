
<?php
$nom_site = "AM-IL.fr";

$login = "";
$mdp = "";

if(isset($_POST['connexion'])) {
    if(isset($_POST['login']))
        $login = $_POST['login'];
    if(isset($_POST['mdp']))
        $mdp = $_POST['mdp'];
} 
 
if(isset($_SESSION['login']))
    $connected = $_SESSION['login'];
else
    $connected = false;


$connexion= new BDD();
$stmt = $connexion->get_stmt();

// puis je faire, au lieu de faire le if ci dessus, faire le if ds la requete, puisque tt est identique sauf la table étudiée? 
    //SELECT * FROM ".if (isset($_POST['orga']) echo "organisation; else echo "membre"; ." WHERE login=? AND mdp=?");
    mysqli_stmt_prepare($stmt,"SELECT * FROM organisation WHERE login=? AND mdp=?");    
    mysqli_stmt_bind_param($stmt,'ss', $_POST['login'], $_POST['mdp']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt)== 1){   // si une ligne est bonne, c'est que login et mdp correspondent
       $connected=true;
       $_SESSION['login'] = true;

       echo "vous etes connecté";
    } 
    else {
        if(isset($_POST['connexion'])) {
            ?>
            <script type='text/javascript'> document.getElementById("vide").innerHTML='Echec de connexion'; </script> 
            <?php
        }
    }
//}    


// if (isset($_POST['inscription'])) {

// // A GARDER SI JE FAIS CETTE FONCTIONNALITE (STR_SHUFFLE)    
//     // $chaine = "abcdefghijklmnopqrstuvwxyz0123456789";
//     // $confirm = str_shuffle($chaine); //On créé le code de confirmation

//     $sexe = $_POST['sexe'];
//     $pseudo = htmlentities($_POST['pseudo']);
//     $prenom = htmlentities($_POST['prenom']);
//     $mail = htmlentities($_POST['mail']);
//     $mdp = htmlentities($_POST['mdp']);
//     $mdp2 = htmlentities($_POST['mdp2']);
//     $nom = htmlentities($_POST['nom']);
//     $naissance = htmlentities($_POST['naissance']);
//     $activites = htmlentities($_POST['activites']);
    
   
//         /*On Fait la variable contenant le mail de confirmation*/

    // $message = "<html><body> <img src='http://www.web-astronomie.com/images/entete-mail.png'></br><br>";
    // $message .= "<font face='Tahoma' color='#3b5998' size='2'>Bonjour ";
    // if(isset($prenom)) 
    //     $message .= $prenom; 
    // else $message .= $pseudo;
    // $message .= " et bienvenue sur " .$nom_site. "</br>";
    // $message .= "Vous veneez de vous inscrire et je vous en remercie  <br/>";
    // $message .= "Vos identifiants sont : <br/>";
    // $message .= 'Votre pseudo : <b>' . $pseudo .'</b><br>';
    // // mettre le mdp ds le mail de confirmation?
    // $message .= 'Votre mot de passe : <b>' . $mdp .'</b><br>';
    // $message .= 'Pour modifier vos infos, rendez-vous dans votre compte<br>';
    // $message .= '</br>';
    // $message .= 'Cliquez sur le lien ci-dessous pour activer votre compte :</br>';
    // $message .= '</br>';
    // $message .= '<a href="http://www.web-astronomie.com/confirm.php?login=' . str_replace(' ','%20',$pseudo) . '&confirm=' . $confirm . '">';
    // $message .= 'Cliquez ici pour activer</a>';
    // $message .= '</br></br>';
    // $message .= 'Nous vous remercions de votre fidélité<br>';
    // $message .= 'L\'équipe de <b>'.$nom_site.'</b></font></body></html>';

    // $inscription = new BDD(); //On se connecte à la bdd
   
    // $inscription->requete("SELECT COUNT(*) AS nb FROM membres WHERE pseudo='$pseudo' OR mail='$mail' OR prenom='$prenom'");
    // $donnees = $inscription->retourne_tableau();

    // $info_formulaire = array();  //tableau des erreurs, initialisé
       
       
    // if($donnees['nb'] >= 1){ //On verifie que le pseudo ou le mail n'existe pas déjà
    //     $info_formulaire[] ="Votre pseudo est déjà pris !";
    // }
                 
// conditions a voir tels que prenom ou pseudo doit etre rempli, en + des autres conditions
    if( (empty($mdp) || empty($mdp2) || empty($mail)  || empty($sexe)) && (empty($pseudo) || empty($prenom))) { //On verifie que les variables précédentes ne soient pas vide
                
        $info_formulaire[] ="Un ou plusieurs champs ne sont pas remplis !";
    }       
       
    if( $mdp != $verif_mdp) //On verifie que les 2 pass sont identiques
    {    
        $info_formulaire[] ="Les deux mots de passe ne sont pas identiques !";            
    }
                                                   
       
    if (!preg_match("!^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$!", $mail)) //Verifie que l'email entrée n'est pas une fausse.
    {    
        $info_formulaire[] ="Votre adresse email n'est pas correcte !";
    }
               
               
    if(isset($info_formulaire) && count($info_formulaire) == 0)   //si tableau vide, cad pas d'erreurs
    {   
        $inscription->requete("INSERT INTO membres (sexe, pseudo, prenom, mail, mdp, nom, activites) VALUES ('$sexe', '$pseudo', '$prenom', '$mail', '$mdp', '$nom', '$activites')");
                       
        $info_formulaire[] ="Félicitation, vous êtes maintenant inscrit";
        if ($sexe=='femme') 
            $info_formulaire[] .= "e";
        $info_formulaire[] .=" sur AM-IL.fr ! ";
                                                                           
        $entete = "MIME-Version: 1.0\r\n";
        $entete .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $entete .= "From: ".$nom_site." <$email_admin>\r\n";
        $entete .= "Reply-To: $email_admin\r\n";
        mail($mail,'Bienvenue sur ' .$nom_site. ' ' . $pseudo .'.' , $message, $entete);
                                 
        $inscription->fin($inscription); //On se deconnecte de la bdd
    }

// if (isset($_POST['connexion'])) {
//     if ()
// }

/*?>*/

}
if (isset($info_formulaire) && count($info_formulaire)>0){
    foreach ($info_formulaire as $value)
        echo "<p>- $value</p>";
}
else {
?>    
<div><label for="orga"> Vous êtes une organisation:</label><input type="radio" id="orga" name="qui" value="organisateur" />
     <label for="membre"> vous êtes un membre ou un futur membre:</label><input type="radio" id="membre" name="qui" value="membre" />
</div>
<div id="membre">
<form method="POST" action="">  
    <p> Je suis déjà membre AM-IL</p>
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
    <!-- <p> Les infos suivantes sont optionnelles, vous pouvez les remplir maintenant, plus tard ou même jamais.</p>
    <p> Elles seront affichées lorsque vous vous inscrirez à une activité.</p>
    <p> <label for="nom"> Nom <input type="text" id="nom" name="nom" /> </p>
    <p> <label for="activites"> Activités préférées<input type="text" id="activites" name="activites" /> </label> </p> -->
    <p> <input type="submit" value="Inscription" name="inscription" /> </p>
</form>
</div>

<div id="orga">
<form method="POST" action="">  
    <p> Mon organisation est déjà inscrite</p>
    <p> <sup>*</sup><label for="login"> Adresse mail </label><input type="text" id="login" name="login" <?php if (isset($_POST["login"])) echo "value='".$_POST["login"]."'"; ?> />  </p>
    <p> <sup>*</sup><label for="mdp"> Mot de passe </label><input type="password" id="mdp" name="mdp" />  </p>
    <p> <input type="submit" value="Connexion" name="connexion_orga" /> </p>
    <p> <a href="/register_false.php"> Mot de passse oublié?</a> </p>
</form>
<p> OU </p>
<form method="POST" action="">
    <p> J'inscris mon organisation</p>
    <p> <label for="orga"> Nom de l'organisation </label><input type="text" id="orga" name="orga" <?php if (isset($_POST["orga"])) echo "value='".$_POST["orga"]."'";  ?> />  </p>
    <p> <label for="prenom"> Prénom </label><input type="text" id="prenom" name="prenom" <?php if (isset($_POST["prenom"])) echo "value='".$_POST["prenom"]."'"; ?>  />  </p>
    <p> <sup>*</sup><label for="login"> Adresse mail/ Login </label><input type="text" id="login" name="login" <?php if (isset($_POST["login"])) echo "value='".$_POST["login"]."'";  ?> /> </p>
    <p> <sup>*</sup><label for="mdp"> Mot de passe </label><input type="password" id="mdp" name="mdp" />  </p>
    <p> <sup>*</sup><label for="mdp2"> Confirmez votre mot de passe </label><input type="password" id="mdp2" name="mdp2" />  </p>
    <!-- <p> Les infos suivantes sont optionnelles, vous pouvez les remplir maintenant, plus tard ou même jamais.</p>
    <p> Elles seront affichées lorsque vous vous inscrirez à une activité.</p>
    <p> <label for="nom"> Nom <input type="text" id="nom" name="nom" /> </p>
    <p> <label for="activites"> Activités préférées<input type="text" id="activites" name="activites" /> </label> </p> -->
    <p> <input type="submit" value="Inscription" name="inscription" /> </p>
</form>
</div>
<?php
}