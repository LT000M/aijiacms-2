<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($AJ_PC) {
$itemid or dheader($MOD['linkurl']);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	//if(get_fenzhandomain($item['cityids']))include load('404.inc');
if($item && $item['status'] > 2) {
	if($MOD['show_html'] && is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) {
		@header("HTTP/1.1 301 Moved Permanently");
		dheader($MOD['linkurl'].$item['linkurl']);
	}
	extract($item);
} else {
	$head_title = lang('message->item_not_exists');
	@header("HTTP/1.1 404 Not Found");
	exit(include template('show-notfound', 'message'));
}
$CAT = get_cat($catid);
if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) {
	$head_title = lang('message->without_permission');
	exit(include template('noright', 'message'));
}
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($MOD['keylink']) $content = keylink($content, $moduleid);

$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	require AJ_ROOT.'/include/property.func.php';
	$options = property_option($catid);
	$values = property_value($moduleid, $itemid);
}




$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
//$selltime = timetodate($selltime, 3);
//$completion = timetodate($completion, 3);

if($map){
$map_mid = $map;
}else{
$map_mid=$map_mid ;}
$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }

$itype = explode('|', trim($MOD['inquiry_type']));
$iask = explode('|', trim($MOD['inquiry_ask']));
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $AJ_TIME ? true : false;
$linkurl = $MOD['linkurl'].$linkurl;
$thumbs = get_albums($item);
$albums =  get_albums($item, 1);
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$update = '';
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
		$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($item['totime'] && $item['totime'] < $AJ_TIME && $item['status'] == 3) {
			$update .= ",status=4";
			$db->query("UPDATE {$table}_search SET status=4 WHERE itemid=$itemid and isnew=1");
		}
	
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
switch($at) {
	case 'sale':
	
	$head_title = $title.'-二手房';
	if(returnsx("r")>0)$head_title .=  returnsx("r").'室';
	if(returnsx("g")>0)$head_title .=  returnsx("g").'-'.returnsx("h").'平米';
	
	$condition = 'status=3 and houseid = '.$itemid.' ';

	$getstr=$_GET['str'];

$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(returnsx("b")!=-1) $condition .=" and price>=".returnsx("b")."";
if(returnsx("c")!=-1) $condition .=" and price<=".returnsx("c")."";
if(returnsx("g")!=-1){$condition.=" and houseearm>=".returnsx("g")."";}
if(returnsx("h")!=-1){$condition.=" and houseearm<=".returnsx("h")."";}
if(returnsx("r")!=-1) $condition .= " AND room=".returnsx("r")."";
	if(returnsx("j")!=-1)
	{   
	   
		
		if(returnsx("j")==1)
		{ $condition.=" and typeid=0";
		
		}
	elseif(returnsx("j")==2)
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
			$order = " order by price/houseearm desc";
			$order_name = "单价从高到低";
		}
		elseif(returnsx("n")=='5')
		{
			$order = " order by price/houseearm ASC";
			$order_name = "单价从低到高";
		}
		elseif(returnsx("n")=='6')
		{
				$order = " order by (price+0) desc";
			$order_name = "总价从高到低";
		}
		elseif(returnsx("n")=='7')
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
	$tags = array();
$hsall=$db->pre.'sale_5';
$pagesize =10;
    $page = max($page,1);
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
$result = $db->query("SELECT * FROM $hsall WHERE {$condition} $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MODULE[5][linkurl].$r['linkurl'];
		
		$tags[] = $r;
	}
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'sale');
	break;
	case 'rent':
	
	
	$condition = 'status=3 and houseid = '.$itemid.' ';
$getstr=$_GET['str'];

