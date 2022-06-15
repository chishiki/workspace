<?php

final class WorkspacePDF {

	private $doc;
	private $fileObject;
	private $fileObjectID;

	public function __construct($loc, $input) {

		if ($loc[2] == 'rooms' && ctype_digit($loc[3])) {

			// /pdf/workspace/rooms/<roomID>/

			$roomID = $loc[3];
			$doc = 'CRESTRON WEB EXAMPLE PDF [ASTEROID]';
			$fileObject = 'WorkspaceRoom';
			$fileObjectID = $roomID;

		}

		$this->doc = $doc;
		$this->fileObject = $fileObject;
		$this->fileObjectID = $fileObjectID;

	}

	public function doc() {

		return $this->doc;

	}

	public function getFileObject() {

		return $this->fileObject;

	}

	public function getFileObjectID() {

		return $this->fileObjectID;

	}

}

?>