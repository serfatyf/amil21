<!doctype html>
<html lang="<?php echo $_SESSION['langue'] ?>">	

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php if(isset($charset)) echo $charset; else echo "utf-8";?>" />
		<link rel='stylesheet' href='header.css' />
 		<?php if ($_SESSION['langue']=='fr') $title="AM-IL, le site des communautés juives du 06 et du 83";
 			 else $title="AM-IL, THE jews french Riviera communities website "; ?>
 		<title> <?php echo $title; ?></title>
		<script type="text/javascript" src="jquery-1.11.0.js"></script>		
		<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
			<script>
				tinymce.init({
    			selector: "textarea#elm1",
    			theme: "modern",
   				width: 800, height: 200,
    			plugins: [
         		"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        		"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        		"save table contextmenu directionality emoticons template paste textcolor"
   				],
   				content_css: "css/content.css",
   				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   				style_formats: [
        		{title: 'Bold text', inline: 'b'},
        		{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
       			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
    		    {title: 'Example 1', inline: 'span', classes: 'example1'},
    		    {title: 'Example 2', inline: 'span', classes: 'example2'},
    		    {title: 'Table styles'},
      			  {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
   				 ]
				 }); 
			</script>

		<link rel="stylesheet" href="/resources/demos/style.css">	
	</head>
<body>
<?php 
$connexion= new BDD(false);			// le texte de présentation
$connexion->requete("SELECT * FROM  textes WHERE langue='". $_SESSION['langue'] ."'");
$textes = $connexion->retourne_tableau();
foreach ($textes as $value) 
	$texte[$value['use']] = $value['texte'];
?>

<div id="page">
<div id="content">
<ul>	
	<li class="menu">  <a href='index.php'> <?php echo $texte['accueil']; ?> </a></li>
	<li class="menu"> <a href="activites.php"> <?php echo $texte['activites']; ?> </a> </li> 
	<li class="menu">  <a href='organisations.php'> <?php echo $texte['organisations']; ?> </a> </li>

	<?php 		//si je suis connecté, le bouton deco est affiché
		if (isset($_SESSION['id_membre']) || isset($_SESSION['id_orga'])) {  
			echo "<li class='menu'>  <a href='mon_compte.php'>". $texte['compte']."  </a> </li>";
			echo "<li class='menu'>  <a href='deconnexion.php'>".$texte['deconnexion'] ."</a> </li>";
	
		}	
				// si je suis deconnecté, il y a le bouton connexion en haut de page
		else echo "<li class='menu'> <a href='inscription.php'>". $texte['inscription']."</a> </li>"; 
	?>
</ul>
<div class="clear">
<a id="logo" href="index.php"><img src="index.png" alt="logo, lien vers l'accueil"></a></div>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
	<input type="submit" name="langue" value="fr"/>
	<input type="submit" name="langue" value="en"/>
</form>
