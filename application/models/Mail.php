<?php

class Default_Model_Mail extends Vololo_Db_Table {
	protected $_name = 'mail';

	function subscribe($mail, $type, $studia) {
		$mt = new Default_Model_Type();
		$ms = new Default_Model_Studia();
		$mmt = new Default_Model_Mailtype();
		$mms = new Default_Model_Mailstudia();

		$types = $mt->fetchCol(
			'id',
			@$type[0] == 'all'
				? null
				: '`stitle` IN ("'.implode('","', $type).'")'
		);
		$studios = $ms->fetchCol(
			'id',
			@$studia[0] == 'all'
				? null
				: '`stitle` IN ("'.implode('","', $studia).'")'
		);

		$id = (int)$this->fetchOne('id', array('`title` = ?' => $mail));
		if (!$id) $id = $this->insert(array(
			'title' => $mail
		));
		else $this->update(array(
			'active' => 1
		), array('`id` = ?' => $id));

		if ($id && $types && $studios) {
			$mmt->delete(array('`mailid` = ?' => $id));
			$mms->delete(array('`mailid` = ?' => $id));
			foreach ($types as $el) $mmt->insert(array(
				'typeid' => $el,
				'mailid' => $id
			));
			foreach ($studios as $el) $mms->insert(array(
				'studiaid' => $el,
				'mailid' => $id
			));
		}
	}

	function fetchSubscribers($type, $studios) {
		$mt = new Default_Model_Type();
		$mmt = new Default_Model_Mailtype();
		$mms = new Default_Model_Mailstudia();

		$types = $mt->fetchCol(
			'id',
			'`stitle` IN ("'.implode('","', $type).'")'
		);

		return $type && $studios ? $this->getAdapter()->fetchAll($this->getAdapter()->select()
			->from(array('m' => $this->info('name')))
			->join(array('t' => $mmt->info('name')), 't.mailid = m.id', '')
			->join(array('s' => $mms->info('name')), 's.mailid = m.id', '')
			->where('m.active = 1')
			->where('t.typeid IN ('.implode(',', $types).')')
			->where('s.studiaid IN ('.implode(',', $studios).')')
			->group('m.id')
		) : array();
	}
}