<p>Par <em><?= $news[ 'author' ] ?></em>, le <?= $news[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?></p>
<h2><?= $news[ 'title' ] ?></h2>
<p><?= nl2br( $news[ 'content' ] ) ?></p>

<?php if ( $news[ 'dateadd' ] != $news[ 'dateupdate' ] ) { ?>
	<p style="text-align: right;">
		<small><em>Modifiée le <?= $news[ 'dateupdate' ]->format( 'd/m/Y à H\hi' ) ?></em></small>
	</p>
<?php } ?>

<p><a href="commenter-<?= $news[ 'id' ] ?>.html">Ajouter un commentaire</a></p>

<?php
if ( empty( $comments ) ) {
	?>
	<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
	<?php
}

/** @var \Entity\Comment[] $comments */
foreach ( $comments as $comment ) {
	?>
	<fieldset>
		<legend>
			Posté par <strong><?= htmlspecialchars( $comment[ 'author' ] ) ?></strong> le <?= $comment[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?>
			<?php if ( $user->isAuthenticated() ) { ?> -
				<a href="admin/comment-update-<?= $comment[ 'id' ] ?>.html">Modifier</a> |
				<a href="admin/comment-delete-<?= $comment[ 'id' ] ?>.html">Supprimer</a>
			<?php } ?>
		</legend>
		<p><?= nl2br( htmlspecialchars( $comment[ 'content' ] ) ) ?></p>
	</fieldset>
	<?php
}
?>

<p><a href="commenter-<?= $news[ 'id' ] ?>.html">Ajouter un commentaire</a></p>