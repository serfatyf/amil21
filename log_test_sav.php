<?php
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

$_SESSION['login']=false;
// if(isset($_SESSION['nom']))
//     $connected = $_SESSION['nom'];
// else
//     $connected = false;


  $connexion= new BDD();
  $stmt = $connexion->get_stmt();

// puis je faire, au lieu de faire le if ci dessus, faire le if ds la requete, puisque tt est identique sauf la table étudiée? 
    //SELECT * FROM ".if (isset(
    
  mysqli_stmt_prepare($stmt,"SELECT `pseudo`, `id` FROM membre WHERE login=? AND mdp=?");     
    
  mysqli_stmt_bind_param($stmt,'ss', $_POST['login'], $_POST['mdp']);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  if (mysqli_stmt_num_rows($stmt)== 1){   // s'il existe une ligne ds le tableau de la requete, 
    //$connected=true;
    $_SESSION['login'] = true;     //c'est que login et mdp correspondent, on se connecte
    mysqli_stmt_bind_result($stmt, $pseudo, $id); 
    $_SESSION['nom'] = $pseudo;
    $_SESSION['id'] = $id;
    $_SESSION['type'] = $membre;
	  
    echo  "ok";
  }
  
  mysqli_stmt_prepare($stmt,"SELECT `pseudo`, `id_orga` FROM organisation WHERE login=? AND mdp=?");     
    
  mysqli_stmt_bind_param($stmt,'ss', $_POST['login'], $_POST['mdp']);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  if (mysqli_stmt_num_rows($stmt)== 1){   // s'il existe une ligne ds le tableau de la requete, 
    //$connected=true;
    $_SESSION['login'] = true;     //c'est que login et mdp correspondent, on se connecte
    mysqli_stmt_bind_result($stmt, $pseudo, $id); 
    $_SESSION['nom'] = $pseudo;
    $_SESSION['id'] = $id;
    $_SESSION['type'] = $membre;
    
    echo  "ok";
  }
  else
    echo "ko";


//   } 
// else { mm chose sur organisation}

// if (!$connected){

?>
<!-- 	<form method="POST" action="index.php?menu=log_test" >
  orga:<input type="radio" name="type" value="orga">
  membre:<input type="radio" name="type" value="membre"> 
	login: <input type="text" name="login" />
	passwd: <input type="password" name="mdp" />
	<input type="submit" name="connexion" />
</form> -->
<?php 
//}
?>
