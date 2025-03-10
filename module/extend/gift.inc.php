<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['gift_enable'] or dheader(AJ_PATH);
require AJ_ROOT.'/include/post.func.php';
$ext = 'gift';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require AJ_ROOT.'/module/'.$module.'/'.$ext.'.class.php';
$do = new $ext();
$typeid = isset($typeid) ? intval($typeid) : 0;
switch($action) {
	case 'my':
		login();
		$condition = "username='$_username'";
		$lists = $do->get_my_order($condition);
		$head_title = $L['gift_my_order'].$AJ['seo_delimiter'].$L['gift_title'];
	break;
	case 'order':
		login();
		$itemid or dheader($AJ_PC ? $url : $mob);
		$do->itemid = $itemid;
		$item = $do->get_one();
		$item or dheader($AJ_PC ? $url : $mob);
		extract($item);
		$left = $amount - $orders > 0 ? $amount - $orders : 0;
		$process = $left ? get_process($fromtime, $totime) : 4;
		$_url = $AJ_PC ? $linkurl : str_replace($url, $mob, $linkurl);
		if($process == 1) dalert($L['gift_error_1'], $_url);
		if($process == 3) dalert($L['gift_error_3'], $_url);
		if($process == 4) dalert($L['gift_error_4'], $_url);
		if($_credit < $credit) dalert($L['gift_error_5'], $_url);
		if(!check_group($_groupid, $groupid)) dalert($L['gift_error_6'], $_url);
		if($maxorder) {
			$num = $db->count($AJ_PRE.'gift_order', "itemid=$itemid AND username='$_username'");
			if($num >= $maxorder) dalert($L['gift_error_7'], 'index.php?action=my');
		}
		if($EXT['gift_time']) {
			$t = $db->get_one("SELECT * FROM {$AJ_PRE}gift_order WHERE username='$_username'");
			if($t && $AJ_TIME - $t['addtime'] < $EXT['gift_time']) dalert($L['gift_error_8'], $_url);
		}
		credit_add($_username, -$credit);
		credit_record($_username, -$credit, 'system', $L['gift_credit_reason'], 'ID:'.$itemid);
		$db->query("INSERT INTO {$AJ_PRE}gift_order (itemid,credit,username,ip,addtime,status) VALUES ('$itemid','$credit','$_username','$AJ_IP','$AJ_TIME','".$L['gift_status']."')");
		$db->query("UPDATE {$AJ_PRE}gift SET orders=orders+1 WHERE itemid=$itemid");
		dheader('index.php?success=1&itemid='.$itemid);
	break;
	default:
		if($itemid) {
			$do->itemid = $itemid;
			$item = $do->get_one();
			$item or dheader($url);
			extract($item);
			$left = $amount - $orders > 0 ? $amount - $orders : 0;
			$process = $left ? get_process($fromtime, $totime) : 4;
			$adddate = timetodate($addtime, 3);
			$fromdate = $fromtime ? timetodate($fromtime, 3) : $L['timeless'];
			$todate = $totime ? timetodate($totime, 3) : $L['timeless'];
			$middle = str_replace('.thumb.', '.middle.', $thumb);
			$large = str_replace('.thumb.'.file_ext($thumb), '', $thumb);
			$gname = '';
			if($groupid) {
				$GROUP = cache_read('group.php');
				foreach(explode(',', $groupid) as $gid) {
					if(isset($GROUP[$gid])) $gname .= $GROUP[$gid]['groupname'].' ';
				}
			}
			$content = $AJ_PC ? parse_video($content) : video5($content);
			if(!$AJ_BOT) $db->query("UPDATE LOW_PRIORITY {$AJ_PRE}{$ext} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');
			$head_title = $title.$AJ['seo_delimiter'].$L['gift_title'];
		} else {
			$pagesize = 8;
			$offset = ($page-1)*$pagesize;
			$head_title = $L['gift_title'];
			if($catid) $typeid = $catid;
			$condition = "1";
			if($typeid) {
				isset($TYPE[$typeid]) or dheader($url);
				$condition .= " AND typeid IN (".type_child($typeid, $TYPE).")";
				$head_title = $TYPE[$typeid]['typename'].$AJ['seo_delimiter'].$head_title;
			}
			if($keyword) $condition .= " AND title LIKE '%$keyword%'";
			if($cityid) $condition .= ($AREA[$cityid]['child']) ? " AND areaid IN (".$AREA[$cityid]['arrchildid'].")" : " AND areaid=$cityid";
			$lists = $do->get_list($condition, 'addtime DESC');
		}
	break;
}
$template = $ext;
if($AJ_PC) {
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace($url, $mob, $AJ_URL);
} else {
	$foot = '';
	if($action == 'my') {
		$pages = mobile_pages($items, $page, $pagesize);
		$back_link =  $mob;
	} else {
		if($itemid) {
			$back_link = $mob;
		} else {
			$pages = mobile_pages($items, $page, $pagesize);
			$back_link = ($kw || $page > 1 || $typeid) ? $mob : AJ_MOB.'more.php';
		}
	}
}
include template($template, $module);
?>