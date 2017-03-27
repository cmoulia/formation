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
	<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'update', false, [ 'id' => $news[ 'id' ] ] ) ?>">Modifier la news</a>
<?php endif; ?>

<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'delete', false, [ 'id' => $news[ 'id' ] ] ) ?>">Supprimer la news</a>
<h2><?= htmlentities( $news[ 'title' ] ) ?></h2>

<?php if ( $news[ 'dateadd' ] != $news[ 'dateupdate' ] ): ?>
	<p><?= nl2br( htmlentities( $news[ 'content' ] ) ) ?></p>
<?php endif; ?>


<?php if ( empty( $comment_a ) ): ?>
	<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php endif; ?>
<form action="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'insertCommentJson','json', [ 'news' => $news[ 'id' ] ] ) ?>" method="post" id="commentform1">
	<p>
		<?= $form ?>
		<input type="submit" value="Commenter" />
	</p>
</form>

<div id="commentList">
	<?php foreach ( $comment_a as $comment ): ?>
		<?php require 'includes/comment.part.php'; ?>
	<?php endforeach; ?>
</div>

<form action="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'insertCommentJson','json', [ 'news' => $news[ 'id' ] ] ) ?>" method="post" id="commentform2">
	<p>
		<?= $form ?>
		<input type="submit" value="Commenter" />
	</p>
</form>