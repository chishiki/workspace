<?php

final class WorkspaceRoomCategoryView {

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

	public function adminRoomCategoryList() {

		$body = '

			<div class="row">
				<div class="col-12 col-sm-6 offset-sm-6 col-md-3 offset-md-9 col-lg-2 offset-lg-10">
					<a href="/' . Lang::prefix() . 'workspace/admin/room-categories/create/" class="btn btn-block btn-outline-success">' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mt-2">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceRoomCategoryID') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceRoomCategoryName') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->adminRoomCategoryListRows() . '</tbody>
					</table>
				</div>
			</div>

	';

		$card = new CardView('workspace_room_category_list',array('container'),'',array('col-12'),Lang::getLang('workspaceRoomCategoryList'),$body);
		return $card->card();

	}

	public function adminRoomCategoryForm($type, $roomCategoryID = null) {

		$category = new WorkspaceRoomCategory($roomCategoryID);
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($category->$key)) { $category->$key = $value; } }
		}

		$form = '

			<form id="room_category_form_' . $type . '" method="post" action="/' . Lang::prefix() . 'workspace/admin/room-categories/' . $type . '/' . ($roomCategoryID?$roomCategoryID.'/':'') . '">
				
				' . ($roomCategoryID?'<input type="hidden" name="roomCategoryID" value="' . $roomCategoryID . '">':'') . '

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomCategoryNameEnglish">' . Lang::getLang('roomCategoryNameEnglish') . '</label>
						<input type="text" class="form-control" name="roomCategoryNameEnglish" value="' . $category->roomCategoryNameEnglish . '">
					</div>
					
				</div>

				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomCategoryDescriptionEnglish">' . Lang::getLang('roomCategoryDescriptionEnglish') . '</label>
						<textarea class="form-control" name="roomCategoryDescriptionEnglish">' . $category->roomCategoryDescriptionEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomCategoryNameJapanese">' . Lang::getLang('roomCategoryNameJapanese') . '</label>
						<input type="text" class="form-control" name="roomCategoryNameJapanese" value="' . $category->roomCategoryNameJapanese . '">
					</div>
					
				</div>

				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomCategoryDescriptionJapanese">' . Lang::getLang('roomCategoryDescriptionJapanese') . '</label>
						<textarea class="form-control" name="roomCategoryDescriptionJapanese">' . $category->roomCategoryDescriptionJapanese . '</textarea>
					</div>

				</div>
				
				<hr />

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/room-categories/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="room-category-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/room-categories/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('workspaceRoomCategory'.ucfirst($type)).($type=='update'?' ['.$category->roomCategoryName().']':'');
		$card = new CardView('workspace_room_category_confirm_'.$type,array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function adminRoomCategoryConfirmDelete($roomCategoryID) {

		$category = new WorkspaceRoomCategory($roomCategoryID);

		$form = '

			<form id="room_form_delete" method="post" action="/' . Lang::prefix() . 'workspace/admin/room-categories/delete/' . $roomCategoryID . '/">
				
				<input type="hidden" name="roomCategoryID" value="' . $roomCategoryID . '">

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomCategoryNameEnglish">' . Lang::getLang('roomCategoryNameEnglish') . '</label>
						<input type="text" class="form-control" value="' . $category->roomCategoryNameEnglish . '" disabled>
					</div>

				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomCategoryDescriptionEnglish">' . Lang::getLang('roomCategoryDescriptionEnglish') . '</label>
						<textarea class="form-control" disabled>' . $category->roomCategoryDescriptionEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomCategoryNameJapanese">' . Lang::getLang('roomCategoryNameJapanese') . '</label>
						<input type="text" class="form-control" value="' . $category->roomCategoryNameJapanese . '" disabled>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomCategoryDescriptionJapanese">' . Lang::getLang('roomCategoryDescriptionJapanese') . '</label>
						<textarea class="form-control" disabled>' . $category->roomCategoryDescriptionJapanese . '</textarea>
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<button type="submit" name="room-category-confirm-delete" class="btn btn-block btn-outline-danger">' . Lang::getLang('delete') . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/room-categories/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('roomCategoryConfirmDelete').' ['. $category->roomCategoryName() .']';
		$card = new CardView('workspace_room_category_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	private function adminRoomCategoryListRows() {

		$hpcl = new WorkspaceRoomCategoryList();
		$categories = $hpcl->roomCategories();

		$rows = '';

		foreach ($categories AS $roomCategoryID) {

			$category = new WorkspaceRoomCategory($roomCategoryID);

			$rows .= '
				<tr id="room_category_id_' . $roomCategoryID . '" class="room-category-list-row">
					<th scope="row" class="text-center">' . $roomCategoryID . '</th>
					<td class="text-left">' . $category->roomCategoryName() . '</td>
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'workspace/admin/room-categories/update/' . $roomCategoryID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'workspace/admin/room-categories/confirm-delete/' . $roomCategoryID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
					</td>
				</tr>
			';

		}

		return $rows;

	}

	public function roomCategoryDropdown($name = 'roomCategoryID', $selectedRoomCategoryID = null, $required = true, $disabled = false, $size = null) {

		$hpcl = new WorkspaceRoomCategoryList();
		$categories = $hpcl->roomCategories();

		$d = '<select class="form-control' . ($size?' form-control-'.$size:'') . '" name="' . $name . '"' . ($disabled?' disabled':'') . '>';
		if (!$required) { $d .= '<option value="0">----</option>'; }
		foreach ($categories AS $thisRoomCategoryID) {
			$category = new WorkspaceRoomCategory($thisRoomCategoryID);
			$d .= '<option value="' . $thisRoomCategoryID . '"' . ($thisRoomCategoryID==$selectedRoomCategoryID?' selected':'') . '>' . $category->roomCategoryName() . '</option>';
		}
		$d .= '</select>';

		return $d;

	}

}

?>