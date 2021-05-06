<?php

final class PerihelionSatellitePrint {

	private $loc;
	private $input;

	public function __construct($loc, $input) {

		$this->loc = $loc;
		$this->input = $input;

	}

	public function doc() {

		$doc = 'perihelion-satellite print';
		return $doc;

	}

}

?>