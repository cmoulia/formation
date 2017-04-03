<?php
use App\Frontend\Modules\Connexion\ConnexionController;

?>
<h2>Connexion / <a href="<?= ConnexionController::getLinkToRegister() ?>">Inscription</a></h2>

<form action="" method="post">
	<label>Pseudo</label>
	<input type="text" name="login" /><br />
	
	<label>Mot de passe</label>
	<input type="password" name="password" /><br /><br />
	
	<input type="submit" value="Connexion" />
</form>