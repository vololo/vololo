<?php

class StudiaController extends Vololo_Controller_Action {
	function indexAction() {
		$this->view->id = explode(' ', (string)$this->getRequest()->getParam('id'));
	}
}