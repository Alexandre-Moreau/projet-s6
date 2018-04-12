<!DOCTYPE html>
<html>
	<head>
		<title>BTG</title>
		<link rel="shortcut icon" type="image/png" href="./images/favicon.png"/>
		<!-- https://www.flaticon.com/packs/space-3 -->
	
		<!-- jQuery -->
		<script src="lib/jquery/jquery-3.3.1.min.js"></script>
		
		<!-- Tether 1.3.3 -->
		<script src="lib/tether/tether.min.js"></script>

		<!-- Bootstrap 4.0 -->
		<link rel="stylesheet" href="lib/bootstrap4/css/bootstrap.min.css">
		<script src="lib/bootstrap4/js/bootstrap.min.js"></script>

		<!-- Styles -->
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script src="js/main.js" type="text/javascript"></script>

		<!-- Animate -->
		<link rel="stylesheet" type="text/css" href="lib/animate/animate.css">

	</head>

	<body>
		<header>

			<nav id="nav" class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand" href=".?r=site/index">BTG</a>

				<div class="collapse navbar-collapse" id="navbarToggler">
					<ul class="navbar-nav mr-auto mt-2 mt-md-0">
						<li class="nav-item">
							<a class="nav-link" href=".?r=site/index"><?php echo _ACCUEIL;?> <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=site/rechercher"><?php echo _RECHERCHER;?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=article/showAll"><?php echo _ARTICLES;?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=article/create"><?php echo _ARTICLES_NEW;?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href=".?r=site/creerOntoterminologie"><?php echo _ONTO_NEW;?></a>
						</li>
						<!--<li class="nav-item">
							<a class="nav-link" href=".?r=maintenance/index"><?php echo _MAINTENANCE;?></a>
						</li>-->
					</ul>
					

					<div class="dropdown" id="dropdownLangues">
						<a class="btn btn-secondary dropdown-toggle" href="#" id="dropdownMenuLangues" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php
							echo '<img src="images/langues/'.$_SESSION['langue'].'.svg"/> '.$_SESSION['langue'];
						?>
						</a>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuLangues">
							<button id="btn-fr" class="dropdown-item"><img src="images/langues/fr.svg"/> fr</button>
							<button id="btn-en" class="dropdown-item"><img src="images/langues/en.svg"/> en</button>
							<button id="btn-cn" class="dropdown-item"><img src="images/langues/cn.svg"/> cn</button>
						</div>
					</div>

				</div>
			</nav>

		</header>
		<?php
		/* 
			print("  --debug: code à enlever dans header.php--  ");
			print_r($_SESSION);
		/* */
		?>
<div id="content">
