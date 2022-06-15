<?php

final class WorkspaceNewsViewController {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc, $input, $modules, $errors, $messages) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages =  $messages;

	}

	public function getView() {

		$loc = $this->loc;
		$input = $this->input;
		$errors = $this->errors;

		if ($loc[1] == 'news') {

			$view = new WorkspaceNewsView();

			if (!empty($loc[2])) {
				$newsID = WorkspaceNewsUtilities::getNewsWithURL($loc[2]);
				if ($newsID) {
					return $view->newsView($newsID);
				}
			}

			return $view->newsList();

		}

	}

}

?>