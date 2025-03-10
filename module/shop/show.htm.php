<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if(!$item || $item['status'] < 3) return false;
require_once AJ_ROOT.'/include/content.class.php';
$could_comment = in_array($moduleid, explode(',', $EXT['comment_module'])) ? 1 : 0;
extract($item);
$CAT = get_cat($catid);
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $_content =  $t['content'];
if($content) {
	if($MOD['keylink']) $content = DC::keylink($content, $moduleid);
	if($lazy) $content = DC::lazy($content);
	$content = DC::format($content, 1);
}
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require_once AJ_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}
$adddate = timetodate($addtime, 5);
$editdate = timetodate($edittime, 5);
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $AJ_TIME ? true : false;
$fileurl = $linkurl;
$linkurl = $MOD['linkurl'].$linkurl;
$albums = get_albums($item);
$pics = count($albums);
$pics_width = $pics*70;
$amount = number_format($amount, 0, '.', '');
$fee = DC::fee($item['fee'], $MOD['fee_view']);
$user_status = 4;
$map_mid  = isset($map_mid) ? $map_mid : 0;
if($map){
$map_mid = $map;
}else{
$map_mid=$map_mid ;}
$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : ($MOD['template_show'] ? $MOD['template_show'] : 'show'));
$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
if($EXT['mobile_enable']) $head_mobile = str_replace($MOD['linkurl'], $MOD['mobile'], $linkurl);
$AJ_PC = $GLOBALS['AJ_PC'] = 1;
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
$filename = AJ_ROOT.'/'.$MOD['moduledir'].'/'.$fileurl;
if($AJ['pcharset']) $filename = convert($filename, AJ_CHARSET, $AJ['pcharset']);
file_put($filename, $data);
if($EXT['mobile_enable']) {
	include AJ_ROOT.'/include/mobile.htm.php';
	$head_pc = $linkurl;
	$could_purchase = (SELL_ORDER && $price > 0 && $minamount > 0 && $amount > 0 && $unit && $username) ? 1 : 0;
	$could_inquiry = ($user_status == 3 && $username && !$expired) ? 1 : 0;
	$head_title = $head_name = $CAT['catname'];
	$js_item = $js_album = 1;
	$foot = '';
	if($_content) {
		$content = $_content;
		if($MOD['keylink']) $content = DC::keylink($content, $moduleid, 0);
		$content = DC::format($content, 0);
	}
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	file_put(str_replace(AJ_ROOT, AJ_ROOT.'/mobile', $filename), $data);
}
return true;
?>