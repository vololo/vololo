<?php

class Default_Model_Parser {
	function load($url) {
		return @file_get_contents($url);
		//$url = 'http://gatorsurf.com/images/nph-pr.cgi/010110A/http/'.str_ireplace('http://', '', $url);
		$ret = '';
		$d = explode('/', $url);
		$host = @$d[2];
		if ($host) {
			$ip = gethostbyname($host);
			if ($ip) {
				array_shift($d);array_shift($d);array_shift($d);
				$d = '/'.implode('/', $d);
				$ua = array(
					'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
					'Mozilla/5.0 (compatible; Yahoo! Slurp/3.0; http://help.yahoo.com/help/us/ysearch/slurp)',
					'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
					'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 MRA 5.6 (build 03278) Firefox/3.6.8 (.NET CLR 3.5.30729)',
					'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 ( .NET CLR 3.5.30729) WebMoney Advisor'
				);
				$data = array(
					"POST ".$d." HTTP/1.1\r\n" ,
					"Host: ".$host."\r\n"  ,
					"User-Agent: ".$ua[rand(0, count($ua) - 1)]."\r\n" ,
					"Content-Type: application/x-www-form-urlencoded\r\n" ,
					"Content-Length: ".strlen($q)."\r\n" ,
					"Connection: close\r\n\r\n" ,
					$q
				);
				$answer = '';
				$fp = fsockopen($ip, 80);
				if ($fp) {
					foreach($data as $row) fputs($fp, $row);
					$break = false;
					while(!feof($fp)) {
						$line = fread($fp, 10240);
						if (stripos($line, '404 Not Found') !== false) return '';
						$answer .= $line;
					}
					fclose($fp);
				}
				$ind = strpos($answer, "\r\n\r\n");
				$answer = trim(substr($answer, $ind));
				if ($answer) $ret = $answer;
			}
		}
		return $ret;
	}

	function cleanMessage($str) {
		 return trim(preg_replace(array(
			'/\ style\=\"text\-align\:\ justify\;\"/si',
		 	'/\<img[^\>]+\>/si',
		 	'/<(|\/)a[^\>]*>/si',
		 	'/\&quot\;/si',
		 	'/<(|\/)font[^\>]*>/si',
		 	'/<(|\/)span[^\>]*>/si',
		 	'/\&nbsp\;/si',
		 	'/\<p\>\<\/p\>/si',
		 	'/\<div\>\<\/div\>/si'
		), array('', '', '', '"', '', '', ' ', '', ''), $str));
	}

	function cleanMessageBlog($str) {
		 return trim(preg_replace(array(
			'/\ style\=\"text\-align\:\ justify\;\"/si',
		 	'/\&quot\;/si',
		 	'/<(|\/)font[^\>]*>/si',
		 	'/<(|\/)span[^\>]*>/si',
		 	'/\&nbsp\;/si',
		 	'/\<p\>\<\/p\>/si',
		 	'/\ (class|rel)=\"[^\"]*\"/si',
		 	'/\<div\>\<\/div\>/si'
		), array('', '"', '', '', ' ', '', '', ''), $str));
	}

	function cleanUrl($str) {
		 return @rtrim(str_ireplace('http://', '', trim($str)), '/');
	}

	function sortOid($data) {
		if ($data) {
			$sc = array();
			foreach ($data as $key => $row) {
			    $sc[$key]  = $row['oid'];
			}
			array_multisort($sc, SORT_ASC, $data);
		}
		return $data;
	}

	function parseJson($url) {
		$data = array();
		$c = @$this->load($url);
		if ($c) {
			try {
				$items = Zend_Json::decode($c);
				if ($items) {
					foreach ($items as $el) {
						$data[] = array(
							'oid' => $el['id'],
							'title' => $this->cleanMessage($el['title']),
							'url' => $el['url'] ? $this->cleanUrl($el['url']) : '',
							'src' => $el['src'],
							'message' => $this->cleanMessage($el['message']),
							'pic' => $el['image']
						);
					}
				}
			}
			catch (Exception $e) {

			}
		}
		return $data ? $data : false;
	}

