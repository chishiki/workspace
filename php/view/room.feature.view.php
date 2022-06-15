<?php

final class WorkspaceRoomFeatureView {

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

	public function adminRoomFeatureForm($roomID) {

		$room = new WorkspaceRoom($roomID);
		$newFeature = new WorkspaceRoomFeature();

		$hpv = new WorkspaceRoomView();
		$form = $hpv->adminRoomFormTabs('update', $roomID, 'features');

		$hpfl = new WorkspaceRoomFeatureList($roomID);
		$features = $hpfl->features();
		if (!empty($features)) {
			$form .= '<ul id="admin_room_feature_list" class="list-group">';
			foreach ($features as $roomFeatureID) {
				$feature = new WorkspaceRoomFeature($roomFeatureID);
				$form .= '
					<li class="list-group-item admin-room-feature-list-item d-flex justify-content-between align-items-center" data-room-feature-id="' . $roomFeatureID . '">
						<span class="drag-handle btn btn-outline-secondary mr-3"><span class="fas fa-grip-lines"></span></span>
						<span class="admin-room-feature-name flex-grow-1 d-block">' . $feature->roomFeatureName() . '</span>
						<button type="button" class="btn btn-danger delete-room-feature ml-3"><span class="far fa-trash-alt"></span></button>
					</li>
				';
			}
			$form .= '</ul>';
			$form .= '<hr />';
		}

		$form .= '

			<form id="workspace_room_feature_manager_form" method="post" action="/' . Lang::prefix() . 'workspace/admin/rooms/update/' . $roomID . '/features/">

				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomFeatureNameEnglish">' . Lang::getLang('roomFeatureNameEnglish') . '</label>
						<input type="text" class="form-control" name="roomFeatureNameEnglish" value="' . $newFeature->roomFeatureNameEnglish . '" placeholder="' . Lang::getLang('addNewFeatureHere', 'en') . '">
					</div>
					
				</div>
				
				<div class="form-row">

					<div class="form-group col-12">
						<label for="roomFeatureNameJapanese">' . Lang::getLang('roomFeatureNameJapanese') . '</label>
						<input type="text" class="form-control" name="roomFeatureNameJapanese" value="' . $newFeature->roomFeatureNameJapanese . '" placeholder="' . Lang::getLang('addNewFeatureHere', 'ja') . '">
					</div>
				
				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12 sm-6 offset-sm-6 offset-md-10 col-md-2">
						<button type="submit" name="add-room-feature" class="btn btn-block btn-success"><span class="fas fa-plus"></span></button>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('workspaceRoomFeatureManager') . ' ['.$room->roomName().']';
		$card = new CardView('workspace_room_feature_manager',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

}

?>