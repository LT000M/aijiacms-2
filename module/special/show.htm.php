<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
if(!$MOD['show_html'] || !$itemid) return false;
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if(!$item || $item['status'] < 3 || $item['islink'] > 0) return false;
$could_comment = in_array($moduleid, explode(',', $EXT['comment_module'])) ? 1 : 0;
extract($item);
$CAT = get_cat($catid);
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $_content =  $t['content'];
$content = $_content =  $t['content'];
$content = parse_video($content);
if($MOD['keylink']) $content = keylink($content, $moduleid);
if($lazy) $content = img_lazy($content);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require_once AJ_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}

$TYPE = array();
foreach(get_type('special-'.$itemid) as $v) {
	$v['linkurl'] = $MOD['linkurl'].rewrite('type.php?tid='.$v['typeid']);
	$TYPE[] = $v;
}
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$fileurl = $domain ? $filepath : $linkurl;
$linkurl = $MOD['linkurl'].$linkurl;
$user_status = 3;
$seo_file = 'show';
include AJ_ROOT.'/include/seo.inc.php';
if($item['seo_title']) $seo_title = $item['seo_title'];
if($item['seo_keywords']) $head_keywords = $item['seo_keywords'];
if($item['seo_description']) $head_description = $item['seo_description'];
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : ($MOD['template_show'] ? $MOD['template_show'] : 'show'));
$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
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
	foreach($TYPE as $k=>$v) {
		$TYPE[$k]['linkurl'] = str_replace($MOD['linkurl'], $MOD['mobile'], $v['linkurl']);
	}
	$back_link = $MOD['mobile'].$CAT['linkurl'];
	$head_name = $CAT['catname'];
	$foot = '';
	$content = video5($_content);
	if($MOD['keylink']) $content = keylink($content, $moduleid, 1);
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	file_put(str_replace(AJ_ROOT, AJ_ROOT.'/mobile', $filename), $data);
}
return true;
?>