<?php

/*

CREATE TABLE `workspace_WorkspaceRoom` (
  `roomID` int(12) NOT NULL AUTO_INCREMENT,
  `roomCategoryID` int(12) NOT NULL,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `roomNameEnglish` varchar(255) NOT NULL,
  `roomDescriptionEnglish` text NOT NULL,
  `roomNameJapanese` varchar(255) NOT NULL,
  `roomDescriptionJapanese` text NOT NULL,
  `roomPublished` int(1) NOT NULL,
  `roomFeatured` int(1) NOT NULL,
  `roomURL` varchar(100) NOT NULL,
  PRIMARY KEY (`roomID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class WorkspaceRoom extends ORM {

	public $roomID;
	public $roomCategoryID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $roomNameEnglish;
	public $roomDescriptionEnglish;
	public $roomNameJapanese;
	public $roomDescriptionJapanese;
	public $roomPublished;
	public $roomFeatured;
	public $roomURL;
	public $roomBookingURL;

	public function __construct($roomID = null) {

		$dt = new DateTime();

		$this->roomID = 0;
		$this->roomCategoryID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->roomNameEnglish = '';
		$this->roomDescriptionEnglish = '';
		$this->roomNameJapanese = '';
		$this->roomDescriptionJapanese = '';
		$this->roomPublished = 0;
		$this->roomFeatured = 0;
		$this->roomURL = '';
		$this->roomBookingURL = '';

		if ($roomID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'roomID = :roomID';

			$query = 'SELECT * FROM workspace_WorkspaceRoom WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':roomID', $roomID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function roomName() {
		$roomName = $this->roomNameEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomNameJapanese)) {
			$roomName = $this->roomNameJapanese;
		}
		return $roomName;
	}

	public function roomDescription() {
		$roomDescription = $this->roomDescriptionEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->roomDescriptionJapanese)) {
			$roomDescription = $this->roomDescriptionJapanese;
		}
		return $roomDescription;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('roomID' => $this->roomID);
		self::update($this, $conditions, true, false, 'workspace_');

	}

}

final class WorkspaceRoomList {

	private $rooms;

	public function __construct(WorkspaceRoomListParameters $arg) {

		$this->rooms = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';

		if ($arg->roomID) { $where[] = 'roomID = :roomID'; }
		if ($arg->roomCategoryID) { $where[] = 'roomCategoryID = :roomCategoryID'; }
		if ($arg->roomURL) { $where[] = 'roomURL = :roomURL'; }
		if ($arg->roomPublished === true) { $where[] = 'roomPublished = 1'; }
		if ($arg->roomPublished === false) { $where[] = 'roomPublished = 0'; }
		if ($arg->roomFeatured === true) { $where[] = 'roomFeatured = 1'; }
		if ($arg->roomFeatured === false) { $where[] = 'roomFeatured = 0'; }

		$orderBy = array();
		foreach ($arg->orderBy AS $field => $sort) { $orderBy[] = $field . ' ' . $sort; }

		switch ($arg->resultSet) {
			case 'robust':
				$selector = '*';
				break;
			default:
				$selector = 'roomID';
		}

		$query = 'SELECT ' . $selector . ' FROM workspace_WorkspaceRoom WHERE ' . implode(' AND ',$where) . ' ORDER BY ' . implode(', ',$orderBy);
		if ($arg->limit) { $query .= ' LIMIT ' . (!is_null($arg->offset)?$arg->offset.', ':'') . $arg->limit; }

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);

		if ($arg->roomID) { $statement->bindParam(':roomID', $arg->roomID, PDO::PARAM_INT); }
		if ($arg->roomCategoryID) { $statement->bindParam(':roomCategoryID', $arg->roomCategoryID, PDO::PARAM_INT); }
		if ($arg->roomURL) { $statement->bindParam(':roomURL', $arg->roomURL, PDO::PARAM_STR); }

		$statement->execute();

		while ($row = $statement->fetch()) {
			if ($arg->resultSet == 'robust') {
				$this->rooms[] = $row;
			} else {
				$this->rooms[] = $row['roomID'];
			}
		}

	}

	public function rooms() {

		return $this->rooms;

	}

	public function roomCount() {

		return count($this->rooms);

	}

}

final class WorkspaceRoomListParameters {

	// list filters
	public $roomID;
	public $roomCategoryID;
	public $roomPublished;
	public $roomFeatured;
	public $roomURL;

	// view parameters
	public $title;
	public $descriptionConcat;

	public $currentPage;
	public $numberOfPages;

	public $resultSet;
	public $orderBy;
	public $limit;
	public $offset;

	public function __construct() {

		$this->roomID = null;
		$this->roomCategoryID = null;
		$this->roomPublished = true; // [null => either; true => published only; false => not published only]
		$this->roomFeatured = null; // [null => either; true => featured only; false => not featured only]
		$this->roomURL = null;

		$this->title = array('langKey' => 'workspaceRooms', 'langSelector' => 'session');
		$this->descriptionConcat = null; // ^null$|(^[0-9]+)$

		$this->currentPage = null;
		$this->numberOfPages = null;

		$this->resultSet = 'id'; // [id|robust]
		$this->orderBy = array('created' => 'DESC');
		$this->limit = null;
		$this->offset = null;

	}

}

final class WorkspaceRoomUtilities {

	public static function roomUrlExists($roomURL) {

		$arg = new WorkspaceRoomListParameters();
		$arg->roomURL = $roomURL;
		$roomList = new WorkspaceRoomList($arg);

		if ($roomList->roomCount() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public static function getRoomWithURL($roomURL) {

		$roomID = null;

		$arg = new WorkspaceRoomListParameters();
		$arg->roomURL = $roomURL;
		$roomList = new WorkspaceRoomList($arg);
		$rooms = $roomList->rooms();

		if (count($rooms)) {
			$roomID = $rooms[0];
		}

		return $roomID;

	}

}

?>