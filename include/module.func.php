<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function get_fee($item_fee, $mod_fee) {
	if($item_fee < 0) {
		$fee = 0;
	} else if($item_fee == 0) {
		$fee = $mod_fee;
	} else {
		$fee = $item_fee;
	}
	return $fee;
}

function keyword($kw, $items, $moduleid) {
	global $AJ;
	if(!$AJ['search_kw'] || $items < 2 || strlen($kw) < 3 || strlen($kw) > 30 || strpos($kw, ' ') !== false || strpos($kw, '%') !== false) return;
	$kw = addslashes($kw);
	$r = DB::get_one("SELECT * FROM ".AJ_PRE."keyword WHERE moduleid=$moduleid AND word='$kw' ORDER BY itemid ASC");
	if($r) {
		$items = $items > $r['items'] ? $items : $r['items'];
		$month_search = date('Y-m', $r['updatetime']) == date('Y-m', AJ_TIME) ? 'month_search+1' : '1';
		$week_search = date('W', $r['updatetime']) == date('W', AJ_TIME) ? 'week_search+1' : '1';
		$today_search = date('Y-m-d', $r['updatetime']) == date('Y-m-d', AJ_TIME) ? 'today_search+1' : '1';
		DB::query("UPDATE ".AJ_PRE."keyword SET items='$items',updatetime='".AJ_TIME."',total_search=total_search+1,month_search=$month_search,week_search=$week_search,today_search=$today_search WHERE itemid=$r[itemid]");
		DB::query("DELETE FROM ".AJ_PRE."keyword WHERE moduleid=$moduleid AND word='$kw' AND itemid>$r[itemid]");
	} else {
		$letter = trim(gb2py($kw));
		$status = $AJ['search_check_kw'] ? 2 : 3;
		if(strlen($letter) < 2) $status = 2;
		DB::query("INSERT INTO ".AJ_PRE."keyword (moduleid,word,keyword,letter,items,updatetime,total_search,month_search,week_search,today_search,status) VALUES ('$moduleid','$kw','$kw','$letter','$items','".AJ_TIME."','1','1','1','1','$status')");
	}
}

function money_add($username, $amount) {
	if($username && $amount) {
		if($amount < 0) {
			$r = DB::get_one("SELECT money FROM ".AJ_PRE."member WHERE username='$username'");
			if($r['money'] < abs($amount)) {
				set_cookie('auth', '');
				dhttp(403, 0);
				dalert('HTTP 403 Forbidden - Bad Data', AJ_PATH);
			}
		}
		DB::query("UPDATE ".AJ_PRE."member SET money=money+{$amount} WHERE username='$username'");
	}
}

function money_record($username, $amount, $bank, $editor, $reason, $note = '') {
	if($username && $amount) {
		$r = DB::get_one("SELECT money FROM ".AJ_PRE."member WHERE username='$username'");
		$balance = $r['money'];
		$reason = addslashes(stripslashes(strip_tags($reason)));
		$note = addslashes(stripslashes(strip_tags($note)));
		DB::query("INSERT INTO ".AJ_PRE."finance_record (username,bank,amount,balance,addtime,reason,note,editor) VALUES ('$username','$bank','$amount','$balance','".AJ_TIME."','$reason','$note','$editor')");
	}
}
//发放佣金
function amount_record($username, $kehu,$amount, $addtime, $status, $note, $editor) {
	if($username && $amount) {
		$r = DB::get_one("SELECT money FROM ".AJ_PRE."member WHERE username='$username'");
		$balance = $r['money'];
		$kehu = addslashes(stripslashes(strip_tags($kehu)));
		$note = addslashes(stripslashes(strip_tags($note)));
		DB::query("INSERT INTO ".AJ_PRE."finance_amount (username,kehu,amount,addtime,status,note,editor) VALUES ('$username','$kehu','$amount','".AJ_TIME."','$status','$note','$editor')");
	}
}
//客户来源
function keyuanfrom($khxingming, $dianhua,$username,$bianhao,$pc) {
	if($username) {
		$xqbianhao='MK'.$bianhao;
		
		DB::query("INSERT INTO ".AJ_PRE."keyuan (khxingming,dianhua,username,lurusj,khlaiyuan,gtjieduan,zhuangtai,xqbianhao) VALUES ('$khxingming','$dianhua','$username','".AJ_TIME."','$pc','新注册','2','$xqbianhao')");
	}
}
//赏金
function bounty_add($username, $amount) {

       

	if($username && $amount) DB::query("UPDATE ".AJ_PRE."member SET bounty=bounty+{$amount} WHERE username='$username'");
}
//赏金记录
function bounty_record($mid,$tid,$username, $amount, $paytime, $ip, $title, $editor, $reason, $note = '') {
	global $AJ;
	if($username && $amount) {
	$r = DB::get_one("SELECT bounty FROM ".AJ_PRE."member WHERE username='$username'");
		$balance = $r['bounty'];
		$reason = addslashes(stripslashes(strip_tags($reason)));
		$note = addslashes(stripslashes(strip_tags($note)));
		DB::query("INSERT INTO  ".AJ_PRE."finance_bounty (mid,tid,username,amount,paytime,ip,title,reason,note,editor) VALUES ('$mid','$tid','$username','$amount','".AJ_TIME."','".AJ_IP."','".addslashes($title)."','$reason','$note','$editor')");
	
	}
}
function credit_add($username, $amount) {
	if($username && $amount) DB::query("UPDATE ".AJ_PRE."member SET credit=credit+{$amount} WHERE username='$username'");
}

