<?php
/** @var \Entity\News $news */
/** @var \OCFram\User $user */
/** @var \Entity\Comment[] $comment_a */
?>

<p style="text-align: right;">
	<small><em>Modifiée le <?= $news[ 'dateupdate' ]->format( 'd/m/Y à H\hi' ) ?></em></small>
</p>
<?php if ( $news[ 'fk_MEM_admin' ] ): ?>
	<p>
		Par <em><?= htmlentities( $news[ 'fk_MEM_author' ][ 'username' ] ) ?></em>, le <?= $news[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?>
	</p>
<?php endif; ?>

<?php if ( $user->isAuthenticated() && $news[ 'fk_MEM_author' ][ 'username' ] == $user->getAttribute( 'user' )[ 'username' ] ): ?>
	<p>Modéré par <em><?= htmlentities( $news[ 'fk_MEM_admin' ][ 'username' ] ) ?></em></p>
	<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'update', [ 'id' => $news[ 'id' ] ] ) ?>">Modifier la news</a>
<?php endif; ?>

<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'delete', [ 'id' => $news[ 'id' ] ] ) ?>">Supprimer la news</a>
<h2><?= htmlentities( $news[ 'title' ] ) ?></h2>

<?php if ( $news[ 'dateadd' ] != $news[ 'dateupdate' ] ): ?>
	<p><?= nl2br( htmlentities( $news[ 'content' ] ) ) ?></p>
<?php endif; ?>

<p><a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'insertComment', [ 'news' => $news[ 'id' ] ] ) ?>">Ajouter un commentaire</a></p>

<?php if ( empty( $comment_a ) ): ?>
	<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php endif; ?>

<?php foreach ( $comment_a as $comment ): ?>
	<fieldset>
		<legend>
			Posté par
			<strong><?= htmlentities( ( $comment[ 'fk_MEM_author' ] ) ? $comment[ 'fk_MEM_author' ][ 'username' ] : $comment[ 'author' ] ) ?></strong> le <?= $comment[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?>
			<?php if ( $user->isAuthenticated() && $user->isAdmin() ): ?> -
				<a href="<?= \OCFram\RouterFactory::getRouter( 'Backend' )->getUrl( 'News', 'updateComment', [ 'id' => $comment[ 'id' ] ] ) ?>">Modérer</a> |
				<a href="<?= \OCFram\RouterFactory::getRouter( 'Backend' )->getUrl( 'News', 'deleteComment', [ 'id' => $comment[ 'id' ] ] ) ?>">Supprimer</a>
			<?php endif; ?>
			<?php if ( $user->isAuthenticated() && !$user->isAdmin() && $comment[ 'fk_MEM_author' ][ 'username' ] == $user->getAttribute( 'user' )[ 'username' ] ): ?> -
				<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'updateComment', [ 'id' => $comment[ 'id' ] ] ) ?>">Modifier</a> |
				<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'deleteComment', [ 'id' => $comment[ 'id' ] ] ) ?>">Supprimer</a>
			<?php endif; ?>
		</legend>
		<p class="comment content"><?= nl2br( htmlentities( $comment[ 'content' ] ) ) ?></p>
	</fieldset>
<?php endforeach; ?>

<p><a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'insertComment', [ 'news' => $news[ 'id' ] ] ) ?>">Ajouter un commentaire</a></p>