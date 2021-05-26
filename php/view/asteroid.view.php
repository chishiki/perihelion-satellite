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

			<div class="row">
				<div class="col-12 col-sm-6 offset-sm-6 col-md-3 offset-md-9 col-lg-2 offset-lg-10">
					<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/create/" class="btn btn-block btn-outline-success">' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mt-2">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('asteroidID') . '</th>
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

		$card = new CardView('asteroid_list',array('container'),'',array('col-12'),Lang::getLang('asteroids'),$body);
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
						<div class="input-group">
							<input type="number" class="form-control" name="asteroidDiameter" value="' . $asteroid->asteroidDiameter . '" min="0" step="0.1" max="99999.9"> <!-- decimal(6,1) -->
							<div class="input-group-append"><span class="input-group-text">KM</span></div>
						</div>
					</div>

					<div class="form-group col-12 col-md-3">
						<label for="asteroidDistanceFromSun">' . Lang::getLang('asteroidDistanceFromSun') . '</label>
						<div class="input-group">
							<input type="number" class="form-control" name="asteroidDistanceFromSun" value="' . $asteroid->asteroidDistanceFromSun . '" min="0" step="0.0001" max="9999.9999"> <!-- decimal(8,4) -->
							<div class="input-group-append"><span class="input-group-text">AU</span></div>
						</div>
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
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="asteroid-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('asteroid'.ucfirst($type)).($type=='update'?' ['.$asteroid->asteroidName.']':'');
		$card = new CardView('asteroid_confirm_'.ucfirst($type),array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function asteroidConfirmDelete($asteroidID) {

		$asteroid = new Asteroid($asteroidID);

		$form = '

			<form id="asteroid_form_delete" method="post" action="/' . Lang::prefix() . 'perihelion-satellite/asteroids/delete/' . $asteroidID . '/">
				
				<input type="hidden" name="asteroidID" value="' . $asteroidID . '">

				<div class="form-row">
				
					<div class="form-group col-12 col-md-6">
						<label for="asteroidName">' . Lang::getLang('asteroidName') . '</label>
						<input type="text" class="form-control" name="asteroidName" value="' . $asteroid->asteroidName . '" disabled>
					</div>
					
					<div class="form-group col-12 col-md-3">
						<label for="asteroidDiameter">' . Lang::getLang('asteroidDiameter') . '</label>
						<div class="input-group">
							<input type="number" class="form-control" name="asteroidDiameter" value="' . $asteroid->asteroidDiameter . '" disabled>
							<div class="input-group-append"><span class="input-group-text">KM</span></div>
						</div>
					</div>

					<div class="form-group col-12 col-md-3">
						<label for="asteroidDistanceFromSun">' . Lang::getLang('asteroidDistanceFromSun') . '</label>
						<div class="input-group">
							<input type="number" class="form-control" name="asteroidDistanceFromSun" value="' . $asteroid->asteroidDistanceFromSun . '" disabled>
							<div class="input-group-append"><span class="input-group-text">AU</span></div>
						</div>
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
						<button type="submit" name="asteroid-delete" class="btn btn-block btn-outline-danger">' . Lang::getLang('delete') . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('asteroidConfirmDelete').' ['. $asteroid->asteroidName .']';
		$card = new CardView('asteroid_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	private function asteroidListRows($asteroids) {

		$rows = '';

		foreach ($asteroids AS $asteroidID) {

			$asteroid = new Asteroid($asteroidID);

			$rows .= '
				<tr id="asteroid_id_' . $asteroidID . '" class="asteroid-list-row">
					<th scope="row" class="text-center">' . $asteroidID . '</th>
					<td class="text-left">' . $asteroid->asteroidName . '</td>
					<td class="text-center">' . number_format($asteroid->asteroidDiameter, 1) . ' KM</td> <!-- decimal(6,1) -->
					<td class="text-center">' . number_format($asteroid->asteroidDistanceFromSun, 4) . ' AU</td> <!-- decimal(8,4) -->
					<td class="text-center">' . $asteroid->asteroidDiscoverer . '</td>
					<td class="text-center">' . $asteroid->asteroidDateDiscovered . '</td>
					<td class="text-center text-nowrap">
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