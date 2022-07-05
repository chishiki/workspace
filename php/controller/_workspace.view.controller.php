<?php

final class WorkspaceViewController {

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
		$this->messages = $messages;

	}

	public function getView() {

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;
		$errors = $this->errors;
		$messages = $this->messages;

		if ($loc[0] == 'workspace') {
			if ($loc[1] == 'admin') {
				if ($loc[2] == 'blocks') { $v = new WorkspaceAdminBlockViewController($loc, $input, $modules, $errors, $messages); }
				if ($loc[2] == 'news') { $v = new WorkspaceAdminNewsViewController($loc, $input, $modules, $errors, $messages); }
				if ($loc[2] == 'rooms') { $v = new WorkspaceAdminRoomViewController($loc, $input, $modules, $errors, $messages); }
				if ($loc[2] == 'room-categories') { $v = new WorkspaceAdminRoomCategoryViewController($loc, $input, $modules, $errors, $messages); }
			}
			if ($loc[1] == 'news') {
				$v = new WorkspaceNewsViewController($loc, $input, $modules, $errors, $messages);
			}
			if ($loc[1] == 'rooms') {
				$v = new WorkspaceRoomViewController($loc, $input, $modules, $errors, $messages);
			}
		}

		if (isset($v)) {
			return $v->getView();
		} else {
			$url = '/' . Lang::prefix();
			header("Location: $url" );
		}

	}

}

?>