<p><a href="role-insert"><img src="/img/update.png" alt="Ajouter" />Ajouter un r&ocirc;le</a></p>

<table>
	<tr>
		<th>Nom</th>
		<th>Description</th>
		<th>Action</th>
	</tr>
	<?php
	/** @var \Entity\Role[] $role_a */
	foreach ( $role_a as $role ) {
		?>
		<tr>
			<td><?= $role[ 'name' ] ?></td>
			<td><?= $role[ 'description' ] ?></td>
			<td><a href="role-update-<?= $role[ 'id' ] ?>"><img src="/img/update.png" alt="Modifier" /></a>
				<a href="role-delete-<?= $role[ 'id' ] ?>"><img src="/img/delete.png" alt="Supprimer" /></a></td>
		</tr>
	<?php } ?>
</table>