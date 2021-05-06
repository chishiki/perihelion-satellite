<?php 

final class PerihelionSatelliteIndexView {

    private $urlArray;
	private $view;
	
	public function __construct($urlArray) {
		
	    $this->urlArray = $urlArray;
		$this->view = $this->index();
		
		if (!Auth::isLoggedIn()) {
			$loginURL = '/' . Lang::prefix() . 'login/';
			header("Location: $loginURL");
		}

	}

	private function index() {

		$view = new AsteroidView();
	    return $view->asteroidList();
	    
	}
	
	public function getView() {
		
		return $this->view;
		
	}
	
}


?>