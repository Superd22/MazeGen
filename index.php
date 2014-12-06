<?php

require('maze.php');
	
	$width = 25;
	$height = 15;

	print_r("Génération d'un labyrinthe ".$width."x".$height."<br />");


	// Démarrage du chrono
	$time_start = microtime(true);

	// Création de l'objet
	$maze = new ZeMaze($width,$height);
	// On rend le labyrinthe parfait
	$maze->make_perfect();
	// Fin du chrono quand c'est fait
	$time_end = microtime(true);

	// On affiche le labyrinthe
	$maze->draw_maze();


	// Chrono 
	$time = $time_end - $time_start;
		// + Affichage
		echo "<br />Généré en ".$time;
?>


	<link rel="stylesheet" type="text/css" href="style.css"/ >
