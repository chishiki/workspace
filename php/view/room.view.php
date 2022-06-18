<?php

final class WorkspaceRoomView {

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

	public function adminRoomList(WorkspaceRoomListParameters $arg) {

		$body = '

			<div class="row mb-3">
				<div class="col-12 col-md-8 col-lg-6">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'workspace/admin/rooms/') . '
				</div>
				<div class="col-12 col-md-4 col-lg-2 offset-lg-4">
					<a href="/' . Lang::prefix() . 'workspace/admin/rooms/create/" class="btn btn-block btn-outline-success btn-sm"><span class="fas fa-plus"></span> ' . Lang::getLang('create') . '</a>
				</div>
			</div>

			<div class="table-container mb-3">

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover table-sm">
						<thead class="thead-light">
							<tr>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceRoomName') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceRoomPublished') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('workspaceRoomFeatured') . '</th>
								<th scope="col" class="text-center">' . Lang::getLang('action') . '</th>
							</tr>
						</thead>
						<tbody>' . $this->adminRoomListRows($arg) . '</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 col-md-8 col-lg-6">
					' . PaginationView::paginate($arg->numberOfPages,$arg->currentPage,'/' . Lang::prefix() . 'workspace/admin/rooms/') . '
				</div>
			</div>
			

		';

		$card = new CardView('workspace_room_list',array('container'),'',array('col-12'),Lang::getLang('workspaceRoomList'),$body);
		return $card->card();

	}

	public function adminRoomForm($type, $roomID = null) {

		$site = new Site($_SESSION['siteID']);
		$room = new WorkspaceRoom($roomID);
		$pcv = new WorkspaceRoomCategoryView();
		if (!empty($this->input)) {
			foreach($this->input AS $key => $value) { if(isset($room->$key)) { $room->$key = $value; } }
		}

		$form = $this->adminRoomFormTabs($type, $roomID) . '

			<form id="roomForm' . ucfirst($type) . '" method="post" action="/' . Lang::prefix() . 'workspace/admin/rooms/' . $type . '/' . ($roomID?$roomID.'/':'') . '">
				
				' . ($roomID?'<input type="hidden" name="roomID" value="' . $roomID . '">':'') . '
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomCategoryID">' . Lang::getLang('roomCategory') . '</label>
						' . $pcv->roomCategoryDropdown('roomCategoryID', $room->roomCategoryID) . '
					</div>
					
				</div>
				
				<hr />
				
				<div class="row">
				
					<div class="col-12 col-md-6">
					
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="roomNameEnglish">' . Lang::getLang('roomNameEnglish') . '</label>
								<input type="text" class="form-control" name="roomNameEnglish" value="' . $room->roomNameEnglish . '">
							</div>
							
						</div>
		
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="roomDescriptionEnglish">' . Lang::getLang('roomDescriptionEnglish') . '</label>
								<textarea id="workspace_admin_room_form_description_english" class="form-control" name="roomDescriptionEnglish">' . $room->roomDescriptionEnglish . '</textarea>
							</div>
		
						</div>
					
					</div>
					
					<div class="col-12 col-md-6">

						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="roomNameJapanese">' . Lang::getLang('roomNameJapanese') . '</label>
								<input type="text" class="form-control" name="roomNameJapanese" value="' . $room->roomNameJapanese . '">
							</div>
							
						</div>
		
						<div class="form-row">
						
							<div class="form-group col-12">
								<label for="roomDescriptionJapanese">' . Lang::getLang('roomDescriptionJapanese') . '</label>
								<textarea id="workspace_admin_room_form_description_japanese" class="form-control" name="roomDescriptionJapanese">' . $room->roomDescriptionJapanese . '</textarea>
							</div>
		
						</div>
				
					</div>
				
				</div>
				
				<hr />
				
				<div class="form-row">
					<div class="form-group col-12">
						<div class="form-check">
							<input type="checkbox" id="checkbox_room_published" name="roomPublished" class="form-check-input" value="1"' . ($room->roomPublished?' checked':'') . '>
							<label class="form-check-label" for="checkbox_room_published">Published</label>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-12">
						<div class="form-check">
							<input type="checkbox" id="checkbox_room_featured" name="roomFeatured" class="form-check-input" value="1"' . ($room->roomFeatured?' checked':'') . '>
							<label class="form-check-label" for="checkbox_room_featured">Featured</label>
						</div>
					</div>
				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomURL">' . Lang::getLang('roomURL') . ' (' . Lang::getLang('alphanumericHyphenOnly') . ')</label>
						<div class="input-group">
							<div class="input-group-prepend"><div class="input-group-text"><!--http://' . $site->siteURL . '/' . Lang::prefix() . 'workspace/news-->/</div></div>
							<input type="text" class="form-control" name="roomURL" value="' . $room->roomURL . '" required>
							<div class="input-group-append"><div class="input-group-text">/</div></div>
						</div>
					</div>

				</div>
				
				<hr />

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/rooms/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('returnToList') . '</a>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3 offset-md-3">
						<button type="submit" name="room-' . $type . '" class="btn btn-block btn-outline-'. ($type=='create'?'success':'primary') . '">' . Lang::getLang($type) . '</button>
					</div>
					
					<div class="form-group col-12 col-sm-4 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/rooms/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>

			</form>

		';

		$header = Lang::getLang('workspaceRoom'.ucfirst($type)).($type=='update'?' ['.$room->roomName().']':'');
		$card = new CardView('workspace_room_confirm_'.ucfirst($type),array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function adminRoomConfirmDelete($roomID) {

		$room = new WorkspaceRoom($roomID);
		$pcv = new WorkspaceRoomCategoryView();

		$form = '

			<form id="room_form_delete" method="post" action="/' . Lang::prefix() . 'workspace/admin/rooms/delete/' . $roomID . '/">
				
				<input type="hidden" name="roomID" value="' . $roomID . '">

				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomCategoryID">' . Lang::getLang('roomCategory') . '</label>
						' . $pcv->roomCategoryDropdown('', $room->roomCategoryID, true, true, null) . '
					</div>
					
				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomNameEnglish">' . Lang::getLang('roomNameEnglish') . '</label>
						<input type="text" class="form-control" value="' . $room->roomNameEnglish . '" disabled>
					</div>

				</div>
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomDescriptionEnglish">' . Lang::getLang('roomDescriptionEnglish') . '</label>
						<textarea class="form-control" disabled>' . $room->roomDescriptionEnglish . '</textarea>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12 col-sm-8 col-md-6">
						<label for="roomNameJapanese">' . Lang::getLang('roomNameJapanese') . '</label>
						<input type="text" class="form-control" value="' . $room->roomNameJapanese . '" disabled>
					</div>

				</div>
				
				<hr />
				
				<div class="form-row">
				
					<div class="form-group col-12">
						<label for="roomDescriptionJapanese">' . Lang::getLang('roomDescriptionJapanese') . '</label>
						<textarea class="form-control" disabled>' . $room->roomDescriptionJapanese . '</textarea>
					</div>

				</div>

				<div class="form-row">
				
					<div class="form-group col-6 col-md-3 offset-md-6">
						<button type="submit" name="room-confirm-delete" class="btn btn-block btn-outline-danger">' . Lang::getLang('delete') . '</button>
					</div>
					
					<div class="form-group col-6 col-md-3">
						<a href="/' . Lang::prefix() . 'workspace/admin/rooms/" class="btn btn-block btn-outline-secondary" role="button">' . Lang::getLang('cancel') . '</a>
					</div>
					
				</div>
				
			</form>
		';

		$header = Lang::getLang('roomConfirmDelete').' ['. $room->roomName .']';
		$card = new CardView('workspace_room_confirm_delete',array('container'),'',array('col-12'),$header,$form);
		return $card->card();

	}

	public function roomList(WorkspaceRoomListParameters $arg) {

		$hpl = new WorkspaceRoomList($arg);
		$rooms = $hpl->rooms();

		$roomList = '<div class="container mt-3">';

		$roomList .= '<h3 class="workspace-h">' .  Lang::getLang($arg->title['langKey'], $arg->title['langSelector']) . '</h3>';

		foreach ($rooms AS $roomID) {

			$img = '';
			$imageFetch = new ImageFetch('WorkspaceRoom', $roomID, null, true);
			if ($imageFetch->imageExists()) {
				$img = '<span class="room-list-item-image-span">';
					$img .= '<img src="' . $imageFetch->getImageSrc() . '" class="room-list-item-image">';
				$img .= '</span>';
			}

			$room = new WorkspaceRoom($roomID);
			$roomList .= '
				<div class="room-list-item row clickable" data-url="/' . Lang::prefix() . 'workspace/rooms/' . $room->roomURL . '/">
					<div class="room-list-item-image col-12 col-md-3 col-lg-2">' . $img . '</div>
					<div class="room-list-item-room col-12 col-md-9 col-lg-10">
						<span class="room-list-item-room-name">' . $room->roomName() . '</span>
						<br />
						<span class="room-list-item-room-description">' . mb_substr($room->roomDescription(), 0, $arg->descriptionConcat) . '...</span>
					</div>
				</div>
			';
		}

		$roomList .= '</div>';

		return $roomList;

	}

	public function roomView($roomID) {

		$room = new WorkspaceRoom($roomID);

		$bookingButton = '';
		if ($room->roomBookingURL) {
			$bookingButton = '
				<div class="row">
					<div class="col-12">
						<a class="btn btn-outline-primary btn-block" href="' . $room->roomBookingURL . '">' . lang('bookRoom') . '</a>
					</div>
				</div>
			';
		}

		$view = '
		
			<div class="room-view container-fluid">

				<div class="row">
					
					<div class="col-12 col-sm-6 mb-3">' . $this->roomCarousel($roomID) . '</div>
					
					<div class="col-12 col-sm-6 mb-3">
						<h1 class="workspace-h">' . $room->roomName() . '</h1>
						<p>' . nl2br(htmlentities($room->roomDescription()),true) . '</p>
						' . $bookingButton . '
					</div>

					<div class="col-12 mb-3">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="room_view_features_nav" data-toggle="tab" href="#room_view_features_panel" role="tab" aria-controls="home" aria-selected="true">' . Lang::getLang('workspaceRoomFeatures') . '</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="room_view_specifications_nav" data-toggle="tab" href="#room_view_specifications_panel" role="tab" aria-controls="profile" aria-selected="false">' . Lang::getLang('workspaceRoomSpecifications') . '</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="room_view_downloads_nav" data-toggle="tab" href="#room_view_downloads_panel" role="tab" aria-controls="contact" aria-selected="false">' . Lang::getLang('workspaceRoomDownloads') . '</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="room_view_features_panel" role="tabpanel" aria-labelledby="home-tab">' . $this->roomViewFeatures($roomID) . '</div>
							<div class="tab-pane fade" id="room_view_specifications_panel" role="tabpanel" aria-labelledby="profile-tab">' . $this->roomViewSpecifications($roomID) . '</div>
							<div class="tab-pane fade" id="room_view_downloads_panel" role="tabpanel" aria-labelledby="contact-tab">' . $this->roomViewDownloads($roomID) . '</div>
						</div>
					</div>
					
				</div>
				
			</div>

		';

		return $view;

	}

	private function roomViewFeatures($roomID) {

		$featureList = new WorkspaceRoomFeatureList($roomID);
		$features = $featureList->features();

		$view = '<div id="workspace_room_features" class="container-fluid">';
			$view .= '<div class="row">';
				$view .= '<div class="col-12">';
					$view .= '<ul>';
						foreach ($features AS $roomFeatureID) {
							$feature = new WorkspaceRoomFeature($roomFeatureID);
							$view .= '<li>' . $feature->roomFeatureName() . '</li>';
						}
					$view .= '</ul>';
				$view .= '</div>';
			$view .= '</div>';
		$view .= '</div>';

		return $view;

	}

	private function roomViewSpecifications($roomID) {

		$specList = new WorkspaceRoomSpecificationList($roomID);
		$specs = $specList->specifications();

			$view = '<div id="workspace_room_specification" class="container-fluid">';
			foreach ($specs AS $roomSpecificationID) {
				$spec = new WorkspaceRoomSpecification($roomSpecificationID);
				$view .= '<div class="row">';
					$view .= '<div class="spec-name col-12 col-sm-5 col-md-3 border font-weight-bolder py-2">' . $spec->roomSpecificationName() . '</div>';
					$view .= '<div class="spec-description col-12 col-sm-7 col-md-9 border py-2">' . $spec->roomSpecificationDescription() . '</div>';
				$view .= '</div>';
			}
			$view .= '</div>';

		return $view;

	}

	private function roomViewDownloads($roomID) {

		$downloads = File::getObjectFileArray('WorkspaceRoom', $roomID);
		$view = '<div id="workspace_room_downloads" class="container-fluid">';
			$view .= '<div id="workspace_room_downloads_container" class="row">';
				foreach ($downloads AS $fileID) {
					$file = new File($fileID);
					$view .= '
						<div class="col-12 col-md-6 col-lg-3 my-3">
							<div class="card">
								<div class="card-header">' . $file->fileTitleEnglish . '</div>
								<div class="card-body">
									<a class="btn btn-primary btn-block" href="/file/' . $fileID . '/" download>
										' . Lang::getLang('download') . '<br />
										<span class="font-weight-lighter"><small>' . $file->fileOriginalName . ' ' . (number_format($file->fileSize/1000, '0')) . 'KB</small></span>
									</a>
								</div>
							</div>
						</div>
					';
				}
			$view .= '</div>';
		$view .= '</div>';
		return $view;

	}

	private function adminRoomListRows(WorkspaceRoomListParameters $arg) {

		$roomList = new WorkspaceRoomList($arg);
		$rooms = $roomList->rooms();

		$rows = '';

		foreach ($rooms AS $roomID) {

			$room = new WorkspaceRoom($roomID);

			$rows .= '
				<tr id="room_id_' . $roomID . '" class="room-list-row">
					<th scope="row" class="text-left">' . $room->roomName() . '</th>
					<td class="text-center">' . ($room->roomPublished?'&#10004;':'') . '</td>
					<td class="text-center">' . ($room->roomFeatured?'&#10004;':'') . '</td>
					<td class="text-center text-nowrap">
						<a href="/' . Lang::prefix() . 'workspace/admin/rooms/update/' . $roomID . '/" class="btn btn-sm btn-outline-primary">' . Lang::getLang('update') . '</a>
						<a href="/' . Lang::prefix() . 'workspace/admin/rooms/confirm-delete/' . $roomID . '/" class="btn btn-sm btn-outline-danger">' . Lang::getLang('delete') . '</a>
					</td>
				</tr>
			';

		}

		return $rows;

	}

	public function adminRoomFormTabs($type = 'create', $roomID = null, $activeTab = 'room-form') {

		$roomFormURL = '#';
		$updateOnly = true;

		if ($type == 'update' && ctype_digit($roomID)) {
			$roomFormURL = '/' . Lang::prefix() . 'workspace/admin/rooms/update/' . $roomID . '/';
			$updateOnly = false;
		}

		$t = '

			<ul id="admin_room_form_nav_tabs" class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link' . ($activeTab=='room-form'?' active':'') . '" href="' . $roomFormURL . '">' . Lang::getLang('workspaceRoom') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='features'?' active':'') . '" href="' . $roomFormURL . 'features/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('workspaceRoomFeatures') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='specifications'?' active':'') . '" href="' . $roomFormURL . 'specifications/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('workspaceRoomSpecifications') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='images'?' active':'') . '" href="' . $roomFormURL . 'images/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('workspaceRoomImages') . '</a>
				</li>
				<li class="nav-item">
					<a class="nav-link' . ($updateOnly?' disabled':'') . ($activeTab=='files'?' active':'') . '" href="' . $roomFormURL . 'files/"' . ($updateOnly?' tabindex="-1"':'') . '>' . Lang::getLang('workspaceRoomFiles') . '</a>
				</li>
			</ul>
			
		';

		return $t;

	}

	private function roomCarousel($roomID) {

		$arg = new NewImageListParameters();
		$arg->imageObject = 'WorkspaceRoom';
		$arg->imageObjectID = $roomID;
		$nil = new NewImageList($arg);
		$images = $nil->images();

		$panels = '';
		for ($i = 0; $i < count($images); $i++) {
			$panels .= '
				<div class="carousel-item' . ($i==0?' active':'') . '">
					<img src="/image/' . $images[$i] . '" class="d-block w-100"">
				</div>
			';
		}

		$carousel = '
			<div id="workspace_room_carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">' . $panels . '</div>
				<a class="carousel-control-prev" href="#workspace_room_carousel" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#workspace_room_carousel" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		';

		return $carousel;

	}

}

?>