<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($AJ_PC) {
	if($MOD['index_html']) {	
		$html_file = AJ_ROOT.'/'.$MOD['moduledir'].'/'.$AJ['index'].'.'.$AJ['file_ext'];
		if(!is_file($html_file)) tohtml('index', $module);
		if(is_file($html_file)) exit(include($html_file));
	}
	if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
	$maincat = $childcat = get_maincat(0, $moduleid, 1);
	if($AJ['city']){
$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}
$condition = "status=3 and isnew=1";
	if($cityid) {
		$areaid = $cityid;
		$ARE = get_area($areaid);
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	}

	//$aijiacms_task = "moduleid=$moduleid&html=index";$condition = "status=3 and isnew=1";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	
	$items = $r['num'];
	if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'].($page > 1 ? 'index.php?page='.$page : '');
} else {
	$condition = "status=3 and isnew=1";
	if($cityid) {
		$areaid = $cityid;
		$ARE = get_area($areaid);
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	}
	
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	
	//$pages = mobile_pages($items, $page, $pagesize);
	if(returnsx("p")!=-1)$page=returnsx("p");
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	$total = ceil($items/$pagesize);
	$pages= mobilehousepages($items, $page, $lst,$pagesize) ;
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['title'] = str_replace('style="color:', 'style="font-size:16px;color:', set_style($r['title'], $r['style']));
			if(!$r['islink']) $r['linkurl'] = $MOD['mobile'].$r['linkurl'];
			$r['date'] = timetodate($r[$time], 3);
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	$back_link = AJ_MOB.'channel.php';
	$head_name = $MOD['name'];
}
$seo_file = 'index';
include AJ_ROOT.'/include/seo.inc.php';
include template($MOD['template_index'] ? $MOD['template_index'] : 'index', $module);
?>