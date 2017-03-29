<?php
/** @var \Entity\News $news */
/** @var \OCFram\User $user */
/** @var \Entity\Comment[] $comment_a */
?>
<form action="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )
									   ->getUrl( 'News', 'insertComment', false, [ 'news' => $news[ 'id' ] ] ) ?>" method="post" class="js-form-comment"
	  data-action="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'insertCommentJson', 'json', [ 'news' => $news[ 'id' ] ] ) ?>">
	<p>
		<?= $form ?>
		<input type="submit" value="Commenter" />
	</p>
</form>