<?php

/*

CREATE TABLE `workspace_WorkspaceRoomCategory` (
  `roomCategoryID` int(12) NOT NULL AUTO_INCREMENT,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `roomCategoryNameEnglish` varchar(255) NOT NULL,
  `roomCategoryDescriptionEnglish` text NOT NULL,
  `roomCategoryNameJapanese` varchar(255) NOT NULL,
  `roomCategoryDescriptionJapanese` text NOT NULL,
  `roomCategoryPublished` int(1) NOT NULL,
  `roomCategoryURL` varchar(100) NOT NULL,
  `roomCategoryDisplayOrder` int(4) NOT NULL,
  PRIMARY KEY (`roomCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class WorkspaceRoomCategory extends ORM {

	public $roomCategoryID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $roomCategoryNameEnglish;
	public $roomCategoryDescriptionEnglish;
	public $roomCategoryNameJapanese;
	public $roomCategoryDescriptionJapanese;
	public $roomCategoryPublished;
	public $roomCategoryURL;
	public $roomCategoryDisplayOrder;

	public function __construct($roomCategoryID = null) {

		$dt = new DateTime();

		$this->roomCategoryID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->roomCategoryNameEnglish = '';
		$this->roomCategoryDescriptionEnglish = '';
		$this->roomCategoryNameJapanese = '';
		$this->roomCategoryDescriptionJapanese = '';
		$this->roomCategoryPublished = 0;
		$this->roomCategoryURL = '';
		$this->roomCategoryDisplayOrder = 0;

		if ($roomCategoryID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'roomCategoryID = :roomCategoryID';

			$query = 'SELECT * FROM workspace_WorkspaceRoomCategory WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':roomCategoryID', $roomCategoryID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function roomCategoryName() {
		$roomCategoryName = $this->roomCategoryNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomCategoryNameJapanese)) {
			$roomCategoryName = $this->roomCategoryNameJapanese;
		}
		return $roomCategoryName;
	}

	public function roomCategoryDescription() {
		$roomCategoryDescription = $this->roomCategoryDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomCategoryDescriptionJapanese)) {
			$roomCategoryDescription = $this->roomCategoryDescriptionJapanese;
		}
		return $roomCategoryDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('roomCategoryID' => $this->roomCategoryID);
		self::update($this, $conditions, true, false, 'workspace_');

	}

}

final class WorkspaceRoomCategoryList {

	private $roomCategories;

	public function __construct() {

		$this->roomCategories = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';

		$query = 'SELECT roomCategoryID FROM workspace_WorkspaceRoomCategory WHERE ' . implode(' AND ',$where) . ' ORDER BY roomCategoryDisplayOrder ASC';

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		$statement->execute();

		while ($row = $statement->fetch()) {
			$this->roomCategories[] = $row['roomCategoryID'];
		}

	}

	public function roomCategories() {

		return $this->roomCategories;

	}

	public function roomCategoryCount() {

		return count($this->roomCategories);

	}

}

?>