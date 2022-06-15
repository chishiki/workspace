<?php

final class WorkspaceExportController {

	private $loc;
	private $input;
	private $modules;
	
	private $filename;
	private $columns;
	private $rows;

	public function __construct($loc, $input, $modules) {

		$this->loc = $loc;
		$this->input = $input;
		$this->modules = $modules;

		$this->filename = 'export';
		$this->columns = array();
		$this->rows = array();
		
		if ($loc[0] == 'csv' && $loc[1] == 'workspace') {

			if ($loc[2] == 'rooms') {

				// /csv/workspace/rooms/

				$arg = new WorkspaceRoomListParameter();
				$roomList = new WorkspaceRoomList($arg);
				$rooms = $roomList->rooms();

				$this->filename = 'room_export_' . str_replace('_', '-', $loc[4]);

				$this->columns[] = 'roomID';
				$this->columns[] = 'roomName';
				$this->columns[] = 'roomDiameter';
				$this->columns[] = 'roomDistanceFromSun';
				$this->columns[] = 'roomDiscoverer';
				$this->columns[] = 'roomDateDiscovered';

				foreach ($rooms AS $roomID) {
					$data = array();
					$room = new WorkspaceRoom($roomID);
					$data[] = $roomID;
					$data[] = $room->roomName;
					$data[] = $room->roomDiameter;
					$data[] = $room->roomDistanceFromSun;
					$data[] = $room->roomDiscoverer;
					$data[] = $room->roomDateDiscovered;
					$this->rows[] = $data;
				}

			}

		}

	}

	public function filename() {

		return $this->filename;
		
	}
	
	public function columns() {

		return $this->columns;
		
	}
	
	public function rows() {

		return $this->rows;
		
	}

}

?>