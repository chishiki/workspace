<?php

final class WorkspaceController {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc, $input, $modules) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = array();
		$this->messages =  array();

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;
		$modules = $this->modules;

		if ($loc[0] == 'workspace') {
			if ($loc[1] == 'admin') {

				if (!Auth::isLoggedIn()) {
					$loginURL = '/' . Lang::prefix() . 'login/';
					header("Location: $loginURL");
				}

				if ($loc[2] == 'news') { $controller = new WorkspaceAdminNewsController($loc,$input,$modules); }
				if ($loc[2] == 'rooms') { $controller = new WorkspaceAdminRoomController($loc,$input,$modules); }
				if ($loc[2] == 'room-categories') { $controller = new WorkspaceAdminRoomCategoryController($loc,$input,$modules); }
			}
		}

		if (isset($controller)) {
			$controller->setState();
			$this->errors = $controller->getErrors();
			$this->messages = $controller->getMessages();
		}

	}

	public function getErrors() {
		return $this->errors;
	}

	public function getMessages() {
		return $this->messages;
	}

}

?>