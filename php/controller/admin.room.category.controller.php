<?php

final class WorkspaceAdminRoomCategoryController {

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

		// let's only allow logged in users to view room pages
		if (!Auth::isLoggedIn()) {
			$loginURL = '/' . Lang::prefix() . 'login/';
			header("Location: $loginURL");
		}

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;

		if ($loc[2] == 'room-categories') {

			// /workspace/admin/room-categories/create/
			if ($loc[3] == 'create' && isset($input['room-category-create'])) {

				// $this->errors (add validation here: ok to create?)
				// $this->errors[] = array('room-category-create' => Lang::getLang('thereWasAProblemCreatingYourWorkspaceRoomCategory'));

				if (empty($this->errors)) {

					$category = new WorkspaceRoomCategory();
					foreach ($input AS $property => $value) { if (isset($category->$property)) { $category->$property = $value; } }
					WorkspaceRoom::insert($category, false, 'workspace_');
					$successURL = '/' . Lang::prefix() . 'workspace/admin/room-categories/';
					header("Location: $successURL");

				}

			}

			// /workspace/admin/room-categories/update/<roomID>/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && isset($input['room-category-update'])) {

				$roomCategoryID = $loc[4];

				// $this->errors (add validation here: ok to update?)
				// $this->errors[] = array('room-category-update' => Lang::getLang('thereWasAProblemUpdatingYourWorkspaceRoomCategory'));

				if (empty($this->errors)) {

					$category = new WorkspaceRoomCategory($roomCategoryID);
					$category->updated = date('Y-m-d H:i:s');
					foreach ($input AS $property => $value) { if (isset($category->$property)) { $category->$property = $value; } }
					$conditions = array('roomCategoryID' => $roomCategoryID);
					WorkspaceRoom::update($category, $conditions, true, false, 'workspace_');
					$this->messages[] = Lang::getLang('roomCategoryUpdateSuccessful');

				}

			}

			// /workspace/admin/room-categories/delete/<roomID>/
			if ($loc[3] == 'delete' && ctype_digit($loc[4]) && isset($input['room-category-delete'])) {

				$roomCategoryID = $loc[4];

				if ($input['roomCategoryID'] != $roomCategoryID) {
					$this->errors[] = array('room-category-delete' => Lang::getLang('thereWasAProblemDeletingYourWorkspaceRoomCategory'));
				}

				if (empty($this->errors)) {

					$category = new WorkspaceRoomCategory($roomCategoryID);
					$category->markAsDeleted();
					$this->messages[] = Lang::getLang('roomCategoryDeleteSuccessful');

				}

			}

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