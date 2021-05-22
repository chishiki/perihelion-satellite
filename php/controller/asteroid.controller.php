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

		// let's only allow logged in users to view asteroid pages
		if (!Auth::isLoggedIn()) {
			$loginURL = '/' . Lang::prefix() . 'login/';
			header("Location: $loginURL");
		}

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;

		if ($loc[1] == 'asteroids') {

			// /perihelion-satellite/asteroids/create/
			if ($loc[2] == 'create' && isset($input['asteroid-create'])) {

				// $this->errors (add validation here: ok to create?)
				// $this->errors[] = array('asteroid-create' => Lang::getLang('thereWasAProblemCreatingYourAsteroid'));

				if (empty($this->errors)) {

					$asteroid = new Asteroid();
					foreach ($input AS $property => $value) { if (isset($asteroid->$property)) { $asteroid->$property = $value; } }
					Asteroid::insert($asteroid, false, 'example_');
					$successURL = '/' . Lang::prefix() . 'perihelion-satellite/asteroids/';
					header("Location: $successURL");

				}

			}

			// /perihelion-satellite/asteroids/update/<asteroidID>/
			if ($loc[2] == 'update' && ctype_digit($loc[3]) && isset($input['asteroid-update'])) {

				$asteroidID = $loc[3];

				// $this->errors (add validation here: ok to update?)
				// $this->errors[] = array('asteroid-update' => Lang::getLang('thereWasAProblemUpdatingYourAsteroid'));

				if (empty($this->errors)) {

					$asteroid = new Asteroid($asteroidID);
					$asteroid->updated = date('Y-m-d H:i:s');
					foreach ($input AS $property => $value) { if (isset($asteroid->$property)) { $asteroid->$property = $value; } }
					$conditions = array('asteroidID' => $asteroidID);
					Asteroid::update($asteroid, $conditions, true, false, 'example_');
					$this->messages[] = Lang::getLang('asteroidUpdateSuccessful');

				}

			}

			// /perihelion-satellite/asteroids/delete/<asteroidID>/
			if ($loc[2] == 'delete' && ctype_digit($loc[3]) && isset($input['asteroid-delete'])) {

				$asteroidID = $loc[3];

				if ($input['asteroidID'] != $asteroidID) {
					$this->errors[] = array('asteroid-delete' => Lang::getLang('thereWasAProblemDeletingYourAsteroid'));
				}

				if (empty($this->errors)) {

					$asteroid = new Asteroid($asteroidID);
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