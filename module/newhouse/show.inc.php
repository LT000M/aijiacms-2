<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$could_comment = in_array($moduleid, explode(',', $EXT['comment_module'])) ? 1 : 0;
$could_wenfang = in_array($moduleid, explode(',', $EXT['wenfang_module'])) ? 1 : 0;
if($AJ_PC) {
	$itemid or dheader($MOD['linkurl']);
	if(!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if($item['groupid'] == 2) include load('404.inc');
	if($item && $item['status'] > 2) {
		if($MOD['show_html'] && is_file(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl'])) d301($MOD['linkurl'].$item['linkurl']);
		require AJ_ROOT.'/include/content.class.php';
		extract($item);
	} else {
		include load('404.inc');
	}
	$CAT = get_cat($catid);
	//if(!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
verify();
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if($MOD['keylink']) $content = keylink($content, $moduleid);
$CP = $MOD['cat_property'] && $CAT['property'];
if($CP) {
	//require AJ_ROOT.'/include/property.func.php';
	//$options = property_option($catid);
	//$values = property_value($moduleid, $itemid);
}
//历史价格图

$buynum = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}message WHERE title='$title' AND typeid=1 AND status=3");
$buynum = $buynum['num'];

//意向登记
$message=$db->pre.'message';

		$result = $db->query("SELECT * FROM $message  where title='$title'and typeid=1 LIMIT 0,6");
	
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], $L['message_list_date']);
			
		     
			$messages[] = $r;
		}

	//相册图楼盘  10条记录

$catids = isset($catids) ? $catids : '';


$cat=get_cat($catids);

	
$picitem = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}newhouse_xiangce WHERE houseid=$itemid");
$picitems = $picitem['num'];


$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
//$selltime = timetodate($selltime, 3);
//$completion = timetodate($completion, 3);

$pricea=$price-500;
$priceb=$price+500;
$itype = explode('|', trim($MOD['inquiry_type']));
$iask = explode('|', trim($MOD['inquiry_ask']));
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $AJ_TIME ? true : false;
$linkurl = $MOD['linkurl'].$linkurl;

$fee = get_fee($item['fee'], $MOD['fee_view']);
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
$zhiyes=explode(" ",$zhiye);		  
$update = '';
if(check_group($_groupid, $MOD['group_contact'])) {
	if($fee) {
		$user_status = 4;
		$aijiacms_task = "moduleid=$moduleid&html=show&itemid=$itemid";
	} else {
		$user_status = 3;
		$member = $item['username'] ? userinfo($item['username']) : array();
		if($item['totime'] && $item['totime'] < $AJ_TIME && $item['status'] == 3) {
			$update .= ",isfx=0";
			$db->query("UPDATE {$table} SET isfx=0 WHERE itemid=$itemid and isnew=1");
		}
	
	}
} else {
	$user_status = $_userid ? 1 : 0;
	if($_username && $item['username'] == $_username) {
		$member = userinfo($item['username']);
		$user_status = 3;
	}
}
$user = array();
if($_userid) {

	$user = userinfo($_username);
	//$company = $user['company'];
	$truename = $user['truename'];
	$telephones = $user['telephone'] ? $user['telephone'] : $user['mobile'];
	$email = $user['mail'] ? $user['mail'] : $user['email'];
	
}

$urlToEncode=$MOD['mobile'].'show.php?itemid='.$itemid;
switch($at) {
	case 'xiangce':
	$head_title ='-楼盘相册';
	
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'xiangce');
	break;
	case 'jiage':
	$head_title ='-楼盘价格走势';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'jiage');
	break;
	case 'huxing':
	$head_title = '-楼盘户型';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'huxing');
	break;
	case 'build':
	$head_title = '-楼栋信息';
	$newhouse_sand_pic=$db->pre.'newhouse_sand_pic';
	
	$newhouse_sand_pic= $db->get_one("SELECT * FROM $newhouse_sand_pic WHERE house_id=$itemid");
	$sand_pic=$newhouse_sand_pic['img'];
	$data=$newhouse_sand_pic['data'];	
