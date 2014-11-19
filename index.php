<?php

include('maze.php');
	
	$time_start = microtime(true);

	$maze = new ZeMaze(10,10);
	$maze->make_perfect();

	$time_end = microtime(true);

	$maze->draw_maze();
	$time = $time_end - $time_start;

		echo "<br />Généré en ".$time;
?>


	<link rel="stylesheet" type="text/css" href="style.css"/ >
