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

final class WorkspaceAdminBlockViewController {

	private array $loc;
	private array $input;
	private array $modules;
	private array $errors;
	private array $messages;

	public function __construct(array $loc = array(), array $input = array(), array $modules = array(), array $errors = array(), array $messages = array()) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages = $messages;

	}

	public function getView() {

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;
		$errors = $this->errors;
		$messages = $this->messages;

		if ($loc[0] == 'workspace' && $loc[1] == 'admin' && $loc[2] == 'blocks') {

			$view = new WorkspaceBlockView($loc, $input, $modules, $errors, $messages);
			$panko = new BreadcrumbsView($loc, array('highlight'), array(), array('workspace'));

			// /workspace/admin/blocks/create/
			if ($loc[3] == 'create') {
				return $panko->breadcrumbs() . $view->workspaceBlockForm('create');
			}

			// /workspace/admin/blocks/update/<blockID>/
			if ($loc[3] == 'update' && is_numeric($loc[4])) {

				$blockID = $loc[4];

				if ($loc[5] == 'images') {

					$view = new ImageView($loc, $input, $errors);
					$block = new Block($blockID);
					$wbv = new WorkspaceBlockView();

					$arg = new NewImageViewParameters();
					$arg->cardHeader = $arg->cardHeader . ' [' . $block->title() . ']';
					$arg->navtabs = $wbv->adminBlockFormTabs('update', $blockID, 'images');
					$arg->cardContainerDivClasses = array('container');
					$arg->imageObject = 'Block';
					$arg->imageObjectID = $blockID;
					$arg->displayDefaultRadio = true;

					return $view->newImageManager($arg);

				} else {

					return $panko->breadcrumbs() . $view->workspaceBlockForm('update', $loc[4]);

				}

			}

			// /workspace/admin/blocks/confirm-delete/<blockID>/
			if ($loc[3] == 'confirm-delete' && is_numeric($loc[4])) {
				return $panko->breadcrumbs() . $view->workspaceBlockConfirmDelete($loc[4]);
			}

			// /workspace/admin/blocks/
			$arg = new WorkspaceBlockListParameters();
			if (isset($_SESSION['workspace']['block']['filters'])) {
				foreach ($_SESSION['workspace']['block']['filters'] AS $filterKey => $filterValue) {
					if (property_exists($arg, $filterKey) && !empty($filterValue)) { $arg->$filterKey = $filterValue; }
				}
			}
			$list = new WorkspaceBlockList($arg);

			$arg->currentPage = 1;
			$arg->numberOfPages = ceil($list->resultCount()/25);
			$arg->limit = 25;
			$arg->offset = 0;

			if (is_numeric($loc[3]) && $loc[3] <= $arg->numberOfPages) {
				$currentPage = $loc[3];
				$arg->currentPage = $currentPage;
				$arg->offset = 25 * ($currentPage- 1);
			}

			return $panko->breadcrumbs() . $view->workspaceBlockList($arg);

		}

	}

}

?>