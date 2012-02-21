<?php

class MailController extends Vololo_Controller_Action {
	function indexAction() {
		$this->view->mail = (string)$this->getRequest()->getPost('mail');
		$this->view->type = explode(' ', (string)$this->getRequest()->getParam('type'));
		$this->view->studia = explode(' ', (string)$this->getRequest()->getParam('studia'));
	}

	function unsubscribeAction() {
		$this->view->mail = @base64_decode((string)$this->getRequest()->getParam('mail'));
	}

	function adminAction() {
		$this->view->post = $this->getRequest()->getPost();
	}
}