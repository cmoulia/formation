<?php
/** @var \Entity\User[] $listeUsers */
?>
<p style="text-align: center">Il y a actuellement <?= $nombreUsers ?> utilisateurs. En voici la liste :</p>

<p><a href="user-insert"><img src="/img/update.png" alt="Ajouter" />Ajouter un utilisateur</a></p>
<table>
	<tr>
		<th>Username</th>
		<th>Email</th>
		<th>Pr&eacute;nom/Nom</th>
		<th>Date d'ajout</th>
		<th>Action</th>
	</tr>
	<?php foreach ( $listeUsers as $listeUser ): ?>
		<tr>
			<td><?= htmlentities($listeUser[ 'username' ]) ?></td>
			<td><?= htmlentities($listeUser[ 'email' ]) ?></td>
			<td><?= htmlentities($listeUser[ 'firstname' ] . ' ' . $listeUser[ 'lastname' ]) ?></td>
			<td><?= htmlentities($listeUser[ 'dateregister' ]->format( 'd/m/Y à H\hi' )) ?></td>
			<td>
				<a href="user-update-<?= $listeUser[ 'id' ] ?>"><img src="/img/update.png" alt="Modifier" /></a>
				<a href="user-delete-<?= $listeUser[ 'id' ] ?>"><img src="/img/delete.png" alt="Supprimer" /></a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>