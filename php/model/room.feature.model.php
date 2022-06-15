<?php

/*

CREATE TABLE `workspace_WorkspaceRoomFeature` (
  `roomFeatureID` int(12) NOT NULL AUTO_INCREMENT,
  `roomID` int(12) NOT NULL,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `roomFeatureNameEnglish` varchar(255) NOT NULL,
  `roomFeatureDescriptionEnglish` text NOT NULL,
  `roomFeatureNameJapanese` varchar(255) NOT NULL,
  `roomFeatureDescriptionJapanese` text NOT NULL,
  `roomFeaturePublished` int(1) NOT NULL,
  `roomFeatureDisplayOrder` int(4) NOT NULL,
  PRIMARY KEY (`roomFeatureID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class WorkspaceRoomFeature extends ORM {

	public $roomFeatureID;
	public $roomID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $roomFeatureNameEnglish;
	public $roomFeatureDescriptionEnglish;
	public $roomFeatureNameJapanese;
	public $roomFeatureDescriptionJapanese;
	public $roomFeaturePublished;
	public $roomFeatureDisplayOrder;

	public function __construct($roomFeatureID = null) {

		$dt = new DateTime();

		$this->roomFeatureID = 0;
		$this->roomID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->roomFeatureNameEnglish = '';
		$this->roomFeatureDescriptionEnglish = '';
		$this->roomFeatureNameJapanese = '';
		$this->roomFeatureDescriptionJapanese = '';
		$this->roomFeaturePublished = 0;
		$this->roomFeatureDisplayOrder = 0;

		if ($roomFeatureID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'roomFeatureID = :roomFeatureID';

			$query = 'SELECT * FROM workspace_WorkspaceRoomFeature WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':roomFeatureID', $roomFeatureID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function roomFeatureName() {
		$roomFeatureName = $this->roomFeatureNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomFeatureNameJapanese)) {
			$roomFeatureName = $this->roomFeatureNameJapanese;
		}
		return $roomFeatureName;
	}

	public function roomFeatureDescription() {
		$roomFeatureDescription = $this->roomFeatureDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomFeatureDescriptionJapanese)) {
			$roomFeatureDescription = $this->roomFeatureDescriptionJapanese;
		}
		return $roomFeatureDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('roomFeatureID' => $this->roomFeatureID);
		self::update($this, $conditions, true, false, 'workspace_');

	}

}

final class WorkspaceRoomFeatureList {

	private $features;

	public function __construct($roomID) {

		$this->features = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';
		$where[] = 'roomID = :roomID';

		$query = 'SELECT roomFeatureID FROM workspace_WorkspaceRoomFeature WHERE ' . implode(' AND ',$where) . ' ORDER BY roomFeatureDisplayOrder ASC';

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		$statement->bindParam(':roomID', $roomID, PDO::PARAM_INT);
		$statement->execute();

		while ($row = $statement->fetch()) {
			$this->features[] = $row['roomFeatureID'];
		}

	}

	public function features() {

		return $this->features;

	}

	public function featureCount() {

		return count($this->features);

	}

}

?>