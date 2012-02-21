<?php

class Default_Model_Ev extends Vololo_Db_Table {
	protected $_name = 'ev';

	function fetchList($year) {
		return $this->getAdapter()->fetchAll($this->getAdapter()->select()
			->from(array('i' => $this->info('name')))
			->where('YEAR(`date`) = ?', $year)
			->order('i.date desc')
		);
	}
}