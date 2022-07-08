<?php 

final class WorkspaceIndexView {

    private $urlArray;
	private $view;
	
	public function __construct($urlArray) {
		
	    $this->urlArray = $urlArray;
		$this->view = $this->index();

	}

	private function index() {

		$h = '';

		// GET FEATURED PRODUCTS LIST
		$hpv = new WorkspaceRoomView();
		$arg = new WorkspaceRoomListParameters();
		$arg->roomFeatured = true;
		$arg->descriptionConcat = 77; // if English do we make this longer...?
		$arg->title = array('langKey' => 'workspaceFeaturedRooms', 'langSelector' => 'en');
		$h .= $hpv->roomList($arg);

		// GET BLOCKS
		$wbv = new WorkspaceBlockView();
		$h .= $wbv->workspaceBlockContainer();

		// GET NEWS LIST
		$hnw = new WorkspaceNewsView();
		$h .= $hnw->newsList();

		return $h;
	    
	}
	
	public function getView() {
		
		return $this->view;
		
	}
	
}


?>