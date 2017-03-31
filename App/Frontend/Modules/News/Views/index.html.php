<?php
use App\Frontend\Modules\News\NewsController;

/** @var \Entity\News[] $news_a */
?>
<?php foreach ( $news_a as $news ): ?>
	<h2>
		<a href="<?= NewsController::getLinkTo( 'show', null, [ 'id' => $news[ 'id' ] ] ) ?>"><?= htmlentities( $news[ 'title' ] ) ?></a>
	</h2>
	<p class="news content"><?= nl2br( htmlentities( $news[ 'content' ] ) ) ?></p>
<?php endforeach; ?>