function credit_record($username, $amount, $editor, $reason, $note = '') {
	global $AJ;
	if($AJ['log_credit'] && $username && $amount) {
		$r = DB::get_one("SELECT credit FROM ".AJ_PRE."member WHERE username='$username'");
		$balance = $r['credit'];
		$reason = addslashes(stripslashes(strip_tags($reason)));
		$note = addslashes(stripslashes(strip_tags($note)));
		DB::query("INSERT INTO ".AJ_PRE."finance_credit (username,amount,balance,addtime,reason,note,editor) VALUES ('$username','$amount','$balance','".AJ_TIME."','$reason','$note','$editor')");
	}
}

function sms_add($username, $amount) {
	if($username && $amount) DB::query("UPDATE ".AJ_PRE."member SET sms=sms+{$amount} WHERE username='$username'");
}

function sms_record($username, $amount, $editor, $reason, $note = '') {
	if($username && $amount) {
		$r = DB::get_one("SELECT sms FROM ".AJ_PRE."member WHERE username='$username'");
		$balance = $r['sms'];
		$reason = addslashes(stripslashes(strip_tags($reason)));
		$note = addslashes(stripslashes(strip_tags($note)));
		DB::query("INSERT INTO ".AJ_PRE."finance_sms (username,amount,balance,addtime,reason,note,editor) VALUES ('$username','$amount','$balance','".AJ_TIME."','$reason','$note','$editor')");
	}
}

function secondstodate($seconds) {
	include load('include.lang');
	$date = '';
	if($seconds > 0) {
		$t = floor($seconds/86400);
		if($t) {
			$date .= $t.$L['mod_day'];
			$seconds = $seconds%86400;
		}
		$t = floor($seconds/3600);
		if($t) {
			$date .= $t.$L['mod_hour'];
			$seconds = $seconds%3600;
		}
		$t = floor($seconds/60);
		if($t) {
			$date .= $t.$L['mod_minute'];
			$seconds = $seconds%60;
		}
		if($seconds) {
			$date .= $seconds.$L['mod_second'];
		}
	}
	return $date;
}

function get_intro($content, $length = 0) {
	if($length) {
		$intro = trim(strip_tags($content));
		$intro = preg_replace("/&([a-z]{1,});/", '', $intro);
		$intro = str_replace(array("\r", "\n", "\t", '  '), array('', '', '', ''), $intro);
		return dsubstr($intro, $length);
	} else {
		return '';
	}
}

function get_description($content, $length) {
	if($length) {
		$content = str_replace(array(' ', '[pagebreak]'), array('', ''), $content);
		return nl2br(dsubstr(trim(strip_tags($content)), $length, '...'));
	} else {
		return '';
	}
}

function get_module_setting($moduleid, $key = '') {
	$M = cache_read('module-'.$moduleid.'.php');
	return $key ? $M[$key] : $M;
}

function anti_spam($string) {
	global $AJ;
	if($AJ['anti_spam'] && preg_match("/^[a-z0-9_@\-\s\/\.\,\(\)\+]+$/i", $string)) {
		return '<img src="'.AJ_PATH.'api/image.png.php?auth='.encrypt($string, AJ_KEY.'SPAM').'" align="absmddle"/>';
	} else {
		return $string;
	}
}

function hide_ip($ip, $sep = '*') {
	if(!preg_match("/[\d\.]{7,15}/", $ip)) return $ip;
	$tmp = explode('.', $ip);
	return $tmp[0].'.'.$tmp[1].'.'.$sep.'.'.$sep;
}

