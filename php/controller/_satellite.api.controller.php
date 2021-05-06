<?php

final class PerihelionSatelliteAPI {
		
	    private $loc;
	    private $input;
	    
	    public function __construct($loc, $input) {
			
	        $this->loc = $loc;
	        $this->input = $input;
			
		}
		
		public function response() {

			if ($this->loc[2] == 'asteroids' && ctype_digit($this->loc[3])) {

				// /api/perihelion-satellite/asteroids/<asteroidID>/
				$asteroidID = $this->loc[3];
				$asteroid = new Asteroid($this->loc[3]);
				return json_encode($asteroid);

			}

            $response = '{"api":"perihelion-satellite"}';
            return $response;

		}
		
	}

?>