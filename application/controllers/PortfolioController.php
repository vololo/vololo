<?php

class PortfolioController extends Vololo_Controller_Action {
	function indexAction() {
		$this->view->studia = explode(' ', (string)$this->getRequest()->getParam('studia'));
		$this->view->id = explode(' ', (string)$this->getRequest()->getParam('id'));
	}
}