	function parsePortfolioDf34() {
		$data = array();
		$c = $this->load('http://df34.ru/portfolio/preview/sites/');
		preg_match_all('/class\=\"work\-preview\"\>\<a\ href\=\"([^\"]+)/si', $c, $links);
		if (@$links[1]) {
			foreach (@$links[1] as $k => $el) {
				$c = $this->load('http://df34.ru'.$el);
				preg_match('/class\=\"portfolio\-content\"\>(.*?)\<div\ class\=\"hFooter/si', $c, $res);
				$c = @$res[1];
				if ($c) {
					preg_match('/H1\>([^\<]+)/si', $c, $title);
					preg_match('/p\>\<a\ href\=\"([^\"]+)/si', $c, $link);
					preg_match('/div\ class\=\"work\-img\"\>\<img\ alt\=\"\"\ src\=\"([^\"]+)/si', $c, $image);
					preg_match_all('/p\>(.*?)\<\/p/si', $c, $message);
					$mes = array();
					if ($message) {
						foreach ($message[1] as $el1) {
							if (mb_strlen(strip_tags($el1)) > 40 && !stripos($el1, @$link[1])) $mes[] = $el1;
						}
					}
					$id = md5($el);
					$data[] = array(
						'oid' => $id,
						'title' => $this->cleanMessage(@$title[1]),
						'url' => $link ? $this->cleanUrl(@$link[1]) : '',
						'src' => 'http://df34.ru'.$el,
						'message' => $mes ? $this->cleanMessage('<p>'.implode('</p><p>', $mes).'</p>') : '',
						'pic' => $image ? 'http://df34.ru'.$image[1] : ''
					);
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioOnvolga() {
		$data = array();
		$c = $this->load('http://onvolga.ru/portfolio/web-studio-sozdanie-sitov.html');
		preg_match_all('/href\=\"([^\"]+)"\ class\=\"contentpagetitle/si', $c, $links);
		if (@$links[1]) {
			foreach (@$links[1] as $k => $el) {
				$c = $this->load('http://onvolga.ru'.$el);
				preg_match('/img\ height\=\"180\"\ width\=\"250\"\ src\=\"([^\"]+)\"/si', $c, $image);
				preg_match('/class\=\"contentpagetitle\"\>([^\<]+)\<\/a/si', $c, $title);
				preg_match('/class\=\"article\-content\"\>(.*?)\<span\ class\=\"article\_separator/si', $c, $message);
				$message = preg_replace('/\<div\ class\=\"tag\"\>(.*?)\<\/div\>/si', '', @$message[1]);
				$message = preg_replace('/\<\/div\>\<\/div\>/si', '</div>', $message);
				preg_match('/(target\=\"\_blank\"\ |)href\=\"([^\"]+)/si', $message, $link);

				$id = md5($el);
				$data[] = array(
					'oid' => $id,
					'title' => $this->cleanMessage(@$title[1]),
					'url' => $link ? $this->cleanUrl((@$link[2] == '/index.php' ? 'http://onvolga.ru' : @$link[2])) : '',
					'src' => 'http://onvolga.ru'.$el,
					'message' => $this->cleanMessage($message),
					'pic' => $image ? 'http://onvolga.ru'.$image[1] : ''
				);
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioActual() {
		$data = array();
		$c = $this->load('http://www.actual-media.ru/portfolio/');
		preg_match_all('/class\=\"portfolio\_item\"\ id\=\"num(\d+)\"\>(.*?)\<\!\-\-END/si', $c, $links);
		if (@$links[2]) {
			foreach (@$links[2] as $k => $el) {
				preg_match('/src\=\"([^\"]+)\"/si', $el, $image);
				preg_match('/h3\>([^\<]+)/si', $el, $title);
				preg_match('/Сайт\:\<\/span\>\<a\ href\=\"([^\"]+)/si', $el, $link);
				preg_match('/Описание\:\<\/span\>\<em\>(.*?)\<\/em/si', $el, $message);
				$id = @(int)$links[1][$k];
				$data[] = array(
					'oid' => $id,
					'title' => $this->cleanMessage(@$title[1]),
					'url' => $link ? $this->cleanUrl(@$link[1]) : '',
					'src' => 'http://www.actual-media.ru/portfolio/#num'.$id,
					'message' => $this->cleanMessage(@$message[1]),
					'pic' => $image ? 'http://www.actual-media.ru'.$image[1] : ''
				);
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioTs() {
		$data = array();
		for ($i = 2010; $i <= date('Y'); $i++) {
			$c = $this->load('http://www.tsikoliya.ru/index.php/sajty-sdelannye-v-'.$i.'.html');
			preg_match_all('/a\ href\=\"\/index\.php\/sajty\-sdelannye\-v\-'.$i.'\/([^\"]+)\"\>([^\<]+)/si', $c, $links);
			if (@$links[1]) {
				foreach (@$links[1] as $k => $el) {
					$c = $this->load('http://www.tsikoliya.ru/index.php/sajty-sdelannye-v-'.$i.'/'.$el);
					if ($c) {
						preg_match('/table\ class\=\"contentpaneopen\"\>(.*?)\<\/table/si', $c, $res);
						if (@$res[1]) {
							preg_match('/img\ src\=\"([^\"]+)/si', $res[1], $image);
							preg_match('/a\ href\=\"([^\"]+)/si', $res[1], $link);
							preg_match_all('/p(\ style\=\"text\-align\:\ justify\;\"|\ style\=\"text\-align\:\ left\;\"|)\>(.*?)\<\/p/si', $res[1], $message);
							$message = @$message[2] ? '<p>'.implode('</p><p>', $message[2]).'</p>' : '';
							$message = preg_replace('/(href|src)\=\"\//si', '$1="http://www.tsikoliya.ru/', $message);
							$link = $link ? $this->cleanUrl($link[1]) : '';
							$data[] = array(
								'oid' => md5($el),
								'title' => $this->cleanMessage(@$links[2][$k]),
								'url' => substr($link, 0, 1) == '/' ? '' : $link,
								'src' => 'http://www.tsikoliya.ru/index.php/sajty-sdelannye-v-'.$i.'/'.$el,
								'message' => $message,
								'pic' => $image ? 'http://www.tsikoliya.ru'.$image[1] : ''
							);
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioWebv() {
		$data = array();
		$c = $this->load('http://web-v.ru/sites.php');
		$c = @iconv('windows-1251', 'utf-8', $c);
		preg_match_all('/a\ href\=\"sites\_([^\.]+)\.php\"\ class\=\"f12\_s/si', $c, $links);
		if (@$links[1]) {
			foreach (@$links[1] as $el) {
				$c = $this->load('http://web-v.ru/sites_'.$el.'.php');
				$c = @iconv('windows-1251', 'utf-8', $c);
				if ($c) {
					preg_match('/class\=\"left\_contact.*?src\=\"img\/([^\"]+).*?class\=\"right\_contact/si', $c, $image);
					preg_match('/p\ class\=\"f16\"\ style\=\"margin\-left\:\ 39px\"\>([^\<]+)/si', $c, $title);
					preg_match('/p\ style\=\"margin\-left\:\ 40px\"\>(.*?)\<a/si', $c, $message);
					preg_match('/a\ class\=\"s\"\ href\=\"([^\"]+)/si', $c, $link);
					$data[] = array(
						'oid' => $el,
						'title' => $this->cleanMessage(@$title[1]),
						'url' => $this->cleanUrl($link[1]),
						'src' => 'http://web-v.ru/sites_'.$el.'.php',
						'message' => $this->cleanMessage(@$message[1]),
						'pic' => $image ? 'http://web-v.ru/img/'.$image[1] : ''
					);
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioBalt() {
		$data = array();
		$c = $this->load('http://b-alt.ru');
		$c = @iconv('windows-1251', 'utf-8', $c);
		preg_match_all('/div\ class\=\"project\"\>(.*?)\<\/div/si', $c, $els);
		if (@$els[1]) {
			foreach ($els[1] as $el) {
				preg_match('/h4\>(.*?)\<a/si', $el, $title);
				if (!@$title[1]) continue;
				preg_match('/a\ href\=\"http\:\/\/([^\"]+)/si', $el, $link);
				preg_match('/span\ class\=\"middle\"\>(.*?)\<span\ class\=\"bottom/si', $el, $message);
				$data[] = array(
					'oid' => md5(@$title[1]),
					'title' => $this->cleanMessage(@strip_tags($title[1])),
					'url' => $this->cleanUrl($link[1]),
					'src' => 'http://b-alt.ru',
					'message' => $this->cleanMessage(@$message[1]),
					'pic' => ''
				);
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioMagwai() {
		return array();
	}

	function parsePortfolioUnique() {
		return array();
	}

	function parsePortfolioPlexonline() {
		$data = array();
		$c = $this->load('http://www.plexonline.ru/index.php?page=portfolio');
		$c = @iconv('windows-1251', 'utf-8', $c);
		preg_match('/720\" cellpadding\=\"0\"\ cellspacing\=\"0\"\>(.*?)\<\/table/si', $c, $res);
		preg_match_all('/valign\=\"top\"\>(.*?)\<\/td/si', @$res[1], $tds);
		if (@$tds[1]) {
			foreach ($tds[1] as $td) {
				preg_match('/href\=\"pages\/portfolioid\.php\?\&id\=(\d+)/si', $td, $id);
				preg_match('/href\=\"http\:\/\/([^\"]+)/si', $td, $url);
				preg_match('/br\>([^\<]+)/si', $td, $title);
				if (!@(int)$id[1]) continue;
				$data[] = array(
					'oid' => (int)$id[1],
					'title' => $this->cleanMessage(@$title[1]),
					'url' => $this->cleanUrl(@$url[1]),
					'src' => 'http://www.plexonline.ru/pages/portfolioid.php?&id='.(int)$id[1],
					'message' => '',
					'pic' => 'http://www.plexonline.ru/portfolio/portfolio'.(int)$id[1].'.jpg'
				);
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioModesco() {
		$data = array();
		$urls = array(
			'http://modesco.ru/index.html',
			'http://modesco.ru/index2.html'
		);
		foreach ($urls as $el) {
			$c = $this->load($el);
			if ($c) {
				$c = @iconv('windows-1251', 'utf-8', $c);
				preg_match('/table\ align\=\"left\"\ width\=\"100\%\"\ border\=\"0px\"\ cellpadding\=\"0\"\ cellspacing\=\"0\"\>(.*?)\<\/table/si', $c, $res);
				if (@$res[1]) {
					preg_match_all('/tr\>(.*?)\<\/tr/si', $res[1], $trs);
					if (@$trs[1]) {
						foreach ($trs[1] as $item) {
							preg_match('/img\ src\=\"([^\"]+)/si', $item, $image);
							preg_match('/target\=\_blank\ href\=\"([^\"]+)\"\>([^\<]+)/si', $item, $url);
							preg_match('/valign\=\"top\"\>(.*?)\<\/td/si', $item, $message);
							$title = $this->cleanMessage($url[2]);
							if (!$title) continue;
							$id = md5($title);
							$url = $this->cleanUrl($url[1]);
							$data[] = array(
								'oid' => $id,
								'title' => $title,
								'url' => $url ? $url : '',
								'src' => $el,
								'message' => $this->cleanMessage($message[1]),
								'pic' => @$image[1] ? 'http://modesco.ru/'.trim($image[1]) : ''
							);
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioKe() {
		$data = array();
		$c = $this->load('http://konovalovershov.ru');
		if ($c) {
			$c = @iconv('windows-1251', 'utf-8', $c);
			preg_match('/работы\:\<\/a\>(.*?)\<\/td/si', $c, $res);
			if (@$res[1]) {
				preg_match_all('/href\=\"([^\"]+)\"\ target\=\"\_blank\"\>([^\<]+)/si', $res[1], $links);
				if (@$links[1]) {
					foreach ($links[1] as $k => $oid) {
						$id = md5($oid);
						$data[] = array(
							'oid' => $id,
							'title' => $this->cleanMessage($links[2][$k]),
							'url' => $oid && $oid != '#' ? $this->cleanUrl($oid) : '',
							'src' => 'http://konovalovershov.ru',
							'message' => '',
							'pic' => ''
						);
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioStudia7() {
		$data = array();
		$c = $this->load('http://studia7.com/webdesign');
		if ($c) {
			preg_match('/section\ class\=\"blog\"\>(.*?)\<\/section/si', $c, $res);
			if (@$res[1]) {
				preg_match_all('/class\=\"blog\_readmore\"\ href\=\"([^\"]+)/si', $res[1], $links);
				if (@$links[1]) {
					foreach ($links[1] as $k => $el) {
						$c = $this->load('http://studia7.com'.$el);
						preg_match('/article\ class\=\"item\-page\"\>(.*?)\<\/article/si', $c, $res);
						if (@$res[1]) {
							preg_match('/h2\>([^\<]+)\<\/h2/si', $res[1], $title);
							preg_match('/div\ class\=\"work\_descript\"\>(.*?)\<div\ class\=\"work\_developers/si', $res[1], $message);
							$message = preg_replace('/(\<\/div\>$|\<p\>\<br\ \/\>\<\/p\>)/si', '', trim(@$message[1]));
							preg_match('/class\=\"work\_images\"\>(.*?)\<\/div/si', $res[1], $image);
							if (@$image[1]) {
								preg_match_all('/img\ src\=\"([^\"]+)/si', $image[1], $image);
								$image = @$image[1][0];
							}
							preg_match('/class\=\"work\_developers\"\>.*?a\ href\=\"([^\"]+)/si', $res[1], $link);
							$id = md5($el);
							$data[] = array(
								'oid' => $id,
								'title' => $this->cleanMessage(@$title[1]),
								'url' => @$link[1] ? $this->cleanUrl($link[1]) : '',
								'src' => 'http://studia7.com'.$el,
								'message' => $this->cleanMessage($message),
								'pic' => $image ? 'http://studia7.com'.$image : ''
							);
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioVivastudio() {
		$data = array();
		$c = $this->load('http://vivastudio.ru/portfolio.php');
		if ($c) {
			$c = @iconv('windows-1251', 'utf-8', $c);
			preg_match('/div\ id\=\"menusites\"\>(.*?)\<\/div/si', $c, $res);
			if (@$res[1]) {
				preg_match_all('/href\=\"\/portfolio\/([^\"]+)\"\ (|\ )title\=\"[^\"]+\"\>([^\<]+)/si', $res[1], $links);
				if (@$links[1]) {
					foreach ($links[1] as $k => $oid) {
						$c = $this->load('http://vivastudio.ru/portfolio/'.$oid);
						if ($c) {
							$c = @iconv('windows-1251', 'utf-8', $c);
							$id = md5($oid);
							preg_match('/div\ id\=\"content1\"\>(.*?)\<table/si', $c, $message);
							preg_match('/ex\>\<a\ \ rel\=\\\'nofollow\\\'\ \ href\=\\\'([^\\\']+)/si', $c, $url);
							if (!@$url[1]) preg_match('/Ссылка\ на\ сайт\:\ \<a\ \ href\=\"([^\"]+)/si', $c, $url);
							preg_match('/img\ src=\\\'\/portfolio\/([^\\\']+)/si', $c, $image);
							$data[] = array(
								'oid' => $id,
								'title' => $this->cleanMessage($links[3][$k]),
								'url' => $this->cleanUrl($url[1]),
								'src' => 'http://vivastudio.ru/portfolio/'.$oid,
								'message' => $this->cleanMessage($message[1]),
								'pic' => @$image[1] ? 'http://vivastudio.ru/portfolio/'.$image[1] : ''
							);
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioArtnet() {
		$data = array();
		$c = $this->load('http://artnet-studio.ru/portfolio.html?id=8&page=1');
		if ($c) {
			$c = @iconv('windows-1251', 'utf-8', $c);
			preg_match_all('/\-\ \<a\ href\=\"\/portfolio\.html\?id\=(\d+)\"/si', $c, $years);
			if (@$years[1]) {
				foreach ($years[1] as $y) {
					if (($y == 9 || $y == 12) && $y < 132) continue;
					$c = $this->load('http://artnet-studio.ru/portfolio.html?id='.$y.'&page=1');
					if ($c) {
						$c = @iconv('windows-1251', 'utf-8', $c);
						preg_match_all('/\>(\d+)\<\/option/si', $c, $pages);
						if (@$pages[1]) {
							for ($i = 0; $i < ceil(count($pages[1]) / 2); $i++) {
								$c = $this->load('http://artnet-studio.ru/portfolio.html?id='.$y.'&page='.$pages[1][$i]);
								if ($c) {
									$c = @iconv('windows-1251', 'utf-8', $c);
									preg_match_all('/td\ colspan\=\"2\"\>(.*?)tr\>(\	\ \ \	\ \ \<tr|\	\ \ \<\/table)/si', $c, $items);
									if (@$items[1]) {
										foreach ($items[1] as $item) {
											preg_match('/a\ href\=\"\/portfolio\/view\/(\d+)\.html/si', $item, $id);
											if (@$id[1]) {
												preg_match('/h3\>([^\<]+)/si', $item, $title);
												preg_match('/\&nbsp\;\&nbsp\;\&nbsp\;\&nbsp\;\&nbsp\;\&nbsp\;\&nbsp\;\ (.*?)\<\/div/si', $item, $message);
												preg_match('/src\=\"files\/([^\"]+)/si', $item, $image);
												preg_match('/target\=\"\_blank\"\ href\=\"([^\"]+)/si', $item, $link);
												$data[] = array(
													'oid' => $id[1],
													'title' => $this->cleanMessage($title[1]),
													'url' => $link[1] ? $this->cleanUrl($link[1]) : '',
													'src' => 'http://artnet-studio.ru/portfolio/view/'.$id[1].'.html',
													'message' => $this->cleanMessage($message[1]),
													'pic' => @$image[1] ? 'http://artnet-studio.ru/files/'.trim(str_replace('tm_', 'tb_', $image[1])) : ''
												);
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioInweb() {
		$data = array();
		$c = $this->load('http://inweb.ru/portfolio');
		if ($c) {
			$c = @iconv('windows-1251', 'utf-8', $c);
			preg_match('/table\ border\=\"0\"\ cellpadding\=\"0\"\ cellspacing\=\"0\"\ width\=\"100\%\"\>(.*?)\<\/table/si', $c, $res);
			if (@$res[1]) {
				preg_match_all('/a\ target\=\"\_blank\"\ href\=\"([^\"]+)\"\ style\=\"color\:\#00508c\;\ font\-size\:14px\;\"\>([^\<]+)/si', $res[1], $links);
				preg_match_all('/img\ border\=\"0\"\ width\=\"200\"\ height\=\"124\"\ src\=\"([^\"]+)/si', $res[1], $images);
				if (@$links[1]) {
					foreach ($links[1] as $k => $el) {
						$data[] = array(
							'oid' => md5($links[2][$k]),
							'title' => $this->cleanMessage($links[2][$k]),
							'url' => $this->cleanUrl(@$el),
							'src' => 'http://inweb.ru/portfolio',
							'message' => '',
							'pic' => @$images[1][$k] ? 'http://inweb.ru'.$images[1][$k] : ''
						);
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioRw1() {
		$data = array();
		$c = $this->load('http://rw1.ru/component/option,com_portfol/Itemid,70/');
		if ($c) {
			$c = @iconv('windows-1251', 'utf-8', $c);
			preg_match_all('/tr\ class\=\"sectiontableentry\"\d+\"\>(.*?)\<\/tr/si', $c, $items);
			if (@$items[1]) {
				foreach ($items[1] as $item) {
					preg_match('/refid\=(\d+)/si', $item, $id);
					if (@(int)$id[1]) {
						preg_match('/src\=\/home\/rw1ru\/domains\/rw1\.ru\/public\_html\/images\/portfolio\/([^\&]+)/si', $item, $image);
						preg_match('/a\ href\=\"([^\"]+)\"\ target\=\"\_blank/si', $item, $link);
						preg_match('/a\ style\=\"font\-weight\:bold\;\ color\:\#254459\;\ text\-decoration\:underline\;\"\ href\=\"([^\"]+)\"\ title\=\".*?\"\>([^\<]+)/si', $item, $src_title);
						preg_match('/Вид\ услуг\:\<\/span\>\&nbsp\;(.*?)\<\/div/si', $item, $message);
						$data[] = array(
							'oid' => (int)$id[1],
							'title' => $this->cleanMessage(strip_tags($src_title[2])),
							'url' => $link[1] ? $this->cleanUrl($link[1]) : '',
							'src' => $src_title[1] ? 'http://rw1.ru/'.trim($src_title[1]) : '',
							'message' => $this->cleanMessage($message[1]),
							'pic' => @$image[1] ? 'http://rw1.ru/images/portfolio/'.trim($image[1]) : ''
						);
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioMfrog() {
		$data = array();
		$c = $this->load('http://mfrog.ru/portfolio/type/1');
		if ($c) {
			preg_match_all('/href\=\"http\:\/\/mfrog\.ru\/portfolio\/type\/1\/page\/([^\"]+)/si', $c, $pages);
			if ($pages[1]) {
				foreach ($pages[1] as $page) {
					$c = $this->load('http://mfrog.ru/portfolio/type/1/page/'.$page);
					if ($c) {
						preg_match_all('/label\>\<a\ href\=\"([^\"]+)/si', $c, $links);
						if ($links[1]) {
							foreach ($links[1] as $link) {
								$c = $this->load($link);
								if ($c) {
									$c = @iconv('windows-1251', 'utf-8', $c);
									$id = explode('/', $link);
									$id = $id[count($id) - 1];
									preg_match('/h1\>([^\<]+)/si', $c, $title);
									preg_match('/href\=\"([^\"]+)\"\ class\=\"site\-link/si', $c, $link1);
									preg_match('/img\ class\=\"grp\"\ src\=\"([^\"]+)/si', $c, $image);
									$data[] = array(
										'oid' => $id,
										'title' => $this->cleanMessage(strip_tags($title[1])),
										'url' => $link1[1] ? $this->cleanUrl($link1[1]) : '',
										'src' => $link,
										'message' => '',
										'pic' => @$image[1] ? $image[1] : ''
									);
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioStride() {
		$data = array();
		for  ($id = 1; $id < 150; $id++) {
			$c = $this->load('http://stride.ru/portfolio/?subcatid=17&objid='.$id);
			if ($c) {
				$c = @iconv('windows-1251', 'utf-8', $c);
				if (stripos($c, '<p class="header3">сайты</p>') === false) continue;
				preg_match('/p\ class\=\"header2\"\>\<span\ class\=\"big\"\>(.*?)\<\/span/si', $c, $title);
				if (@$title[1]) {
					$c = explode('<p class="header">Задача</p>', $c);
					$c = @$c[1];
					$c = explode('<br style="line-height: 45px;">', $c);
					$c = @$c[0];
					preg_match('/class\=\"attention\"\>\<a\ href\=\"([^\"]+)/si', $c, $link);

					preg_match('/src\=\"\/izo\/portfolio\/([^\"]+)/si', $c, $image);
					$message = preg_replace(array(
						'/\<(|\/)div\>/si',
						'/\<p\ style\=\"text\-align\:\ center\;\"\>(\<img|\&nbsp\;).*?\<\/p\>/si',
						'/\<p\ style\=\"text\-align\:\ center\;\"\>\<span\ class\=\"attention\"\>.*?\<\/p\>/si',
						'/\<p\ class\=\"header\"\>.*?\<\/p\>/si',
						'/\<p\>\&nbsp\;\<\/p\>/si',
						'/(href|src)\=\"\//si'
					), array(
						'',
						'',
						'',
						'',
						'',
						'$1="http://stride.ru/'
					), $c);
					if (!@$link[1]) {
						preg_match('/\>([a-z\.\-\_]+?)\</si', $message, $link);
					}
					$data[] = array(
						'oid' => $id,
						'title' => reverse_htmlentities(trim($this->cleanMessage($title[1]))),
						'url' => @$link[1] ? $this->cleanUrl($link[1]) : '',
						'src' => 'http://stride.ru/portfolio/?subcatid=17&objid='.$id,
						'message' => $this->cleanMessage($message),
						'pic' => $image ? 'http://stride.ru/izo/portfolio/'.$image[1] : ''
					);
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioJinnweb() {
		$data = array();
		$c = $this->load('http://jinnweb.ru/portfolio/');
		if ($c) {
			$c = @iconv('windows-1251', 'utf-8', $c);
			preg_match_all('/a\ href\=\"http\:\/\/jinnweb\.ru\/portfolio\/([^\/]+)\/\">Подробнее\ \»\<\/a/si', $c, $links);
			if (@$links[1]) {
				foreach ($links[1] as $id) {
					$c = $this->load('http://jinnweb.ru/portfolio/'.$id.'/');
					if ($c) {
						$c = @iconv('windows-1251', 'utf-8', $c);
						preg_match('/div\ class\=\"caption\"\>([^\<]+)/si', $c, $title);
						if (!@trim($title[1])) preg_match('/span\ class\=\"capt\"\>([^\<]+)/si', $c, $title);
						preg_match('/ou\(\"([^\"]+)/si', $c, $link);
						preg_match('/img\_big\(\\\'([^\\\']+)/si', $c, $image);
						preg_match('/div\ class\=\"desc\"\>(.*?)\<\/div/si', $c, $message);
						$data[] = array(
							'oid' => $id,
							'title' => $this->cleanMessage($title[1]),
							'url' => $link[1] ? $this->cleanUrl($link[1]) : '',
							'src' => 'http://jinnweb.ru/portfolio/'.$id.'/',
							'message' => $this->cleanMessage($message[1]),
							'pic' => $image ? 'http://jinnweb.ru'.trim($image[1]) : ''
						);
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolio21age() {
		$data = array();
		$c = $this->load('http://www.21age.ru/portfolio.html');
		if ($c) {
			preg_match_all('/portfolio\.html\?start\=([^\"]+)\"\ class\=\"pagenav/si', $c, $pages);
			if (@$pages[1]) {
				array_unshift($pages[1], '0');
				array_pop($pages[1]);
				array_pop($pages[1]);
				foreach ($pages[1] as $el) {
					$c = $this->load('http://www.21age.ru/portfolio.html?start='.$el);
					if ($c) {
						preg_match_all('/div\ class\=\"yjround\_content\_j\"\>(.*?)\<p\>Виды\ работ/si', $c, $items);
						if (@$items[1]) {
							foreach ($items[1] as $item) {
								preg_match('/h2\>([^\<]+)/si', $item, $title);
								preg_match('/href\=\"\/images\/stories\/portfol\/([^\"]+)/si', $item, $image);
								preg_match('/a\ target\=\"\_blank\"\ href\=\"([^\"]+)/si', $item, $link);
								$tit = $this->cleanMessage($title[1]);
								$id = md5($tit);
								$data[] = array(
									'oid' => $id,
									'title' => $tit,
									'url' => $link[1] ? $this->cleanUrl($link[1]) : '',
									'src' => 'http://www.21age.ru/portfolio.html?start='.$el,
									'message' => '',
									'pic' => 'http://www.21age.ru/images/stories/portfol/'.trim($image[1])
								);

							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioWebpp() {
		$data = array();
		$c = $this->load('http://www.webpp.ru/portfolio/');
		if ($c) {
			preg_match_all('/a\ class\=\"loupe\"\ href\=\"([^\"]+)/si', $c, $res);
			if (@$res[1]) {
				foreach ($res[1] as $el) {
					$c = $this->load('http://www.webpp.ru'.$el);
					if ($c) {
						preg_match('/class\=\"portfolio\-element\-title\"\>(.*?)\<h3\>Работы\ в\ этом\ году\<\/h3/si', $c, $c);
						$c = @$c[1];
						preg_match('/class\=\"portfolio\-element\-navigation\"\>(.*?)\<\/div/si', $c, $link);
						preg_match('/img\ src\=\"([^\"]+)/si', $c, $image);
						preg_match('/h3\>([^\<]+)/si', $c, $title);
						preg_match('/div\ class\=\"text\"\>(.*?)\<\/div/si', $c, $message);
						$cc = preg_replace(array(
							'/\<p\>\<a\ href\=\"[^\"]+\"\>[^\<]+\<\/a\>\<\/p\>/si'
						), array('', ''), $message[1]);
						$data[] = array(
							'oid' => md5($el),
							'title' => $this->cleanMessage($title[1]),
							'url' => $link ? $this->cleanUrl(strip_tags($link[1])) : '',
							'src' => 'http://www.webpp.ru'.$el,
							'message' => $this->cleanMessage($cc),
							'pic' => $image ? 'http://www.webpp.ru'.trim($image[1]) : ''
						);
					}
				}
			}
		}

/*
		for ($year = 2007; $year <= date('Y'); $year++) {
			$c = $this->load('http://www.webpp.ru/portfolio/'.$year.'/');
			preg_match('/ul\ class\=\"list\ portfolio\-list\"\>(.*?)\<\/ul/si', $c, $res);
			if (@$res[1]) {
				preg_match_all('/href\=\"\/portfolio\/view\/([\d]+)\/\"/si', $res[1], $items);
				if (@$items[1]) {
					foreach ($items[1] as $id) {
						$c = $this->load('http://www.webpp.ru//portfolio/view/'.$id.'/');
						if ($c) {
							preg_match('/div\ class\=\"portfolio\"\>(.*?)\<h3/si', $c, $message);
							if ($message) {
								preg_match('/\<p\>\<a\ href\=\"([^\"]+)\"\>[^\<]+\<\/a\>\<\/p/si', $message[1], $link);
								preg_match('/img\ class\=\"large\"\ src\=\"([^\"]+)/si', $c, $image);
								preg_match('/h2\ class\=\"nb\"\>([^\<]+)/si', $c, $title);
								$cc = preg_replace(array(
									'/\<p\>\<a\ href\=\"[^\"]+\"\>[^\<]+\<\/a\>\<\/p\>/si'
								), array('', ''), $message[1]);
								$data[] = array(
									'oid' => $id,
									'title' => $this->cleanMessage($title[1]),
									'url' => $link ? $this->cleanUrl($link[1]) : '',
									'src' => 'http://www.webpp.ru/portfolio/view/'.$id.'/',
									'message' => $this->cleanMessage($cc),
									'pic' => $image ? 'http://www.webpp.ru'.trim($image[1]) : ''
								);
							}
						}
					}
				}
			}
		}*/
		return $this->sortOid($data);
	}

	function parsePortfolioIrcit() {
		$data = array();
		$c = $this->load('http://www.ircit.ru/works/websites/');
		if ($c) {
			preg_match('/div\ class\=\"page\"\>\<table\>(.*?)\<\/table\>\<\/div/si', $c, $res);
			if (@$res[1]) {
				preg_match_all('/a\ href\=\"\/works\/websites\/\?PAGEN\_1\=([\d]+)/si', $res[1], $pages);
				if (@$pages[1]) {
					array_unshift($pages[1], 1);
					foreach ($pages[1] as $page) {
						$c = $this->load('http://www.ircit.ru/works/websites/?PAGEN_1='.$page);
						if ($c) {
							preg_match_all('/a\ href\=\"\/works\/websites\/([^\"]+)\"\>\<img\ class\=\"preview/si', $c, $links);
							if (@$links[1]) {
								foreach ($links[1] as $el) {
									$id = trim(str_replace('/', '_', $el), '_');
									if ($id == 'site') continue;
									$c = $this->load('http://www.ircit.ru/works/websites/'.$el);
									if ($c) {
										$c = @iconv('windows-1251', 'utf-8', $c);
										preg_match('/align\=\"left\"\ valign\=\"middle\"\>\<a\ href\=\"([^\"]+)/si', $c, $link);
										preg_match('/class\=\"tabs\.items\"\>(.*?)\<div\ align\=\"center/si', $c, $message);
										preg_match('/align\=\"center\"\>\<br\ \/\>\<img\ border\=\"0\"\ src\=\"([^\"]+)/si', $c, $image);
										preg_match('/div\ class\=\"line\"\>\<h1\>([^\<]+)/si', $c, $title);
										$data[] = array(
											'oid' => $id,
											'title' => $this->cleanMessage($title[1]),
											'url' => $link ? $this->cleanUrl($link[1]) : '',
											'src' => 'http://www.ircit.ru/works/websites/'.$el,
											'message' => $this->cleanMessage($message[1]),
											'pic' => $image ? 'http://www.ircit.ru'.trim($image[1]) : ''
										);
									}
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioWebdecision() {
		$data = array();
		$years = array();
		for ($year = 2004; $year <= date('Y'); $year++) {
			for ($id = 1; $id < 30; $id++) {
				$c = $this->load('http://web-decision.ru/folio/site'.$year.'/'.$id.'.php');
				if ($c) {
					$c = @iconv('windows-1251', 'utf-8', $c);
					$i = stripos($c, '<div class="block-folio2-left">');
					if ($i !== false) {
						$c = substr($c, $i);
						$i = stripos($c, '</td></tr>');
						if ($i !== false) {
							$cc = $c = substr($c, 0, $i);
							preg_match('/href\=\"([^\"]+)/si', $c, $link);
							preg_match('/span\ style\=\"font\-size\:14pt\"\>(.*?)\<p/si', $c, $title);
							preg_match('/(target\=\"\_blank\"\>|block\-folio2\-right\"\>[^\<]*)\<img\ src\=\"([^\"]+)/si', $c, $image);
							$i = stripos($c, '</span>');
							if ($i !== false) {
								$cc = substr($c, $i + 7);
								$i = stripos($cc, '</div>');
								if ($i !== false) {
									$cc = substr($cc, 0, $i);
								}
							}
							$cc = preg_replace(array(
								'/\<p\>\<strong\>Адрес.*?\<\/p\>/si',
								'/\<p\>\<strong\>Год.*?\<\/p\>/si'
							), array('', ''), $cc);
							$link = $this->cleanUrl($link[1]);
							$title = trim(strip_tags(str_replace("\n", '', $title[1])));
							while (stripos($title, '  ') !== false) $title = str_replace('  ', ' ', $title);
							$data[] = array(
								'oid' => $year.$id,
								'title' => $this->cleanMessage($title),
								'url' => $link && substr($link, 0, 2 != '..') ? $link : '',
								'src' => 'http://web-decision.ru/folio/site'.$year.'/'.$id.'.php',
								'message' => $this->cleanMessage($cc),
								'pic' => $image[2] ? 'http://web-decision.ru'.str_replace('../', '/folio/', trim($image[2])) : ''
							);
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioClickon() {
		$data = array();
		$c = $this->load('http://www.clickon.ru/portfolio/date/');
		$i = stripos($c, '<div id="by-date">');
		if ($i !== false) {
			$c = substr($c, $i);
			$i = stripos($c, '<div id="sideBar">');
			if ($i !== false) {
				$c = substr($c, 0, $i);
				preg_match_all('/href\=\"\/portfolio\/sites\/([\d]+)\.work\"\>([^\<]+)/si', $c, $all);
				if (@$all[1]) {
					foreach ($all[1] as $k => $id) {
						if ($id == 1445) continue;
						$c = $this->load('http://www.clickon.ru/portfolio/sites/'.$id.'.work');
						if ($c) {
							if (stripos($c, 'name="piar"') !== false) continue;
							$i = stripos($c, '<div id="onework">');
							if ($i !== false) {
								$cc = substr($c, $i);
								$i = stripos($cc, '<div id="navigator">');
								if ($i !== false) {
									$cc = substr($cc, 18, $i - 27);
									$i = stripos($cc, '<big>Представитель клиента');
									if ($i !== false) $c = substr($cc, $i);
									preg_match('/class\=\"ext\ up\"\ href\=\"([^\"]+)/si', $c, $link);
									$cc = preg_replace(array(
										'/\<big\>\<a\ name\=\"[^\"]+\"\>[^\<]+\<\/a\>\<\/big\>\n\<br\/\>/si',
										'/\<h2\>[^\<]+\<\/h2\>/si'
									), array('', ''), $cc);
									$data[] = array(
										'oid' => $id,
										'title' => $this->cleanMessage($all[2][$k]),
										'url' => @$this->cleanUrl($link[1]),
										'src' => 'http://www.clickon.ru/portfolio/sites/'.$id.'.work',
										'message' => $this->cleanMessage($cc),
										'pic' => ''
									);
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parsePortfolioIntervolga() {
		$data = array();
		$page = 1;
		$ok = true;
		while ($ok) {
			$c = $this->load('http://intervolga.ru/port/all/all/page/'.$page);
			$i = stripos($c, '<div class="portfolioSection">');
			if ($i === false) $ok = false;
			else {
				$c = substr($c, $i);
				$i = stripos($c, 'portfolioWorks');
				if ($i === false) $ok = false;
				else {
					$c = substr($c, 0, $i);
					preg_match_all('/div\ class\=\"img\"\>\<a\ href\=\"\/port\/all\/all\/show\/([\d]+)\/\"\>\<img\ class\=\"imgfade\"\ src\=\"\/var\/portel0\/\d+\.([^\"]+)/si', $c, $id_img);
					preg_match_all('/h3\>\<a\ href\=\"\/port\/all\/all\/show\/\d+\/\"\>([^\<]+)/si', $c, $title);
					preg_match_all('/h3\>\<a\ href\=\"\/port\/all\/all\/show\/\d+\/\"\>([^\<]+)/si', $c, $title);
					preg_match_all('/\<\/em\>[^\<]*\<p\>(.*?)\<\/p\>[^\<]*\<ul\>/si', $c, $message);
					if (@$id_img[1] && count($id_img[1]) == count($title[1])) {
						foreach ($id_img[1] as $k => $id) {
							$full = $this->load('http://intervolga.ru/port/all/all/show/'.$id.'/');
							preg_match('/h3\>\<a\ href\ \=\ \"([^\"]+)/si', $full, $full_res);
							$data[] = array(
								'oid' => $id,
								'title' => $this->cleanMessage($title[1][$k]),
								'url' => $this->cleanUrl(@$full_res[1]),
								'src' => 'http://intervolga.ru/port/all/all/show/'.$id.'/',
								'message' => $this->cleanMessage($message[1][$k]),
								'pic' => 'http://intervolga.ru/var/portel1/'.$id.'.'.$id_img[2][$k]
							);
						}
					}

				}
			}
			$page++;
		}
		return $this->sortOid($data);
	}

	function parseBlogIntervolga() {
		$data = array();
		$c = $this->load('http://intervolga.ru/weblog/');
		if ($c) {
			preg_match('/ul\ class\=\"pager\"\>(.*?)\<\/ul/si', $c, $pager);
			if (@$pager[1]) {
				preg_match_all('/li\>\<a\ href\=\"\/weblog\/page\/(\d+)/si', $pager[1], $pages);
				if (@$pages[1]) {
					array_unshift($pages[1], 1);
					foreach ($pages[1] as $page) {
						$c = $this->load('http://intervolga.ru/weblog/page/'.$page.'/');
						if ($c) {
							preg_match_all('/h3\>\<a\ href\=\"\/weblog\/([^\/]+)\/\"\>([^\<]+)/si', $c, $links);
							if (@$links[1]) {
								foreach ($links[1] as $k => $id) {
									$c = $this->load('http://intervolga.ru/weblog/'.$id.'/');
									if ($c) {
										preg_match('/div\ class\=\"title\"\>.*?\<\/div\>(.*?)\<div\ class\=\"tags/si', $c, $message);
										preg_match('/p\>.*?\<em\>(.*?)\<br\ \/\>/si', $message[1], $date);
										preg_match('/Автор\:(\ \<.*?\>|\ )([^\<]+)/si', $message[1], $author);
										$message = preg_replace('/\<p\>[^\<]*\<em\>.*?\<\/em\>[^\<]*\<\/p\>/si', '', $message[1]);
										$message = str_ireplace('="/', '="http://intervolga.ru/', $message);
										$date = explode(' ', trim($date[1]));
										$ds0 = substr($date[0], 0, 2);
										$ds2 = substr($date[0], -4);
										$ds1 = substr($date[0], 4, -6);
										$date = $ds2.'-'.str_ireplace(array(
												'января',
												'февраля',
												'марта',
												'апреля',
												'мая',
												'июня',
												'июля',
												'августа',
												'сентября',
												'октября',
												'ноября',
												'декабря'
											), array(
												'01',
												'02',
												'03',
												'04',
												'05',
												'06',
												'07',
												'08',
												'09',
												'10',
												'11',
												'12'
											), $ds1).'-'.$ds0.' '.str_replace('.', ':', $date[2]).':00';
										$message = $this->cleanMessageBlog($message);
										if ($message) $data[] = array(
											'oid' => $id,
											'title' => $this->cleanMessageBlog($links[2][$k]),
											'author' => $this->cleanMessageBlog($author[2]),
											'src' => 'http://intervolga.ru/weblog/'.$id.'/',
											'date_create' => $date,
											'message' => $message
										);
									}
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parseBlogWebdecision() {
		$data = array();
		for ($i = 1; $i < 10; $i++) {
			$c = $this->load('http://blog.web-decision.ru/page/'.$i);
			if ($c) {
				if (stripos($c, 'удовлетворяющих вашим условиям') !== false) break;
				preg_match_all('/h2\>\<a\ href\=\"http\:\/\/blog\.web\-decision\.ru\/([^\"]+)\"\ rel\=\"bookmark\"\ title\=\"[^\"]*\"\>([^\<]+)/si', $c, $posts);
				if (@$posts[1]) {
					foreach ($posts[1] as $k => $rid) {
						$id = md5($rid);
						$c = $this->load('http://blog.web-decision.ru/'.$rid);
						preg_match('/small>([^\ ]+)\ \<\!\-\-/si', $c, $date);
						preg_match('/div\ class\=\"entry\"\>(.*?)\<p\ class\=\"postmetadata/si', $c, $message);
						$message = $this->cleanMessageBlog($message[1]);
						$data[] = array(
							'oid' => $id,
							'title' => $this->cleanMessageBlog($posts[2][$k]),
							'author' => '',
							'src' => 'http://blog.web-decision.ru/'.$rid,
							'date_create' => date('Y-m-d H:i:s', strtotime($date[1])),
							'message' => $this->cleanMessageBlog(substr($message, 0, strlen($message) - 7))
						);
					}
				}

			}
		}
		return $this->sortOid($data);
	}

	function parseBlogClickon() {
		$data = array();
		$c = $this->load('http://www.clickon.ru/blog/');
		if ($c) {
			preg_match('/div\ class\=\"naver-blog\"\>(.*?)\<\/div/si', $c, $pager);
			if (@$pager[1]) {
				preg_match_all('/a\ href\=\"\/blog\/(\d+)\.page/si', $pager[1], $pages);
				if (@$pages[1]) {
					array_unshift($pages[1], 1);
					foreach ($pages[1] as $page) {
						$c = $this->load('http://www.clickon.ru/blog/'.$page.'.page');
						if ($c) {
							preg_match_all('/big\ class\=\"blog\-title\"\>\<a\ class\=\"thea\ folupd\"\ href\=\"\/blog\/([^\"]+)\/\"\ title\=\"\"\>([^\<]+)/si', $c, $links);
							if (@$links[1]) {
								foreach ($links[1] as $k => $rid) {
									$id = str_replace('/', '_', $rid);
									$c = $this->load('http://www.clickon.ru/blog/'.$rid.'/');
									if ($c) {
										preg_match('/class\=\"blog\-post\ pl\"\>(.*?)\<\/div\>\<\/div\>\<\/div\>\<\/div/si', $c, $message);
										preg_match('/big\>([^\<]+)\<\/big\>\<noindex\>\<dfn\ title\=\"Создано\ ([^\.]+)/si', $c, $author_date);
										$data[] = array(
											'oid' => $id,
											'title' => $this->cleanMessageBlog($links[2][$k]),
											'author' => $this->cleanMessageBlog($author_date[1]),
											'src' => 'http://www.clickon.ru/blog/'.$rid.'/',
											'date_create' => trim($author_date[2]),
											'message' => $this->cleanMessageBlog($message[1])
										);
									}
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parseBlogIrcit() {
		$data = array();
		$c = $this->load('http://www.ircit.ru/company/blog/history.php?PAGEN_1=1');
		if ($c) {
			preg_match('/div\ class\=\"page\"\>(.*?)\<\/div/si', $c, $pager);
			if (@$pager[1]) {
				preg_match_all('/a\ href\=\"\/company\/blog\/history\.php\?PAGEN\_1\=(\d+)\"\>/si', $pager[1], $pages);
				if (@$pages[1]) {
					array_unshift($pages[1], 1);
					foreach ($pages[1] as $page) {
						$c = $this->load('http://www.ircit.ru/company/blog/history.php?PAGEN_1='.$page);
						if ($c) {
							$c = @iconv('windows-1251', 'utf-8', $c);
							preg_match_all('/h2\ class\=\"blog\-post\-title\"\>\<a\ href\=\"\/company\/blog\/([^\.]+)\.php\"\ title\=\"[^\"]*\"\>([^\<]+)/si', $c, $links);
							if (@$links[1]) {
								foreach ($links[1] as $k => $rid) {
									$id = str_replace('/', '_', $rid);
									$c = $this->load('http://www.ircit.ru/company/blog/'.$rid.'.php');
									if ($c) {
										$c = @iconv('windows-1251', 'utf-8', $c);
										preg_match('/div\ class\=\"blog\-post\-content\"\ style\=\"padding\-bottom\:15px\;\"\>(.*?)\<div\ class\=\"blog\-post\-info\-back\"/si', $c, $message);
										preg_match('/href\=\"\/company\/blog\/[^\/]+\/\"\>([^\<]+)\<\/a\>\<\/div/si', $c, $author);
										preg_match('/div\ class\=\"blog\-post\-date\"\>([^\<]+)/si', $c, $date);
										$message = $this->cleanMessageBlog($message[1]);
										$message = str_ireplace('="/', '="http://www.ircit.ru/', $message);
										$message = str_ireplace('=\'/', '=\'http://www.ircit.ru/', $message);
										$data[] = array(
											'oid' => $id,
											'title' => $this->cleanMessageBlog($links[2][$k]),
											'author' => $this->cleanMessageBlog($author[1]),
											'src' => 'http://www.ircit.ru/company/blog/'.$rid.'.php',
											'date_create' => date('Y-m-d H:i:s', strtotime($date[1])),
											'message' => $this->cleanMessageBlog(substr($message, 0, strlen($message) - 12))
										);
									}
								}
							}
						}
					}
				}
			}
		}
		return $this->sortOid($data);
	}

	function parseBlogMagwai() {
		return 'next';
	}

	function parseBlogWebpp() {
		return 'next';
	}

	function parseBlog21age() {
		return 'next';
	}

	function parseBlogJinnweb() {
		return 'next';
	}

	function parseBlogStride() {
		return 'next';
	}

	function parseBlogMfrog() {
		return 'next';
	}

	function parseBlogRw1() {
		return 'next';
	}

	function parseBlogInweb() {
		return 'next';
	}

	function parseBlogArtnet() {
		return 'next';
	}

	function parseBlogVivastudio() {
		return 'next';
	}

	function parseBlogModesco() {
		return 'next';
	}

	function parseBlogStudia7() {
		return 'next';
	}

	function parseBlogKe() {
		return 'next';
	}

	function parseBlogUnique() {
		return 'next';
	}
	function parseBlogWebv() {
		return 'next';
	}
	function parseBlogBalt() {
		return 'next';
	}
	function parseBlogTs() {
		return 'next';
	}
	function parseBlogActual() {
		return 'next';
	}
	function parseBlogOnvolga() {
		return 'next';
	}
	function parseBlogDf34() {
		return 'next';
	}
	function parseRss($url) {
		$data = array();
		$xml = @simplexml_load_file($url);
		if ($xml) {
			$link = $xml->xpath("/rss/channel/item/link");
			$author = $xml->xpath("/rss/channel/item/dc:creator");
			$title = $xml->xpath("/rss/channel/item/title");
			$date = $xml->xpath("/rss/channel/item/pubDate");
			$message = $xml->xpath("/rss/channel/item/content:encoded");
			if ($link && $title) {
				foreach ($link as $k => $el) {
					$id = md5((string)$el[0]);
					$data[] = array(
						'oid' => $id,
						'title' => $this->cleanMessageBlog((string)$title[$k][0]),
						'author' => $this->cleanMessageBlog((string)$author[$k][0]),
						'src' => (string)$el[0],
						'date_create' => date('Y-m-d H:i:s', strtotime((string)$date[$k][0])),
						'message' => $this->cleanMessageBlog((string)$message[$k][0])
					);
				}
			}

		}
		return $this->sortOid($data);
	}
}

function reverse_htmlentities($mixed)
{
	return strip_tags(str_ireplace(array(
		'&amp;',
		'&lt;',
		'&gt;',
		'&laquo;',
		'&raquo;',
		'&quot;',
		'&mdash;'
	), array(
		'&',
		'<',
		'>',
		'«',
		'»',
		'"',
		'—'
	), $mixed));
}