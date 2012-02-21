<?php
/**
 * Vololo
 *
 * Copyright (c) 2010 Vololo Ltd. <info@vololo.ru>, http://vololo.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

class Vololo_Db_Model_Page extends Vololo_Db_Table {
	protected $_name = 'page';
	protected $_multilang_field = array(
		'title',
		'message'
	);

	function fetchCard($id) {
		$ret = $this->fetchRow(array('`stitle` = ?' => $id));
		return $ret = $ret ? $ret : $this->fetchRow('`stitle` = "error"');
	}
}
