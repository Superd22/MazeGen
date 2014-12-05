<?php
error_reporting(-1);

ini_set('error_reporting', E_ALL);

	class ZeMaze {


		function __construct($width,$height) {
				print_r("Génération d'un labyrinthe ".$width."x".$height."<br />");

				$this->ensemble = array();
				$this->width = $width;
				$this->height = $height;
				$this->size = $width * $height;

				for($i=1;$i<=($width*$height);$i++) {

					$this->ensemble[$i] = $i; 

					$this->cases[$i]['r'] = $this->cases[$i]['b'] = true;
					if( ($i % $this->width) == 0) {$this->cases[$i]['r'] = 0;}
					if( $i/$this->width > $height-1) {$this->cases[$i]['b'] = 0;}
				}
	    }

	    private function drop_wall($n,$b) {
	    	$this->cases[$n][$b] = 0;
	    } 

	    private function get_voisin($n,$mur) {


	    	$voisin = false;

	    		// Si nous sommes sur un mur de droite, on verifie qu'on a un voisin
	    		// (ie qu'il est sur la même ligne que nous)
	    	if($mur == 'r' AND ( ceil($n / $this->width) ==  ceil(($n+1) / $this->width) )  ) {
	    	 $voisin = $n + 1;
	    	}
	    		// Sinon, si nous sommes sur un mur en bas, on vereifie qu'on a un voisin
	    		// (ie qu'il est dans les limites du tableau)
	    	elseif ($mur == 'b' AND ($n+$this->width <= $this->size)) $voisin = $n + $this->width;

	    	return $voisin;
	    }

	    private function rand_destroy() {

	    	$n = rand(1,$this->size);
	    	$mur = array_rand($this->cases[$n]);

	    	if($this->cases[$n][$mur]) {
				$voisin = $this->get_voisin($n,$mur);

				if($voisin) {
						$ouvert_n = $this->ensemble[$n];
						$ouvert_voisin = $this->ensemble[$voisin];

						if($ouvert_n != $ouvert_voisin) {
							$this->drop_wall($n,$mur);

							foreach($this->ensemble as $cel=>$ouvert) {
								if($ouvert == $ouvert_voisin) {$this->ensemble[$cel] = $ouvert_n;}
							}
						}

					}
				}
			}

	    public function make_perfect() {
	    $is_not_perfect = true;
	   while(count(array_unique($this->ensemble)) > 1) {
	    		$this->rand_destroy();
			}
	    }


	    public function draw_maze() {
	    	echo "<div class='maze'>";
	    	foreach($this->cases as $key=>$case) {
	    		$attra = '';
	    		if($case['r']) $attra = "right";
	    		if($case['b']) $attra .= " bottom";

	    		echo "<span id='cel_".$key."' class='".$attra."'>".$key."<br />".$case['r'].$case['b']."</span>";
	    		if(is_integer($key / $this->width)) echo "<br />";
	    	}
	    	echo "</div>";
	    }

	}

?>
