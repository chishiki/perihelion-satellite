<?php

final class AsteroidView {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc = array(), $input = array(), $modules = array(), $errors = array(), $messages = array()) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages = $messages;

	}

	public function asteroidList() {

		$arg = new AsteroidListParameter();
		$asteroidList = new AsteroidList($arg);
		$asteroids = $asteroidList->asteroids();

		$body = '

			<div class="d-flex mb-2 justify-content-end">
				<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/create/" class="btn btn-outline-success">' . Lang::getLang('create') . '</a>
			</div>

			<div class="table-container">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col">' . Lang::getLang('asteroidID') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('asteroidName') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('asteroidDiameter') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('asteroidDistanceFromSun') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('asteroidDiscoverer') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('asteroidDateDiscovered') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->asteroidListRows($asteroids) . '</tbody>
					</table>
				</div>
			</div>

	';

		$card = new CardView('satellite_asteroid_list',array('container'),'',array('col-12'),Lang::getLang('asteroids'),$body);
		return $card->card();

	}

	public function asteroidForm($type, $asteroidID = null) {

		$asteroid = new Asteroid($asteroidID);
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($asteroid->$key)) { $asteroid->$key = $value; } }
		}

		$form = '

			<form id="asteroidForm' . ucfirst($type) . '" method="post" action="/' . Lang::prefix() . 'perihelion-satellite/asteroids/' . $type . '/' . ($asteroidID?$asteroidID.'/':'') . '">
				
				' . ($asteroidID?'<input type="hidden" name="asteroidID" value="' . $asteroidID . '">':'') . '
				
				<div class="form-row">
				
					<div class="form-group col-12 col-md-6">
						<label for="asteroidName">' . Lang::getLang('asteroidName') . '</label>
						<input type="text" class="form-control" name="asteroidName" value="' . $asteroid->asteroidName . '">
					</div>
					
					<div class="form-group col-12 col-md-3">
						<label for="asteroidDiameter">' . Lang::getLang('asteroidDiameter') . '</label>
						<input type="number" class="form-control" name="asteroidDiameter" value="' . $asteroid->asteroidDiameter . '">
					</div>

					<div class="form-group col-12 col-md-3">
						<label for="asteroidDistanceFromSun">' . Lang::getLang('asteroidDistanceFromSun') . '</label>
						<input type="number" class="form-control" name="asteroidDistanceFromSun" value="' . $asteroid->asteroidDistanceFromSun . '">
					</div>

					<div class="form-group col-12 col-md-8">
						<label for="asteroidDiscoverer">' . Lang::getLang('asteroidDiscoverer') . '</label>
						<input type="text" class="form-control" name="asteroidDiscoverer" value="' . $asteroid->asteroidDiscoverer . '">
					</div>

					<div class="form-group col-12 col-md-4">
						<label for="asteroidDateDiscovered">' . Lang::getLang('asteroidDateDiscovered') . '</label>
						<input type="date" class="form-control" name="asteroidDateDiscovered" value="' . $asteroid->asteroidDateDiscovered . '">
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<button type="submit" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('asteroidConfirmDelete').' ['. $asteroid->asteroidName .']';
		$card = new CardView('satellite_asteroid_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function asteroidConfirmDelete($asteroidID) {

		$asteroid = new Asteroid($asteroidID);

		$form = '

			<form id="asteroid_confirm_delete">
			
				<div class="form-row">
				
					<div class="form-group col-12 col-md-6">
						<label for="asteroidName">' . Lang::getLang('asteroidName') . '</label>
						<input type="text" class="form-control" name="asteroidName" value="' . $asteroid->asteroidName . '" disabled>
					</div>
					
					<div class="form-group col-12 col-md-3">
						<label for="asteroidDiameter">' . Lang::getLang('asteroidDiameter') . '</label>
						<input type="number" class="form-control" name="asteroidDiameter" value="' . $asteroid->asteroidDiameter . '" disabled>
					</div>

					<div class="form-group col-12 col-md-3">
						<label for="asteroidDistanceFromSun">' . Lang::getLang('asteroidDistanceFromSun') . '</label>
						<input type="number" class="form-control" name="asteroidDistanceFromSun" value="' . $asteroid->asteroidDistanceFromSun . '" disabled>
					</div>

					<div class="form-group col-12 col-md-8">
						<label for="asteroidDiscoverer">' . Lang::getLang('asteroidDiscoverer') . '</label>
						<input type="text" class="form-control" name="asteroidDiscoverer" value="' . $asteroid->asteroidDiscoverer . '" disabled>
					</div>

					<div class="form-group col-12 col-md-4">
						<label for="asteroidDateDiscovered">' . Lang::getLang('asteroidDateDiscovered') . '</label>
						<input type="date" class="form-control" name="asteroidDateDiscovered" value="' . $asteroid->asteroidDateDiscovered . '" disabled>
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/delete/' . $asteroidID . '/" class="btn btn-block btn-outline-danger" role="button">' . Lang::getLang('delete') . '</a>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('asteroidConfirmDelete').' ['. $asteroid->asteroidName .']';
		$card = new CardView('satellite_asteroid_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	private function asteroidListRows($asteroids) {

		$rows = '';

		foreach ($asteroids AS $asteroidID) {

			$asteroid = new Asteroid($asteroidID);

			$rows .= '
				<tr id="asteroid_id_' . $asteroidID . '" class="asteroid-list-row">
					<th scope="row">' . $asteroidID . '</th>
					<td class="text-center">' . $asteroid->asteroidName . '</td>
					<td class="text-center">' . $asteroid->asteroidDiameter . '</td>
					<td class="text-center">' . $asteroid->asteroidDistanceFromSun . '</td>
					<td class="text-center">' . $asteroid->asteroidDiscoverer . '</td>
					<td class="text-center">' . $asteroid->asteroidDateDiscovered . '</td>
					<td class="text-center">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/update/' . $asteroidID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/confirm-delete/' . $asteroidID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
					</td>
				</tr>
			';

		}

		return $rows;

	}

}

?>