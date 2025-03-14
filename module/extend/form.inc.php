<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['form_enable'] or dheader(AJ_PATH);
require AJ_ROOT.'/include/post.func.php';
$ext = 'form';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require AJ_ROOT.'/module/'.$module.'/'.$ext.'.class.php';
$do = new $ext();
$typeid = isset($typeid) ? intval($typeid) : 0;
if($itemid) {
	$do->itemid = $itemid;
	$f = $do->get_one();
	$f or dheader($AJ_PC ? $url : $mob);
	unset($f['answer']);
	extract($f);
	(isset($item) && preg_match("/^[a-z0-9_\-]{1,}$/i", $item)) or $item = '';
	$could_form = true;
	$error = 0;
	if($maxanswer) {
		$condition = $_username ? "AND username='$_username'" : "AND ip='$AJ_IP'";
		$num = $db->count($AJ_PRE.'form_record', "fid=$itemid $condition");
		if($num >= $maxanswer) {
			$could_form = false;
			$error = 1;
		}
	}
	if($fromtime && $AJ_TIME < $fromtime) {
		$could_form = false;
		$error = 2;
	}
	if($totime && $AJ_TIME > $totime) {
		$could_form = false;		
		$error = 3;
	}
	if(!check_group($_groupid, $groupid)) {
		$could_form = false;
		$error = 4;
		if(!$_userid && $groupid && strpos(','.$groupid.',', ',3,') === false) $error = 5;
	}
	if($submit) {
		if($verify == 1) captcha($captcha, 1);
		if($verify == 2) question($answer, 1);
		if($could_form) {
			$post = $other = array();
			$result = $db->query("SELECT * FROM {$AJ_PRE}form_question WHERE fid=$itemid ORDER BY listorder ASC,qid ASC LIMIT 100");
			while($r = $db->fetch_array($result)) {
				$qid = $r['qid'];
				$t = explode('-', $r['required']);
				$r['min'] = isset($t[0]) ? intval($t[0]) : 0;
				$r['max'] = isset($t[1]) ? intval($t[1]) : 0;
				if($r['min'] && $r['max'] <= $r['min']) $r['max'] = 0;
				$r['option'] = array();
				if($r['type'] == 0 || $r['type'] == 1) {
					if(isset($a[$qid])) {
						if($r['min'] && strlen($a[$qid]) < $r['min']) message(lang($L['form_min_word'], array($r['name'], $r['min'])));
						if($r['max'] && strlen($a[$qid]) > $r['max']) message(lang($L['form_max_word'], array($r['name'], $r['max'])));
						$post[$qid] = dhtmlspecialchars(trim($a[$qid]));
					} else {
						message();
					}
				} else if($r['type'] == 2) {
					if(isset($a[$qid])) {
						if($r['min'] && strlen($a[$qid]) == 0) message(lang($L['form_choose'], array($r['name'])));
						$post[$qid] = dhtmlspecialchars(trim($a[$qid]));
					} else {
						message();
					}
				} else if($r['type'] == 3) {
					if(isset($a[$qid])) {
						if($r['min'] && count($a[$qid]) < $r['min']) message(lang($L['form_min_choose'], array($r['name'], $r['min'])));
						if($r['max'] && count($a[$qid]) > $r['max']) message(lang($L['form_max_choose'], array($r['name'], $r['max'])));
						$str = ',';
						$val = str_replace('(*)', '', $r['value']).'|';
						foreach($a[$qid] as $s) {
							if(strpos($val, $s.'|') === false) message();
							$str .= $s.',';
							if($s == $L['form_other'] && isset($o[$qid])) $other[$qid] = dhtmlspecialchars(trim($o[$qid]));
						}
						$post[$qid] = dhtmlspecialchars(trim($str));
					} else {
						message();
					}
				} else if($r['type'] == 4) {
					if(isset($a[$qid])) {
						$val = str_replace('(*)', '', $r['value']).'|';
						if(strpos($val, $a[$qid].'|') === false) message();
						if($a[$qid] == $L['form_other'] && isset($o[$qid])) $other[$qid] = dhtmlspecialchars(trim($o[$qid]));
						$post[$qid] = dhtmlspecialchars(trim($a[$qid]));
					} else {
						$post[$qid] = '';
					}
				}
			}
			$db->query("INSERT INTO {$AJ_PRE}form_record (fid,username,ip,addtime,item) VALUES ('$itemid','$_username','$AJ_IP','$AJ_TIME','$item')");
			$rid = $db->insert_id();
			foreach($post as $k=>$v) {
				$o = isset($other[$k]) ? $other[$k] : '';
				$db->query("INSERT INTO {$AJ_PRE}form_answer (fid,rid,qid,username,ip,addtime,content,other,item) VALUES ('$itemid','$rid','$k','$_username','$AJ_IP','$AJ_TIME','$v','$o','$item')");
			}
			$db->query("UPDATE {$AJ_PRE}form SET answer=answer+1 WHERE itemid=$itemid");
			dheader('index.php?page=2&itemid='.$itemid);
		} else {
			dalert($L['form_failed'], $AJ_PC ? $linkurl : str_replace($url, $mob, $linkurl));
		}
	}
	$back = $AJ_PC ? $linkurl : str_replace($url, $mob, $linkurl);
	$adddate = timetodate($addtime, 3);
	$fromdate = $fromtime ? timetodate($fromtime, 3) : $L['timeless'];
	$todate = $totime ? timetodate($totime, 3) : $L['timeless'];
	$content = $AJ_PC ? parse_video($content) : video5($content);
	$lists = array();
	$result = $db->query("SELECT * FROM {$AJ_PRE}form_question WHERE fid=$itemid ORDER BY listorder ASC,qid ASC LIMIT 1000");
	while($r = $db->fetch_array($result)) {
		$t = explode('-', $r['required']);
		$r['min'] = isset($t[0]) ? intval($t[0]) : 0;
		$r['max'] = isset($t[1]) ? intval($t[1]) : 0;
		if($r['min'] && $r['max'] <= $r['min']) $r['max'] = 0;
		$r['option'] = array();
		if($r['type'] == 0) {
			if(strpos($r['extend'], 'size=') === false) $r['extend'] .= ' size="50"';
		} else if($r['type'] == 1) {
			if(strpos($r['extend'], 'rows=') === false) $r['extend'] .= ' rows="5"';
			if(strpos($r['extend'], 'cols=') === false) $r['extend'] .= ' cols="80"';
		} else {
			$t = explode('|', $r['value']);
			foreach($t as $k=>$v) {
				$r['option'][$k]['name'] = str_replace('(*)', '', $v);
				$r['option'][$k]['on'] = strpos($v, '(*)') !== false ? 1 : 0;
			}
		}
		$lists[] = $r;
	}
	//$display = 0;
	if(!$AJ_BOT) $db->query("UPDATE LOW_PRIORITY {$AJ_PRE}{$ext} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');
	$head_title = $title.$AJ['seo_delimiter'].$L['form_title'];
	$template = $f['template'] ? $f['template'] : $ext;
} else {
	$head_title = $L['form_title'];
	if($catid) $typeid = $catid;
	$condition = '1';
	if($keyword) $condition .= " AND title LIKE '%$keyword%'";
	if($typeid) {
		isset($TYPE[$typeid]) or dheader($url);
		$condition .= " AND typeid IN (".type_child($typeid, $TYPE).")";
		$head_title = $TYPE[$typeid]['typename'].$AJ['seo_delimiter'].$head_title;
	}
	if($cityid) $condition .= ($AREA[$cityid]['child']) ? " AND areaid IN (".$AREA[$cityid]['arrchildid'].")" : " AND areaid=$cityid";
	$lists = $do->get_list($condition, 'addtime DESC');
	$template = $ext;
}
if($AJ_PC) {
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace($url, $mob, $AJ_URL);
} else {
	$foot = '';
	if($itemid) {
		$back_link = $mob;
	} else {
		$pages = mobile_pages($items, $page, $pagesize);
		$back_link = ($kw || $page > 1 || $typeid) ? $mob : AJ_MOB.'more.php';
	}
}
include template($template, $module);
?>