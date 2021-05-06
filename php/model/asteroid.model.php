<?php

/*

CREATE TABLE `satellite_Asteroid` (
	`asteroidID` INT(12) NOT NULL AUTO_INCREMENT,
	`siteID` INT(12) NOT NULL,
	`creator` INT(12) NOT NULL,
	`created` DATETIME NOT NULL,
	`updated` DATETIME NOT NULL,
	`deleted` INT(1) NOT NULL,
	`asteroidName` VARCHAR(100) NOT NULL,
	`asteroidDiameter` INT(12) NOT NULL,
	`asteroidDistanceFromSun` INT(12) NOT NULL,
	`asteroidDiscoverer` VARCHAR(100) NOT NULL,
	`asteroidDateDiscovered` DATE NOT NULL,
	PRIMARY KEY (`asteroidID`)
);

*/

final class Asteroid extends ORM {

	public $asteroidID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $asteroidName;
	public $asteroidDiameter;
	public $asteroidDistanceFromSun;
	public $asteroidDiscoverer;
	public $asteroidDateDiscovered;

	public function __construct($asteroidID = null) {

		$dt = new DateTime();

		$this->asteroidID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->asteroidName = '';
		$this->asteroidDiameter = 0;
		$this->asteroidDistanceFromSun = 0;
		$this->asteroidDiscoverer = '';
		$this->asteroidDateDiscovered = '0000-00-00';

		if ($asteroidID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'asteroidID = :asteroidID';

			$query = 'SELECT * FROM satellite_Asteroid WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':asteroidID', $asteroidID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function markAsDeleted() { // SOFT DELETE; FOR HARD DELETE USE Asteroid::delete()

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('asteroidID' => $this->asteroidID);
		self::update($this, $conditions, true, false, 'satellite_');

	}

}

final class AsteroidList {

	private $asteroids;

	public function __construct(AsteroidListParameter $arg) {

		$this->asteroids = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';

		if ($arg->asteroidID) { $where[] = 'asteroidID = :asteroidID'; }
		if ($arg->asteroidName) { $where[] = 'asteroidName = :asteroidName'; }
		if ($arg->asteroidDiameter) { $where[] = 'asteroidDiameter = :asteroidDiameter'; }
		if ($arg->asteroidDistanceFromSun) { $where[] = 'asteroidDistanceFromSun = :asteroidDistanceFromSun'; }
		if ($arg->asteroidDiscoverer) { $where[] = 'asteroidDiscoverer = :asteroidDiscoverer'; }
		if ($arg->asteroidDateDiscovered) { $where[] = 'asteroidDateDiscovered = :asteroidDateDiscovered'; }

		$orderBy = array();
		foreach ($arg->orderBy AS $field => $sort) { $orderBy[] = $field . ' ' . $sort; }

		switch ($arg->resultSet) {
			case 'robust':
				$selector = '*';
				break;
			default:
				$selector = 'asteroidID';
		}

		$query = 'SELECT ' . $selector . ' FROM satellite_Asteroid WHERE ' . implode(' AND ',$where) . ' ORDER BY ' . implode(', ',$orderBy);
		if ($arg->limit) { $query .= ' LIMIT ' . $arg->limit . ($arg->offset?', '.$arg->offset:''); }

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);

		if ($arg->asteroidID) { $statement->bindParam(':asteroidID', $arg->asteroidID, PDO::PARAM_INT); }
		if ($arg->asteroidName) { $statement->bindParam(':asteroidName', $arg->asteroidName, PDO::PARAM_STR); }
		if ($arg->asteroidDiameter) { $statement->bindParam(':asteroidDiameter', $arg->asteroidDiameter, PDO::PARAM_INT); }
		if ($arg->asteroidDistanceFromSun) { $statement->bindParam(':asteroidDistanceFromSun', $arg->asteroidDistanceFromSun, PDO::PARAM_INT); }
		if ($arg->asteroidDiscoverer) { $statement->bindParam(':asteroidDiscoverer', $arg->asteroidDiscoverer, PDO::PARAM_STR); }
		if ($arg->asteroidDateDiscovered) { $statement->bindParam(':asteroidDateDiscovered', $arg->asteroidDateDiscovered, PDO::PARAM_STR); }

		$statement->execute();

		while ($row = $statement->fetch()) {
			if ($arg->resultSet == 'robust') {
				$this->asteroids[] = $row;
			} else {
				$this->asteroids[] = $row['asteroidID'];
			}
		}

	}

	public function asteroids() {

		return $this->asteroids;

	}

	public function asteroidCount() {

		return count($this->asteroids);

	}

}

final class AsteroidListParameter {

	public $asteroidID;
	public $asteroidName;
	public $asteroidDiameter;
	public $asteroidDistanceFromSun;
	public $asteroidDiscoverer;
	public $asteroidDateDiscovered;
	public $resultSet;
	public $orderBy;
	public $limit;
	public $offset;

	public function __construct() {

		$this->asteroidID = null;
		$this->asteroidName = null;
		$this->asteroidDiameter = null;
		$this->asteroidDistanceFromSun = null;
		$this->asteroidDiscoverer = null;
		$this->asteroidDateDiscovered = null;
		$this->resultSet = 'id'; // [id|robust]
		$this->orderBy = array('asteroidName' => 'ASC');
		$this->limit = null;
		$this->offset = null;

	}


}

?>