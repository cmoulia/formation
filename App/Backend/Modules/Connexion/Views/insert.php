<p style="text-align: center">Il y a actuellement <?= $nombreUsers ?> utilisateurs. En voici la liste :</p>

<p><a href="user-insert.html"><img src="/img/update.png" alt="Ajouter" />Ajouter un utilisateur</a></p>

<table>
	<tr>
		<th>Username</th>
		<th>Email</th>
		<th>Pr&eacute;nom/Nom</th>
		<th>Date d'ajout</th>
		<th>Action</th>
	</tr>
	<?php
	/** @var \Entity\User[] $listeUsers */
	foreach ( $listeUsers as $listeUser ) {
		?>
		<tr>
			<td><?= $listeUser[ 'username' ] ?></td>
			<td><?= $listeUser[ 'email' ] ?></td>
			<td><?= $listeUser[ 'firstname' ] . ' ' . $listeUser[ 'lastname' ] ?></td>
			<td><?= $listeUser[ 'dateregister' ]->format( 'd/m/Y à H\hi' ) ?></td>
			<td><a href="user-update-<?= $listeUser[ 'id' ] ?>.html"><img src="/img/update.png" alt="Modifier" /></a>
				<a href="user-delete-<?= $listeUser[ 'id' ] ?>.html"><img src="/img/delete.png" alt="Supprimer" /></a></td>
		</tr>
	<?php } ?>
</table>