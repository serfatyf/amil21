<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php if(isset($charset)) echo $charset; else echo "utf-8";?>" />
<?php if(isset($stylesheet)) echo "<link rel='stylesheet' href='$stylesheet' />\n";?>
<title><?php if(isset($title)) echo $title; else echo "Bienvenue, Bienvenido, Welcome";?></title>
</head>
<body>
<?php

require_once("BDD.php");

$maconnexion = new BDD();

$stmt = $maconnexion->get_stmt();

mysqli_stmt_prepare($stmt,"SELECT * from pilote WHERE `nomP` LIKE ?");
mysqli_stmt_bind_param($stmt, "s", $nom);
$nom="D%";

mysqli_stmt_execute($stmt);

mysqli_stmt_bind_result($stmt, $id, $NomP, $SalaireP);

while ($ligne = mysqli_stmt_fetch($stmt)) {
echo "Voil�� $id, $NomP, $SalaireP<br/>";
}

?>
</body>
</html>