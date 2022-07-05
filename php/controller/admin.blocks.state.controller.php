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

final class WorkspaceAdminBlockStateController {

	private array $loc;
	private array $input;
	private array $modules;
	private array $errors;
	private array $messages;

	public function __construct(array $loc = array(), array $input = array(), array $modules = array()) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = array();
		$this->messages = array();

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;

		if ($loc[0] == 'workspace' && $loc[1] == 'admin' && $loc[2] == 'blocks') {

			// if (!empty($this->input)) {
				// print_r($this->input); die();
			// }

			// /workspace/admin/blocks/create/
			if ($loc[3] == 'create' && isset($input['workspace-block-create'])) {

				// $this->errors = $this->validateWorkspaceBlockCreate($input);

				if (empty($this->errors)) {

					$block = new Block();
					foreach ($input AS $property => $value) { if (property_exists($block, $property)) { $block->$property = $value; } }
					Block::insert($block, true, 'workspace_');
					$successURL = '/' . Lang::prefix() . 'workspace/admin/blocks/';
					header("Location: $successURL");

				}

			}

			// /workspace/admin/blocks/update/<blockID>/
			if ($loc[3] == 'update' && is_numeric($loc[4]) && isset($input['workspace-block-update'])) {

				// $this->errors = $this->validateWorkspaceBlockUpdate($blockID, $input);

				if (empty($this->errors)) {

					$block = new Block($loc[4]);
					$block->updated = date('Y-m-d H:i:s');
					foreach ($input AS $property => $value) { if (property_exists($block, $property)) { $block->$property = $value; } }
					$conditions = array('blockID' => $loc[4]);
					Block::update($block, $conditions, true, false, 'workspace_');
					$this->messages[] = Lang::getLang('workspaceBlockSuccessfullyUpdated');

				}

			}

			// /workspace/admin/blocks/delete/<blockID>/
			if ($loc[3] == 'delete' && is_numeric($loc[4]) && isset($input['workspace-block-delete'])) {

				// $this->errors = $this->validateWorkspaceBlockDelete($blockID, $input);

				if (empty($this->errors)) {

					$block = new Block($loc[4]);
					$block->markAsDeleted();
					$successURL = '/' . Lang::prefix() . 'workspace/admin/blocks/';
					header("Location: $successURL");

				}

			}

			if (!isset($_SESSION['workspace']['block']['filters']) || isset($input['filter-reset'])) {
				$_SESSION['workspace']['block']['filters'] = array();
			}
			if (isset($input['filters']) && isset($input['filter'])) {
				foreach ($input['filters'] AS $filterKey => $filterValue) {
					$_SESSION['workspace']['block']['filters'][$filterKey] = $filterValue;
				}
			}

		}

	}

	private function validateWorkspaceBlockCreate($input) {
		// if () { $this->errors['errorKey'][] == Lang::getLang('errorDescription'); }
	}

	private function validateWorkspaceBlockUpdate($blockID, $input) {
		// if () { $this->errors['errorKey'][] == Lang::getLang('errorDescription'); }
	}

	private function validateWorkspaceBlockDelete($blockID, $input) {
		// if () { $this->errors['errorKey'][] == Lang::getLang('errorDescription'); }
	}

	public function getErrors() : array {
		return $this->errors;
	}

	public function getMessages() : array {
		return $this->messages;
	}

}

?>