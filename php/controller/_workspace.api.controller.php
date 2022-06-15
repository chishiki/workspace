<?php

final class WorkspaceAPI {
		
	    private $loc;
	    private $input;
	    
	    public function __construct($loc, $input) {
			
	        $this->loc = $loc;
	        $this->input = $input;
			
		}
		
		public function response() {

			if ($this->loc[2] == 'rooms' && ctype_digit($this->loc[3])) {

				// /api/workspace/rooms/<roomID>/
				$roomID = $this->loc[3];
				$room = new WorkspaceRoom($roomID);
				return json_encode($room);

			}

			if ($this->loc[2] == 'delete-room-feature' && isset($this->input['roomFeatureID'])) {

				// /api/workspace/delete-room-feature/
				$roomFeatureID = $this->input['roomFeatureID'];
				$feature = new WorkspaceRoomFeature($roomFeatureID);
				$feature->markAsDeleted();
				return json_encode($feature);

			}

			if ($this->loc[2] == 'update-room-feature-display-order' && isset($this->input['displayOrder'])) {

				// /api/workspace/update-room-feature-display-order/
				$displayOrder = $this->input['displayOrder'];
				$updateFeatures = array();
				foreach($displayOrder AS $thisDisplayOrder => $roomFeatureID) {
					$dt = new DateTime();
					$feature = new WorkspaceRoomFeature($roomFeatureID);
					if ($feature->roomFeatureDisplayOrder != $thisDisplayOrder) {
						$feature->updated = $dt->format('Y-m-d H:i:s');
						$feature->roomFeatureDisplayOrder = $thisDisplayOrder;
						$cond = array('roomFeatureID' => $roomFeatureID);
						WorkspaceRoomFeature::update($feature, $cond, true, false, 'workspace_');
						$updateFeatures[] = $feature;
					}
				}
				return json_encode($updateFeatures);

			}

			if ($this->loc[2] == 'delete-room-specification' && isset($this->input['roomSpecificationID'])) {

				// /api/workspace/delete-room-specification/
				$roomSpecificationID = $this->input['roomSpecificationID'];
				$specification = new WorkspaceRoomSpecification($roomSpecificationID);
				$specification->markAsDeleted();
				return json_encode($specification);

			}

			if ($this->loc[2] == 'update-room-specification-display-order' && isset($this->input['displayOrder'])) {

				// /api/workspace/update-room-specification-display-order/
				$displayOrder = $this->input['displayOrder'];
				$updateSpecifications = array();
				foreach($displayOrder AS $thisDisplayOrder => $roomSpecificationID) {
					$dt = new DateTime();
					$specification = new WorkspaceRoomSpecification($roomSpecificationID);
					if ($specification->roomSpecificationDisplayOrder != $thisDisplayOrder) {
						$specification->updated = $dt->format('Y-m-d H:i:s');
						$specification->roomSpecificationDisplayOrder = $thisDisplayOrder;
						$cond = array('roomSpecificationID' => $roomSpecificationID);
						WorkspaceRoomSpecification::update($specification, $cond, true, false, 'workspace_');
						$updateSpecifications[] = $specification;
					}
				}
				return json_encode($updateSpecifications);

			}


            $response = '{"api":"workspace"}';
            return $response;

		}
		
	}

?>