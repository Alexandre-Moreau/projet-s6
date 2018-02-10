<!DOCTYPE html>
<html>
	<head>
		<title>BTG</title>
		<link rel="shortcut icon" type="image/png" href="./images/favicon.png"/>
		<!-- https://www.flaticon.com/packs/space-3 -->
	
		<!-- jQuery -->
		<script src="lib/jquery/jquery-3.3.1.min.js"></script>
		
		<!-- Bootstrap 4.0 -->
		<link rel="stylesheet" href="lib/bootstrap4/css/bootstrap.min.css">
		<script src="lib/bootstrap4/js/bootstrap.min.js"></script>

		<!-- styles -->
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script src="js/main.js" type="text/javascript"></script>
	</head>

	<body>
		<header>

			<nav id="nav" class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand" href=".?r=Site/index">BTG</a>

				<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
					<ul class="navbar-nav mr-auto mt-2 mt-md-0">
						<li class="nav-item">
							<a class="nav-link" href=".?r=Site/index">Accueil <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=Site/rechercher">Rechercher</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=Article/showAll">Articles</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=Article/create">Nouvel article</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=Site/creerOntoterminologie">Nouvelle ontoterminologie</a>
						</li>
					</ul>
				
				</div>
			</nav>

		</header>
		<?php
		/*
			print("  --debug: code à enlever dans header.php--  ");
			print_r($_SESSION);
		*/
		?>
<div id="content">
