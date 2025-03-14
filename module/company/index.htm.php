<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$filename = AJ_CACHE.'/htm/company.htm';
if(!$MOD['index_html']) {
	if(is_file($filename)) file_del($filename);
	$mobfile = str_replace('company.htm', 'company.mob.htm', $filename);
	if(is_file($mobfile)) unlink($mobfile);
	return false;
}
if($AJ['rewrite']) {
	defined('AJ_REWRITE') or define('AJ_REWRITE', true);
	$_SERVER["SCRIPT_NAME"] = 'index.php';
	$_SERVER['QUERY_STRING'] = '';
}
$GLOBALS['AJ_URL'] = $AJ_URL = 'index.php';
$CSS = array('catalog');
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$aijiacms_task = "moduleid=$moduleid&html=index";
if($page == 1) $head_canonical = $MOD['linkurl'];
$template = $MOD['template_index'] ? $MOD['template_index'] : 'index';
if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'];
$AJ_PC = $GLOBALS['AJ_PC'] = 1;
ob_start();
include template($template, $module);
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
if($EXT['mobile_enable']) {
	include AJ_ROOT.'/include/mobile.htm.php';
	$head_pc = $MOD['linkurl'];
	$condition = "groupid>5";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize, $MOD['mobile'].'index.php?page={aijiacms_page}');
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	$back_link = AJ_MOB.'channel.php';
	$head_name = $MOD['name'];
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	file_put(str_replace('company.htm', 'company.mob.htm', $filename), $data);
}
return true;
?>