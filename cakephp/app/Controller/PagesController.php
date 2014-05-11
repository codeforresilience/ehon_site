<?php

class PagesController extends AppController {
	function beforeFilter(){
		$this->Auth->allow();
	}

	public function index() {

	}

	public function about() {

	}

	public function contact() {

	}


}
