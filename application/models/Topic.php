<?php

class Default_Model_Topic extends Vololo_Db_Table {
	protected $_name = 'ls_topic';

	function fetchIpane() {
		$s = new Default_Model_Topicuser();
		$b = new Default_Model_Topicblog();
		return $this->getAdapter()->fetchAll($this->getAdapter()->select()
			->from(array('i' => $this->info('name')))
			->join(array('s' => $s->info('name')), 'i.user_id = s.user_id', array(
				'user_stitle' => 's.user_login'
			))
			->join(array('b' => $b->info('name')), 'i.blog_id = b.blog_id', array(
				'blog_stitle' => 'b.blog_url'
			))
			->where('i.topic_publish = 1')
			->group('i.topic_id')
			->order('i.topic_date_add desc')
			->limit(5)
		);
	}
}