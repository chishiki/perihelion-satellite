<?php

final class PerihelionSatellitePDF {

	private $doc;
	private $fileObject;
	private $fileObjectID;

	public function __construct($loc, $input) {

		if ($loc[2] == 'asteroids' && ctype_digit($loc[3])) {

			// /pdf/perihelion-satellite/asteroids/<asteroidID>/

			$asteroidID = $loc[3];
			$doc = 'PERIHELION SATELLITE EXAMPLE PDF [ASTEROID]';
			$fileObject = 'Asteroid';
			$fileObjectID = $asteroidID;

		}

		$this->doc = $doc;
		$this->fileObject = $fileObject;
		$this->fileObjectID = $fileObjectID;

	}

	public function doc() {

		return $this->doc;

	}

	public function getFileObject() {

		return $this->fileObject;

	}

	public function getFileObjectID() {

		return $this->fileObjectID;

	}

}

?>