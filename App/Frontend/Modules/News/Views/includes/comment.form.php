<?php
use App\Frontend\Modules\News\NewsController;

/** @var \Entity\News $news */
/** @var \OCFram\User $user */
/** @var \Entity\Comment[] $comment_a */
?>
<form action="<?= NewsController::getLinkTo( 'insertComment', null, [ 'news' => $news[ 'id' ] ] ) ?>" method="post" class="js-form-comment"
	  data-action="<?= NewsController::getLinkTo( 'insertCommentJson', 'json', [ 'news' => $news[ 'id' ] ] ) ?>">
	<p>
		<?= $form ?>
		<input type="submit" value="Commenter" />
	</p>
</form>