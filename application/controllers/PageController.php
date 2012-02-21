<?php

class PageController extends Vololo_Controller_Page {
	function aboutAction() {
		$this->view->id = 'about';
		$this->_helper->viewRenderer('index');
	}

	function iloveyouAction() {
		$this->view->id = 'iloveyou';
		$this->_helper->viewRenderer('index');
	}

	function ihateyouAction() {
		$this->view->id = 'ihateyou';
		$this->_helper->viewRenderer('index');
	}
}