<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['vote_enable'] or dheader(AJ_PATH);
require AJ_ROOT.'/include/post.func.php';
$ext = 'vote';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require AJ_ROOT.'/module/'.$module.'/'.$ext.'.class.php';
$do = new $ext();
$typeid = isset($typeid) ? intval($typeid) : 0;
if($itemid) {
	$do->itemid = $itemid;
	$item = $do->get_one();
	$item or dheader($url);
	extract($item);
	if($submit) {
		if($verify == 1) captcha($captcha, 1);
		if($verify == 2) question($answer, 1);
		$could_vote = true;
		$condition = $_username ? "AND username='$_username'" : "AND ip='$AJ_IP'";
		$r = $db->get_one("SELECT rid FROM {$AJ_PRE}vote_record WHERE itemid=$itemid $condition");
		if($r) $could_vote = false;
		if($fromtime && $AJ_TIME < $fromtime) $could_vote = false;
		if($totime && $AJ_TIME > $totime) $could_vote = false;
		if(!check_group($_groupid, $groupid)) $could_vote = false;
		if($could_vote) {
			if($item['choose']) {
				$ids = array();
				$num = 0;
				foreach($vote as $k=>$v) {
					$s = 's'.$v;
					if($$s) {
						$ids[] = $v;
						++$num;
					}
				}
				if($num >= $vote_min && $num <= $vote_max) {
					foreach($ids as $k=>$v) {
						$v = 'v'.$v;
						$db->query("UPDATE {$AJ_PRE}vote SET votes=votes+1,`{$v}`=`{$v}`+1 WHERE itemid=$itemid");
					}
					$i = implode(',', $ids);
					$db->query("INSERT INTO {$AJ_PRE}vote_record (itemid,username,ip,votetime,votes) VALUES ('$itemid','$_username','$AJ_IP','$AJ_TIME','$i')");
				}
			} else {
				$i = $vote[0];
				$s = 's'.$i;
				$v = 'v'.$i;
				if($$s) {
					$db->query("UPDATE {$AJ_PRE}vote SET votes=votes+1,`{$v}`=`{$v}`+1 WHERE itemid=$itemid");
					$db->query("INSERT INTO {$AJ_PRE}vote_record (itemid,username,ip,votetime,votes) VALUES ('$itemid','$_username','$AJ_IP','$AJ_TIME','$i')");
				}
			}
			dheader($AJ_PC ? $linkurl : str_replace($url, $mob, $linkurl));
		} else {
			dalert($L['vote_failed'], $AJ_PC ? $linkurl : str_replace($url, $mob, $linkurl));
		}
	}
	$adddate = timetodate($addtime, 3);
	$fromdate = $fromtime ? timetodate($fromtime, 3) : $L['timeless'];
	$todate = $totime ? timetodate($totime, 3) : $L['timeless'];
	$content = $AJ_PC ? parse_video($content) : video5($content);
	$V = array();
	$j = 0;
	for($i = 1; $i < 11; $i++) {
		$s = 's'.$i;
		if($$s) {
			$V[$i]['title'] = $$s;
			$v = 'v'.$i;
			$V[$i]['votes'] = $$v;
			$V[$i]['percent'] = $item['votes'] ? dround($$v*100/$item['votes'], 2, true).'%' : '0%';
			$V[$i]['number'] = ++$j;
		}
	}
	if(!$AJ_BOT) $db->query("UPDATE LOW_PRIORITY {$AJ_PRE}{$ext} SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');
	$head_title = $title.$AJ['seo_delimiter'].$L['vote_title'];
	$template = $item['template'] ? $item['template'] : $ext;
} else {
	$head_title = $L['vote_title'];
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