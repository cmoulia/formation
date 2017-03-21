<?php
foreach ( $listeNews as $news ) {
	?>
	<h2><a href="news-<?= $news[ 'id' ] ?>.html"><?= $news[ 'title' ] ?></a></h2>
	<p><?= nl2br( $news[ 'content' ] ) ?></p>
	<?php
}