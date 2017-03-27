<?php
/** @var \Entity\Role[] $role_a */
?>
<p><a href="<?= \OCFram\RouterFactory::getRouter('Backend')->getUrl( 'Role', 'insert') ?>"><img src="/img/update.png" alt="Ajouter" />Ajouter un r&ocirc;le</a></p>

<table>
	<tr>
		<th>Nom</th>
		<th>Description</th>
		<th>Action</th>
	</tr>
	<?php foreach ( $role_a as $role ): ?>
		<tr>
			<td><?= htmlentities($role[ 'name' ]) ?></td>
			<td class="role content"><?= htmlentities($role[ 'description' ]) ?></td>
			<td>
				<a href="<?= \OCFram\RouterFactory::getRouter('Backend')->getUrl( 'Role', 'update',['id'=> $role[ 'id' ]]) ?>"><img src="/img/update.png" alt="Modifier" /></a>
				<a href="<?= \OCFram\RouterFactory::getRouter('Backend')->getUrl( 'Role', 'delete',['id'=> $role[ 'id' ]]) ?>"><img src="/img/delete.png" alt="Supprimer" /></a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>