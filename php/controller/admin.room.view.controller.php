<?php

final class WorkspaceAdminRoomViewController {

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

		if ($loc[2] == 'rooms') {

			$view = new WorkspaceRoomView($loc, $input);

			// /workspace/admin/rooms/create/
			if ($loc[3] == 'create') { return $view->adminRoomForm('create'); }

			// /workspace/admin/rooms/update/<roomID>/
			if ($loc[3] == 'update' && ctype_digit($loc[4])) {

				$roomID = $loc[4];

				if ($loc[5] == 'features') {
					$view = new WorkspaceRoomFeatureView($loc, $input);
					return $view->adminRoomFeatureForm($roomID);
				}

				if ($loc[5] == 'specifications') {
					$view = new WorkspaceRoomSpecificationView($loc, $input);
					return $view->adminRoomSpecificationForm($roomID);
				}

				if ($loc[5] == 'images') {

					$view = new ImageView($loc, $input, $errors);
					$room = new WorkspaceRoom($roomID);
					$hpv = new WorkspaceRoomView();

					$arg = new NewImageViewParameters();
					$arg->cardHeader = $arg->cardHeader . ' [' . $room->roomName() . ']';
					$arg->navtabs = $hpv->adminRoomFormTabs('update', $roomID, 'images');
					$arg->cardContainerDivClasses = array('container');
					$arg->imageObject = 'WorkspaceRoom';
					$arg->imageObjectID = $roomID;
					$arg->displayDefaultRadio = true;

					return $view->newImageManager($arg);

				}

				if ($loc[5] == 'files') {

					$view = new FileView($loc, $input, $errors);
					$room = new WorkspaceRoom($roomID);
					$hpv = new WorkspaceRoomView();

					$arg = new NewFileViewParameters();
					$arg->cardHeader = $arg->cardHeader . ' [' . $room->roomName() . ']';
					$arg->navtabs = $hpv->adminRoomFormTabs('update', $roomID, 'files');
					$arg->cardContainerDivClasses = array('container');
					$arg->fileObject = 'WorkspaceRoom';
					$arg->fileObjectID = $roomID;

					return $view->newFileManager($arg);

				}

				return $view->adminRoomForm('update',$roomID);

			}

			// /workspace/admin/rooms/confirm-delete/<roomID>/
			if ($loc[3] == 'confirm-delete' && ctype_digit($loc[4])) {
				return $view->adminRoomConfirmDelete($loc[4]);
			}

			// /workspace/admin/rooms/
			$arg = new WorkspaceRoomListParameters();
			$arg->roomPublished = null;
			$arg->descriptionConcat = 77;
			$arg->orderBy = array('roomNameEnglish' => 'ASC');
			$hpl = new WorkspaceRoomList($arg);

			$arg->currentPage = 1;
			$arg->numberOfPages = ceil($hpl->roomCount()/25);
			$arg->limit = 25;
			$arg->offset = 0;

			if (is_numeric($loc[3])) {
				$currentPage = $loc[3];
				$arg->currentPage = $currentPage;
				$arg->offset = 25 * ($currentPage- 1);
			}

			return $view->adminRoomList($arg);

		}

	}

}

?>