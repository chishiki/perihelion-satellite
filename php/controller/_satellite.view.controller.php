<?php

	class BiomassViewController {

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
			$this->messages = $messages;

		}

		public function getView() {

			$loc = $this->loc;
			$input = $this->input;
			$modules = $this->modules;
			$errors = $this->errors;
			$messages = $this->messages;

			if ($loc[0] == 'perihelion-satellite') {
				if ($loc[1] == 'asteroids') { $v = new AsteroidViewController($loc, $input, $modules, $errors, $messages); }
			}

			if (isset($v)) {
				return $v->getView();
			} else {
				$url = '/' . Lang::prefix();
				header("Location: $url" );
			}

		}

	}

?>