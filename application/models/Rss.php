<?php

class Default_Model_Rss extends Vololo_Db_Table {
	function fetchList($type, $studia) {
		$mo = new Default_Model_Topic();
		$mob = new Default_Model_Topicblog();
		$mou = new Default_Model_Topicuser();
		$mot = new Default_Model_Topiccontent();
		$mp = new Default_Model_Portfolio();
		$mb = new Default_Model_Blog();
		$mt = new Default_Model_Type();
		$ms = new Default_Model_Studia();

		$types = $mt->fetchCol(
			'stitle',
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

		if ($types && $studios) {
			$selects = array();

			foreach ($types as $el) {
				$selects[] = $mp->getAdapter()->select()
					->from($el, array(
						'title',
						'date',
						'src',
						'parentid',
						'message'
					))
					->join(array('s' => $ms->info('name')), 's.id = `parentid`', array(
						'studia_title' => 's.title'
					))
					->where('`parentid` IN ("'.implode('","', $studios).'")');
			}
			$selects[] = $mp->getAdapter()->select()
				->from(array('o' => $mo->info('name')), array(
					'title' => 'o.topic_title',
					'date' => 'o.topic_date_add',
					'src' => 'CONCAT("http://'.$_SERVER['HTTP_HOST'].'/blog/blog/", b.blog_url, "/", o.topic_id, ".html")',
					'parentid' => 'o.topic_id',
					'message' => 't.topic_text'
				))
				->join(array('t' => $mot->info('name')), 'o.topic_id = t.topic_id', '')
				->join(array('b' => $mob->info('name')), 'o.blog_id = b.blog_id', '')
				->join(array('u' => $mou->info('name')), 'o.user_id = u.user_id', array(
					'studia_title' => 'u.user_login'
				))
				->where('o.topic_publish = 1');

			$s = $mp->getAdapter()->select()
				->union($selects)
				->order('date desc')
				->limit(20);
			return $this->getAdapter()->fetchAll($s);
		}
		return array();
	}
}