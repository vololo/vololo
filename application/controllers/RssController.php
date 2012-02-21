<?php

class RssController extends Vololo_Controller_Action {
	function indexAction() {
		$this->view->type = explode(' ', (string)$this->getRequest()->getParam('type'));
		$this->view->studia = explode(' ', (string)$this->getRequest()->getParam('studia'));
	}
}