<?php

final class WorkspaceRoomSpecificationView {

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

	public function adminRoomSpecificationForm($roomID) {

		$room = new WorkspaceRoom($roomID);
		$newSpecification = new WorkspaceRoomSpecification();

		$hpv = new WorkspaceRoomView();
		$form = $hpv->adminRoomFormTabs('update', $roomID, 'specifications');

		$hpfl = new WorkspaceRoomSpecificationList($roomID);
		$specifications = $hpfl->specifications();
		if (!empty($specifications)) {
			$form .= '<ul id="admin_room_specification_list" class="list-group">';
			foreach ($specifications as $roomSpecificationID) {
				$specification = new WorkspaceRoomSpecification($roomSpecificationID);
				$form .= '
					<li class="list-group-item admin-room-specification-list-item d-flex justify-content-between align-items-center" data-room-specification-id="' . $roomSpecificationID . '">
						<span class="drag-handle btn btn-outline-secondary mr-3"><span class="fas fa-grip-lines"></span></span>
						<span class="flex-grow-1 d-block">
								<span class="admin-room-specification-name d-block">' . $specification->roomSpecificationName() . '</span>
								<span class="admin-room-specification-description d-none d-md-block"><small>' . $specification->roomSpecificationDescription() . '</small></span>
						</span>
						<button type="button" class="btn btn-danger delete-room-specification ml-3"><span class="far fa-trash-alt"></span></button>
					</li>';
			}
			$form .= '</ul>';
			$form .= '<hr />';
		}

		$form .= '

			<form id="workspace_room_specification_manager_form" method="post" action="/' . Lang::prefix() . 'workspace/admin/rooms/update/' . $roomID . '/specifications/">

				<div class="form-row">
				
					<div class="form-group col-12 col-lg-4 col-xl-3">
						<label for="roomSpecificationNameEnglish">' . Lang::getLang('roomSpecificationNameEnglish') . '</label>
						<input type="text" class="form-control" name="roomSpecificationNameEnglish" value="' . $newSpecification->roomSpecificationNameEnglish . '"">
					</div>

					<div class="form-group col-12 col-lg-8 col-xl-9">
						<label for="roomSpecificationDescriptionEnglish">' . Lang::getLang('roomSpecificationDescriptionEnglish') . '</label>
						<input type="text" class="form-control" name="roomSpecificationDescriptionEnglish" value="' . $newSpecification->roomSpecificationDescriptionEnglish . '">
					</div>
					
				</div>
				
				<hr />
				
				<div class="form-row">

					<div class="form-group col-12 col-lg-4 col-xl-3">
						<label for="roomSpecificationNameJapanese">' . Lang::getLang('roomSpecificationNameJapanese') . '</label>
						<input type="text" class="form-control" name="roomSpecificationNameJapanese" value="' . $newSpecification->roomSpecificationNameJapanese . '">
					</div>

					<div class="form-group col-12 col-lg-8 col-xl-9">
						<label for="roomSpecificationDescriptionJapanese">' . Lang::getLang('roomSpecificationDescriptionJapanese') . '</label>
						<input type="text" class="form-control" name="roomSpecificationDescriptionJapanese" value="' . $newSpecification->roomSpecificationDescriptionJapanese . '">
					</div>
					
				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 sm-6 offset-sm-6 offset-md-10 col-md-2">
						<button type="submit" name="add-room-specification" class="btn btn-block btn-success"><span class="fas fa-plus"></span></button>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('workspaceRoomSpecificationManager') . ' ['.$room->roomName().']';
		$card = new CardView('workspace_room_specification_manager',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

}

?>