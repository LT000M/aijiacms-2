<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$could_comment = in_array($moduleid, explode(',', $EXT['comment_module'])) ? 1 : 0;
if($AJ_PC) {
	$itemid or dheader($MOD['linkurl']);
	if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if($item['groupid'] == 2) include load('404.inc');
	if($item && $item['status'] > 2) {
		if($MOD['show_html'] && is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
		extract($item);
	} else {
		include load('404.inc');
	}
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = $t['content'];
	$content = parse_video($content);
	if($MOD['keylink']) $content = keylink($content, $moduleid);
	if($lazy) $content = img_lazy($content);
	$CP = $MOD['cat_property'] && $CAT['property'];
	if($CP) {
		require AJ_ROOT.'/include/property.func.php';
		$options = property_option($catid);
		$values = property_value($moduleid, $itemid);
	}
	$adddate = timetodate($addtime, 5);
	$editdate = timetodate($edittime, 5);
	$todate = $totime ? timetodate($totime, 3) : 0;
	$expired = $totime && $totime < $AJ_TIME ? true : false;
	$linkurl = $MOD['linkurl'].$linkurl;
	$thumbs = get_albums($item);
	$albums =  get_albums($item, 1);
	$update = '';
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	if(check_group($_groupid, $MOD['group_contact'])) {
		if($fee) {
			$user_status = 4;
			$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
		} else {
			$user_status = 3;
			$member = $item['username'] ? userinfo($item['username']) : array();
			if($item['totime'] && $item['totime'] < $AJ_TIME && $item['status'] == 3) $update .= ",status=4";
			if($member) {
				//$update_user = update_user($member, $item);
				if($update_user) $db->query("UPDATE LOW_PRIORITY {$table} SET ".substr($update_user, 1)." WHERE username='$username'", 'UNBUFFERED');
			}
		}
	} else {
		$user_status = $_userid ? 1 : 0;
		if($_username && $item['username'] == $_username) {
			$member = userinfo($item['username']);
			$user_status = 3;
		}
	}
	if($EXT['mobile_enable']) $head_mobile = str_replace($MOD['linkurl'], $MOD['mobile'], $linkurl);
} else {
	$itemid or dheader($MOD['mobile']);
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	($item && $item['status'] > 2) or message($L['msg_not_exist']);
	if($item['groupid'] == 2) message($L['msg_not_exist']);
	extract($item);
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) message($L['msg_no_right']);
	$member = array();
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	include AJ_ROOT.'/mobile/api/contact.inc.php';
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = video5($t['content']);
	if($MOD['keylink']) $content = keylink($content, $moduleid, 1);
	if($share_icon) $share_icon = share_icon($thumb, $content);
	$editdate = timetodate($edittime, 5);
	$expired = $totime && $totime < $AJ_TIME ? true : false;
	$could_price = ($user_status == 3 && $username && $username != $_username && !$expired) ? 1 : 0;
	$update = '';
	$back_link = $MOD['mobile'].$CAT['linkurl'];
	$head_name = $CAT['catname'];
	$foot = '';
}
if(!$AJ_BOT) include AJ_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : ($MOD['template_show'] ? $MOD['template_show'] : 'show'));
include template($template, $module);
?>