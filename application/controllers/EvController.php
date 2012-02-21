<?php

class EvController extends Vololo_Controller_Action {
	function indexAction() {
		$this->view->year = (int)$this->getRequest()->getParam('year');
	}

	function voteAction() {
		$this->view->id = (int)$this->getRequest()->getPost('id');
		$this->view->value = (int)$this->getRequest()->getPost('value');
		$this->view->type = (string)$this->getRequest()->getPost('type');
		$this->view->message = (string)$this->getRequest()->getPost('message');
		if (!in_array($this->view->type, array(
			'content',
			'navigation',
			'design'
		)) || !$this->view->id || $this->view->value < 1 || $this->view->value > 5) throw new Zend_Controller_Action_Exception(403);
	}
}