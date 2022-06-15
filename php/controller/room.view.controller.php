<?php

final class WorkspaceRoomViewController {

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

		if ($loc[1] == 'rooms') {

			$view = new WorkspaceRoomView($loc, $input);

			if (!empty($loc[2])) {
				$roomURL = $loc[2];
				$roomID = WorkspaceRoomUtilities::getRoomWithURL($roomURL);
				if ($roomID) {
					return $view->roomView($roomID);
				}
			}

			$arg = new WorkspaceRoomListParameters();
			$arg->title = array('langKey' => 'workspaceRoomCatalog', 'langSelector' => 'en');
			$arg->roomPublished = true;
			$arg->descriptionConcat = 77; // if English do we make this longer...?
			return $view->roomList($arg);

		}

	}

}

?>