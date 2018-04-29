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

		<!-- Materialize -->
		<link rel="stylesheet" href="lib/materialize/css/materialize.min.css">
		<script src="lib/materialize/js/materialize.min.js"></script>

		<!-- Styles -->
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script src="js/main.js" type="text/javascript"></script>

		<!-- Animate -->
		<link rel="stylesheet" type="text/css" href="lib/animate/animate.css">

		<!-- Material Icons -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	</head>

	<body>
		<header>

			<nav id="nav">

				<div class="nav-wrapper" id="navbarToggler">
					<a class="brand-logo" href=".?r=site/index"><img id="headerImage" src="./images/favicon-big.png">BTG</a>
					<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

					<ul id="nav-mobile" class="right hide-on-med-and-down">
						<li>
							<a class="nav-link" href=".?r=site/index"><?php echo _ACCUEIL;?> <span class="sr-only"></span></a>
						</li>
						<li>
							<a class="nav-link" href=".?r=site/rechercher"><?php echo _RECHERCHER;?></a>
						</li>
						<li>
							<a class="nav-link" href=".?r=article/showAll"><?php echo _ARTICLES;?></a>
						</li>
						<li>
							<a class="nav-link" href=".?r=article/create"><?php echo _ARTICLES_NEW;?></a>
						</li>
						<li>
							<a class="nav-link" href=".?r=site/creerOntoterminologie"><?php echo _ONTO_NEW;?></a>
						</li>
						<li>
							<a class="nav-link" href=".?r=maintenance/index"><?php echo _MAINTENANCE;?></a>
						</li>
						<!-- Dropdown Trigger -->
						<li>
							<a class="dropdown-trigger" href="#!" data-target="dropdownLanguesNavbar">
								<?php echo '<img class="flags" src="images/langues/'.$_SESSION['langue'].'.svg"/> '.$_SESSION['langue'];?>
								<i class="material-icons right">arrow_drop_down</i>
							</a>
						</li>
						<!-- Dropdown Structure -->
						<ul id="dropdownLanguesNavbar" class="dropdown-content">
							<li><a id="btn-fr"><img class="flags" src="images/langues/fr.svg"/> fr</a></li>
							<li><a id="btn-en"><img class="flags" src="images/langues/en.svg"/> en</a></li>
							<li><a id="btn-cn"><img class="flags" src="images/langues/cn.svg"/> cn</a></li>
						</ul>
					</ul>
				</div>

			</nav>

			<ul id="mobile-demo" class="sidenav">
				<li>
					<a class="nav-link" href=".?r=site/index"><?php echo _ACCUEIL;?> <span class="sr-only"></span></a>
				</li>
				<li>
					<a class="nav-link" href=".?r=site/rechercher"><?php echo _RECHERCHER;?></a>
				</li>
				<li>
					<a class="nav-link" href=".?r=article/showAll"><?php echo _ARTICLES;?></a>
				</li>
				<li>
					<a class="nav-link" href=".?r=article/create"><?php echo _ARTICLES_NEW;?></a>
				</li>
				<li>
					<a class="nav-link" href=".?r=site/creerOntoterminologie"><?php echo _ONTO_NEW;?></a>
				</li>
				<li>
					<a class="nav-link" href=".?r=maintenance/index"><?php echo _MAINTENANCE;?></a>
				</li>
				<!-- Dropdown Trigger -->
				<li>
					<a class="dropdown-trigger" href="#!" data-target="dropdownLanguesSidebar">
						<?php echo '<img class="flags" src="images/langues/'.$_SESSION['langue'].'.svg"/> '.$_SESSION['langue'];?>
						<i class="material-icons right">arrow_drop_down</i>
					</a>
				</li>
				<!-- Dropdown Structure -->
				<ul id="dropdownLanguesSidebar" class="dropdown-content">
					<li><a id="btn-fr"><img class="flags" src="images/langues/fr.svg"/> fr</a></li>
					<li><a id="btn-en"><img class="flags" src="images/langues/en.svg"/> en</a></li>
					<li><a id="btn-cn"><img class="flags" src="images/langues/cn.svg"/> cn</a></li>
				</ul>
			</ul>

		</header>
		<?php
		/* 
			print("  --debug: code à enlever dans header.php--  ");
			print_r($_SESSION);
		/* */
		?>
<div id="content">
