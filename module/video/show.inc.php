<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/content.class.php';
$could_comment = in_array($moduleid, explode(',', $EXT['comment_module'])) ? 1 : 0;
$modurl = $AJ_PC ? $MOD['linkurl'] : $MOD['mobile'];
$itemid or dheader($modurl);
if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($modurl.$item['linkurl']);
	extract($item);
} else {
	include load('404.inc');
}
$CAT = get_cat($catid);
if(!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
if($AJ_PC) {
	if($content) {
		if($MOD['keylink']) $content = DC::keylink($content, $moduleid, $AJ_PC);
		if($lazy) $content = DC::lazy($content);
		$content = DC::format($content, $AJ_PC);
	}
	$CP = $MOD['cat_property'] && $CAT['property'];
	if($CP) {
		require AJ_ROOT.'/include/property.func.php';
		$options = property_option($catid);
		$values = property_value($moduleid, $itemid);
	}
	$linkurl = $MOD['linkurl'].$linkurl;
	$maincat = get_maincat(0, $moduleid);
	$keytags = $tag ? explode(' ', $tag) : array();
	$player = DC::player($video, $width, $height, $MOD['autostart']);
	$update = '';
	$fee = DC::fee($item['fee'], $MOD['fee_view']);
	if($fee) {
		$user_status = 4;
		$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid&page=$page";
		$description = '';
	} else {
		$user_status = 3;
	}
	if($EXT['mobile_enable']) $head_mobile = str_replace($MOD['linkurl'], $MOD['mobile'], $linkurl);
} else {
	$member = array();
	$fee = DC::fee($item['fee'], $MOD['fee_view']);
	include AJ_ROOT.'/mobile/api/content.inc.php';
	if($content) {
		if($MOD['keylink']) $content = DC::keylink($content, $moduleid, $AJ_PC);
		if($share_icon) $share_icon = DC::icon($thumb, $content);
		DC::format($content, $AJ_PC);
	}
	$player = DC::player($video, '100%', '100%', $MOD['autostart'], 0, ' playsinline -webkit-playsinline webkit-playsinline');
	$update = '';
	$head_name = $CAT['catname'];
	$js_item = 1;
	$foot = '';
}
if(!$AJ_BOT) include AJ_ROOT.'/include/update.inc.php';
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : ($MOD['template_show'] ? $MOD['template_show'] : 'show'));
include template($template, $module);
?>