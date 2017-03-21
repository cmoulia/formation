<!DOCTYPE HTML>
<!--suppress HtmlUnknownTarget -->
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?= isset( $title ) ? $title : 'Formation PHP' ?></title>
		<link rel="icon" href="/favicon.ico">
		<!--		<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css">-->
		<link rel="stylesheet" href="/css/Envision.css" type="text/css">
	</head>
	<body>
		<div id="wrap">
			<header>
				<h1><a href="/">Mon super site</a></h1>
				<p>Comment ça, il n'y a presque rien ?</p>
			</header>
			
			<nav>
				<ul>
					<?php /** @var \OCFram\User $user */
					if ( $user->isAuthenticated() ) { ?>
						<li><a href="/">Front Office</a></li>
						<li><a href="/admin/">Back Office</a></li>
						<li><a href="/admin/logout">D&eacute;connexion</a></li>
						<li><a href="/admin/news-insert.html">Ajouter une news</a></li>
						<li><a href="/admin/user">Liste des utilisateurs</a></li>
					<?php }else { ?>
						<li><a href="/">Accueil</a></li>
						<li><a href="/admin/">Connexion</a></li>
					<?php } ?>
				</ul>
			</nav>
			
			<div id="content-wrap">
				<section id="main">
					<?php if ( $user->hasFlash() ) {
						echo '<p style="text-align: center;">', $user->getFlash(), '</p>';
					} ?>
					
					<?= isset( $content ) ? $content : "Content" ?>
				</section>
			</div>
			
			<footer></footer>
			<script href="/js/bootstrap.min.js"></script>
	</body>
</html>
