<?php
/** @var \Entity\Role[] $role_a */
use App\Backend\Modules\Role\RoleController;

?>
<p><a href="<?= RoleController::getLinkToInsert() ?>"><img src="/img/update.png" alt="Ajouter" />Ajouter un r&ocirc;le</a></p>

<table>
	<tr>
		<th>Nom</th>
		<th>Description</th>
		<th>Action</th>
	</tr>
	<?php foreach ( $role_a as $role ): ?>
		<tr>
			<td><?= htmlentities( $role[ 'name' ] ) ?></td>
			<td class="role content"><?= htmlentities( $role[ 'description' ] ) ?></td>
			<td>
				<a href="<?= RoleController::getLinkToUpdate( $role[ 'id' ] ) ?>"><img src="/img/update.png" alt="Modifier" /></a>
				<a href="<?= RoleController::getLinkToDelete( $role[ 'id' ] ) ?>"><img src="/img/delete.png" alt="Supprimer" /></a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>