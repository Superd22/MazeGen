<?php
error_reporting(E_ALL & ~E_NOTICE);


	class ZeMaze {


		function __construct($width,$height) {
				print_r("Génération d'un labyrinthe ".$width."x".$height."<br />");

				$this->ouverts = array();
				$this->width = $width;
				$this->height = $height;
				$this->size = $width * $height;

				for($i=1;$i<=($width*$height);$i++) {
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

	    private function get_ouvert($n) {
	    	$keyOuvert = false;
	    		foreach($this->ouverts as $key=>$ouvert) {
	    			if(in_array($n,$ouvert)) {
	    				$keyOuvert = $key; 
	    				break;
	    			}
	    		}
	    	return $keyOuvert;
	    }

	    private function rand_destroy() {
	    	$n = rand(1,$this->size);
	    	$mur = array_rand($this->cases[$n]);
	    		if($this->cases[$n][$mur]) {
				$voisin = $this->get_voisin($n,$mur);
				if($voisin) {
						$ouvert_n = $this->get_ouvert($n);
						$ouvert_voisin = $this->get_ouvert($voisin);


					if( ($ouvert_n === FALSE AND $ouvert_voisin === FALSE) OR !($ouvert_n === $ouvert_voisin)) {
						$this->drop_wall($n,$mur);

						if($ouvert_n === false) {
							$ouvert_n = sizeof($this->ouverts)+1;
							$this->ouverts[$ouvert_n][] = $n;
						}
						if($ouvert_voisin === false) {
							$ouvert_voisin = sizeof($this->ouverts)+1;
							$this->ouverts[$ouvert_voisin][] = $voisin;
						}

							$this->ouverts[$ouvert_n] = array_merge($this->ouverts[$ouvert_voisin],$this->ouverts[$ouvert_n]);
							unset($this->ouverts[$ouvert_voisin]);
							$this->ouverts = array_values($this->ouverts);

					}
				}
			}
	    }

	    public function make_perfect() {
	    	while(sizeof($this->ouverts[0]) < $this->size) {
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