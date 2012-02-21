<?php

class Default_Model_Twitter extends Vololo_Db_Model_Twitter {
	public $_name = 'twitter';

	function update($msg) {
		$this->_update($msg);
	}

	function fetchList($q) {
		$key = 'status_search_'.date('YmdH').floor(date('i') / 10).md5($q);
    	$cache = Zend_Registry::get('Vololo_Cache');
    	if ($cache && $cache->test($key)) $res = $cache->load($key);
    	else {
    		$res = array();
    		$res_1 = $this->_searchStatuses($q);
    		if (count($res_1)) {
    			$nn = 0;
    			foreach ($res_1 as $n => $el) {
    				if (substr($el['message'], 0, 1) == '@') continue;
					if (stripos($el['message'], '#vololo') === false) continue;
    				if ($nn > 2) break;
    				$res[] = $el;
    				$nn++;
    			}
    		}
    		else $res = $res_1;
    		if ($cache) $cache->save($res, $key);
    	}
        return $res;
	}
}