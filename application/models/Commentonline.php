<?php

class Default_Model_Commentonline extends Vololo_Db_Table {
	protected $_name = 'ls_comment_online';

	function fetchIpane() {
		$res = array();
		$c = new Default_Model_Comment();
		$u = new Default_Model_Topicuser();
		$t = new Default_Model_Topic();
		$b = new Default_Model_Topicblog();
		$s = $this->getAdapter()->select()
			->from(array('i' => $this->info('name')), '')
			->join(array('c' => $c->info('name')), 'i.comment_id = c.comment_id', array(
				'comment_id' => 'c.comment_id',
				'comment_date' => 'c.comment_date'
			))
			->join(array('u' => $u->info('name')), 'c.user_id = u.user_id', array(
				'user_stitle' => 'u.user_login'
			))
			->join(array('t' => $t->info('name')), 'c.target_id = t.topic_id', array(
				'topic_id' => 't.topic_id',
				'topic_title' => 't.topic_title',
				'topic_count_comment' => 't.topic_count_comment'
			))
			->join(array('b' => $b->info('name')), 't.blog_id = b.blog_id', array(
				'blog_stitle' => 'b.blog_url',
				'blog_title' => 'b.blog_title'
			))
			->group('i.comment_online_id')
			->order('i.comment_online_id desc')
			->limit(5);
		return $this->getAdapter()->fetchAll($s);
	}
}