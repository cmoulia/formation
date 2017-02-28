<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 12:08
 */

/** @var array $listeNews */
/** @var \Entity\News $news */
foreach ( $listeNews as $news ) {
	?>
	<h2><a href="news-<?= $news->getId() ?>.html"><?= $news->getTitre() ?></a></h2>
	<p><?= nl2br( $news->getContenu() ) ?></p>
	<?php
}