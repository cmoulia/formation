<?php
/** @var \Entity\User[] $user_a */
use App\Backend\Modules\User\UserController;

?>
<p style="text-align: center">Il y a actuellement <?= $nombreUsers ?> utilisateurs. En voici la liste :</p>

<p><a href="<?= UserController::getLinkToInsert() ?>"><img src="/img/update.png" alt="Ajouter" />Ajouter un utilisateur</a></p>
<table>
	<tr>
		<th>Username</th>
		<th>Email</th>
		<th>Pr&eacute;nom/Nom</th>
		<th>Date d'ajout</th>
		<th>Action</th>
	</tr>
	<?php foreach ( $user_a as $user_ ): ?>
		<tr>
			<td><?= htmlentities( $user_[ 'username' ] ) ?></td>
			<td><?= htmlentities( $user_[ 'email' ] ) ?></td>
			<td><?= htmlentities( $user_[ 'firstname' ] . ' ' . $user_[ 'lastname' ] ) ?></td>
			<td><?= htmlentities( $user_[ 'dateregister' ]->format( 'd/m/Y à H\hi' ) ) ?></td>
			<td>
				<a href="<?= UserController::getLinkToUpdate( $user_[ 'id' ] ) ?>"><img src="/img/update.png" alt="Modifier" /></a>
				<a href="<?= UserController::getLinkToDelete( $user_[ 'id' ] ) ?>"><img src="/img/delete.png" alt="Supprimer" /></a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>