<?php /** @var \Entity\News[] $news_a */
foreach ( $news_a as $news ) {
	?>
	<h2><a href="news-<?= $news[ 'id' ] ?>"><?= $news[ 'title' ] ?></a></h2>
	<p><?= nl2br( $news[ 'content' ] ) ?></p>
	<?php
}