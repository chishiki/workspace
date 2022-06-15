<?php

final class WorkspaceNewsView {

	private $loc;
	private $input;
	private $modules;
	private $errors;
	private $messages;

	public function __construct($loc = array(), $input = array(), $modules = array(), $errors = array(), $messages = array()) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages = $messages;

	}

	public function adminNewsList() {

		$arg = new WorkspaceNewsListParameter();

		$body = '

			<div class="row">
				<div class="col-12 col-sm-6 offset-sm-6 col-md-3 offset-md-9 col-lg-2 offset-lg-10">
					<a href="/' . Lang::prefix() . 'workspace/admin/news/create/" class="btn btn-block btn-outline-success">' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mt-2">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceNewsID') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('newsDate') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceNewsTitle') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->adminNewsListRows($arg) . '</tbody>
					</table>
				</div>
			</div>

	';

		$card = new CardView('workspace_admin_news_list',array('container'),'',array('col-12'),Lang::getLang('workspaceNewsList'),$body);
		return $card->card();

	}

	public function adminNewsForm($type, $newsID = null) {

		$news = new WorkspaceNews($newsID);
		$site = new Site($_SESSION['siteID']);

		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($news->$key)) { $news->$key = $value; } }
		}

		$form = '

			<form method="post" action="/' . Lang::prefix() . 'workspace/admin/news/' . $type . '/' . ($newsID?$newsID.'/':'') . '">
				
				' . ($newsID?'<input type="hidden" name="newsID" value="' . $newsID . '">':'') . '
			
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-6 col-md-4">
						<label for="newsDate">' . Lang::getLang('newsDate') . '</label>
						<div class="input-group">
							<div class="input-group-prepend"><div class="input-group-text"><span class="far fa-calendar-alt"></span></div></div>
							<input type="date" class="form-control" name="newsDate" value="' . $news->newsDate . '" required>
						</div>
					</div>

				</div>
				
				<hr />
				
				<div class="row">
				
					<div class="col-12 col-md-6">
					
						<div class="form-row">
				
							<div class="form-group col-12">
								<label for="newsTitleEnglish">' . Lang::getLang('newsTitleEnglish') . '</label>
								<input type="text" class="form-control" name="newsTitleEnglish" value="' . $news->newsTitleEnglish . '">
							</div>
							
						</div>
		
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="newsContentEnglish">' . Lang::getLang('newsContentEnglish') . '</label>
								<textarea id="workspace_admin_news_form_content_japanese" class="form-control" name="newsContentEnglish">' . $news->newsContentEnglish . '</textarea>
							</div>
		
						</div>
					
					</div>
					
					<div class="col-12 col-md-6">
					
						<div class="form-row">
				
							<div class="form-group col-12">
								<label for="newsTitleJapanese">' . Lang::getLang('newsTitleJapanese') . '</label>
								<input type="text" class="form-control" name="newsTitleJapanese" value="' . $news->newsTitleJapanese . '">
							</div>
							
						</div>
		
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="newsContentJapanese">' . Lang::getLang('newsContentJapanese') . '</label>
								<textarea id="workspace_admin_news_form_content_japanese" class="form-control" name="newsContentJapanese">' . $news->newsContentJapanese . '</textarea>
							</div>
		
						</div>
					
					</div>
				
				</div>

				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="newsURL">' . Lang::getLang('newsURL') . ' (' . Lang::getLang('alphanumericHyphenOnly') . ')</label>
						<div class="input-group">
							<div class="input-group-prepend"><div class="input-group-text"><!--http://' . $site->siteURL . '/' . Lang::prefix() . 'workspace/news-->/</div></div>
							<input type="text" class="form-control" name="newsURL" value="' . $news->newsURL . '" required>
							<div class="input-group-append"><div class="input-group-text">/</div></div>
						</div>
					</div>

				</div>
				
				<hr />

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/news/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="news-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/news/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('workspaceNews'.ucfirst($type));
		$card = new CardView('workspace_admin_news_'.$type, array('container'), '', array('col-12'), $header, $form);
		return $card->card();

	}

	public function adminNewsConfirmDelete($newsID) {

		$news = new WorkspaceNews($newsID);

		$form = '

			<form id="news_form_delete" method="post" action="/' . Lang::prefix() . 'workspace/admin/news/delete/' . $newsID . '/">
				
				<input type="hidden" name="newsID" value="' . $newsID . '">

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="newsTitleEnglish">' . Lang::getLang('newsTitleEnglish') . '</label>
						<input type="text" class="form-control" value="' . $news->newsTitleEnglish . '" disabled>
					</div>

				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="newsContentEnglish">' . Lang::getLang('newsContentEnglish') . '</label>
						<textarea class="form-control" disabled>' . $news->newsContentEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="newsTitleJapanese">' . Lang::getLang('newsTitleJapanese') . '</label>
						<input type="text" class="form-control" value="' . $news->newsTitleJapanese . '" disabled>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="newsContentJapanese">' . Lang::getLang('newsContentJapanese') . '</label>
						<textarea class="form-control" disabled>' . $news->newsContentJapanese . '</textarea>
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<button type="submit" name="news-confirm-delete" class="btn btn-block btn-outline-danger">' . Lang::getLang('delete') . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/news/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('newsConfirmDelete').' ['. $news->newsTitle() .']';
		$card = new CardView('workspace_news_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function newsList() {

		$newsList = '<div id="workspace_news_list" class="container mt-3">';
		$newsList .= '<h3 class="workspace-h">' .  Lang::getLang('workspaceRecentNews') . '</h3>';

		$hnlp = new WorkspaceNewsListParameter();
		$hnl = new WorkspaceNewsList($hnlp);
		$newsItems = $hnl->news();
		foreach ($newsItems AS $newsID) {
			$news = new WorkspaceNews($newsID);
			$newsList .= '
				<div class="news-list-item row clickable" data-url="/' . Lang::prefix() . 'workspace/news/' . $news->newsURL . '/">
					<div class="news-list-item-date col-12 col-md-3 col-lg-2">' . $news->newsDate . '</div>
					<div class="news-list-item-title col-12 col-md-9 col-lg-10">' . $news->newsTitle() . '</a></div>
				</div>
			';
		}

		$newsList .= '</div>';

		return $newsList;

	}

	public function newsView($newsID) {

		$news = new WorkspaceNews($newsID);

		$article = '
		
			<div class="news-article-view container-fluid">
				<div class="row">
					<div class="col-12">
						<h1 class="workspace-h">' . $news->newsTitle() . '</h1>
						<span class="d-block"><small>' . $news->newsDate . '</small></span>
						<p' . nl2br(htmlentities($news->newsContent()),true) . '</p>
					</div>
				</div>
			</div>
		
		';

		return $article;

	}

	private function adminNewsListRows(WorkspaceNewsListParameter $arg) {

		$newsList = new WorkspaceNewsList($arg);
		$news = $newsList->news();

		$rows = '';

		foreach ($news AS $newsID) {

			$news = new WorkspaceNews($newsID);

			$rows .= '
				<tr id="news_id_' . $newsID . '" class="news-list-row">
					<th scope="row" class="text-center">' . $newsID . '</th>
					<td class="text-center">' . $news->newsDate . '</td>
					<td class="text-left">' . $news->newsTitle() . '</td>
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'workspace/admin/news/update/' . $newsID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'workspace/admin/news/confirm-delete/' . $newsID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
					</td>
				</tr>
			';

		}

		return $rows;

	}

}

?>