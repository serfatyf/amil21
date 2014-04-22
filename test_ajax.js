<script>	  
 $(document).ready(function(){
 	$("#button_log").click (function() {
 		$.post("log_test.php"), 
 		{ login: $("#login").val,   mdp: $("#mdp").val },

 		{ function(data) { if (data=='ok') 
 							window.reload;	// si on recharge la page et que le mdp est bon,
 		// la session est ouverte donc on arrive en ligne 6 de ce fichier => affichage fiche d'activite
 						   else alert ("erreur de login ou de mot de passe");
 						  }
 	  	}
 	}
}
 </script>