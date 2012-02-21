<?php

class Default_Model_Evvote extends Vololo_Db_Table {
	protected $_name = 'ev_vote';

	function fetchAvg($id, $type) {
		return round($this->fetchOne('AVG(`value`)', array('`ev` = ?' => $id, '`type` = ?' => $type)));
	}

	function fetchAvgm($id, $type) {
		$res = $this->fetchCol('message', array('`ev` = ?' => $id, '`type` = ?' => $type, 'LENGTH(`message`) > 0'), 'date desc');

		return implode('; ', $res);
	}

	function fetchCard($id, $user, $type) {
		return $this->fetchRow(array('`ev` = ?' => $id, '`type` = ?' => $type, '`author` = ?' => $user));
	}

	function fetchList($id, $user, $type) {
		$vote = $this->fetchCard($id, $user, $type);
		$vote_avg = $this->fetchAvg($id, $type);
		$message_avg = $this->fetchAvgm($id, $type);
		$ret = array();
		$max = 4;
		for ($i = 0; $i <= $max; $i++) {
			$ret[] = new Vololo_View_Data(array(
				'id' => $i + 1,
				'type' => $type,
				'value' => $vote ? $vote->value : 0,
				'value_avg' => $vote_avg,
				'message' => $vote ? $vote->message : '',
				'message_avg' => $message_avg
			));
		}
		return $ret;
	}

	function vote($id, $user, $type, $value, $message) {
		$message = trim(strip_tags($message));
		if (strlen($message) < 2) $message = '';
		$exist = $this->fetchRow(array('`ev` = ?' => $id, '`type` = ?' => $type, '`author` = ?' => $user));
		if ($exist) {
			$d = array('value' => $value);
			if ($message) $d['message'] = $message;
			$this->update($d, array('`id` = ?' => $exist->id));
		}
		else $this->insert(array(
			'ev' => $id,
			'type' => $type,
			'author' => $user,
			'value' => $value,
			'message' => $message
		));
	}
}