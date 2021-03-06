<?php
/**
 * Vololo
 *
 * Copyright (c) 2010 Vololo Ltd. <info@vololo.ru>, http://vololo.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

class Vololo_View_Helper_Txt extends Zend_View_Helper_Abstract  {
	private $_data = null;

	public function txt($key = null, $field = 'value') {
    	if ($key === null) return $this;
    	else {
    		if ($this->_data === null) {
    			$model = new Default_Model_Txt();
    			$all = $model->fetchAll();
    			if (count($all)) {
    				$all = $this->view->override($all, 'txt');

    				foreach ($all as $el) $this->_data[$el->key] = $el;
    			}
    			else $this->_data = array();
    		}
   			return @$this->_data[$key]->$field;
    	}
    }
}