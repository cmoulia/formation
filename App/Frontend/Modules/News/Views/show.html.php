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
<h2 class="news title"><?= htmlentities( $news[ 'title' ] ) ?></h2>

<?php if ( $news[ 'dateadd' ] != $news[ 'dateupdate' ] ): ?>
	<p><?= nl2br( htmlentities( $news[ 'content' ] ) ) ?></p>
<?php endif; ?>


<?php ( empty( $comment_a ) ) ? $empty = true : $empty = false ?>
<p class="nocomment <?= ( $empty ) ?: 'hidden' ?>">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<div class="form">
	<?php require 'includes/comment.form.php' ?>
</div>

<div id="commentList" class="<?= ( $empty ) ? 'hidden' : '' ?>" data-action="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'refreshCommentJson', 'json', [ 'id' => $news[ 'id' ] ] ) ?>" data-update="<?= date_create()->getTimestamp() ?>">
	<?php foreach ( $comment_a as $comment ): ?>
		<?php require 'includes/comment.part.php'; ?>
	<?php endforeach; ?>
</div>
<div class="form <?= ( $empty ) ? 'hidden' : '' ?>">
	<?php require 'includes/comment.form.php' ?>
</div>
<script src="/js/script.js"></script>