<fieldset>
	<legend>
		Posté par
		<strong><?= htmlentities( ( $comment[ 'fk_MEM_author' ] ) ? $comment[ 'fk_MEM_author' ][ 'username' ] : $comment[ 'author' ] ) ?></strong> le <?= $comment[ 'dateadd' ]->format( 'd/m/Y à H\hi' ) ?>
		<?php if ( $user->isAuthenticated() && $user->isAdmin() ): ?> -
			<a href="<?= \OCFram\RouterFactory::getRouter( 'Backend' )->getUrl( 'News', 'updateComment', false, [ 'id' => $comment[ 'id' ] ] ) ?>">Modérer</a> |
			<a href="<?= \OCFram\RouterFactory::getRouter( 'Backend' )->getUrl( 'News', 'deleteComment', false, [ 'id' => $comment[ 'id' ] ] ) ?>">Supprimer</a>
		<?php endif; ?>
		<?php if ( $user->isAuthenticated() && !$user->isAdmin() && $comment[ 'fk_MEM_author' ][ 'username' ] == $user->getAttribute( 'user' )[ 'username' ] ): ?> -
			<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'updateComment', false, [ 'id' => $comment[ 'id' ] ] ) ?>">Modifier</a> |
			<a href="<?= \OCFram\RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'deleteComment', false, [ 'id' => $comment[ 'id' ] ] ) ?>">Supprimer</a>
		<?php endif; ?>
	</legend>
	<p class="comment content"><?= nl2br( htmlentities( $comment[ 'content' ] ) ) ?></p>
</fieldset>