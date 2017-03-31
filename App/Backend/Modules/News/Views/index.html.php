<?php
/** @var \Entity\News[] $news_a */
use App\Backend\Modules\News\NewsController as BackNewsController;

?>
<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>
<table>
	<tr>
		<th>Auteur</th>
		<th>Titre</th>
		<th>Date d'ajout</th>
		<th>Dernière modification</th>
		<th>Action</th>
	</tr>
	<?php foreach ( $news_a as $news ): ?>
		<tr>
			<td><?= htmlentities( $news[ 'fk_MEM_author' ][ 'username' ] ) ?></td>
			<td class="name"><?= htmlentities( $news[ 'title' ] ) ?></td>
			<td>le <?= $news[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?></td>
			<td><?= ( $news[ 'dateadd' ] == $news[ 'dateupdate' ] ? '-' : 'le ' . $news[ 'dateupdate' ]->format( 'd/m/Y à H\hi' ) ) ?></td>
			<td>
				<a href="<?= BackNewsController::getLinkTo( 'update', null, [ 'id' => $news[ 'id' ] ] ) ?>"><img src="/img/update.png" alt="Modérer" /></a>
				<a href="<?= BackNewsController::getLinkTo( 'delete', null, [ 'id' => $news[ 'id' ] ] ) ?>"><img src="/img/delete.png" alt="Supprimer" /></a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

