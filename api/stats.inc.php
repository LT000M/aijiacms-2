<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ['stats'] && !IN_ADMIN) {
	require AJ_ROOT.'/include/client.func.php';
	$robot = is_robot() ? get_robot() : '';
	$os = get_os();
	$pc = is_mob() ? 0 : 1;
	$hp = '';
	if(isset($homepage) && check_name($homepage)) {
		$hp = $homepage;
	} else if($itemid && $moduleid > 4) {
		if(isset($username) && check_name($username)) $hp = $username;
	}
	$url = addslashes(dhtmlspecialchars(str_replace(AJ_PATH, '', $AJ_URL)));
	$refer = is_url($AJ_REF) ? addslashes(dhtmlspecialchars($AJ_REF == AJ_PATH ? '/' : str_replace(AJ_PATH, '', $AJ_REF))) : '';
	$domain = (is_url($AJ_REF) && strpos($AJ_REF, AJ_DOMAIN ? AJ_DOMAIN : AJ_PATH) === false) ? addslashes(dhtmlspecialchars(cutstr($AJ_REF, '://', '/'))) : '';
	if(is_url($AJ_URL) && strpos($AJ_URL, AJ_DOMAIN ? AJ_DOMAIN : AJ_PATH) !== false && strpos($AJ_URL, 'task.js.php') === false && strpos($AJ_URL, 'stats.js.php') === false && strpos($AJ_URL, 'stats.png.php') === false) $db->query("INSERT INTO {$AJ_PRE}stats_pv (mid,catid,itemid,url,refer,domain,homepage,username,ip,robot,pc,addtime) VALUES ('".($mid ? $mid : $moduleid)."','$catid','$itemid','$url','$refer','$domain','$hp','$_username','$AJ_IP','$robot','$pc','$AJ_TIME')");
	$id = md5(AJ_IP.$AJ_TODAY.AJ_UA);
	$ua = addslashes(dhtmlspecialchars(strip_sql(strip_tags(AJ_UA))));
	$uv = get_cookie('uv');
	if($uv == $id) {
		//
	} else {
		set_cookie('uv', $id, $AJ_TODAY);
		$uv = $dc->get('uv-'.$id);
		if($uv == $id) {
			//
		} else {
			$dc->set('uv-'.$id, $id, $AJ_TODAY - $AJ_TIME);
			$area = ip2area(AJ_IP);
			$country = area_parse($area, 'country');
			$province = area_parse($area, 'province');
			$city = area_parse($area, 'city');
			$network = area_parse($area, 'network');
			$bs = get_bs();
			$bd = get_bd();
			$db->query("INSERT INTO {$AJ_PRE}stats_uv (ip,robot,area,country,province,city,network,pc,ua,os,bs,bd,addtime) VALUES ('$AJ_IP','$robot','$area','$country','$province','$city','$network','$pc','$ua','$os','$bs','$bd','$AJ_TIME')");
			echo 'Dstats();';
		}
	}
	if(isset($screenw) && isset($screenh)) {
		$screenw = intval($screenw);
		$screenh = intval($screenh);
		if($screenw > 100 && $screenh > 100) {
			$swh = $dc->get('sn-'.$id);
			if($swh == $screenw.'*'.$screenh) {
				//
			} else {
				$dc->set('sn-'.$id, $screenw.'*'.$screenh, $AJ_TODAY - $AJ_TIME);
				$db->query("INSERT INTO {$AJ_PRE}stats_screen (ip,width,height,ua,url,refer,addtime) VALUES ('$AJ_IP','$screenw','$screenh','$ua','$url','$refer','$AJ_TIME')");
			}
		}
	}
}
?>