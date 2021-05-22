<?php

final class PerihelionSatelliteExportController {

	private $loc;
	private $input;
	private $modules;
	
	private $filename;
	private $columns;
	private $rows;

	public function __construct($loc, $input, $modules) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;

		$this->filename = 'export';
		$this->columns = array();
		$this->rows = array();
		
		if ($loc[0] == 'csv' && $loc[1] == 'perihelion-satellite') {

			if ($loc[2] == 'asteroids') {

				// /csv/perihelion-satellite/asteroids/

				$arg = new AsteroidListParameter();
				$asteroidList = new AsteroidList($arg);
				$asteroids = $asteroidList->asteroids();

				$this->filename = 'asteroid_export_' . str_replace('_', '-', $loc[4]);

				$this->columns[] = 'asteroidID';
				$this->columns[] = 'asteroidName';
				$this->columns[] = 'asteroidDiameter';
				$this->columns[] = 'asteroidDistanceFromSun';
				$this->columns[] = 'asteroidDiscoverer';
				$this->columns[] = 'asteroidDateDiscovered';

				foreach ($asteroids AS $asteroidID) {
					$data = array();
					$asteroid = new Asteroid($asteroidID);
					$data[] = $asteroidID;
					$data[] = $asteroid->asteroidName;
					$data[] = $asteroid->asteroidDiameter;
					$data[] = $asteroid->asteroidDistanceFromSun;
					$data[] = $asteroid->asteroidDiscoverer;
					$data[] = $asteroid->asteroidDateDiscovered;
					$this->rows[] = $data;
				}

			}

		}

	}

	public function filename() {

		return $this->filename;
		
	}
	
	public function columns() {

		return $this->columns;
		
	}
	
	public function rows() {

		return $this->rows;
		
	}

}

?>