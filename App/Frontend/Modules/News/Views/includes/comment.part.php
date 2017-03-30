<?php
/** @var \Entity\News $news */
/** @var \OCFram\User $user */
/** @var \Entity\Comment[] $comment_a */
?>
<fieldset data-id="<?= $comment[ 'id' ] ?>">
	<legend>
		<span>Posté par</span>
		<strong><?= htmlentities( ( $comment[ 'fk_MEM_author' ] ) ? $comment[ 'fk_MEM_author' ][ 'username' ] : $comment[ 'author' ] ) ?></strong>
		<span class="date-add"> le <?= $comment[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?></span>
		<span class="date-update">
		<?php if ( $comment[ 'dateupdate' ]): ?>
			 (<?= $comment[ 'dateupdate' ]->format( 'd/m/Y à H\hi' ) ?>)
		<?php endif; ?>
		</span>
		<?php if ( $user->isAuthenticated() && ( $user->isAdmin() || ( !$user->isAdmin() && $comment[ 'fk_MEM_author' ][ 'username' ] == $user->getAttribute( 'user' )[ 'username' ] ) ) ): ?> -
			<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'updateComment', false, [ 'id' => $comment[ 'id' ] ] ) ?>"
			><?= ( $user->isAdmin() && $comment[ 'fk_MEM_author' ][ 'username' ] != $user->getAttribute( 'user' )[ 'username' ] ) ? 'Modérer' : 'Modifier' ?></a> |
			<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'deleteComment', false, [ 'id' => $comment[ 'id' ] ] ) ?>"
			   class="js-delete-comment"
			   data-action="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'deleteCommentJson', 'json', [ 'id' => $comment[ 'id' ] ] ) ?>"
			>Supprimer</a>
		<?php endif; ?>
	</legend>
	<p class="comment content"><?= nl2br( htmlentities( $comment[ 'content' ] ) ) ?></p>
</fieldset>