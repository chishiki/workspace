<?php

final class WorkspaceAdminRoomController {

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

		if ($loc[2] == 'rooms') {

			// /workspace/admin/rooms/create/
			if ($loc[3] == 'create' && isset($input['room-create'])) {

				// $this->errors (add validation here: ok to create?)
				// $this->errors[] = array('room-create' => Lang::getLang('thereWasAProblemCreatingYourWorkspaceRoom'));

				if (empty($this->errors)) {

					$room = new WorkspaceRoom();
					foreach ($input AS $property => $value) { if (isset($room->$property)) { $room->$property = $value; } }
					WorkspaceRoom::insert($room, false, 'workspace_');
					$successURL = '/' . Lang::prefix() . 'workspace/admin/rooms/';
					header("Location: $successURL");

				}

			}

			// /workspace/admin/rooms/update/<roomID>/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && isset($input['room-update'])) {

				$roomID = $loc[4];

				// $this->errors (add validation here: ok to update?)
				// $this->errors[] = array('room-update' => Lang::getLang('thereWasAProblemUpdatingYourWorkspaceRoom'));

				if (empty($this->errors)) {

					$room = new WorkspaceRoom($roomID);
					$room->updated = date('Y-m-d H:i:s');
					foreach ($input AS $property => $value) { if (isset($room->$property)) { $room->$property = $value; } }
					if (!isset($input['roomPublished'])) { $room->roomPublished = 0; }
					if (!isset($input['roomFeatured'])) { $room->roomFeatured = 0; }
					$conditions = array('roomID' => $roomID);
					WorkspaceRoom::update($room, $conditions, true, false, 'workspace_');
					$this->messages[] = Lang::getLang('roomUpdateSuccessful');

				}

			}

			// /workspace/admin/rooms/update/<roomID>/features/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && $loc[5] == 'features' && isset($input['add-room-feature'])) {

				$roomID = $loc[4];

				// $this->errors (add validation here: ok to update?)
				// $this->errors[] = array('room-update' => Lang::getLang('thereWasAProblemUpdatingYourWorkspaceRoomFeature'));

				if (empty($this->errors)) {

					$feature = new WorkspaceRoomFeature();
					$feature->roomID = $roomID;
					$feature->roomFeaturePublished = 1;
					$feature->roomFeatureDisplayOrder = 1;
					foreach ($input AS $property => $value) { if (isset($feature->$property)) { $feature->$property = $value; } }
					WorkspaceRoomFeature::insert($feature, false, 'workspace_');

				}

			}

			// /workspace/admin/rooms/update/<roomID>/specifications/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && $loc[5] == 'specifications' && isset($input['add-room-specification'])) {

				$roomID = $loc[4];

				// $this->errors (add validation here: ok to update?)
				// $this->errors[] = array('room-update' => Lang::getLang('thereWasAProblemUpdatingYourWorkspaceRoomSpecification'));

				if (empty($this->errors)) {

					$specification = new WorkspaceRoomSpecification();
					$specification->roomID = $roomID;
					$specification->roomSpecificationPublished = 1;
					$specification->roomSpecificationDisplayOrder = 1;
					foreach ($input AS $property => $value) { if (isset($specification->$property)) { $specification->$property = $value; } }
					WorkspaceRoomSpecification::insert($specification, false, 'workspace_');

				}

			}

			// /workspace/admin/rooms/update/<roomID>/images/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && $loc[5] == 'images' && isset($input['submitted-images'])) {

				$roomID = $loc[4];
				// $this->errors (add validation here: ok to upload?)
				// $this->errors[] = array('room-update' => Lang::getLang('thereWasAProblemAddingYourWorkspaceRoomImages'));
				Image::uploadImages($_FILES['images-to-upload'], 'WorkspaceRoom', $roomID, false);

			}

			// /workspace/admin/rooms/update/<roomID>/files/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && $loc[5] == 'files' && isset($input['submitted-files'])) {

				$roomID = $loc[4];
				// $this->errors (add validation here: ok to upload?)
				// $this->errors[] = array('room-update' => Lang::getLang('thereWasAProblemAddingYourWorkspaceRoomFiles'));
				File::uploadFiles($_FILES['files-to-upload'], 'WorkspaceRoom', $roomID, $input['fileTitleEnglish'], $input['fileTitleJapanese']);

			}

			// /workspace/admin/rooms/delete/<roomID>/
			if ($loc[3] == 'delete' && ctype_digit($loc[4]) && isset($input['room-delete'])) {

				$roomID = $loc[4];

				if ($input['roomID'] != $roomID) {
					$this->errors[] = array('room-delete' => Lang::getLang('thereWasAProblemDeletingYourWorkspaceRoom'));
				}

				if (empty($this->errors)) {

					$room = new WorkspaceRoom($roomID);
					$room->markAsDeleted();
					$this->messages[] = Lang::getLang('roomDeleteSuccessful');

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