$typeid = isset($typeid) && isset($TYPE[$typeid]) ? intval($typeid) : 99;
if(returnsx("b")!=-1) $condition .=" and price>=".returnsx("b")."";
if(returnsx("c")!=-1) $condition .=" and price<=".returnsx("c")."";
if(returnsx("g")!=-1){$condition.=" and houseearm>=".returnsx("g")."";}
if(returnsx("h")!=-1){$condition.=" and houseearm<=".returnsx("h")."";}
if(returnsx("r")!=-1) $condition .= " AND room=".returnsx("r")."";
	if(returnsx("j")!=-1)
	{   
	   
		
		if(returnsx("j")==1)
		{ $condition.=" and typeid=0";
		
		}
	elseif(returnsx("j")==2)
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
	$tags = array();
$hsall=$db->pre.'rent_7';
$pagesize =10;
    $page = max($page,1);
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
$result = $db->query("SELECT * FROM $hsall WHERE {$condition} $order LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MODULE[7][linkurl].$r['linkurl'];
		
		$tags[] = $r;
	}
	$head_title = $title.'-租房';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'rent');
	break;
	case 'price':
	$head_title = $title.'-价格走势';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'jiage');
	break;
	case 'map':
	$head_title = $title.'-交通配套';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'map');
	break;

	default:
	
	$at='index';
		$template = 'show';

} $seo_file = 'show';
	include AJ_ROOT.'/include/seo.inc.php';
	include AJ_ROOT.'/include/update.inc.php';
    if($MOD['template_show']) $template = $MOD['template_show'];
   if($CAT['show_template']) $template = $CAT['show_template'];
   if($item['template']) $template = $item['template'];
   if($EXT['mobile_enable']) $head_mobile = str_replace($MOD['linkurl'], $MOD['mobile'], $linkurl);
include template($template, $module);
}
else {
	$itemid or dheader($MOD['mobile']);
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	($item && $item['status'] > 2) or message($L['msg_not_exist']);
	if($item['groupid'] == 2) message($L['msg_not_exist']);
	extract($item);
	$CAT = get_cat($catid);
	if(!check_group($_groupid, $MOD['group_show']) || !check_group($_groupid, $CAT['group_show'])) mobile_msg($L['msg_no_right']);
	$member = array();
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	include AJ_ROOT.'/mobile/api/contact.inc.php';
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = video5($t['content']);
	if($MOD['keylink']) $content = keylink($content, $moduleid, 1);
	if($share_icon) $share_icon = share_icon($thumb, $content);
	$editdate = timetodate($edittime, 5);
	$expired = $totime && $totime < $AJ_TIME ? true : false;
	$could_purchase = (SELL_ORDER && $price > 0 && $minamount > 0 && $amount > 0 && $unit && $username && $username != $_username && !$expired) ? 1 : 0;
	$could_inquiry = ($user_status == 3 && $username && $username != $_username && !$expired) ? 1 : 0;
	$update = '';
	$back_link = $MOD['mobile'].$CAT['linkurl'];
	$head_name = $CAT['catname'];
	$foot = '';
	$map_mid  = isset($map_mid) ? $map_mid : 0;
if($map){
$map_mid = $map;
}else{
$map_mid=$map_mid ;}


$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
	switch($at) {

	case 'sale':
	
	$head_title = $title.'-二手房';
	$condition = 'status=3 and houseid = '.$itemid.' ';

	$tags = array();
$hsall=$db->pre.'sale_5';
$pagesize =10;
    $page = max($page,1);
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
$result = $db->query("SELECT * FROM $hsall WHERE {$condition} order by edittime desc LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MODULE[5][linkurl].$r['linkurl'];
		
		$tags[] = $r;
	}
	
	include template('sale', 'community');
	break;
	case 'rent':
	
	$head_title = $title.'-租房';
	$condition = 'status=3 and houseid = '.$itemid.' ';

	$tags = array();
$hsall=$db->pre.'rent_7';
$pagesize =10;
    $page = max($page,1);
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  {$condition}");
	$items = $r['num'];
	$pages= $AJ_PC ? housepages($items, $page, $lst,$pagesize) : mobilehousepages($items, $page, $lst,$pagesize);
$result = $db->query("SELECT * FROM $hsall WHERE {$condition} order by edittime desc LIMIT {$offset},{$pagesize}", ($CFG['db_expires'] && $page == 1) ? 'CACHE' : '', $CFG['db_expires']);
while($r = $db->fetch_array($result)) {
		$r['adddate'] = timetodate($r['addtime'], 5);
		$r['editdate'] = timetodate($r['edittime'], 5);
		$r['danjia']=floor($r['price']*10000/$r['houseearm']);
		$r['alt'] = $r['title'];
		$r['title'] = set_style($r['title'], $r['style']);
		$r['linkurl'] = $MODULE[7][linkurl].$r['linkurl'];
		
		$tags[] = $r;
	}
	
	include template('rent', 'community');
	break;

	default:
	$typeids=$typeid-1;
	$at='index';
	include template('show', 'community');
}
}
  
	
  
?>
