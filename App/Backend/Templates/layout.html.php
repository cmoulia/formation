<?php
/** @var \OCFram\User $user */
use App\Backend\Modules\News\NewsController;

?>

<!DOCTYPE HTML>
<!--suppress HtmlUnknownTarget -->
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?= isset( $title ) ? $title : 'Formation PHP' ?></title>
		<link rel="icon" href="/favicon.ico">
		<link rel="stylesheet" href="/css/Envision.css" type="text/css">
		<link rel="stylesheet" href="/css/style.css" type="text/css">
	</head>
	<body>
		<div id="wrap">
			<header>
				<h1><a href="<?= NewsController::getLinkTo( 'index' ) ?>">Mon super site</a></h1>
				<p><?= ( $user->getAttribute( 'user' ) ) ? 'Bienvenue ' . $user->getAttribute( 'user' )[ 'firstname' ] . ' ' . $user->getAttribute( 'user' )[ 'lastname' ] : 'Espace Administrateur !' ?></p>
			</header>
			
			<nav>
				<ul>
					<?php foreach ( $menu as $element ): ?>
						<li><a href="<?= $element->link() ?>"><?= $element->label() ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
			
			<div id="content-wrap">
				<section id="main">
					<?php if ( $user->hasFlash() ): ?>
						<p style="text-align: center;"><?= $user->getFlash() ?></p>
					<?php endif; ?>
					
					<?= isset( $content ) ? $content : "Content" ?>
				</section>
			</div>
			
			<footer></footer>
			<script src="/js/jquery-3.2.0.min.js"></script>
			<script src="/js/script.js"></script>
	</body>
</html>
