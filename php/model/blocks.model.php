<?php

/*

CREATE TABLE `workspace_Block` (
    `blockID` int NOT NULL AUTO_INCREMENT,
    `siteID` int NOT NULL,
    `creator` int NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime DEFAULT NULL,
    `deleted` int NOT NULL,
    `blockTitleEnglish` varchar(100) NOT NULL,
    `blockTextEnglish` text NOT NULL,
    `blockLinkUrlEnglish` varchar(255) NOT NULL,
    `blockTitleJapanese` varchar(100) NOT NULL,
    `blockTextJapanese` text NOT NULL,
    `blockLinkUrlJapanese` varchar(255) NOT NULL,
    `blockPublished` int NOT NULL,
    `blockDisplayOrder` int NOT NULL,
    PRIMARY KEY (`blockID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class Block extends ORM {

	public ?int $blockID;
	public int $siteID;
	public int $creator;
	public string $created;
	public ?string $updated;
	public int $deleted;
	public string $blockTitleEnglish;
	public string $blockTextEnglish;
	public string $blockLinkUrlEnglish;
	public string $blockTitleJapanese;
	public string $blockTextJapanese;
	public string $blockLinkUrlJapanese;
	public int $blockPublished;
	public int $blockDisplayOrder;

	public function __construct($blockID = null) {

		$dt = new DateTime();

		$this->blockID = null;
		$this->siteID = $_SESSION['siteID'];
		$this->creator = $_SESSION['userID'];
		$this->created = $dt->format('Y-m-d H:i:s');
		$this->updated = null;
		$this->deleted = 0;
		$this->blockTitleEnglish = '';
		$this->blockTextEnglish = '';
		$this->blockLinkUrlEnglish = '';
		$this->blockTitleJapanese = '';
		$this->blockTextJapanese = '';
		$this->blockLinkUrlJapanese = '';
		$this->blockPublished = 1;
		$this->blockDisplayOrder = 0;

		if (!is_null($blockID)) {

			$nucleus = Nucleus::getInstance();

			$whereClause = array();
			$whereClause[] = 'siteID = :siteID';
			$whereClause[] = 'deleted = 0';
			$whereClause[] = 'blockID = :blockID';

			$query = 'SELECT * FROM workspace_Block WHERE ' . implode(' AND ', $whereClause) . ' LIMIT 1';
			$statement = $nucleus->database->prepare($query);
			$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
			$statement->bindParam(':blockID', $blockID, PDO::PARAM_INT);
			$statement->execute();

			if ($row = $statement->fetch()) {
				foreach ($row AS $key => $value) { if (property_exists($this, $key)) { $this->$key = $value; } }
			}

		}

	}

	public function markAsDeleted() {

		$dt = new DateTime();
		$this->updated = $dt->format('Y-m-d H:i:s');
		$this->deleted = 1;
		$conditions = array('blockID' => $this->blockID);
		self::update($this, $conditions, true, false, 'workspace_');

	}

}

final class WorkspaceBlockList {

	private array $results = array();

	public function __construct(WorkspaceBlockListParameters $arg) {

		// WHERE
		$wheres = array();
		$wheres[] = 'workspace_Block.deleted = 0';
		$wheres[] = 'workspace_Block.siteID = :siteID';
		if (!is_null($arg->blockID)) { $wheres[] = 'workspace_Block.blockID = :blockID'; }
		if (!is_null($arg->creator)) { $wheres[] = 'workspace_Block.creator = :creator'; }
		if (!is_null($arg->created)) { $wheres[] = 'workspace_Block.created = :created'; }
		if (!is_null($arg->updated)) { $wheres[] = 'workspace_Block.updated = :updated'; }
		if (!is_null($arg->blockTitle)) { $wheres[] = 'workspace_Block.blockTitle = :blockTitle'; }
		if (!is_null($arg->blockText)) { $wheres[] = 'workspace_Block.blockText = :blockText'; }
		if (!is_null($arg->blockLinkURL)) { $wheres[] = 'workspace_Block.blockLinkURL = :blockLinkURL'; }
		$where = ' WHERE ' . implode(' AND ', $wheres);

		// SELECTOR
		$selectorArray = array();
		foreach ($arg->resultSet AS $fieldAlias) { $selectorArray[] = $fieldAlias['field'] . ' AS ' . $fieldAlias['alias']; }
		$selector = implode(', ', $selectorArray);

		// ORDER BY
		$orderBys = array();
		foreach ($arg->orderBy AS $fieldSort) { $orderBys[] = $fieldSort['field'] . ' ' . $fieldSort['sort']; }

		$orderBy = '';
		if (!empty($orderBys)) { $orderBy = ' ORDER BY ' . implode(', ', $orderBys); }

		// BUILD QUERY
		$query = 'SELECT ' . $selector . ' FROM workspace_Block' . $where . $orderBy;
		if ($arg->limit) { $query .= ' LIMIT ' . ($arg->offset?$arg->offset.', ':'') . $arg->limit; }

		// PREPARE QUERY, BIND PARAMS, EXECUTE QUERY
		$nucleus = Nucleus::getInstance();
		$statement = $nucleus->database->prepare($query);
		$statement->bindParam(':siteID', $_SESSION['siteID'], PDO::PARAM_INT);
		if (!is_null($arg->blockID)) { $statement->bindParam(':blockID', $arg->blockID, PDO::PARAM_INT); }
		if (!is_null($arg->creator)) { $statement->bindParam(':creator', $arg->creator, PDO::PARAM_INT); }
		if (!is_null($arg->created)) { $statement->bindParam(':created', $arg->created, PDO::PARAM_STR); }
		if (!is_null($arg->updated)) { $statement->bindParam(':updated', $arg->updated, PDO::PARAM_STR); }
		if (!is_null($arg->blockTitle)) { $statement->bindParam(':blockTitle', $arg->blockTitle, PDO::PARAM_STR); }
		if (!is_null($arg->blockText)) { $statement->bindParam(':blockText', $arg->blockText, PDO::PARAM_STR); }
		if (!is_null($arg->blockLinkURL)) { $statement->bindParam(':blockLinkURL', $arg->blockLinkURL, PDO::PARAM_STR); }
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();

		// WRITE QUERY RESULTS TO ARRAY
		while ($row = $statement->fetch()) { $this->results[] = $row; }

	}

	public function results() : array {

		return $this->results;

	}

	public function resultCount() : int {

		return count($this->results);

	}

}

final class WorkspaceBlockListParameters {

	// list filters
	public ?int $blockID;
	public ?int $creator;
	public ?string $created;
	public ?string $updated;
	public ?string $blockTitle;
	public ?string $blockText;
	public ?string $blockLinkURL;

	// view parameters
	public ?int $currentPage;
	public ?int $numberOfPages;

	// results, order, limit, offset
	public array $resultSet;
	public array $orderBy;
	public ?int $limit;
	public ?int $offset;

	public function __construct() {

		// list filters
		$this->blockID = null;
		$this->creator = null;
		$this->created = null;
		$this->updated = null;
		$this->blockTitle = null;
		$this->blockText = null;
		$this->blockLinkURL = null;

		// view parameters
		$this->currentPage = null;
		$this->numberOfPages = null;

		// results, order, limit, offset
		$this->resultSet = array();
		$object = new Block();
		foreach ($object AS $key => $value) {
			$this->resultSet[] = array('field' => 'workspace_Block.'.$key, 'alias' => $key);
		}
		$this->orderBy = array(
			array('field' => 'workspace_Block.created', 'sort' => 'DESC')
		);
		$this->limit = null;
		$this->offset = null;

	}

}

?>