function hide_name($name, $sep = '*') {
	$len = strlen($name);
	$str = '';
	for($i = 0; $i < $len; $i++) {
		$str .= ($i == 0 || $i == $len - 1) ? $name{$i} : $sep;
	}
	return $str;
}

function check_pay($moduleid, $itemid) {
	global $_username, $MOD;
	$condition = "mid=$moduleid AND tid=$itemid AND username='$_username'";
	if($MOD['fee_period']) $condition .= " AND paytime>".(AJ_TIME - $MOD['fee_period']*60);
	return DB::get_one("SELECT itemid FROM ".AJ_PRE."finance_pay WHERE $condition");
}

function check_sign($string, $sign) {
	return $sign == crypt_sign($string);
}

function crypt_sign($string) {
	return strtoupper(md5(md5(AJ_IP.$string.AJ_KEY.'SIGN')));
}

function cache_hits($moduleid, $itemid) {
	if(@$fp = fopen(AJ_CACHE.'/hits-'.$moduleid.'.php', 'a')) {
		flock($fp, LOCK_EX);
		fwrite($fp, $itemid.' ');
		flock($fp, LOCK_UN);
		fclose($fp);
	}
}

function update_hits($moduleid, $table) {
	$hits = trim(file_get(AJ_CACHE.'/hits-'.$moduleid.'.php'));
	file_put(AJ_CACHE.'/hits-'.$moduleid.'.php', ' ');
	file_put(AJ_CACHE.'/hits-'.$moduleid.'.dat', AJ_TIME);
	if($hits) {
		$tmp = array_count_values(explode(' ', $hits));
		$arr = array();
		foreach($tmp as $k=>$v) {
			$arr[$v] .= $k ? ','.$k : '';
		}
		$id = $moduleid == 4 ? 'userid' : 'itemid';
		foreach($arr as $k=>$v) {
			DB::query("UPDATE LOW_PRIORITY {$table} SET `hits`=`hits`+".$k." WHERE `$id` IN (0".$v.")", 'UNBUFFERED');
		}
	}
}

function keylink($content, $item, $mob = 0) {
	global $KEYLINK;
	$KEYLINK or $KEYLINK = cache_read('keylink-'.$item.'.php');
	if(!$KEYLINK) return $content;
	$data = $content;
	foreach($KEYLINK as $k=>$v) {
		$quote = str_replace(array("'", '-'), array("\'", '\-'), preg_quote($v['title']));
		if($mob) {
			$data = preg_replace('\'(?!((<.*?)|(<a.*?)|(<strong.*?)))('.$quote.')(?!(([^<>]*?)>)|([^>]*?</a>)|([^>]*?</strong>))\'si', '<a href="'.str_replace(AJ_PATH, AJ_MOB, $v['url']).'" target="_blank" rel="external">'.$v['title'].'</a>', $data, 1);
		} else {
			$data = preg_replace('\'(?!((<.*?)|(<a.*?)|(<strong.*?)))('.$quote.')(?!(([^<>]*?)>)|([^>]*?</a>)|([^>]*?</strong>))\'si', '<a href="'.$v['url'].'" target="_blank"><strong class="keylink">'.$v['title'].'</strong></a>', $data, 1);
		}
		if($data == '') $data = $content;
	}
	return $data;
}

function gender($gender, $type = 0) {
	global $L;
	if($type) return $gender == 1 ? $L['man'] : $L['woman'];
	return $gender == 1 ? $L['sir'] : $L['lady'];
}

function online($user, $type = 0) {
	$r = DB::get_one("SELECT online FROM ".AJ_PRE."online WHERE `".($type ? 'username' : 'userid')."`='$user'");
	if($r) return $r['online'] ? 1 : -1;
	return 0;
}

function fix_link($url) {
	$url = trim($url);
	if(strlen($url) < 10) return '';
	return strpos($url, '://') === false  ? 'http://'.$url : $url;
}

function vip_year($fromtime) {
	return $fromtime ? intval((AJ_TIME - $fromtime)/86400/365) + 1 : 1;
}

