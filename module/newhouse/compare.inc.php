<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
check_group($_groupid, $MOD['group_compare']) or dalert(lang('message->without_permission'), 'goback');
$AJ_URL = $AJ_REF;
$itemid = $_GET['itemid'];
$itemid = explode('-',$itemid);
if (preg_match('/^[0-9]*$/',$itemid[0])){
}else {
 echo "404";
 dhttp(403);
}
//$itemid && is_array($itemid) or dalert($L['compare_choose'], 'goback');
$itemid = array_unique($itemid);
$item_nums = count($itemid);
$item_nums < 9 or dalert($L['compare_max'], 'goback');
//$item_nums > 1 or dalert($L['compare_min'], 'goback');
$itemid = implode(',', $itemid);
$tags = array();
$result = $db->query("SELECT * FROM {$table} WHERE itemid IN ($itemid) ORDER BY addtime DESC");
while($r = $db->fetch_array($result)) {
	if($r['status'] != 3) continue;
	$r['editdate'] = timetodate($r['edittime'], 3);
	$r['adddate'] = timetodate($r['addtime'], 3);
	$r['stitle'] = dsubstr($r['title'], 30);
	$r['stitle'] = set_style($r['stitle'], $r['style']);
	$r['userurl'] = userurl($r['username']);
	$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
	$tags[] = $r;
}
$head_title = $L['compare_title'].$AJ['seo_delimiter'].$MOD['name'];
include template($MOD['template_compare'] ? $MOD['template_compare'] : 'compare', $module);
?>