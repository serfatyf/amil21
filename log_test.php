<?php

// fichier appelé par activite.php en ajax

 include "config.php";

// include "header.php";

// echo "POST:";  var_dump($_POST);
// echo "sessions:"; var_dump($_SESSION);
// echo "GET:";  var_dump($_GET);


// $login = "";
// $mdp = "";

// if(isset($_POST['connexion'])) {

//   if(isset($_POST['login']))
//     $login = $_POST['login'];
//   if(isset($_POST['mdp']))
//     $mdp = $_POST['mdp'];
// } 

// $_SESSION['login']=false;
// if(isset($_SESSION['nom']))
//     $connected = $_SESSION['nom'];
// else
//     $connected = false;

if (isset($_GET['pseudo']) && isset($_GET['mdp'])){

  $connexion_stmt = new BDD();
  $sql = "SELECT pseudo, id_membre, mdp, sexe FROM membre WHERE `pseudo`=? AND `mdp`=?";
  $arr = array($_GET['pseudo'], $_GET['mdp']);
  $bind ="ss";
  $connexion_stmt->prepare($sql,$bind); 
  $result = $connexion_stmt->execute($arr);
  //echo "result";var_dump($result);
  if (count($result)>0) {
    $_SESSION['pseudo'] = $result[0]['pseudo'];
    $_SESSION['id_membre'] = $result[0]['id_membre'];
    //$_SESSION['genre'] = "membre";
    $_SESSION['sexe'] = $result[0]['sexe'];
    echo "succes";
  }

// puis je faire, au lieu de faire le if ci dessus, faire le if ds la requete, puisque tt est identique sauf la table étudiée? 
    //SELECT * FROM ".if (isset(
    
  // mysqli_stmt_prepare($stmt,"SELECT `pseudo`, `id` FROM membre WHERE login=? AND mdp=?");     
    
  // mysqli_stmt_bind_param($stmt,'ss', $_POST['login'], $_POST['mdp']);
  // mysqli_stmt_execute($stmt);
  // mysqli_stmt_store_result($stmt);
  // if (mysqli_stmt_num_rows($stmt)== 1){   // s'il existe une ligne ds le tableau de la requete, 
    //$connected=true;
//    $_SESSION['login'] = true;     //c'est que login et mdp correspondent, on se connecte
  
       
  
    else {
      echo "erreur";      // ok et ko st les resultats renvoyés à ajax (activite.php)
    }    
}
        // qui permettra d'afficher fiche de l'activite si connecté (ok)
        // ou de renvoyer la fiche de cxonnexion si non connecté (ko) 


 
 