function get_albums($item) {
	$thumbs = array();
	if($item['thumb']) $thumbs[] = $item['thumb'];
	if(isset($item['thumb1']) && $item['thumb1'] && strpos($item['thumbs'], $item['thumb1']) === false) $thumbs[] = $item['thumb1'];
	if(isset($item['thumb2']) && $item['thumb2'] && strpos($item['thumbs'], $item['thumb2']) === false) $thumbs[] = $item['thumb2'];
	foreach(explode('|', $item['thumbs']) as $v) {
		if($v) $thumbs[] = $v;
	}
	$i = count($thumbs);
	while($i++ < 1) {
		$thumbs[] = AJ_SKIN.'image/nopic.gif';;
	}
	return $thumbs;
}

function get_thumbs($item = array()) {
	$thumbs = array();
	if($item) {
		if($item['thumb']) $thumbs[] = $item['thumb'];
		if(isset($item['thumb1']) && $item['thumb1'] && strpos($item['thumbs'], $item['thumb1']) === false) $thumbs[] = $item['thumb1'];
		if(isset($item['thumb2']) && $item['thumb2'] && strpos($item['thumbs'], $item['thumb2']) === false) $thumbs[] = $item['thumb2'];
		foreach(explode('|', $item['thumbs']) as $v) {
			if($v) $thumbs[] = $v;
		}
	}
	return $thumbs;
}

function xml_linkurl($linkurl, $modurl = '') {
	if(strpos($linkurl, '://') === false) $linkurl = $modurl.$linkurl;
	return str_replace('&', '&amp;', $linkurl);
}

function img_lazy($content) {
	return preg_replace("/src=([\"|']?)([^ \"'>]+\.(jpg|jpeg|gif|png|bmp))\\1/i", "src=\"".AJ_SKIN."image/lazy.gif\" class=\"lazy\" original=\"\\2\"", $content);
}

function sort_type($TYPE) {
	$p = $c = array();
	foreach($TYPE as $v) {
		if($v['parentid']) {
			$c[$v['parentid']][] = $v;
		} else {
			$p[] = $v;
		}
	}
	return array($p, $c);
}

function update_user($member, $item, $fileds = array('groupid','vip')) {
	$update = '';
	foreach($fileds as $v) {
		if(isset($item[$v]) && $item[$v] != $member[$v]) $update .= ",$v='".addslashes($member[$v])."'";
	}
	if(isset($item['email']) && $item['email'] != $member['mail']) $update .= ",email='".addslashes($member['mail'])."'";
	return $update;
}

function highlight($str) {
	return '<span class="highlight">'.$str.'</span>';
}

function parse_face($str) {
	if(preg_match_all("/\:([0-9]{3,})\)/i", $str, $m)) {
		foreach($m[0] as $u) {
			$f = substr($u, 1, -1).'.png';
			if(is_file(AJ_ROOT.'/file/face/'.$f)) $str = str_replace($u, '<img src="'.AJ_STATIC.'file/face/'.$f.'" width="24"/>', $str);
		}
	}
	return $str;
}


