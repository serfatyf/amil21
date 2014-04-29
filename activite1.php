<?php
include "config.php";

include "header.php";

// echo "POST:";  var_dump($_POST);
// echo "sessions:"; var_dump($_SESSION);
// echo "GET:";  var_dump($_GET);



if (isset($_SESSION['pseudo'])) {
	$connexion_stmt = new BDD();
	$sql = "SELECT titre, presentation_act, date_fin_inscription, ville_act, departement_act, lieu_act, lieu_rdv, date_act, heure_act, heure_rdv, heure_fin, photo, date_parution FROM act 
				WHERE id_act=?"; 
	$bind = "i";
	$arr= array($_GET["id"]); //echo "arr:"; var_dump($arr);
	$connexion_stmt->prepare($sql,$bind);
	$result = $connexion_stmt->execute($arr); //echo "result:"; var_dump($result);
}
else {
	header('Location: veriflogin_amil.php');
}

?>

//  <script>	  
//  $(document).ready(function(){
//  	  $.ajax({
//             "type":"POST",
//             "url":"log_test.php",
//             "data":"login="+$("#login").val()+"&mdp="+$("#mdp").val(),
//             success:function(data) {
//                 if (data=='succes') {
//                      window.reload;
//                 } else {
//                     alert ("erreur de login ou de mot de passe");
//                 }
//             }})
//         });
// </script>
 <?php 
 //}
  ?>