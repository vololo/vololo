<?php

class Helper_Override extends Vololo_View_Helper_Override  {
	function overridePortfolio(&$r) {
		$r->is_new = (strtotime($r->date) + 86400 * 5) > time();
		$r->date_valid = ltrim(Vololo_Common::getDate($r->date, 'word'), '0');
		$r->date_create_valid = ltrim(Vololo_Common::getDate($r->date_create, 'word'), '0');
		$r->studia_url = '/studia/'.$r->studia_stitle;
		$r->url_valid = $r->studia_url.'/portfolio/'.$r->id;
		$r->url_full = 'http://'.$r->url;
	}

	function overrideBlog(&$r) {
		$r->is_new = (strtotime($r->date) + 86400 * 5) > time();
		$r->date_valid = ltrim(Vololo_Common::getDate($r->date, 'word'), '0');
		$r->date_create_valid = ltrim(Vololo_Common::getDate($r->date_create, 'word'), '0');
		$r->studia_url = '/studia/'.$r->studia_stitle;
		$r->url_valid = $r->studia_url.'/blog/'.$r->id;
	}

	function overrideStudia(&$r) {
		$diff = time() - strtotime(max($r->last_blog, $r->last_portfolio));
		if ($diff < 2592000) {
			$r->class = 'green';
			$r->class_title = 'Фигачат';
		}
		else if ($diff < 7776000) {
			$r->class = 'yellow';
			$r->class_title = 'Подзабили';
		}
		else if ($diff < 15552000) {
			$r->class = 'red';
			$r->class_title = 'Забили';
		}
		else $r->class_title = 'Тухляк';
		$r->url_valid = '/studia/'.$r->stitle;
	}

	function overrideTopic(&$r) {
		$r->is_new = (strtotime($r->topic_date_add) + 86400 * 5) > time();
		$r->topic_date_add_valid = ltrim(Vololo_Common::getDate($r->topic_date_add, 'word'), '0');
		$r->url_valid = '/blog/blog/'.($r->blog_stitle ? $r->blog_stitle.'/' : '').$r->topic_id.'.html';
		$r->url_user_valid = '/blog/profile/'.$r->user_stitle;
	}

	function overrideCommentonline(&$r) {
		$r->comment_date_valid = Vololo_Common::getDate($r->comment_date, 'H:i');
		$r->url_valid = '/blog/blog/'.($r->blog_stitle ? $r->blog_stitle.'/' : '').$r->topic_id.'.html#comment'.$r->comment_id;
		$r->url_user_valid = '/blog/profile/'.$r->user_stitle;
		$r->url_blog_valid = '/blog/'.($r->blog_stitle ? 'blog/'.$r->blog_stitle : 'my/'.$r->user_stitle);
	}

	function overrideEv(&$r) {
		$r->is_new = (strtotime($r->date) + 86400 * 5) > time();
		$r->date_valid = ltrim(Vololo_Common::getDate($r->date, 'word'), '0');
	}
}