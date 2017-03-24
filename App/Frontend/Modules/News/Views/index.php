<?php /** @var \Entity\News[] $news_a */ ?>
<?php foreach ( $news_a as $news ): ?>
	<h2>
		<a href="news-<?= $news[ 'id' ] ?>"><?= htmlentities( $news[ 'title' ] ) ?></a>
	</h2>
	<p class="news content"><?= nl2br( htmlentities( $news[ 'content' ] ) ) ?></p>
<?php endforeach; ?>
