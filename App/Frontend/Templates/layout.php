<?php /** @var \OCFram\User $user */ ?>

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
				<h1><a href="/">Mon super site</a></h1>
				<p><?= ( $user->getAttribute( 'user' ) ) ? 'Bienvenue ' . $user->getAttribute( 'user' )[ 'firstname' ] . ' ' . $user->getAttribute( 'user' )[ 'lastname' ] : 'Bienvenue sur mon blog collaboratif !' ?></p>
			</header>
			
			<nav>
				<ul>
					<?php if ( $user->isAuthenticated() && $user->isAdmin() ): ?>
						<li><a href="/">Front Office</a></li>
						<li><a href="/admin/">Back Office</a></li>
						<li><a href="/logout">D&eacute;connexion</a></li>
						<li><a href="/news-insert">Ajouter une news</a></li>
						<li><a href="/admin/roles">Liste des r&ocirc;les</a></li>
						<li><a href="/admin/users">Liste des utilisateurs</a></li>
					<?php elseif ( $user->isAuthenticated() && !$user->isAdmin() ): ?>
						<li><a href="/">Accueil</a></li>
						<li><a href="/logout">D&eacute;connexion</a></li>
						<li><a href="/news-insert">Ajouter une news</a></li>
<!--						<li><a href="/myaccount">Mon compte</a></li>-->
					<?php else: ?>
						<li><a href="/">Accueil</a></li>
						<li><a href="/login">Connexion</a></li>
					<?php endif; ?>
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
	</body>
</html>
