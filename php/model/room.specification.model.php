<?php

/*

CREATE TABLE `workspace_WorkspaceRoomSpecification` (
  `roomSpecificationID` int(12) NOT NULL AUTO_INCREMENT,
  `roomID` int(12) NOT NULL,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `roomSpecificationNameEnglish` varchar(255) NOT NULL,
  `roomSpecificationDescriptionEnglish` text NOT NULL,
  `roomSpecificationNameJapanese` varchar(255) NOT NULL,
  `roomSpecificationDescriptionJapanese` text NOT NULL,
  `roomSpecificationPublished` int(1) NOT NULL,
  `roomSpecificationDisplayOrder` int(4) NOT NULL,
  PRIMARY KEY (`roomSpecificationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class WorkspaceRoomSpecification extends ORM {

	public $roomSpecificationID;
	public $roomID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $roomSpecificationNameEnglish;
	public $roomSpecificationDescriptionEnglish;
	public $roomSpecificationNameJapanese;
	public $roomSpecificationDescriptionJapanese;
	public $roomSpecificationPublished;
	public $roomSpecificationDisplayOrder;

	public function __construct($roomSpecificationID = null) {

		$dt = new DateTime();

		$this->roomSpecificationID = 0;
		$this->roomID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->roomSpecificationNameEnglish = '';
		$this->roomSpecificationDescriptionEnglish = '';
		$this->roomSpecificationNameJapanese = '';
		$this->roomSpecificationDescriptionJapanese = '';
		$this->roomSpecificationPublished = 0;
		$this->roomSpecificationDisplayOrder = 0;

		if ($roomSpecificationID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'roomSpecificationID = :roomSpecificationID';

			$query = 'SELECT * FROM workspace_WorkspaceRoomSpecification WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':roomSpecificationID', $roomSpecificationID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function roomSpecificationName() {
		$roomSpecificationName = $this->roomSpecificationNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomSpecificationNameJapanese)) {
			$roomSpecificationName = $this->roomSpecificationNameJapanese;
		}
		return $roomSpecificationName;
	}

	public function roomSpecificationDescription() {
		$roomSpecificationDescription = $this->roomSpecificationDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomSpecificationDescriptionJapanese)) {
			$roomSpecificationDescription = $this->roomSpecificationDescriptionJapanese;
		}
		return $roomSpecificationDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('roomSpecificationID' => $this->roomSpecificationID);
		self::update($this, $conditions, true, false, 'workspace_');

	}

}

final class WorkspaceRoomSpecificationList {

	private $specifications;

	public function __construct($roomID) {

		$this->specifications = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';
		$where[] = 'roomID = :roomID';

		$query = 'SELECT roomSpecificationID FROM workspace_WorkspaceRoomSpecification WHERE ' . implode(' AND ',$where) . ' ORDER BY roomSpecificationDisplayOrder ASC';

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		$statement->bindParam(':roomID', $roomID, PDO::PARAM_INT);
		$statement->execute();

		while ($row = $statement->fetch()) {
			$this->specifications[] = $row['roomSpecificationID'];
		}

	}

	public function specifications() {

		return $this->specifications;

	}

	public function specificationCount() {

		return count($this->specifications);

	}

}

?>