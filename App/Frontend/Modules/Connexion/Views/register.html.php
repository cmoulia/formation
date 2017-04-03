<?php
use App\Frontend\Modules\Connexion\ConnexionController;

?>
<h2><a href="<?= ConnexionController::getLinkToLogin() ?>">Connexion</a> / Inscription</h2>
<form action="" method="post">
	<p>
		<?= $form ?>
		
		<input type="submit" value="Valider" />
	</p>
</form>