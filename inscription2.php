<?php
include "config.php";

include "header.php";

?>
<form method="POST"  action="<?php echo $_SERVER['PHP_SELF'];?>" >
	Pseudonyme: <input type="text" name="pseudo" id="pseudo" />
	<span class="erreur"></span>
	<input type="submit" value="M'inscrire" name="inscrip_membre" id="inscrip_membre" />
</form>

<script type="text/javascript">
	$(document).ready(function() {

		$("#inscrip_membre").click(function() {
			var valid = true;
			if ($("#pseudo").val() == ""){
				$("#pseudo").next(".erreur").show().text("veuillez entrer votre nom");
				valid = false;
			}
			return valid;
		});
	});		

</script>