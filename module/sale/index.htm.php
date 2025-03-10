<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$filename =  AJ_ROOT.'/'.$MOD['moduledir'].'/'.$AJ['index'].'.'.$AJ['file_ext'];
if(!$MOD['index_html']) {
	if(is_file($filename)) unlink($filename);
	$mobfile = str_replace(AJ_ROOT, AJ_ROOT.'/mobile', $filename);
	if(is_file($mobfile)) unlink($mobfile);
	return false;
}
$maincat = $childcat = get_maincat(0, $moduleid, 1);
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
$aijiacms_task = "moduleid=$moduleid&html=index";
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
	$condition = "status=3";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize, $MOD['mobile'].'index.php?page={aijiacms_page}');
	$tags = array();
	if($items) {
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
		while($r = $db->fetch_array($result)) {
			$r['title'] = set_style($r['title'], $r['style']);
			if(!$r['islink']) $r['linkurl'] = $MOD['mobile'].$r['linkurl'];
			$tags[] = $r;
		}
		$db->free_result($result);
		$js_load = $MOD['mobile'].'search.php?job=ajax';
	}
	$head_title = $head_name = $MOD['name'];
	ob_start();
	include template($template, $module);
	$data = ob_get_contents();
	ob_clean();
	file_put(str_replace(AJ_ROOT, AJ_ROOT.'/mobile', $filename), $data);
}
return true;
?>