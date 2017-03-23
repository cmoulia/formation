<?php
/** @var \Entity\News $news */
/** @var \OCFram\User $user */

?>

<p>Par <em><?= $news[ 'fk_MEM_author' ][ 'username' ] ?></em>, le <?= $news[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?></p>
<?php if ( $news[ 'fk_MEM_admin' ] ) { ?>
	<p>Modéré par <em><?= $news[ 'fk_MEM_admin' ][ 'username' ] ?></em></p>
<?php } ?>

<?php if ( $user->isAuthenticated() && $news[ 'fk_MEM_author' ][ 'username' ] == $user->getAttribute( 'user' )[ 'username' ] ) { ?>
	<a href="news-update-<?= $news[ 'id' ] ?>">Modifier la news</a>
	<a href="news-delete-<?= $news[ 'id' ] ?>">Supprimer la news</a>
<?php } ?>

<h2><?= $news[ 'title' ] ?></h2>
<p><?= nl2br( $news[ 'content' ] ) ?></p>

<?php if ( $news[ 'dateadd' ] != $news[ 'dateupdate' ] ) { ?>
	<p style="text-align: right;">
		<small><em>Modifiée le <?= $news[ 'dateupdate' ]->format( 'd/m/Y à H\hi' ) ?></em></small>
	</p>
<?php } ?>

<p><a href="news-comment-<?= $news[ 'id' ] ?>">Ajouter un commentaire</a></p>

<?php if ( empty( $comment_a ) ) { ?>
	<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php }

/** @var \Entity\Comment[] $comment_a */
foreach ( $comment_a as $comment ) { ?>
	<fieldset>
		<legend>
			Posté par
			<strong><?= htmlspecialchars( ( $comment[ 'fk_MEM_author' ] ) ? $comment[ 'fk_MEM_author' ][ 'username' ] : $comment[ 'author' ] ) ?></strong> le <?= $comment[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?>
			<?php if ( $user->isAuthenticated() && $user->isAdmin() ) { ?> -
				<a href="admin/news-comment-update-<?= $comment[ 'id' ] ?>">Modérer</a> |
				<a href="admin/news-comment-delete-<?= $comment[ 'id' ] ?>">Supprimer</a>
			<?php }
			if ( $user->isAuthenticated() && !$user->isAdmin() && $comment[ 'fk_MEM_author' ][ 'username' ] == $user->getAttribute( 'user' )[ 'username' ] ) { ?> -
				<a href="news-comment-update-<?= $comment[ 'id' ] ?>">Modifier</a> |
				<a href="news-comment-delete-<?= $comment[ 'id' ] ?>">Supprimer</a>
			<?php } ?>
		</legend>
		<p><?= nl2br( htmlspecialchars( $comment[ 'content' ] ) ) ?></p>
	</fieldset>
<?php } ?>

<p><a href="news-comment-<?= $news[ 'id' ] ?>">Ajouter un commentaire</a></p>