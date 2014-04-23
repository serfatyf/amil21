<?php

class BDD {

	// Chaîne de caractères contenant des informations utiles
	private $serveur;
	private $user;
	private $base;
	private $requete;
	
	// Indicateurs spéciaux
	private $connexion; // Permet de savoir si la connexion au serveur fonctionne
	private $base_en_cours; // Permet de savoir si la connexion à la base se passe bien
	private $requete_en_cours; // Permet d'avoir un indicateur sur la requête en cours d'exécution
	private $ligne_en_cours; // Le tableau de la ligne de requête en cours de traitement
	
	// Statement
	private $stmt; // Charge l'extension "stmt"
	private $sql;	// Requete du type INSERT INTO pilote VALUES ("",?,?)
	private $bind; // Parametres : type de données (i = entier, d = décimal, s = chaine, b = BLOB (grand texte))

	private $last_id; // ID dernier insert

	public function __construct($statement=true) // preciser false si requete simple, rien pr stmt
	{ 


		
		$mdp = "";
		// Sauvegarde des informations utiles à afficher
		$this->serveur = "localhost";
		$this->user = "root";
		$this->base = "amil";
		$this->requete_en_cours = false; // Pour nous protéger d'un appel intempestif à "retourne_ligne"
		


		
		$this->connexion = new mysqli($this->serveur, $this->user, $mdp, $this->base);

		/* check connection */
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		// Ajout de l'extension stmt si $statement est fourni
		 $this->stmt = ($statement) ? $this->connexion->stmt_init() : false;

		$this->requete("SET NAMES 'UTF8';");



	}

	public function __destruct()
	{
		//if($this->stmt!==false) $this->stmt->close();
		$this->connexion->close();
	}

	public function __toString()
	{
		$toret = "<p>Vous êtes connecté sur $this->serveur en tant que $this->user</p>\n";
		$toret .= "<p>Vous travaillez avec la base $this->base</p>\n";
		$toret .= "<p>La requête en cours est : $this->requete</p>\n";
		
		$toret = "";

		return $toret;
	}
	


	// Evite les injections SQL, le XSS est traité dans la class FORMULAIRE
	public function secureRqt($sql) {
		return $this->connexion->real_escape_string($sql); 
	}




	// Statement - Preparation des données
	public function prepare($sql,$bind=''){
		$this->sql = $sql;
		$this->bind = $bind;
		return $this->stmt->prepare($sql);
	}

	// Execute - Execute la requete
	public function execute($arr=''){
		$nbVar = strlen($this->bind);

		//BIND
		if ($nbVar!=0) {
			$bind_param = '$this->stmt->bind_param($this->bind';
				for ($i=0; $i < $nbVar; $i++) { 
					$bind_param .= ', $arr['.$i.']';
				}
				$bind_param .= ' );';
				
				eval($bind_param);
		}

		//EXECUTE
		$this->stmt->execute();


		// RECUPERE RESULTAT
		$explode = explode(" ", $this->sql);
		$typeSQL = strtoupper($explode[0]);

		if($typeSQL == "INSERT") {
			$this->last_id = $this->stmt->insert_id;
		}


		if($typeSQL != "SELECT") {
			return $this->stmt->affected_rows;
		} else {
			if (preg_match("/(SELECT)(.*)(FROM)/i", $this->sql, $col) === 1)
			{
			    $colonnes = explode(",", $col[2]);
			    $nbCol = count($colonnes);
			} else {
			    $nbCol = count(0);
			}

			// Resultat
			$bind_result = '$this->stmt->bind_result(';
			for ($i=0; $i < $nbCol; $i++) { 
				$bind_result .= ($i==0) ? ' $attr'.$i : ', $attr'.$i ;
				
			}
			$bind_result .= ' );';
			eval($bind_result);

			$result = array();
			

			// Mise en tableau du resultat
			while($this->stmt->fetch()) {
				$result2 = '$result[] = array(';
				for ($i=0; $i < $nbCol; $i++) { 
					$result2 .= '"'.str_ireplace(' ', '', $colonnes[$i]).'" => $attr'.$i.', ';
				}
				$result2 .= ' );';
				eval($result2);
			}

			return $result;

		}

	}

	public function get_last_id(){
		return intval($this->last_id);
	}




	public function requete($sql)
	{
		// Mémorisation de la requête à exécuter
		$this->requete = $sql;
		// Exécution de la requête
		$this->requete_en_cours = $this->connexion->query($this->requete);
		
		// Traîtement d'erreur
		if($this->requete_en_cours === false) { // Erreur lors de la requête
				echo "<p>La requête a échouée</p>".$this;
				return false;
		}
		return true;
	}
	


	public function retourne_ligne()
	{
		
		if($this->requete_en_cours === false) { // Pas de requête en cours
			echo "<p>Il n'y a pas de requête en cours !</p>".$this;
			$this->ligne_en_cours = false;
		} else { // ligne_en_cours contient le tableau retourné par mysqli_fetch_assoc
			$this->ligne_en_cours = $this->requete_en_cours->fetch_assoc();
		}
		return $this->ligne_en_cours;
	}

	public function retourne_ligne_en_cours()
	{
		// Si ligne_en_cours est un tableau, c'est qu'il y a une requête en cours, on peut donc renvoyer de nouveau cette ligne : utile pour la première ligne
		if(is_array($this->ligne_en_cours)) {
			return $this->ligne_en_cours;
		} else { // Gestion d'erreur
			return false;
		}
	}

	public function retourne_tableau()
	{
		// Declare le tableau vide de façon a eviter une erreur en cas de reponse vide de la part de SQL
		$tableau_ligne = array();
		while($this->retourne_ligne()) {
			$tableau_ligne[] = $this->retourne_ligne_en_cours();
		}
		return $tableau_ligne;
	}
	
};

?>
