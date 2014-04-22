<?php
include "config.php";



if (isset($_SESSION['id_membre']) || isset($_SESSION['id_orga'])){
	session_destroy();
	header("location: index.php");
}