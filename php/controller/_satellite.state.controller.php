<?php

final class PerihelionSatelliteController {

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

		if (!Auth::isLoggedIn()) {
			$loginURL = '/' . Lang::prefix() . 'login/';
			header("Location: $loginURL");
		}

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;

		if ($loc[0] == 'perihelion-satellite') {
			if ($loc[1] == 'asteroids') { $controller = new AsteroidController($loc,$input,$modules); }
		}

		if (isset($controller)) {
			$controller->setState();
			$this->errors = $controller->getErrors();
			$this->messages = $controller->getMessages();
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