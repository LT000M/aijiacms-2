<?php 
defined('IN_AIJIACMS') or exit('Access Denied');


$moduleid = 7;
$module = 'rent';
$MOD = cache_read('module-'.$moduleid.'.php');
$table = $AJ_PRE.$module.'_'.$moduleid;
$table_data = $AJ_PRE.$module.'_data_'.$moduleid;
if($itemid) {
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if(!$item || $item['status'] < 3 || $item['username'] != $username) dheader($MENU[$menuid]['linkurl']);
	unset($item['template']);
	extract($item);
	$CAT = get_cat($catid);
	$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
	$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
	$content = $t['content'];
		$content = $AJ_PC ? parse_video($content) : video5($content);
	$CP = $MOD['cat_property'] && $CAT['property'];
	if($CP) {
		require AJ_ROOT.'/include/property.func.php';
		$options = property_option($catid);
		$values = property_value($moduleid, $itemid);
	}
	$adddate = timetodate($addtime, 5);
	$editdate = timetodate($edittime, 5);
	$todate = $totime ? timetodate($totime, 3) : 0;
	$expired = $totime && $totime < $AJ_TIME ? true : false;
	$linkurl = $MOD['linkurl'].$linkurl;
	$thumbs = get_albums($item);
	$albums =  get_albums($item, 1);
	$album_js = 1;
	$amount = number_format($amount, 0, '.', '');
	$inquiry_url = $MODULE[4]['linkurl'].'home.php?action=message&job=inquiry&&itemid='.$itemid.'&template='.$template.'&skin='.$skin.'&title='.rawurlencode($title).'&username='.$username.'&sign='.crypt_sign($itemid.$template.$skin.$title.$username);
	$order_url = $MODULE[4]['linkurl'].'home.php?action=message&job=order&&itemid='.$itemid.'&template='.$template.'&skin='.$skin.'&title='.rawurlencode($title).'&username='.$username.'&sign='.crypt_sign($itemid.$template.$skin.$title.$username);
	$update = '';
	include AJ_ROOT.'/include/update.inc.php';
	$head_canonical = $linkurl;
	$head_title = $title.$AJ['seo_delimiter'].$head_title;
	$head_keywords = $keyword;
	$head_description = $introduce ? $introduce : $title;
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, $itemid, $page);
} else {
	$typeid = isset($typeid) ? intval($typeid) : 0;
	$view = isset($view) ? 1 : 0;
	$url = "file=$file";
	$condition = " status=3";
	$usernames = get_broker($userid) ? get_broker($userid).',"'.$username.'"' : '"'.$username.'"';
	
	$condition.= " AND username IN ($usernames)";
	if($typeid) {
		$MTYPE = get_type('product-'.$userid);
		$condition .= " AND mycatid='$typeid'";
		$url .= "&typeid=$typeid";
		$head_title = $MTYPE[$typeid]['typename'].$AJ['seo_delimiter'].$head_title;
	}
	if($kw) {
		$condition .= " AND keyword LIKE '%$keyword%'";
		$url .= "&kw=$kw";
		$head_title = $kw.$AJ['seo_delimiter'].$head_title;
	}
	if($view) {
		$url .= "&view=$view";
	}
		//价目格范围
   if($_GET['b']) $condition .=" and price>=".$_GET['b']."";
   if($_GET['c']) $condition .=" and price<=".$_GET['c']."";

			//建面范围
	if($_GET['g']) $condition .=" and houseearm>=".$_GET['g']."";
   if($_GET['h']) $condition .=" and houseearm<=".$_GET['h']."";
		//户型范围
	if($r== 1){
			$condition.=' AND room=1';
		}
	if($r == 2){
			$condition.=" AND room=2";}
	if($r == 3){
			$condition.=' AND room=3';
			
		}
	if($r== 4){
			$condition.=' AND room=4';
		}
	if($r == 5){
			$condition.=' AND 5<=room ';
		}
   
	//list_order 排序转换
switch ($_GET['order']){
	case "dd":
		$order = " order by price/houseearm desc";
		break;
	case "da":
		$order = " order by price/houseearm asc";
		break;
	case "ed":
		$order = " order by edittime desc";
		break;
		case "ea":
		$order = " order by edittime asc";
		break;
	case "pa":
		$order = " order by price asc";
		break;
	case "pd":
		$order = " order by price desc";
		break;
	case "ha":
		$order = " order by houseearm asc";
		break;
	case "hd":
		$order = " order by houseearm desc";
		break;
	default:
		$order = " order by itemid desc";
		break;
}
if($catid)$condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";

    $demo_url = userurl($username, $url.'&r='.$_GET['r'].'&a='.$_GET['a'].'&p='.$_GET['p'].'&page={aijiacms_page}', $domain);
	//$demo_url = userurl($username, $url.'&page={aijiacms_page}', $domain);
	$pagesize =intval($menu_num[$menuid]);
	if(!$pagesize || $pagesize > 100) $pagesize = 16;
	if($view) $pagesize = ceil($pagesize/2);
	$offset = ($page-1)*$pagesize;
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pages = $AJ_PC ? home_pages($items, $page, $pagesize, $demo_url) : mobile_pages($items, $page, $pagesize, $demo_url);
	$lists = array();
	if($items) {
		$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY edittime DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['linkurl'] =  $MOD['linkurl'].$r['linkurl'];
			if($kw) {
				$r['title'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $r['title']);
				$r['introduce'] = str_replace($kw, '<span class="highlight">'.$kw.'</span>', $r['introduce']);
			}
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username.'&action='.$file.($typeid ? '&typeid='.$typeid : '').($page > 1 ? '&page='.$page : '');
}
include template('rent', $template);
?>