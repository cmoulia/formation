<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>

<table>
	<tr>
		<th>Auteur</th>
		<th>Titre</th>
		<th>Date d'ajout</th>
		<th>Dernière modification</th>
		<th>Action</th>
	</tr>
	<?php
	foreach ( $listeNews as $news ) {
		echo '<tr><td>', $news[ 'author' ], '</td><td>', $news[ 'title' ], '</td><td>le ', $news[ 'dateadd' ]->format( 'd/m/Y à H\hi' ), '</td><td>', ( $news[ 'dateadd' ] == $news[ 'dateupdate' ] ? '-' : 'le ' . $news[ 'dateupdate' ]->format( 'd/m/Y à H\hi' ) ), '</td><td><a href="news-update-', $news[ 'id' ], '.html"><img src="/img/update.png" alt="Modifier" /></a> <a href="news-delete-', $news[ 'id' ], '.html"><img src="/img/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
	}
	?>
</table>