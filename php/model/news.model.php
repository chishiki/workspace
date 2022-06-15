<?php

/*

CREATE TABLE `workspace_WorkspaceNews` (
  `newsID` int(12) NOT NULL AUTO_INCREMENT,
  `siteID` int(12) NOT NULL,
  `creator` int(12) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `newsDate` date NOT NULL,
  `newsTitleEnglish` varchar(255) NOT NULL,
  `newsContentEnglish` text NOT NULL,
  `newsTitleJapanese` varchar(255) NOT NULL,
  `newsContentJapanese` text NOT NULL,
  `newsPublished` int(1) NOT NULL,
  `newsURL` varchar(100) NOT NULL,
  PRIMARY KEY (`newsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class WorkspaceNews extends ORM {

	public $newsID;
	public $siteID;
	public $creator;
	public $created;
	public $updated;
	public $deleted;
	public $newsDate;
	public $newsTitleEnglish;
	public $newsContentEnglish;
	public $newsTitleJapanese;
	public $newsContentJapanese;
	public $newsPublished;
	public $newsURL;

	public function __construct($newsID = null) {

		$dt = new DateTime();

		$this->newsID = 0;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 0;
		$this->newsDate = $dt->format('Y-m-d');
		$this->newsTitleEnglish = '';
		$this->newsContentEnglish = '';
		$this->newsTitleJapanese = '';
		$this->newsContentJapanese = '';
		$this->newsPublished = 0;
		$this->newsURL = '';

		if ($newsID) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();

			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'newsID = :newsID';

			$query = 'SELECT * FROM workspace_WorkspaceNews WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';

			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':newsID', $newsID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (isset($this->$key)) { $this->$key = $value; } }
			}

		}

	}

	public function newsTitle() {
		$newsTitle = $this->newsTitleEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->newsTitleJapanese)) {
			$newsTitle = $this->newsTitleJapanese;
		}
		return $newsTitle;
	}

	public function newsContent() {
		$newsContent = $this->newsContentEnglish;
		if ($_SESSION['lang'] == 'ja' && !empty($this->newsContentJapanese)) {
			$newsContent = $this->newsContentJapanese;
		}
		return $newsContent;
	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('newsID' => $this->newsID);
		self::update($this, $conditions, true, false, 'workspace_');

	}

}

final class WorkspaceNewsList {

	private $news;

	public function __construct(WorkspaceNewsListParameter $arg) {

		$this->news = array();

		$where = array();
		$where[] = 'siteID = :siteID';
		$where[] = 'deleted = 0';

		if ($arg->newsID) { $where[] = 'newsID = :newsID'; }
		if ($arg->newsURL) { $where[] = 'newsURL = :newsURL'; }
		if ($arg->newsPublished === true) { $where[] = 'newsPublished = 1'; }
		if ($arg->newsPublished === false) { $where[] = 'newsPublished = 0'; }

		$orderBy = array();
		foreach ($arg->orderBy AS $field => $sort) { $orderBy[] = $field . ' ' . $sort; }

		switch ($arg->resultSet) {
			case 'robust':
				$selector = '*';
				break;
			default:
				$selector = 'newsID';
		}

		$query = 'SELECT ' . $selector . ' FROM workspace_WorkspaceNews WHERE ' . implode(' AND ',$where) . ' ORDER BY ' . implode(', ',$orderBy);
		if ($arg->limit) { $query .= ' LIMIT ' . $arg->limit . ($arg->offset?', '.$arg->offset:''); }

		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);

		if ($arg->newsID) { $statement->bindParam(':newsID', $arg->newsID, PDO::PARAM_INT); }
		if ($arg->newsURL) { $statement->bindParam(':newsURL', $arg->newsURL, PDO::PARAM_STR); }

		$statement->execute();

		while ($row = $statement->fetch()) {
			if ($arg->resultSet == 'robust') {
				$this->news[] = $row;
			} else {
				$this->news[] = $row['newsID'];
			}
		}

	}

	public function news() {

		return $this->news;

	}

	public function newsCount() {

		return count($this->news);

	}

}

final class WorkspaceNewsListParameter {

	public $newsID;
	public $newsURL;
	public $newsPublished;
	public $resultSet;
	public $orderBy;
	public $limit;
	public $offset;

	public function __construct() {

		$this->newsID = null;
		$this->newsURL = null;
		$this->newsPublished = null; // [null => either, true => yes, false => no]
		$this->resultSet = 'id'; // [id|robust]
		$this->orderBy = array('newsDate' => 'DESC');
		$this->limit = null;
		$this->offset = null;

	}

}

final class WorkspaceNewsUtilities {

	public static function newsUrlExists($newsURL) {

		$arg = new WorkspaceNewsListParameter();
		$arg->newsURL = $newsURL;
		$newsList = new WorkspaceNewsList($arg);

		if ($newsList->newsCount() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public static function getNewsWithURL($newsURL) {

		$newsID = null;

		$arg = new WorkspaceNewsListParameter();
		$arg->newsURL = $newsURL;
		$newsList = new WorkspaceNewsList($arg);
		$newsItems = $newsList->news();

		if (count($newsItems)) {
			$newsID = $newsItems[0];
		}

		return $newsID;

	}

}

?>