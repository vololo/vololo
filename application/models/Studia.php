<?php

class Default_Model_Studia extends Vololo_Db_Table {
	protected $_name = 'studia';

	function fetchNotPortfolioParsed() {
		return $this->fetchAll('UNIX_TIMESTAMP(`parsed_portfolio`) + 86400 < UNIX_TIMESTAMP(NOW())', null, 1);
	}

	function fetchNotBlogParsed() {
		return $this->fetchAll('UNIX_TIMESTAMP(`parsed_blog`) + 86400 < UNIX_TIMESTAMP(NOW())', null, 1);
	}

	function fetchCard($id) {
		return $this->fetchRow(array('`stitle` = ?' => $id));
	}

	function fetchIpane() {
		$b = new Default_Model_Blog();
		$p = new Default_Model_Portfolio();
		$s = $this->getAdapter()->select()
			->from(array('i' => $this->info('name')))
			->joinLeft(array('b' => $b->info('name')), 'b.parentid = i.id', array(
				'last_blog' => 'MAX(b.date)'
			))
			->joinLeft(array('p' => $p->info('name')), 'p.parentid = i.id', array(
				'last_portfolio' => 'MAX(p.date)'
			))
			->group('i.id')
			->order('MAX(p.date) desc')
			->order('MAX(b.date) desc');
		return $this->getAdapter()->fetchAll($s);
		//return $this->fetchAll(null, 'title');
	}

	function fetchOlist() {
		return $this->fetchAll(null, 'title');
	}
}