function get_face() {
	$faces = array();
	$face = glob(AJ_ROOT.'/file/face/*.png');
	
	if($face) {
		foreach($face as $k=>$v) {
			$faces[$k] = basename($v, '.png');
		}
	}
	
	return $faces;
}
function get_uid() {
	DB::query("INSERT INTO ".AJ_PRE."uid () VALUES ()");
	return DB::insert_id();
}
function url2video($u) {
	$d = cutstr($u, '://', '/');
	$h = substr($u, 0, 5) == 'https' ? 'https://' : 'http://';
	switch($d) {
		case 'v.youku.com':
			if(strpos($u, '/embed/') !== false) return $u;
			$p = cutstr($u, 'id_', '.html');
			if($p) return $h.'player.youku.com/embed/'.$p;
		break;
		case 'player.youku.com':
			if(strpos($u, '/embed/') !== false) return $u;
			$p = cutstr($u, 'sid/', '/');
			if($p) return $h.'player.youku.com/embed/'.$p;
			$p = cutstr($u, 'embed/', strpos($u, "'") !== false ? "'" : '"');
			if($p) return $h.'player.youku.com/embed/'.$p;
		break;
		case 'imgcache.qq.com':
		case 'static.v.qq.com':
		case 'v.qq.com':
			if(strpos($u, '/iframe/') !== false) return $u;
			$p = cutstr($u, 'vid=', '&');
			if($p) return $h.'v.qq.com/iframe/player.html?vid='.$p.'&tiny=0&auto=0';
			$p = cutstr($u, 'cover/', '.html');
			if($p) $p = cutstr($u, '/', '/');
			if($p) return $h.'v.qq.com/iframe/player.html?vid='.$p.'&tiny=0&auto=0';
		break;
		case 'www.iqiyi.com':
			if(strpos($u, 'shareplay.html') !== false) return $u;
			$c = dcurl($u);
			if($c) {
				$p1 = cutstr($c, 'data-player-videoid="', '"');
				$p2 = cutstr($c, 'data-player-tvid="', '"');
				if($p1 && $p2) return $h.'m.iqiyi.com/shareplay.html?vid='.$p1.'&tvid='.$p2;
			}
		break;
		case 'open.iqiyi.com':
			if(strpos($u, 'shareplay.html') !== false) return $u;
			$p1 = cutstr($u, 'vid=', '&');
			$p2 = cutstr($u, 'tvId=', '&');
			if($p1 && $p2) return $h.'m.iqiyi.com/shareplay.html?vid='.$p1.'&tvid='.$p2;
		break;
		case 'player.video.qiyi.com':
			if(strpos($u, 'shareplay.html') !== false) return $u;
			$p1 = cutstr($u, 'player.video.qiyi.com/', '/');
			$p2 = cutstr($u, 'tvId=', '-');
			if($p1 && $p2) return $h.'m.iqiyi.com/shareplay.html?vid='.$p1.'&tvid='.$p2;
		break;
		case 'www.bilibili.com':
			if(strpos($u, 'player.html') !== false) return $u;
			$p = cutstr($u, '/video/', strpos($u, '?') === false ? '/' : '?');
			if($p) return $h.'player.bilibili.com/player.html?bvid='.$p;
		break;
		case 'www.acfun.cn':
			if(strpos($u, '/player/') !== false) return $u;
			$p = cutstr($u, '/v/', strpos($u, '?') === false ? '/' : '?');
			if($p) return $h.'www.acfun.cn/player/'.$p;
		break;
		case 'www.youtube.com':
			if(strpos($u, '/embed/') !== false) return $u;
			$p = cutstr($u, 'v=', '&');
			if($p) return $h.'www.youtube.com/embed/'.$p;
		break;
		case 'www.huya.com':
			if(strpos($u, '/iframe/') !== false) return $u;
			$p = cutstr($u, 'www.huya.com/', '/');
			if($p) return $h.'liveshare.huya.com/iframe/'.$p;
		break;
		case 'www.douyu.com':
			if(strpos($u, '/share/') !== false) return $u;
			$p = cutstr($u, 'www.douyu.com/', '/');
			if($p) return $h.'staticlive.douyucdn.cn/common/share/play.swf?room_id='.$p;
		break;
	}
	return $u;
}

function url2video5($u) {
	$d = cutstr($u, '://', '/');
	switch($d) {
		case 'www.youtube.com':
			$p = cutstr($u, '/v/', '&');
			if($p) return 'http://www.youtube.com/embed/'.$p;

		break;
		case 'liveshare.huya.com':
			$p = cutstr($u, '/iframe/', '/');
			if($p) return 'http://m.huya.com/'.$p;
		break;
		case 'staticlive.douyucdn.cn':
			$p = cutstr($u, 'room_id=', '&');
			if($p) return 'https://m.douyu.com/'.$p;
		break;
	}
	return $u;
}

function parse_video($content) {
	if(strpos($content, '<embed') !== false) {
		if(!preg_match_all("/<embed[^>]*>(.*?)<\/embed>/i", $content, $matches)) return $content;
		foreach($matches[0] as $m) {
			$n = '';
			$url = cutstr($m, 'src="', '"');
			$url = url2video($url);
			if($url) {
				$url = str_replace('<em></em>', '', $url);
				$w = cutstr($m, 'width="', '"');
				$h = cutstr($m, 'height="', '"');
				is_numeric($w) or $w = 600;
				is_numeric($h) or $h = 500;
				$d = cutstr($url, '://', '/');
				if(in_array($d, array('player.youku.com', 'v.qq.com', 'm.iqiyi.com', 'liveshare.huya.com'))) {
					$n = '<iframe width="'.$w.'" height="'.$h.'" frameborder="0" scrolling="no" src="'.$url.'"></iframe>';
				} else if($d == 'staticlive.douyucdn.cn') {
					$n = '<embed src="'.$url.'" width="'.$w.'" height="'.$h.'" allownetworking="all" allowscriptaccess="always" quality="high" bgcolor="#000" wmode="window" allowfullscreen="true" allowFullScreenInteractive="true" type="application/x-shockwave-flash"></embed>';
				}
			}
			if($n) $content = str_replace($m, $n, $content);
		}
	}
	return $content;
}

?>