<?php
/**
 * Vololo
 *
 * Copyright (c) 2010 Vololo Ltd. <info@vololo.ru>, http://vololo.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

class Vololo_Db_Model_Twitter {
    public $_name = 'default';
    public $_service;
    public $_twitter;

    function __construct($options = array()) {
    	$this->_twitter = Zend_Registry::get('Vololo_Twitter');
    	if (isset($this->_twitter[$this->_name]['service'])) $this->_service = $this->_twitter[$this->_name]['service'];
		else {
			$consumer_key = isset($options['consumer_key']) ? $options['consumer_key'] : $this->_twitter['consumer_key'];
			$consumer_secret = isset($options['consumer_secret']) ? $options['consumer_secret'] : $this->_twitter['consumer_secret'];
			$callback_url = isset($options['callback_url']) ? $options['callback_url'] : $this->_twitter['callback_url'];
			$token = isset($options['token']) ? $options['token'] : $this->_twitter['token'];
			$token_secret = isset($options['token_secret']) ? $options['token_secret'] : $this->_twitter['token_secret'];
			$at = new Zend_Oauth_Token_Access();
			$at->setToken($token);
			$at->setTokenSecret($token_secret);
			$opt = array(
			    'accessToken' => $at
			);
			if ($consumer_key) $opt['consumerKey'] = $consumer_key;
			if ($consumer_secret) $opt['consumerSecret'] = $consumer_secret;
			if ($callback_url) $opt['callbackUrl'] = $callback_url;
			$this->_service = new Vololo_Service_Twitter($opt);
			$this->_twitter[$this->_name]['service'] = $this->_service;
			Zend_Registry::set('Vololo_Twitter', $this->_twitter);
		}
	}

	function _fetchStatuses() {
		$res = array();
		if (isset($this->_twitter[$this->_name]['status_list'])) $statuses = $this->_twitter[$this->_name]['status_list'];
		else {
			$statuses = $this->_service->status->userTimeline();
			$this->_twitter[$this->_name]['status_list'] = $statuses;
			Zend_Registry::set('Vololo_Twitter', $this->_twitter);
		}
		if ($statuses && count($statuses) > 0) {
			foreach ($statuses as $el) {
				$d = $this->_parseStatus($el);
				$res[] = $d;
				$this->_twitter[$this->_name]['status_card'][$d['id']] = $d;
			}
		}
		return $res ? new Vololo_View_Data($res) : array();
	}

	function _searchStatuses($q, $_param = array()) {
		$res = array();
		$k = 'status_search_'.md5($q);
		if (isset($this->_twitter[$this->_name][$k])) $statuses = $this->_twitter[$this->_name][$k];
		else {
			$statuses = $this->_service->status->statusSearchTimeline($q, $_param);
			$this->_twitter[$this->_name][$k] = $statuses;
			Zend_Registry::set('Vololo_Twitter', $this->_twitter);
		}
		if ($statuses && $statuses->results && count($statuses) > 0) {
			foreach ($statuses->results as $el) {
				$d = $this->_parseStatus($el);
				$res[] = $d;
				$this->_twitter[$this->_name]['status_card'][$d['id']] = $d;
			}
		}
		return $res ? new Vololo_View_Data($res) : array();

	}

	function _parseStatus($el) {
		return array(
			'id' => (string)$el->id,
			'date' => date('Y-m-d H:i:s', strtotime((string)$el->created_at)),
			'message' => (string)$el->text,
			'from_user' => (string)$el->from_user
		);
	}

	function _update($msg) {
		$this->_service->status->update($msg);
	}
}
