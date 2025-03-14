<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($AJ_PC) {
	if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
	$typeid = isset($typeid) ? intval($typeid) : 99;
	isset($TYPE[$typeid]) or $typeid = 99;
	$dtype = $typeid != 99 ? " AND typeid=$typeid" : '';
	$maincat = get_maincat($catid ? $CAT['parentid'] : 0, $moduleid);
	if($AJ['city']){
$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}
if($_COOKIE['SRecentlyGoods']){
	$browseHouse = browsesale($_COOKIE['SRecentlyGoods']);
  
 }
 $condition = "status=3";
	if($cityid) {
		$areaid = $cityid;
		$ARE = get_area($areaid);
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	}
	
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	
	if($catid) $seo_title = $seo_catname.$seo_title;
	if($typeid != 99) $seo_title = $TYPE[$typeid].$seo_delimiter.$seo_title;
	if($page == 1) $head_canonical = $MOD['linkurl'];
	$aijiacms_task = "moduleid=$moduleid&html=index";
	if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'].($page > 1 ? 'index.php?page='.$page : '');
} else {
	$condition = "status=3";
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
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);

	
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['title'] = str_replace('style="color:', 'style="font-size:16px;color:', set_style($r['title'], $r['style']));
			$r['linkurl'] = $MOD['mobile'].$r['linkurl'];
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