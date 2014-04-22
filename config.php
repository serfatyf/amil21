<?php

if(!isset($_SESSION))
	session_start();


$langue = 'fr';
if(isset($_SESSION['langue']))
    $langue = $_SESSION['langue'];
if(isset($_POST['langue'])) {
    switch($_POST['langue']) {
        case 'fr':
        case 'en':
            $langue = $_POST['langue'];
            break;
    }
}
$_SESSION['langue'] = $langue;

require_once "BDD_steph.php";

$nom_site = "AM-IL.fr";
    
// $connexion = new BDD();    
if(isset($_POST['deco'])){
	unset($_SESSION['login']);
	unset($_SESSION['id_membre']);
	unset($_SESSION['type']);
}