$data = json_decode($data, true);


	
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'build');
	break;
	case 'hxinfo':
	$head_title ='-楼盘户型';
	$huxing=$db->pre.'newhouse_huxing';
	
	$hxinfo= $db->get_one("SELECT * FROM $huxing WHERE itemid=$id");
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'hxinfo');
	break;
	case 'xcinfo':
	$head_title ='-楼盘相册';
	$xiangce=$db->pre.'newhouse_xiangce';
	
	$hxinfo= $db->get_one("SELECT * FROM $xiangce WHERE itemid=$id");
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'xcinfo');
	break;
	case 'zixun':
		//资讯  10条记录
$article=$db->pre.'article_8';
  $pagesize =10;
	if(!$pagesize || $pagesize > 100) $pagesize = 30;
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $article   WHERE  houseid = $itemid and status=3");
	$items = $r['num'];
	$pages = pages($r['num'], $page, $pagesize);


	$tjw =$db->query("SELECT * FROM  $article WHERE houseid=$itemid and status=3 ORDER BY itemid DESC LIMIT $offset,$pagesize");
	
	while($tjws=$db->fetch_array($tjw)){
	$quyu = $tjws['houseid'];
		 $tjws['linkurl'] = $MODULE[8][linkurl].$tjws['linkurl'];
		 $qynames = $db->query("SELECT * FROM {$table} WHERE itemid=$quyu");
		 $qyname = $db->fetch_array($qynames);
		 $diqu=$qyname['title'];
		 $tjws[quyu]=$diqu;
	
		$new_lists[]=$tjws;	
	}

	$head_title = '-楼盘动态';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'zixun');
	break;
	
	case 'peitao':
	$head_title = '-地图交通';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'peitao');
	break;
	case 'dianping':
	$head_title = '-楼盘点评';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'dianping');
	break;
	case 'wenfang':
	$head_title = '-楼盘问答';
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'wenfang');
	break;
	case 'xinxi':
	$head_title = '-楼盘详细信息';
	$typeids=$typeid-1;
	$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'xinxi');
	break;
	
	default:
	$at='index';
	$template = 'show';
  
} 

    $seo_file = 'show';
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
	//$could_purchase = (SELL_ORDER && $price > 0 && $minamount > 0 && $amount > 0 && $unit && $username && $username != $_username && !$expired) ? 1 : 0;
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
	$newhouse_sandpic=$db->pre.'newhouse_sand_pic';
	
	$newhouse_sand_pic= $db->get_one("SELECT * FROM $newhouse_sandpic WHERE house_id=$itemid");

	$sand_pic=$newhouse_sand_pic['img'];
	$sand_pic = substr($sand_pic, 2);
	
	$data=$newhouse_sand_pic['data'];	
$data = json_decode($data, true);	   
 $zhiyes=explode(" ",$zhiye);
	switch($at) {
	case 'xiangce':
	$head_title = $title.'-楼盘相册';
	include template('xiangce', 'newhouse');
	break;
	case 'dongtai':
	$head_title = $title.'-最新动态';
	include template('dongtai', 'newhouse');
	break;
	case 'huxing':
	$head_title = $title.'-户型';
	include template('huxing', 'newhouse');
	break;
	case 'xinxi':
	$head_title = $title.'-楼盘详细信息';
	//$typeids=$typeid-1;
	
	include template('xinxi', 'newhouse');
	break;
	case 'build':
	$head_title = $title.'-楼栋信息';
    include template('build', 'newhouse');
	break;
	case 'wenfang':
	$head_title =$title. '-楼盘问答';
	include template('wenfang', 'newhouse');
	break;
	case 'hxinfo':
	$head_title =$title.'-楼盘户型';
	$huxing=$db->pre.'newhouse_huxing';
	$hxinfo= $db->get_one("SELECT * FROM $huxing WHERE itemid=$id");
	include template('hxinfo', 'newhouse');
	break;
	default:
	$typeids=$typeid-1;
	$at='index';
	$seo_file = 'show';
	require AJ_ROOT.'/include/content.class.php';
include AJ_ROOT.'/include/seo.inc.php';
if(!$AJ_BOT) include AJ_ROOT.'/include/update.inc.php';
	include template('show', 'newhouse');
}
}
  
	
  
?>