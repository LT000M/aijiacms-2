<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function mobile_pages($total, $page = 1, $perpage = 20, $demo = '') {
	global $AJ_URL, $AJ, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	if($demo) {
		$demo_url = str_replace('%7Baijiacms_page%7D', '{aijiacms_page}', $demo);
		$home_url = str_replace('{aijiacms_page}', '1', $demo_url);
	} else {
		if(defined('AJ_REWRITE') && $AJ['rewrite'] && $_SERVER["SCRIPT_NAME"] && strpos($AJ_URL, '?') === false) {
			$demo_url = $_SERVER["SCRIPT_NAME"];
			$demo_url = str_replace('//', '/', $demo_url);//Fix Nginx
			$mark = false;
			if(substr($demo_url, -4) == '.php') {
				if(strpos($_SERVER['QUERY_STRING'], '.html') === false) {
					$qstr = '';
					if($_SERVER['QUERY_STRING']) {					
						if(substr($_SERVER['QUERY_STRING'], -5) == '.html') {
							$qstr = '-'.substr($_SERVER['QUERY_STRING'], 0, -5);
						} else {
							parse_str($_SERVER['QUERY_STRING'], $qs);
							foreach($qs as $k=>$v) {
								$qstr .= '-'.$k.'-'.rawurlencode($v);
							}
						}
					}
					$demo_url = substr($demo_url, 0, -4).'-htm-page-{aijiacms_page}'.$qstr.'.html';
				} else {
					$demo_url = substr($demo_url, 0, -4).'-htm-'.$_SERVER['QUERY_STRING'];
					$mark = true;
				}
			} else {
				$mark = true;
			}
			if($mark) {
				if(strpos($demo_url, '%') === false) $demo_url =  rawurlencode($demo_url);
				$demo_url = str_replace(array('%2F', '%3A'), array('/', ':'), $demo_url);
				if(strpos($demo_url, '-page-') !== false) {
					$demo_url = preg_replace("/page-([0-9]+)/", 'page-{aijiacms_page}', $demo_url);
				} else {
					$demo_url = str_replace('.html', '-page-{aijiacms_page}.html', $demo_url);
				}
			}
			$home_url = str_replace('-page-{aijiacms_page}', '-page-1', $demo_url);
		} else {
			$AJ_URL = str_replace('&amp;', '&', $AJ_URL);
			$demo_url = $home_url = preg_replace("/(.*)([&?]page=[0-9]*)(.*)/i", "\\1\\3", $AJ_URL);
			$s = strpos($demo_url, '?') === false ? '?' : '&';
			$demo_url = $demo_url.$s.'page={aijia'.'cms_page}';
			if(defined('AJ_ADMIN') && strpos($demo_url, 'sum=') === false) $demo_url = str_replace('page=', 'sum='.$items.'&page=', $demo_url);
		}
	}
	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);
	$url = str_replace('{aijiacms_page}', $_page, $demo_url);
	$pages .= '<a href="'.$url.'" data-transition="none" id="page-prev">&laquo; '.$L['prev_page'].'</a> ';
	if(strpos($demo_url, 'javascript') === false) {
		$pages .= '<a href="javascript:GoPage('.$total.', '.$items.', \''.$demo_url.'\');" id="page-goto"><b>'.$page.'</b>/'.$total.'</a> ';
	} else {		
		$pages .= '<a href="'.$url.'" id="page-goto"><b>'.$page.'</b>/'.$total.'</a> ';
	}
	$_page = $page >= $total ? 1 : $page + 1;
	$url = str_replace('{aijiacms_page}', $_page, $demo_url);
	$pages .= '<a href="'.$url.'" data-transition="none" id="page-next">'.$L['next_page'].' &raquo;</a> ';
	return $pages;
}

function m301($moduleid, $catid = 0, $itemid = 0, $page = 1) {
	global $MODULE;
	$url = '';
	if($itemid) {
		if($moduleid > 4) {
			$item = DB::get_one("SELECT * FROM ".get_table($moduleid)." WHERE itemid=$itemid");
			if($item && $item['status'] > 2) {
				$url = $MODULE[$moduleid]['mobile'].itemurl($item, $page > 1 ? $page : '');
			}
		}
	} else if($catid) {
		$CAT = get_cat($catid);
		$url = $MODULE[$moduleid]['mobile'].listurl($CAT, $page > 1 ? $page : '');
	} else {
		$url = $MODULE[$moduleid]['mobile'];
	}
	if($moduleid == 4) {
		global $username, $AJ_URL;
		if(check_name($username)) $url = userurl($username, cutstr($AJ_URL, $username.'&', '.html'));
	}
	if($url) d301($url);
}

function input_trim($wd) {
	return trim(urldecode(str_replace('%E2%80%86', '', urlencode($wd))));
}
function video5($content) {
	if(strpos($content, '<embed') !== false) {
		if(!preg_match_all("/<embed[^>]*>(.*?)<\/embed>/i", $content, $matches)) return $content;
		foreach($matches[0] as $m) {
			$content = str_replace($m, video5_player(video5_url($m)), $content);
		}
	}
	return $content;
}

function video5_url($content) {
	$url = '';
	if(strpos($content, 'vcastr3.swf') !== false) {
		$url = cutstr($content, 'source&gt;', '&lt;/');
	} else if(strpos($content, 'src="') !== false) {
		$url = cutstr($content, 'src="', '"');
	}
	return $url;
}

function video5_frame($url, $w, $h) {
	return '<iframe src="'.$url.'" width="'.$w.'" height="'.$h.'" frameborder="0" scrolling="no" allowfullscreen="true" allowtransparency="true"></iframe>';
}

function video5_play($url) {
	return '<a href="'.$url.'" target="_blank" rel="external"><div style="width:100%;height:200px;background:#000000 url('.AJ_PATH.'/file/image/play.png) no-repeat center center;background-size:48px 48px;"></div></a>';
}

function video5_player($url, $w = 280, $h = 210, $a = 0) {
	$ext = file_ext($url);
	$url = url2video($url);
	$dom = cutstr($url, '://', '/');
	$u5 = '';
	if(in_array($dom, array('player.youku.com', 'v.qq.com', 'm.iqiyi.com'))) {//, 'liveshare.huya.com'
		return video5_frame($url, $w, $h);
	} else if(in_array($dom, array('www.youtube.com'))) {
		return video5_frame(url2video5($url), $w, $h);
	} else if($ext == 'mp4' || $ext == 'flv') {
		$u5 = $url;
	}
	return $u5 ? '<video src="'.$u5.'" width="'.$w.'" height="'.$h.'"'.($a ? ' autoplay="autoplay"' : '').' controls="controls">'.video5_play($u5).'</video>' : video5_play(url2video5($url));
}
function is_pc() {
	if(AJ_DEBUG || is_robot()) return false;
	$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
	if(strpos($UA, 'WINDOWS NT') !== false) {
		if(strpos($GLOBALS['AJ_URL'], 'plg_') !== false) return false;//QQ
		return true;
	}
	return false;
}
function share_icon($thumb, $content) {
	if(strpos($thumb, '.thumb.') !== false) return substr($thumb, 0, strpos($thumb, '.thumb.'));
	if($thumb) return $thumb;
	if(strpos($content, '<img') !== false) return 'auto';
	return AJ_PATH.'apple-touch-icon-precomposed.png';
}
?>