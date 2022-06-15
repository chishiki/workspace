<?php

final class WorkspaceAdminNewsViewController {

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

		if ($loc[2] == 'news') {

			$view = new WorkspaceNewsView();

			// /workspace/admin/news/create/
			if ($loc[3] == 'create') { return $view->adminNewsForm('create'); }

			// /workspace/admin/news/update/<newsID>/
			if ($loc[3] == 'update' && ctype_digit($loc[4])) { return $view->adminNewsForm('update',$loc[4]); }

			// /workspace/admin/news/confirm-delete/<newsID>/
			if ($loc[3] == 'confirm-delete' && ctype_digit($loc[4])) { return $view->adminNewsConfirmDelete($loc[4]); }

			// /workspace/admin/news/
			return $view->adminNewsList();

		}

	}

}

?>