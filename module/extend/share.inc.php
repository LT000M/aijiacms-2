<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($mid > 4 && $itemid) {
	$item = $db->get_one("SELECT * FROM ".get_table($mid)." WHERE itemid=$itemid");
	($item && $item['status'] > 2) or message($L['msg_not_exist']);
	$title = $item['title'];
	$linkurl = $item['linkurl'];
	if(strpos($linkurl, '://') === false) $linkurl = ($AJ_PC ? $MODULE[$mid]['linkurl'] : $MODULE[$mid]['mobile']).$linkurl;
	$pic = isset($item['thumb']) ? str_replace('.thumb.', '.middle.', $item['thumb']) : '';
	$auth = urlencode(str_replace('amp;', '', $linkurl));
} else {
	message($L['share_not_support']);
}
$sms = 'sms:?body='.$linkurl;
if(preg_match("/(iPhone|iPod|iPad)/i", $_SERVER['HTTP_USER_AGENT'])) $sms = 'sms: &body='.$item['title'].$linkurl;
$template = 'share';
$head_title = $head_name = $L['share_title'];
$foot = '';
if($AJ_PC) {	
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace(AJ_PATH, AJ_MOB, $AJ_URL);
	$moduleid = $mid;
} else {
	$foot = '';
	$back_link = $linkurl;
}
include template($template, $module);
?>