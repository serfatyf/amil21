<?php
include "config.php";

include "header.php";


$orga = array();


$connexion = new BDD();
$sql = "SELECT id_orga, nom_orga, adresse, presentation_orga, logo FROM organisation"; 
$connexion->prepare($sql);
$result = $connexion->execute(); echo "result_test:"; var_dump($result);
foreach ($result as $value) {
	echo "<a href='organisation.php?id=".$value['id_orga']."'> ".$value['nom_orga'] ."</a>";
	echo "<p>".$value['adresse'].$value['presentation_orga']."</p>" ;
	// echo "<img src='/images/".$value['logo']."> ";
 
}






// $arr= array($_GET["id"]); echo "arr:"; var_dump($arr);
// $connexion_stmt->prepare($sql,$bind);
// $result = $connexion_stmt->execute($arr); echo "result:"; var_dump($result);














// require_once('verif_auth.php');

// if (isset($_POST['submit'])){
// $maconnexion = new BDD();

// $stmt = $maconnexion->get_stmt();
// // SELECT type FROM type_act WHERE type LIKE ?
// // mysqli_stmt_prepare($stmt,"INSERT INTO `type_act`(type) VALUES (?)");
//  mysqli_stmt_prepare($stmt, "DELETE FROM type_act WHERE id=?");
// mysqli_stmt_bind_param($stmt, "i", $essai);
// $essai = $_POST['activite'];
// mysqli_stmt_execute($stmt);
// mysqli_stmt_bind_result($stmt,$result);
// while ($ligne=mysqli_stmt_fetch($stmt))
// 	echo $result."<br/>";

// $maconnexion->requete("INSERT INTO type_act (type) VALUES ('".$_POST['activite']."')");
// mysqli_stmt_bind_result($stmt, $id, $Type);

// while ($ligne = mysqli_stmt_fetch($stmt)) {
// echo "Voilà les types commencant par c: $Type<br/>";
// }

    // mysqli_stmt_store_result($stmt);
    // if (mysqli_stmt_num_rows($stmt)== 1){
    //    $connected=true;
    //    $_SESSION['login'] = true;
    // }
// }
// 
//}

//  <form method="post">
// 	<input type="text" name="activite"/>
// 	<input type="submit" name="submit" />
// </form> 