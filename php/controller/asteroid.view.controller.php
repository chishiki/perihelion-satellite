<?php

final class AsteroidViewController {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc, $input, $modules, $errors, $messages) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages =  $messages;

	}

	public function getView() {

		$loc = $this->loc;

		if ($loc[1] == 'asteroids') {

			$asteroidView = new AsteroidView();

			// /perihelion-satellite/asteroids/create/
			if ($loc[2] == 'create') { return $asteroidView->asteroidForm('create'); }

			// /perihelion-satellite/asteroids/update/<asteroidID>/
			if ($loc[2] == 'update' && ctype_digit($loc[3])) { return $asteroidView->asteroidForm('update',$loc[3]); }

			// /perihelion-satellite/asteroids/
			return $asteroidView->asteroidList();

		}

	}

}

?>