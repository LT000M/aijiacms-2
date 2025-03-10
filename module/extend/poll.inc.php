<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['poll_enable'] or dheader(AJ_PATH);
require AJ_ROOT.'/include/post.func.php';
$ext = 'poll';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require AJ_ROOT.'/module/'.$module.'/'.$ext.'.class.php';
$do = new $ext();
$typeid = isset($typeid) ? intval($typeid) : 0;
if($action == 'js') {
	$itemid or exit;
	exit('document.write(\'<iframe src="'.($AJ_PC ? $url : $mob).'index.php?action=show&itemid='.$itemid.'" style="width:99%;height:0;" scrolling="no" frameborder="0" id="aijiacms_poll_'.$itemid.'"></iframe>\');');
} else if($action == 'ajax') {
	$itemid or exit($L['poll_error_3']);
	$I = $db->get_one("SELECT * FROM {$AJ_PRE}poll_item WHERE itemid=$itemid");
	$I or exit($L['poll_error_4']);
	$do->itemid = $pollid = $I['pollid'];
	$item = $do->get_one();
	$item or exit($L['poll_error_5']);
	if(!check_group($_groupid, $item['groupid'])) exit($_userid ? $L['poll_error_1'] : $L['poll_error_2']);
	if($item['fromtime'] && $item['fromtime'] > $AJ_TIME) exit($L['poll_error_6']);
	if($item['totime'] && $item['totime'] < $AJ_TIME) exit($L['poll_error_7']);
	if($item['verify'] == 1) {
		$msg = captcha($captcha, 1, true);
		if($msg) exit($msg);
	}
	if($item['verify'] == 2) {
		$msg = question($answer, 1, true);
		if($msg) exit($msg);
	}
	$condition = $_username ? "AND username='$_username'" : "AND ip='$AJ_IP' AND polltime>".($AJ_TIME - 86400);
	$t = $db->get_one("SELECT * FROM {$AJ_PRE}poll_record WHERE itemid=$itemid {$condition}");
	if($t) exit($L['poll_error_8']);
	if($item['poll_max']) {		
		$t = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}poll_record WHERE pollid=$pollid {$condition}");
		if($t['num'] >= $item['poll_max']) exit(lang($L['poll_error_9'], array($item['poll_max'])));
	}
	$db->query("INSERT INTO {$AJ_PRE}poll_record (itemid,pollid,username,ip,polltime) VALUES ('$itemid','$pollid','$_username','$AJ_IP','$AJ_TIME')");
	$db->query("UPDATE {$AJ_PRE}poll_item SET polls=polls+1 WHERE itemid=$itemid");
	$db->query("UPDATE {$AJ_PRE}poll SET polls=polls+1 WHERE itemid=$pollid");
	exit('ok');
} else if($action == 'show') {
	$itemid or exit;
	$do->itemid = $itemid;
	$P = $do->get_one();
	$P or exit;
	extract($P);
	$cols = $poll_cols;
	$percent = dround(100/$cols).'%';
	$pagesize = $poll_page;
	$offset = ($page-1)*$pagesize;
	$order = $poll_cols ? 'polls DESC,listorder DESC,itemid DESC' : 'listorder DESC,itemid DESC';
	$polls = $do->item_list("pollid=$itemid", $order);
	$condition = $_username ? "AND username='$_username'" : "AND ip='$AJ_IP' AND polltime>".($AJ_TIME - 86400);
	$votes = array();
	$result = $db->query("SELECT * FROM {$AJ_PRE}poll_record WHERE pollid=$itemid $condition");
	while($r = $db->fetch_array($result)) {
		$votes[$r['itemid']] = $r['itemid'];
	}
	if(!$AJ_BOT) $db->query("UPDATE LOW_PRIORITY {$AJ_PRE}{$ext} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');	
	$template_poll = $P['template_poll'] ? $P['template_poll'] : 'poll';
	$template = $ext;
} else {
	if($itemid) {
		$do->itemid = $itemid;
		$item = $do->get_one();
		$item or dheader($AJ_PC ? $url : $mob);
		extract($item);
		$adddate = timetodate($addtime, 3);
		$fromdate = $fromtime ? timetodate($fromtime, 3) : $L['timeless'];
		$todate = $totime ? timetodate($totime, 3) : $L['timeless'];
		$content = $AJ_PC ? parse_video($content) : video5($content);
		$head_title = $title.$AJ['seo_delimiter'].$L['poll_title'];
		$template = $item['template'] ? $item['template'] : $ext;
		if($AJ_PC) {
			//
		} else {
			$P = $item;
			$pagesize = 1000;
			$offset = ($page-1)*$pagesize;
			$order = $poll_cols ? 'polls DESC,listorder DESC,itemid DESC' : 'listorder DESC,itemid DESC';
			$polls = $do->item_list("pollid=$itemid", $order);
			$condition = $_username ? "AND username='$_username'" : "AND ip='$AJ_IP' AND polltime>".($AJ_TIME - 86400);
			$votes = array();
			$result = $db->query("SELECT * FROM {$AJ_PRE}poll_record WHERE pollid=$itemid $condition");
			while($r = $db->fetch_array($result)) {
				$votes[$r['itemid']] = $r['itemid'];
			}
			if(!$AJ_BOT) $db->query("UPDATE LOW_PRIORITY {$AJ_PRE}{$ext} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');	
			$template_poll = $P['template_poll'] ? $P['template_poll'] : 'poll';
			$pages = '';
		}
	} else {
		$head_title = $L['poll_title'];
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