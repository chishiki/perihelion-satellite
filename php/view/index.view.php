<?php 

final class PerihelionSatelliteIndexView {

    private $urlArray;
	private $view;
	
	public function __construct($urlArray) {
		
	    $this->urlArray = $urlArray;
		$this->view = $this->index();

	}

	private function index() {

		$addToIndex = 'ASTEROID MODULE LOADED';
		if (Auth::isLoggedIn()) {
			$addToIndex = '<a href="/' . Lang::prefix() . 'perihelion-satellite/asteroids/" class="btn btn-outline-info">' . Lang::getLang('asteroids') . '</a>';
			$addToIndex .= '<hr />';
		}
		$addToIndex .= '<p class="font-weight-lighter">Edit this card or remove it in /perihelion-satellite/php/view/index.view.php</p>';

		$card = new CardView(
			'satellite_index',
			array('container-fluid','my-3'),
			'',
			array('col-12','col-md-8','offset-md-2'),
			'PERIHELION SATELLITE',
			$addToIndex,
			false
		);
		return $card->card();
	    
	}
	
	public function getView() {
		
		return $this->view;
		
	}
	
}


?>