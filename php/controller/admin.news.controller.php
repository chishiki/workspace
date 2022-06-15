<?php

final class WorkspaceAdminNewsController {

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

		// let's only allow logged in users to view news pages
		if (!Auth::isLoggedIn()) {
			$loginURL = '/' . Lang::prefix() . 'login/';
			header("Location: $loginURL");
		}

	}

	public function setState() {

		$loc = $this->loc;
		$input = $this->input;

		if ($loc[2] == 'news') {

			// /workspace/admin/news/create/
			if ($loc[3] == 'create' && isset($input['news-create'])) {


				$this->validateNewsURL($input['newsURL'], 'create');

				if (empty($this->errors)) {

					$news = new WorkspaceNews();
					foreach ($input AS $property => $value) { if (isset($news->$property)) { $news->$property = $value; } }
					WorkspaceNews::insert($news, false, 'workspace_');
					$successURL = '/' . Lang::prefix() . 'workspace/admin/news/';
					header("Location: $successURL");

				}

			}

			// /workspace/admin/news/update/<newsID>/
			if ($loc[3] == 'update' && ctype_digit($loc[4]) && isset($input['news-update'])) {

				$newsID = $loc[4];

				$this->validateNewsURL($input['newsURL'], 'update', $newsID);

				if (empty($this->errors)) {

					$news = new WorkspaceNews($newsID);
					$news->updated = date('Y-m-d H:i:s');
					foreach ($input AS $property => $value) { if (isset($news->$property)) { $news->$property = $value; } }
					$conditions = array('newsID' => $newsID);
					WorkspaceNews::update($news, $conditions, true, false, 'workspace_');
					$this->messages[] = Lang::getLang('newsUpdateSuccessful');

				}

			}

			// /workspace/admin/news/delete/<newsID>/
			if ($loc[3] == 'delete' && ctype_digit($loc[4]) && isset($input['news-delete'])) {

				$newsID = $loc[4];

				if ($input['newsID'] != $newsID) {
					$this->errors[] = array('news-delete' => Lang::getLang('thereWasAProblemDeletingYourWorkspaceNews'));
				}

				if (empty($this->errors)) {

					$news = new WorkspaceNews($newsID);
					$news->markAsDeleted();
					$this->messages[] = Lang::getLang('newsDeleteSuccessful');

				}

			}

		}

	}

	private function validateNewsURL($newsURL, $type, $newsID = null) {

		if (empty($newsURL)) {
			$this->errors[] = array('newsURL' => Lang::getLang('newsUrlMustBeSet'));
		} else {
			if (WorkspaceNewsUtilities::newsUrlExists($newsURL)) {
				if ($type == 'update' && ctype_digit($newsID)) {
					$news = new WorkspaceNews($newsID);
					if ($news->newsURL != $newsURL) {
						$this->errors[] = array('newsURL' => Lang::getLang('newsUrlAlreadyUsedByAnotherNewsItem'));
					}
				} else {
					$this->errors[] = array('newsURL' => Lang::getLang('newsUrlAlreadyExists'));
				}
			}
			if (!preg_match('/^[A-Za-z0-9-]+$/D', $newsURL)) {
				$this->errors[] = array('newsURL' => Lang::getLang('onlyAlphanumericAndHyphenInputAreAllowedInTheUrlField'));
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