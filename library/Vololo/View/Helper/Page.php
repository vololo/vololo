<?php
/**
 * Vololo
 *
 * Copyright (c) 2010 Vololo Ltd. <info@vololo.ru>, http://vololo.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

class Vololo_View_Helper_Page extends Zend_View_Helper_Abstract  {
	public function page($key = null, $field = 'message') {
		$model = new Default_Model_Page();
		$f = $field == 'description' ? 'message' : $field;
		$data = $model->fetchCard($key);
		$data_valid = $this->view->override()->overrideSingle($data, 'page');
		return $field == 'all' ? $data_valid : $data_valid->$field;
    }
}