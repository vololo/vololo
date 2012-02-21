<?php

class Default_Model_Type extends Vololo_Db_Table {
	protected $_name = 'type';

	function fetchList($types) {
		return $this->fetchAll('`stitle` IN ("'.implode('","', $types).'")', 'orderid');
	}
}