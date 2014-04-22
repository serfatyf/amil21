<?php
if (isset($_POST['act'])){
$connexion= new BDD();
$stmt = $connexion->get_stmt();
mysqli_stmt_prepare($stmt,"INSERT INTO type_act (type,type_affich) VALUES (?,?)");    
    mysqli_stmt_bind_param($stmt,'ss', $type,$type_affich);
    $type=$_POST['activite']; $type_affich=$_POST['activite_affich'];
    mysqli_stmt_execute($stmt);
    // while (mysqli_stmt_fetch($stmt)){        a quoi est ce que ca servirait?
    // 	echo $stmt;
    // }

    // mysqli_stmt_store_result($stmt);
    // if (mysqli_stmt_num_rows($stmt)== 1){
    //    $connected=true;
    //    $_SESSION['login'] = true;
    // }
}
?>
<form method="post" action="">
	activite:<input type="text" name="activite"/>
	activite affichee:<input type="text" name="activite_affich"/>
    <input type="submit" name="act" />
</form>