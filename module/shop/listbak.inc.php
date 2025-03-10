<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
	if($AJ['city']){
$mainarea = get_mainarea($cityid);
$mainareas = get_mainarea2($areaids);
}else{
$mainarea = get_mainarea(0);
$mainareas = get_mainarea3($areaids);}
	if($MOD['list_html']) {
		$html_file = listurl($CAT, $page);
		if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) d301($MOD['linkurl'].$html_file);
	}
	if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) include load('403.inc');
	$CP = $MOD['cat_property'] && $CAT['property'];
	if($MOD['cat_property'] && $CAT['property']) {
		require AJ_ROOT.'/include/property.func.php';
		$PPT = property_condition($catid);
	}
	unset($CAT['moduleid']);
	extract($CAT);
	$maincat = get_maincat($child ? $catid : $parentid, $moduleid);
	$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);
$getstr=$_GET['str'];
$condition = 'status=3 ';
if(returnsx("d")!=-1)
{
$areaid=get_areapy($areapy);
}
else
{
$areaidd=get_areapy($areapy);
}
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(returnsx("b")!=-1) $condition .=" and price>=".returnsx("b")."";
if(returnsx("c")!=-1) $condition .=" and price<=".returnsx("c")."";
if(returnsx("g")!=-1){$condition.=" and houseearm>=".returnsx("g")."";}
if(returnsx("h")!=-1){$condition.=" and houseearm<=".returnsx("h")."";}
if(returnsx("l")!=-1){$condition.=" and floor>=".returnsx("l")."";}
if(returnsx("e")!=-1){$condition.=" and floor<=".returnsx("e")."";}
if(returnsx("y")!=-1){$condition.=" and year>=".returnsx("y")."";}
if(returnsx("w")!=-1){$condition.=" and year<=".returnsx("w")."";}
if(returnsx("t")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("t").",`catid`)" ;
if(returnsx("s")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("s").",`toward`)" ;

if(returnsx("f")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("f").",`fix`)" ;
if($areaid!=-1 && $areaidd==-1) {
	$arrchildid = get_arrchildids($areaid);
		$condition.=" and areaid in (".$arrchildid.")";}
if($areaidd!=-1) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=".$areaidd;

if(returnsx("r")!=-1) $condition .= " AND room=".returnsx("r")."";

echo $condition;

if(returnsx("o")!=-1)
	{
		$lst.= "-o".returnsx("o");
		$fromdate = timetodate($AJ_TIME-returnsx("o")*86400, 'Ymd');
		$condition .= " AND edittime>=$fromdate";
		$condition .= " AND edittime>=$fromdate";
		$lstaddr.= "<i>".$opentime_name."<a href=\"list".deal_str($lst,'o').".html\"></a></i>";
	}
	if(returnsx("j")!=-1)
	{   
	   
		if(returnsx("j")==1)
		{   $condition.=' AND istop=1';
			
		}
		elseif(returnsx("j")==2)
		{   $condition.=' AND ishot=1';
		
		}
		elseif(returnsx("j")==3)
		{ $condition.=" and typeid=0";
		
		}
	elseif(returnsx("j")==4)
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
	$tags = array();

	if($items) {
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} {$order} LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['linkurl']= $AJ_PC ? $MOD['linkurl'].$r['linkurl'] : $MOD['mobile'].$r['linkurl'];
		if($r['to_time'] < $AJ_TIME ) {
			$db->query("UPDATE {$table} SET istop=0 WHERE itemid=".$r['itemid']."");
		}
		if($r['hot_time'] < $AJ_TIME ) {
			$db->query("UPDATE {$table} SET ishot=0 WHERE itemid=".$r['itemid']."");
		}
			$tags[] = $r;
		}
		$db->free_result($result);
	}//右边浏览过房源
//右边浏览过房源
if($_COOKIE['RRecentlyGoods']){
	$browseHouse = browseHouse($_COOKIE['RRecentlyGoods']);
  
 }
	$showpage = 1;
	$datetype = 5;
	$seo_file = 'list';
	if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'].listurl($CAT, $page);

	if($CAT['parentid']) {
		$PCAT = get_cat($CAT['parentid']);
		$back_link = $MOD['mobile'].$PCAT['linkurl'];
	} else {
		$back_link = $MOD['mobile'];
	}
	$head_title = $head_name = $CAT['catname'];

$seo_file = 'list';
include AJ_ROOT.'/include/seo.inc.php';
$template = $CAT['template'] ? $CAT['template'] : ($MOD['template_list'] ? $MOD['template_list'] : 'list');
include template($template, $module);
?>