<?php

class Default_Model_Portfolio extends Vololo_Db_Table {
	protected $_name = 'portfolio';

	function fetchByOid($pid, $oid) {
		return $this->fetchRow(array('`parentid` = ?' => $pid, '`oid` = ?' => $oid));
	}

	function fetchCard($id) {
		$s = new Default_Model_Studia();
		return $this->getAdapter()->fetchRow($this->getAdapter()->select()
			->from(array('i' => $this->info('name')))
			->join(array('s' => $s->info('name')), 'i.parentid = s.id', array(
				'studia_id' => 's.id',
				'studia_title' => 's.title',
				'studia_stitle' => 's.stitle'
			))
			->group('i.id')
			->where('i.id = ?', $id)
		);
	}

	function fetchIpane() {
		$s = new Default_Model_Studia();
		return $this->getAdapter()->fetchAll($this->getAdapter()->select()
			->from(array('i' => $this->info('name')))
			->join(array('s' => $s->info('name')), 'i.parentid = s.id', array(
				'studia_id' => 's.id',
				'studia_title' => 's.title',
				'studia_stitle' => 's.stitle'
			))
			->group('i.id')
			->order('i.date desc')
			->limit(10)
		);
	}

	function fetchList($id) {
		$s = new Default_Model_Studia();
		return $this->getAdapter()->fetchAll($this->getAdapter()->select()
			->from(array('i' => $this->info('name')))
			->join(array('s' => $s->info('name')), 'i.parentid = s.id', array(
				'studia_id' => 's.id',
				'studia_title' => 's.title',
				'studia_stitle' => 's.stitle'
			))
			->group('i.id')
			->where('i.parentid = ?', $id)
			->order('i.date desc')
		);
	}

	function fetchTwitter($ids) {
		return $this->fetchMail($ids);
	}

	function fetchMail($ids) {
		if ($ids) {
			$s = new Default_Model_Studia();
			return $this->getAdapter()->fetchAll($this->getAdapter()->select()
				->from(array('i' => $this->info('name')))
				->join(array('s' => $s->info('name')), 'i.parentid = s.id', array(
					'studia_title' => 's.title'
				))
				->where('i.id IN ('.implode(',', $ids).')')
				->group('i.id')
				->order('i.date desc')
			);
		}
		return array();
	}
}