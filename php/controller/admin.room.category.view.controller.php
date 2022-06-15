<?php

final class WorkspaceAdminRoomCategoryViewController {

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

		if ($loc[2] == 'room-categories') {

			$view = new WorkspaceRoomCategoryView();

			// /workspace/admin/room-categories/create/
			if ($loc[3] == 'create') { return $view->adminRoomCategoryForm('create'); }

			// /workspace/admin/room-categories/update/<roomCategoryID>/
			if ($loc[3] == 'update' && ctype_digit($loc[4])) { return $view->adminRoomCategoryForm('update',$loc[4]); }

			// /workspace/admin/room-categories/confirm-delete/<roomCategoryID>/
			if ($loc[3] == 'confirm-delete' && ctype_digit($loc[4])) { return $view->adminRoomCategoryConfirmDelete($loc[4]); }

			// /workspace/admin/room-categories/
			return $view->adminRoomCategoryList();

		}

	}

}

?>