<?php

/*

CREATE TABLE `workspace_Block` (
    `blockID` int NOT NULL AUTO_INCREMENT,
    `siteID` int NOT NULL,
    `creator` int NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime DEFAULT NULL,
    `deleted` int NOT NULL,
    `blockTitleEnglish` varchar(100) NOT NULL,
    `blockTextEnglish` text NOT NULL,
    `blockLinkUrlEnglish` varchar(255) NOT NULL,
    `blockTitleJapanese` varchar(100) NOT NULL,
    `blockTextJapanese` text NOT NULL,
    `blockLinkUrlJapanese` varchar(255) NOT NULL,
    `blockPublished` int NOT NULL,
    `blockDisplayOrder` int NOT NULL,
    PRIMARY KEY (`blockID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/

final class WorkspaceBlockView {

	private array $loc;
	private array $input;
	private array $modules;
	private array $errors;
	private array $messages;

	public function __construct(array $loc = array(), array $input = array(), array $modules = array(), array $errors = array(), array $messages = array()) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;
		$this->errors = $errors;
		$this->messages = $messages;

	}

	public function workspaceBlockForm($type, $blockID = null) {

		$hidden = '';
		if ($type == 'update' && $blockID) {
			$hidden .= '<input type="hidden" name="blockID" value="' . $blockID . '">';
		}

		$block = new Block($blockID);
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($block->$key)) { $block->$key = $value; } }
		}

		$form = '

			<form id="block_' . $type . '_form" method="post" action="/' . Lang::prefix() . 'workspace/admin/blocks/' . $type . '/'  . ($blockID?$blockID.'/':'') . '">

			' . $hidden . '

			<div class="form-row">

				<div class="form-group col-12 col-lg-5 col-xl-4">
					<label for="block_title_english">' . Lang::getLang('blockTitleEnglish') . '</label>
					<input type="text" id="block_title_english" class="form-control" name="blockTitleEnglish" value="' . $block->blockTitleEnglish . '">
				</div>

				<div class="form-group col-12 col-lg-7 col-xl-8">
					<label for="block_link_url_english">' . Lang::getLang('blockLinkUrlEnglish') . '</label>
					<input type="text" id="block_link_url_english" class="form-control" name="blockLinkUrlEnglish" value="' . $block->blockLinkUrlEnglish . '">
				</div>

				<div class="form-group col-12">
					<label for="block_text_english">' . Lang::getLang('blockTextEnglish') . '</label>
					<textarea id="block_text_english" class="form-control" name="blockTextEnglish">' . $block->blockTextEnglish . '</textarea>
				</div>

			</div>
			
			<hr />
			
			<div class="form-row">

				<div class="form-group col-12 col-lg-5 col-xl-4">
					<label for="block_title_japanese">' . Lang::getLang('blockTitleJapanese') . '</label>
					<input type="text" id="block_title_japanese" class="form-control" name="blockTitleJapanese" value="' . $block->blockTitleJapanese . '">
				</div>

				<div class="form-group col-12 col-lg-7 col-xl-8">
					<label for="block_link_url_japanese">' . Lang::getLang('blockLinkUrlJapanese') . '</label>
					<input type="text" id="block_link_url_japanese" class="form-control" name="blockLinkUrlJapanese" value="' . $block->blockLinkUrlJapanese . '">
				</div>

				<div class="form-group col-12">
					<label for="block_text_japanese">' . Lang::getLang('blockTextJapanese') . '</label>
					<textarea id="block_text_japanese" class="form-control" name="blockTextJapanese">' . $block->blockTextJapanese . '</textarea>
				</div>

			</div>
			
			<hr />

			<div class="form-row">

				<div class="form-group col-12 col-sm-4 col-lg-3">
					<a href="/' . Lang::prefix() . 'workspace/admin/blocks/" class="btn btn-block btn-outline-secondary" role="button">
						<span class="fas fa-arrow-left"></span>
						' . Lang::getLang('returnToList') . '
					</a>
				</div>

				<div class="form-group col-12 col-sm-4 col-lg-3 offset-lg-3">
					<button type="submit" name="workspace-block-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">
						<span class="far fa-save"></span>
						' . Lang::getLang($type) . '
					</button>
				</div>

				<div class="form-group col-12 col-sm-4 col-lg-3">
					<a href="/' . Lang::prefix() . 'workspace/admin/blocks/" class="btn btn-block btn-outline-secondary" role="button">
						<span class="fas fa-times"></span>
						' . Lang::getLang('cancel') . '
					</a>
				</div>

			</div>

			</form>

		';

		$card = new CardView('workspace_block_form',array('container-fluid'),'',array('col-12'),Lang::getLang('workspaceBlock' . ucfirst($type)), $form);
		return $card->card();

	}

	public function workspaceBlockConfirmDelete($blockID) {

		$block = new Block($blockID);
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($block->$key)) { $block->$key = $value; } }
		}

		$form = '

			<form id="block_confirm_delete_form" method="post" action="/' . Lang::prefix() . 'workspace/admin/blocks/delete/'.$blockID.'/">

			<input type="hidden" name="blockID" value="' . $blockID . '">

			<div class="form-row">

				<div class="form-group col-12 col-lg-5 col-xl-4">
					<label for="block_title_english">' . Lang::getLang('blockTitleEnglish') . '</label>
					<input type="text" id="block_title_english" class="form-control" value="' . $block->blockTitleEnglish . '" readonly>
				</div>

				<div class="form-group col-12 col-lg-7 col-xl-8">
					<label for="block_link_url_english">' . Lang::getLang('blockLinkUrlEnglish') . '</label>
					<input type="text" id="block_link_url_english" class="form-control" value="' . $block->blockLinkUrlEnglish . '" readonly>
				</div>

				<div class="form-group col-12">
					<label for="block_text_english">' . Lang::getLang('blockTextEnglish') . '</label>
					<textarea id="block_text_english" class="form-control" readonly>' . $block->blockTextEnglish . '</textarea>
				</div>

			</div>
			
			<hr />
			
			<div class="form-row">

				<div class="form-group col-12 col-lg-5 col-xl-4">
					<label for="block_title_japanese">' . Lang::getLang('blockTitleJapanese') . '</label>
					<input type="text" id="block_title_japanese" class="form-control" value="' . $block->blockTitleJapanese . '" readonly>
				</div>

				<div class="form-group col-12 col-lg-7 col-xl-8">
					<label for="block_link_url_japanese">' . Lang::getLang('blockLinkUrlJapanese') . '</label>
					<input type="text" id="block_link_url_japanese" class="form-control" value="' . $block->blockLinkUrlJapanese . '" readonly>
				</div>

				<div class="form-group col-12">
					<label for="block_text_japanese">' . Lang::getLang('blockTextJapanese') . '</label>
					<textarea id="block_text_japanese" class="form-control" readonly>' . $block->blockTextJapanese . '</textarea>
				</div>

			</div>

			<div class="form-row">

				<div class="form-group col-12 col-sm-4 col-lg-3">
					<a href="/' . Lang::prefix() . 'workspace/admin/blocks/" class="btn btn-block btn-outline-secondary" role="button">
						<span class="fas fa-arrow-left"></span>
						' . Lang::getLang('returnToList') . '
					</a>
				</div>

				<div class="form-group col-12 col-sm-4 col-lg-3 offset-lg-3">
					<button type="submit" name="workspace-block-delete" class="btn btn-block btn-outline-danger">
						<span class="far fa-trash-alt"></span>
						' . Lang::getLang('delete') . '
					</button>
				</div>

				<div class="form-group col-12 col-sm-4 col-lg-3">
					<a href="/' . Lang::prefix() . 'workspace/admin/blocks/" class="btn btn-block btn-outline-secondary" role="button">
						<span class="fas fa-times"></span>
						' . Lang::getLang('cancel') . '
					</a>
				</div>

			</div>

			</form>

		';

		$card = new CardView('workspace_block_confirm_delete_form',array('container-fluid'),'',array('col-12'),Lang::getLang('workspaceBlockConfirmDelete'), $form);
		return $card->card();

	}

	public function workspaceBlockList(WorkspaceBlockListParameters $arg) {

		$list = '

			<div class="row mb-3">
				<div class="col-12 col-md-8 col-lg-10">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'workspace/admin/blocks/') . '
				</div>
				<div class="col-12 col-md-4 col-lg-2">
					<a href="/' . Lang::prefix() . 'workspace/admin/blocks/create/" class="btn btn-block btn-outline-success btn-sm"><span class="fas fa-plus"></span> ' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mb-3">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-sm">
						<thead class"thead-light">
							<tr>
								<th scope="col" class="text-center text-nowrap">' . Lang::getLang('blockID') . '</th>
								<th scope="col" class="text-center text-nowrap">' . Lang::getLang('blockTitle') . '</th>
								<!--<th scope="col" class="text-center text-nowrap">' . Lang::getLang('blockText') . '</th>-->
								<!--<th scope="col" class="text-center text-nowrap">' . Lang::getLang('blockLinkURL') . '</th>-->
								<th scope="col" class="text-center text-nowrap">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->workspaceBlockListRows($arg) . '</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col-12 col-md-8 col-lg-10">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'workspace/admin/blocks/') . '
				</div>
			</div>

		';

		$card = new CardView('workspace_block_list',array('container-fluid'),'',array('col-12'),Lang::getLang('workspaceBlockList'), $list);
		return $card->card();

	}

	public function workspaceBlockListRows(WorkspaceBlockListParameters $arg) {

		$list = new WorkspaceBlockList($arg);
		$results = $list->results();

		$rows = '';

		foreach ($results AS $r) {

			$b = new Block($r['blockID']);

			$rows .= '

				<tr id="workspace_block_key_' . $r['blockID'] . '" class="workspace-block-list-row" data-row-block-id="' . $r['blockID'] . '">
					<th scope="row" class="text-center workspace-block-list-cell" data-cell-block-id="' . $r['blockID'] . '">' . $r['blockID'] . '</th>
					<td class="text-center workspace-block-list-cell" data-cell-block-title="' . $b->title() . '">' . $b->title() . '</td>
					<!--<td class="text-center workspace-block-list-cell" data-cell-block-text="' . $b->text() . '">' . $b->text() . '</td>-->
					<!--<td class="text-center workspace-block-list-cell" data-cell-block-link-url="' . $b->url() . '">' . $b->url() . '</td>-->
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'workspace/admin/blocks/update/' . $r['blockID'] . '/" class="btn btn-sm btn-outline-primary">
							<span class="far fa-edit"></span>
							' . Lang::getLang('update') . '
						</a>
						<a href="/' . Lang::prefix() . 'workspace/admin/blocks/confirm-delete/' . $r['blockID'] . '/" class="btn btn-sm btn-outline-danger">
							<span class="far fa-trash-alt"></span>
							' . Lang::getLang('delete') . '
						</a>
					</td>
				</tr>

			';

		}

		return $rows;

	}

	public function workspaceBlockContainer() : string {

		$arg = new WorkspaceBlockListParameters();
		$blockList = new WorkspaceBlockList($arg);
		$blocks = $blockList->results();

		$h = '';

		if (!empty($blocks)) {

			$blockItems = '';

			foreach ($blocks AS $block) {

				$b = new Block($block['blockID']);

				$blockItems .= '
					<div class="col-12 col-sm-6 col-lg-3 mt-3">
						<div class="card">
							<img src="/image/27/600/" class="card-img-top">
							<div class="card-body">
								<h3 class="card-title">' . $b->title() . '</h3>
								<p class="card-text">' . $b->text() . '</p>
							</div>
						</div>
					</div>
				';

			}

			$h = '
				<div id="workspace_block_container" class="container-fluid">
					<div class="row">
						' . $blockItems . '
					</div>
				</div>
			';

		}

		return $h;

	}

	public function workspaceBlockFilter($filterKey, $selectedFilter = null) {

		$arg = new WorkspaceBlockListParameters();
		$arg->resultSet = array();
		$arg->resultSet[] = array('field' => 'DISTINCT(workspace_Block.'.$filterKey.')', 'alias' => $filterKey);
		$arg->orderBy = array();
		$arg->orderBy[] = array('field' => 'workspace_Block.'.$filterKey, 'sort' => 'ASC');
		$valueList = new WorkspaceBlockList($arg);
		$values = $valueList->results();

		$filter = '<select name="filters[' . $filterKey . ']" class="form-control">';
		$filter .= '<option value="">' . Lang::getLang($filterKey) . '</option>';
		foreach ($values AS $value) {
			$filter .= '<option value="' . $value[$filterKey] . '"' . ($value[$filterKey]==$selectedFilter?' selected':'') . '>' . $value[$filterKey] . '</option>';
		}
		$filter .= '</select>';

		return $filter;

	}

}

?>