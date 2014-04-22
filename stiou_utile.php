<?php
define("TITLE", "AM-IL, le site des communautés juives du 06 et du 83");
define("BONJOUR", "Bonour");
define("ACTIVITIES", "Activités");

$rqt = "select * from langue where lang= fr";			//where lang= en"
$req= mysql_query($rqt);
while ($res= mysql_fetch_assoc($req)) {
	$langue[$res['text']] = $res['value'];
}
//table avant la requete disant WHERE lang=fr
				
id		text		value		lang
1		BONJOUR		Bonjour		fr
2		BONJOUR		Hello		en
3		ACTIVITIES	Activités	fr
4		ACTIVITIES	Activities	en
 
 /* ecriture donnée par*/ print_r($langue);
$langue = array(										// trié par la requete WHERE lang = en, il reste
	'BONJOUR' 	 => 'Bonjour', 							// 'BONJOUR' => 'Hello'
	'ACTIVITIES' => 'Activités'							// 'ACTIVITIES' => 'activities'
);
 /* ecriture donnée par */ echo '<pre>'.print($langue, true).'</pre>';
$langue['BONJOUR'] = 'Bonjour';		 
$langue['ACTIVITIES'] = 'Activités';
?>

<?php
define("TITLE", "AM-IL, THE jews french Riviera communities website");
define("BONJOUR", "Hello");
define("ACTIVITIES", "Activities");
?>