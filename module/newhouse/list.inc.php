<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
$group_list  = isset($group_list ) ? intval($group_list ) : 0;
$child   = isset($child  ) ? intval($child ) : 0;
$letter = isset($letter ) ? intval($letter ) : 0;

$getstr=$_GET['str'];

$condition = 'status=3 and isnew=1';
$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(returnsx("b")!=-1) $condition .=" and price>=".returnsx("b")."";
if(returnsx("c")!=-1) $condition .=" and price<=".returnsx("c")."";
if(returnsx("t")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("t").",`catid`)" ;
if(returnsx("l")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("l").",`lpts`)" ;
//if(returnsx("l")!=-1) $condition .= " and lpts IN (".returnsx("l").")" ;
if(returnsx("j")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("j").",`buildtype`)" ;
if(returnsx("f")!=-1) $condition .= " AND FIND_IN_SET(".returnsx("f").",`fitment`)" ;

	if(returnsx("a")!=-1 && returnsx("d")==-1) {
	$arrchildid = get_arrchildids(returnsx("a"));
		$condition.=" and areaid in (".$arrchildid.")";}
//if(returnsx("a")!=-1 && returnsx("d")==-1) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=".returnsx("a");
if(returnsx("d")!=-1) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=".returnsx("d");
if(returnsx("e")!=-1) $condition.=" and `letter` like '%".returnsx("e")."%'";
if(returnsx("o")!=-1) $condition.=" and DATE_FORMAT(selltime,'%Y%m') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL ".returnsx("o")." MONTH),'%Y%m')";
if(returnsx("h")!=-1) $condition .= " AND typeid=".returnsx("h")."";
if($MOD['list_html']) {
	$html_file = listurl($CAT, $page);
	if(is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$html_file)) {
		@header("HTTP/1.1 301 Moved Permanently");
		dheader($MOD['linkurl'].$html_file);
	}
}
if(!check_group($_groupid, $MOD['group_list']) || !check_group($_groupid, $CAT['group_list'])) {
	$head_title = lang('message->without_permission');
	exit(include template('noright', 'message'));
}
$CP = $MOD['cat_property'] && $CAT['property'];
if($MOD['cat_property'] && $CAT['property']) {
	require AJ_ROOT.'/include/property.func.php';
	$PPT = property_condition($catid);
}
unset($CAT['moduleid']);
extract($CAT);

$maincat = get_maincat($child ? $catid : $parentid, $moduleid);

$sorder  = array($L['order'], $L['order_auto'], $L['price_dsc'], $L['price_asc'], $L['vip_dsc'], $L['vip_asc'], $L['selltime_dsc'], $L['selltime_asc'], $L['minamount_dsc'], $L['minamount_asc']);
$dorder  = array($MOD['order'], '', 'price DESC', 'price ASC', 'vip DESC', 'vip ASC', 'selltime DESC', 'selltime ASC', 'minamount DESC', 'minamount ASC');
isset($order) && isset($dorder[$order]) or $order = 0;

$areaids=$_GET['areaid'];


		
	if(returnsx("n")!=-1)
	{
		if(returnsx("n")=='1')
		{
			$order=" order by price desc";
		}
		elseif(returnsx("n")=='2')
		{
			$order=" order by price asc";
		}
		elseif(returnsx("n")=='3')
		{
			$order=" order by selltime asc";
		}
		elseif(returnsx("n")=='4')
		{
			$order="order by selltime desc";
		}
		$lst.= "-n".$ord;
	}
	else
	{
		$order = " order by ".$MOD['order'];
	}
	


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
if(returnsx("p")!=-1)$page=returnsx("p");
$pagesize = $MOD['pagesize'];
$offset = ($page-1)*$pagesize;
$items = $db->count($table, $condition, $CFG['db_expires']);
$total = ceil($items/$pagesize);
verify();

//$pages= $AJ_PC ? housepages($items, $page, returnsx("p"),$pagesize) : mobile_pages($items, $page, $pagesize, $MOD['mobile'].listurl($CAT, '{aijiacms_page}'));
$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
$tags = array();

if($items) {
   // $order = $dorder[$order] ? " ORDER BY $dorder[$order]" : '';
	$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE {$condition} {$order} LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
	
	while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['alt'] = $r['title'];
		$r['tedian'] = $r['tedian'];
		//if($lazy && isset($r['thumb']) && $r['thumb']) $r['thumb'] = AJ_SKIN.'image/lazy.gif" original="'.$r['thumb'];
		$r['buildtype'] = $r['buildtype'];
		$r['telephone'] = $r['telephone'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl']= $AJ_PC ? $MOD['linkurl'].$r['linkurl'] : $MOD['mobile'].$r['linkurl'];
		
		
		$tags[] = $r;
	}
	$db->free_result($result);
}
$showpage = 1;
$datetype = 5;
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
if($EXT['wap_enable']) $head_mobile = $EXT['wap_url'].'index.php?moduleid='.$moduleid.'&catid='.$catid.($page > 1 ? '&page='.$page : '');
$template = $CAT['template'] ? $CAT['template'] : ($MOD['template_list'] ? $MOD['template_list'] : 'list');
include template($template, $module);
?>