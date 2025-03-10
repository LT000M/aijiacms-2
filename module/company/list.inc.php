<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($AJ_PC) {
	
	if($MOD['list_html']) {
		$html_file = listurl($CAT, $page);
		if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) d301($MOD['linkurl'].$html_file);
	}
	if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) include load('403.inc');
	unset($CAT['moduleid']);
	extract($CAT);
	$maincat = get_maincat($child ? $catid : $parentid, $moduleid);
	
$getstr=$_GET['str'];
	if(returnsx("u")==-1)$condition = "groupid>5 ";
	if(returnsx("u")!=-1)
	{
		$lst.= "-u".$source;
		if(returnsx("u")==1)
		{
			$condition.=' groupid=6';
			$head_title = "经纪人";
		}
		elseif(returnsx("u")==2)
		{
				$condition.=' groupid=7 ';
			$head_title = "中介";
		}

	}
	
if(returnsx("a")!=-1 && returnsx("d")==-1) {
	$arrchildid = get_arrchildids(returnsx("a"));
		$condition.=" and areaid in (".$arrchildid.")";}
$areaids=$_GET['areaid'];
if($AJ['city'] && empty($areaid) && !empty($cityid)){
	
	$areaid = $cityid;
	$ARE = get_area($areaid);
	$condition .= $ARE['child'] ? " and areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	}
	
if($AJ['city']){

$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}

$items = $db->count($table, $condition, $CFG['db_expires']);
verify();
if(returnsx("p")!=-1)$page=returnsx("p");
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	$total = ceil($items/$pagesize);
	//$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobile_pages($items, $page, $pagesize, $MOD['mobile'].listurl($CAT, '{aijiacms_page}'));
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
	$tags = $_tags = $ids = array();
	if($items) {
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} ORDER BY ".$MOD['order']." LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
		while($r = $db->fetch_array($result)) {
			if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
			$tags[] = $r;
		}
	}
	$showpage = 1;
	if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'].listurl($CAT, $page);
} else {
	if(!$CAT || $CAT['moduleid'] != $moduleid) message($L['msg_not_cate']);
	if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) message($L['msg_no_right']);
	$condition = "groupid>5";
	$condition .= " AND catids like '%,".$catid.",%'";
	if($cityid) {
		$areaid = $cityid;
		$ARE = get_area($areaid);
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	}
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = mobile_pages($items, $page, $pagesize, $MOD['mobile'].listurl($CAT, '{aijiacms_page}'));
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	if($CAT['parentid']) {
		$PCAT = get_cat($CAT['parentid']);
		$back_link = $MOD['mobile'].$PCAT['linkurl'];
	} else {
		$back_link = $MOD['mobile'];
	}
	$head_title = $head_name = $CAT['catname'];
}
$seo_file = 'list';
include AJ_ROOT.'/include/seo.inc.php';
$template = $CAT['template'] ? $CAT['template'] : ($MOD['template_list'] ? $MOD['template_list'] : 'list');
include template($template, $module);
?>