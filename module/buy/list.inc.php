<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
	if($AJ['city']){
$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}
if($AJ_PC) {
	
	if($MOD['list_html']) {
		$html_file = listurl($CAT, $page);
		if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) d301($MOD['linkurl'].$html_file);
	}
	//if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) include load('403.inc');
	$CP = $MOD['cat_property'] && $CAT['property'];
	if($MOD['cat_property'] && $CAT['property']) {
		require AJ_ROOT.'/include/property.func.php';
		$PPT = property_condition($catid);
	}
	unset($CAT['moduleid']);
	extract($CAT);
	$maincat = get_maincat($child ? $catid : $parentid, $moduleid);

	$getstr=$_GET['str'];
$condition = 'status=3 ';
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(returnsx("g")!=-1){$condition.=" and houseearm>=".returnsx("g")."";}
if(returnsx("h")!=-1){$condition.=" and houseearm<=".returnsx("h")."";}
if(returnsx("t")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("t").",`catid`)" ;
if(returnsx("a")!=-1 && returnsx("d")==-1) {
	$arrchildid = get_arrchildids(returnsx("a"));
		$condition.=" and areaid in (".$arrchildid.")";}
if(returnsx("d")!=-1) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=".returnsx("d");
if(returnsx("r")!=-1) $condition .= " AND room=".returnsx("r")."";
if(returnsx("o")!=-1)
	{
		$lst.= "-o".returnsx("o");
		$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
		$fromdate = $AJ_TIME-returnsx("o")*86400;
		$condition .= " AND edittime>=$fromdate";
		
		$opentime_name= returnsx("o")."天内";
		
	}
	if(returnsx("u")!=-1)
	{   
	   
		
		if(returnsx("u")==1)
		{ $condition.=" and typeid=0";
		
		}
	elseif(returnsx("u")==2)
		{ $condition.=" and typeid=1";
		
		}
	}

	if(returnsx("n")!=-1)
	{
		
		if(returnsx("n")=='1')
		{
		    $order = " order by edittime desc";
		
		}
		if(returnsx("n")=='2')
		{
		    $order = " order by houseearm desc";
			$order_name = "建面从大到小";
		}
		elseif(returnsx("n")=='3')
		{
				$order = " order by houseearm ASC";
			$order_name = "建面从小到大";
		}
		
		elseif(returnsx("n")=='4')
		{
				$order = " order by (price+0) desc";
			$order_name = "总价从高到低";
		}
		elseif(returnsx("n")=='5')
		{
				$order = " order by (price+0) ASC";
			$order_name = "总价从低到高";
		}
		
		
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
		$order_name = "默认排序";
	}
	if($cityid) {
		$areaid = $cityid;
		$ARE = get_area($areaid);
		$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	}
		
			$items = $db->count($table, $condition, $CFG['db_expires']);
		
	
	//$page = max($page,1);
if(returnsx("p")!=-1)$page=returnsx("p");
	$pagesize = $MOD['pagesize'];
	$offset = ($page-1)*$pagesize;
	$total = ceil($items/$pagesize);
	//$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobile_pages($items, $page, $pagesize, $MOD['mobile'].listurl($CAT, '{aijiacms_page}'));
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
	
verify();
	$tags = array();
	
	if($items) {
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition}  $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$tags[] = $r;
		}
		$db->free_result($result);
	}
	$showpage = 1;
	$datetype = 5;
	if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'].listurl($CAT, $page);
} else {
	//if(!$CAT || $CAT['moduleid'] != $moduleid) message($L['msg_not_cate']);
	//if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) message($L['msg_no_right']);
	$getstr=$_GET['str'];
	$condition = "status=3";
	$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(returnsx("g")!=-1){$condition.=" and houseearm>=".returnsx("g")."";}
if(returnsx("h")!=-1){$condition.=" and houseearm<=".returnsx("h")."";}
if(returnsx("t")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("t").",`catid`)" ;
if(returnsx("a")!=-1 && returnsx("d")==-1) {
	$arrchildid = get_arrchildids(returnsx("a"));
		$condition.=" and areaid in (".$arrchildid.")";}
if(returnsx("d")!=-1) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=".returnsx("d");
if(returnsx("r")!=-1) $condition .= " AND room=".returnsx("r")."";
if(returnsx("o")!=-1)
	{
		$lst.= "-o".returnsx("o");
		$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
		$fromdate = $AJ_TIME-returnsx("o")*86400;
		$condition .= " AND edittime>=$fromdate";
		
		$opentime_name= returnsx("o")."天内";
		
	}
	if(returnsx("u")!=-1)
	{   
	   
		
		if(returnsx("u")==1)
		{ $condition.=" and typeid=0";
		
		}
	elseif(returnsx("u")==2)
		{ $condition.=" and typeid=1";
		
		}
	}

	if(returnsx("n")!=-1)
	{
		
		if(returnsx("n")=='1')
		{
		    $order = " order by edittime desc";
		
		}
		if(returnsx("n")=='2')
		{
		    $order = " order by houseearm desc";
			$order_name = "建面从大到小";
		}
		elseif(returnsx("n")=='3')
		{
				$order = " order by houseearm ASC";
			$order_name = "建面从小到大";
		}
		
		elseif(returnsx("n")=='4')
		{
				$order = " order by (price+0) desc";
			$order_name = "总价从高到低";
		}
		elseif(returnsx("n")=='5')
		{
				$order = " order by (price+0) ASC";
			$order_name = "总价从低到高";
		}
		
		
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
		$order_name = "默认排序";
	}
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