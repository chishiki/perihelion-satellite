<?php

final class AsteroidController {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc, $input, $modules) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = array();
		$this->messages =  array();

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;

		if ($loc[2] == 'asteroids') {

			if ($loc[3] == 'create' && !empty($input)) {

				// $this->errors (add validation here: ok to create?)

				if (empty($this->errors)) {

					$asteroid = new Asteroid();
					foreach ($input AS $property => $value) { if (isset($asteroid->$property)) { $asteroid->$property = $value; } }
					$asteroidID = Asteroid::insert($asteroid, true, 'satellite_');
					$successURL = '/' . Lang::prefix() . 'perihelion-satellite/asteroids/';
					header("Location: $successURL");

				}

			}

			if ($loc[3] == 'update' && ctype_digit($loc[4])) {

				if (!empty($input)) {

					// $this->errors (add validation here: ok to update?)

					if (empty($this->errors)) {

						$asteroid = new Asteroid($asteroidID);
						$asteroid->updated = date('Y-m-d H:i:s');
						foreach ($input AS $property => $value) { if (isset($asteroid->$property)) { $asteroid->$property = $value; } }
						$conditions = array('asteroidID' => $asteroidID);
						Asteroid::update($asteroid, $conditions, true, false, 'satellite_');
						$this->messages[] = Lang::getLang('asteroidUpdateSuccessful');

					}

				}


			}

			if ($loc[3] == 'confirm-delete' && ctype_digit($loc[4])) {

				// $this->errors (add validation here: ok to delete?)

				if (empty($this->errors)) {

					$asteroid = new Asteroid($loc[3]);
					$asteroid->markAsDeleted(); // example of a SOFT delete (flagged as deleted but stays in database)
					$this->messages[] = Lang::getLang('asteroidDeleteSuccessful');

				}

			}

		}

	}

	public function getErrors() {
		return $this->errors;
	}

	public function getMessages() {
		return $this->messages;
	}

}

?>