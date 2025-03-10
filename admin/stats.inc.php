<?php
/*
	[AIJIACMS] Copyright (c) 2008-2021 www.aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
    array('流量统计', '?file='.$file),
    array('UV记录', '?file='.$file.'&action=uv'),
    array('PV记录', '?file='.$file.'&action=pv'),
    array('统计报表', '?file='.$file.'&action=report'),
    array('在线会员', '?file='.$file.'&action=online'),
    array('404日志', '?file='.$file.'&action=404'),
);
switch($action) {
	case 'clear_pv':
		$time = $AJ_TODAY - 30*86400;
		$db->query("DELETE FROM {$AJ_PRE}stats_pv WHERE addtime<$time");
		dmsg('清理成功', '?file='.$file.'&action=pv');
	break;
	case 'clear_uv':
		$time = $AJ_TODAY - 365*86400;
		$db->query("DELETE FROM {$AJ_PRE}stats_uv WHERE addtime<$time");
		dmsg('清理成功', '?file='.$file.'&action=uv');
	break;
	case 'clear':
		$time = $AJ_TODAY - 30*86400;
		$db->query("DELETE FROM {$AJ_PRE}404 WHERE addtime<$time");
		dmsg('清理成功', '?file='.$file.'&action=404');
	break;
	case '404':
		$sfields = array('按条件', '网址', '来源', '搜索引擎', '会员', 'IP', '客户端', '操作系统', '浏览器');
		$dfields = array('url', 'url', 'refer', 'robot', 'username', 'ip', 'ua', 'os', 'bs');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$ip = isset($ip) ? $ip : '';
		$os = isset($os) ? $os : '';
		$bs = isset($bs) ? $bs : '';
		$pc = isset($pc) ? intval($pc) : -1;
		$robot = isset($robot) ? $robot : '';
		(isset($username) && check_name($username)) or $username = '';
		(isset($fromdate) && is_time($fromdate)) or $fromdate = '';
		$fromtime = $fromdate ? datetotime($fromdate) : 0;
		(isset($todate) && is_time($todate)) or $todate = '';
		$totime = $todate ? datetotime($todate) : 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$condition = '1';
		if($keyword) $condition .= match_kw($dfields[$fields], $keyword);
		if($fromtime) $condition .= " AND addtime>=$fromtime";
		if($totime) $condition .= " AND addtime<=$totime";
		if($ip) $condition .= " AND ip='$ip'";
		if($os) $condition .= " AND os='$os'";
		if($bs) $condition .= " AND bs='$bs'";
		if($robot) $condition .= $robot == 'all' ? " AND robot<>''" : " AND robot='$robot'";
		if($pc > -1) $condition .= " AND pc=$pc";
		if($username) $condition .= " AND username='$username'";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}404 WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = $areas = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}404 WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if(isset($areas[$r['ip']])) {
				$r['area'] = $areas[$r['ip']];
			} else {
				$r['area'] = $areas[$r['ip']] = ip2area($r['ip']);
			}
			$r['addtime'] = timetodate($r['addtime'], 6);
			$lists[] = $r;
		}
		include tpl('stats_404');
	break;
	case 'online':
		$sfields = array('按条件', '会员名', '会员ID');
		$dfields = array('username', 'username', 'userid');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$sorder  = array('结果排序方式', '访问时间降序', '访问时间升序', '会员ID降序', '会员ID升序');
		$dorder  = array('lasttime DESC', 'lasttime DESC', 'lasttime ASC', 'userid DESC', 'userid ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		$online = isset($online) ? intval($online) : 2;

		$fields_select = dselect($sfields, 'fields', '', $fields);
		$order_select  = dselect($sorder, 'order', '', $order);

		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields]='$kw'";
		if($mid) $condition .= " AND moduleid=$mid";
		if($online < 2) $condition .= " AND online=$online";
		$lastime = $AJ_TIME - $AJ['online'];
		$db->query("DELETE FROM {$AJ_PRE}online WHERE lasttime<$lastime");
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}online WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}online WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['lasttime'] = timetodate($r['lasttime'], 'H:i:s');
			$lists[] = $r;
		}
		include tpl('stats_online');
	break;
	case 'update':
		require AJ_ROOT.'/include/client.func.php';
		$table = $AJ_PRE.'stats_uv';
		if(!isset($fid)) {
			$r = $db->get_one("SELECT min(itemid) AS fid FROM {$table}");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max(itemid) AS tid FROM {$table}");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		isset($num) or $num = 100;
		$itemid or $itemid = 1;
		if($fid <= $tid) {
			$result = $db->query("SELECT * FROM {$table} WHERE itemid>=$fid ORDER BY itemid LIMIT 0,$num ");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$itemid = $r['itemid'];
					$sql = '';
					/*
					$area = ip2area($r['ip']);
					if($area && $area != $r['area']) $sql .= "area='".addslashes($area)."',";

					$country = area_parse($area, 'country');
					if($country && $country != $r['country']) $sql .= "country='".addslashes($country)."',";

					$province = area_parse($area, 'province');
					if($province && $province != $r['province']) $sql .= "province='".addslashes($province)."',";

					$city = area_parse($area, 'city');
					if($city && $city != $r['city']) $sql .= "city='".addslashes($city)."',";

					$network = area_parse($area, 'network');
					if($network && $network != $r['network']) $sql .= "network='".addslashes($network)."',";
					*/

					$os = get_os($r['ua']);
					if($os && $os != $r['os']) $sql .= "os='".$os."',";

					$bs = get_bs($r['ua']);
					if($bs && $bs != $r['bs']) $sql .= "bs='".$bs."',";

					$bd = get_bd($r['ua']);
					if($bd && $bd != $r['bd']) $sql .= "bd='".$bd."',";

					if($sql) {
						$sql = substr($sql, 0, -1);
						$db->query("UPDATE {$table} SET {$sql} WHERE itemid=$itemid");
					}
				}
				$itemid += 1;
			} else {
				$itemid = $fid + $num;
			}
		} else {
			msg("更新成功", '?file='.$file.'&action=uv');
		}
		msg('ID从'.$fid.'至'.($itemid-1).'转换成功', "?file=$file&action=$action&fid=$itemid&tid=$tid&num=$num", 0);
	break;
	case 'report':
		$job or $job = 'pvs';
		include tpl('stats_report');
	break;
	case 'pv':
		$sfields = array('按条件', '网址', '来源', '来源域名', '搜索引擎', '会员', '所属商家', 'IP');
		$dfields = array('url', 'url', 'refer', 'domain', 'robot', 'username', 'homepage', 'ip');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$dorder  = array('sid DESC', 'addtime DESC', 'addtime ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		isset($robot) or $robot = '';
		isset($url) or $url = '';
		isset($refer) or $refer = '';
		isset($domain) or $domain = '';
		$pc = isset($pc) ? intval($pc) : -1;
		$islink = isset($islink) ? intval($islink) : -1;
		(isset($fromdate) && is_time($fromdate)) or $fromdate = '';
		$fromtime = $fromdate ? datetotime($fromdate) : 0;
		(isset($todate) && is_time($todate)) or $todate = '';
		$totime = $todate ? datetotime($todate) : 0;
		$catid or $catid = '';
		$itemid or $itemid = '';

		$fields_select = dselect($sfields, 'fields', '', $fields);
		$module_select = module_select('mid', '模块', $mid);

		$condition = '1';
		if($keyword) $condition .= match_kw($dfields[$fields], $keyword);
		if($fromtime) $condition .= " AND addtime>=$fromtime";
		if($totime) $condition .= " AND addtime<=$totime";
		if($mid) $condition .= " AND mid=$mid";
		if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		if($itemid) $condition .= " AND itemid=$itemid";
		if($url) $condition .= " AND url='$url'";
		if($refer) $condition .= " AND refer='$refer'";
		if($domain) $condition .= " AND domain='$domain'";
		if($robot) $condition .= $robot == 'all' ? " AND robot<>''" : " AND robot='$robot'";
		if($pc > -1) $condition .= " AND pc=$pc";
		if($islink > -1) $condition .= $islink ? " AND domain<>''" : " AND domain=''";
		foreach($dfields as $v) {
			if(in_array($v, array('url', 'robot'))) continue;
			isset($$v) or $$v = '';
			if($$v) $condition .= " AND $v='".$$v."'";
		}

		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}stats_pv WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = $areas = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}stats_pv WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if(isset($areas[$r['ip']])) {
				$r['area'] = $areas[$r['ip']];
			} else {
				$r['area'] = $areas[$r['ip']] = ip2area($r['ip']);
			}
			$r['addtime'] = timetodate($r['addtime'], 6);
			if($r['refer'] && strpos($r['refer'], '://') === false) $r['refer'] = AJ_PATH.($r['refer'] == '/' ? '' : $r['refer']);
			if(strpos($r['url'], '://') === false) $r['url'] = AJ_PATH.$r['url'];
			$lists[] = $r;
		}
		include tpl('stats_pv');
	break;
	case 'uv':
		$sfields = array('按条件', '搜索引擎', 'IP', '地区', '国家', '省份', '城市', '网络', '客户端', '操作系统', '设备品牌', '浏览器', '分辨率');
		$dfields = array('ua', 'robot', 'ip', 'area', 'country', 'province', 'city', 'network', 'ua', 'os', 'bd', 'bs', 'screen');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$dorder  = array('itemid DESC', 'addtime DESC', 'addtime ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;
		$pc = isset($pc) ? intval($pc) : -1;
		(isset($fromdate) && is_time($fromdate)) or $fromdate = '';
		$fromtime = $fromdate ? datetotime($fromdate) : 0;
		(isset($todate) && is_time($todate)) or $todate = '';
		$totime = $todate ? datetotime($todate) : 0;
		isset($robot) or $robot = '';

		$fields_select = dselect($sfields, 'fields', '', $fields);

		$condition = '1';
		if($keyword) $condition .= match_kw($dfields[$fields], $keyword);
		if($fromtime) $condition .= " AND addtime>=$fromtime";
		if($totime) $condition .= " AND addtime<=$totime";
		if($pc > -1) $condition .= " AND pc=$pc";
		if($robot) $condition .= $robot == 'all' ? " AND robot<>''" : " AND robot='$robot'";
		foreach($dfields as $v) {
			if(in_array($v, array('robot'))) continue;
			isset($$v) or $$v = '';
			if($$v) $condition .= " AND $v='".$$v."'";
		}

		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}stats_uv WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = $areas = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}stats_uv WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if(!$r['screen']) {
				$r['screen'] = $dc->get('sn-'.md5($r['ip'].$AJ_TODAY.strip_sql($r['ua'], 0)));
				if($r['screen']) $db->query("UPDATE {$AJ_PRE}stats_uv SET screen='$r[screen]' WHERE itemid=$r[itemid]");
			}
			$r['location'] = $r['province'] ? '<a href="javascript:;" onclick="Dq(\'province\',this.innerHTML);">'.$r['province'].'</a>'.($r['city'] == $r['province'] ? '' : ' <a href="javascript:;" onclick="Dq(\'city\',this.innerHTML);">'.$r['city'].'</a>') : '<a href="javascript:;" onclick="Dq(\'country\',\''.$r['country'].'\');">'.$r['country'].'</a> <a href="javascript:;" onclick="Dq(\'city\',this.innerHTML);">'.$r['city'].'</a>';
			$r['addtime'] = timetodate($r['addtime'], 6);
			$lists[] = $r;
		}
		include tpl('stats_uv');
	break;
	default:
		$W = array('天', '一', '二', '三', '四', '五', '六');
		$sorder  = array('排序方式', '总UV降序', '总UV升序', '电脑UV降序', '电脑UV升序', '手机Uv降序', '手机UV升序', '总IP降序', '总IP升序', '电脑IP降序', '电脑IP升序', '手机IP降序', '手机IP升序', '总PV降序', '总PV升序', '电脑PV降序', '电脑PV升序', '手机PV降序', '手机PV升序', '爬虫PV降序', '爬虫PV升序', '电脑爬虫PV降序', '电脑爬虫PV升序', '手机爬虫PV降序', '手机爬虫PV升序', '日期降序', '日期升序');
		$dorder  = array('id DESC', 'uv DESC', 'uv ASC', 'uv_pc DESC', 'uv_pc ASC', 'uv_mb DESC', 'uv_mb ASC', 'ip DESC', 'ip ASC', 'ip_pc DESC', 'ip_pc ASC', 'ip_mb DESC', 'ip_mb ASC', 'pv DESC', 'pv ASC', 'pv_pc DESC', 'pv_pc ASC', 'pv_mb DESC', 'pv_mb ASC', 'rb DESC', 'rb ASC', 'rb_pc DESC', 'rb_pc ASC', 'rb_mb DESC', 'rb_mb ASC', 'id DESC', 'id ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;

		isset($fromdate) or $fromdate = '';
		$fromtime = is_date($fromdate) ? str_replace('-', '', $fromdate) : '';
		isset($todate) or $todate = '';
		$totime = is_date($todate) ? str_replace('-', '', $todate) : '';
		(isset($username) && check_name($username)) or $username = '';

		$order_select = dselect($sorder, 'order', '', $order);

		if($username) {
			$condition = "username='$username'";
			$table = $AJ_PRE.'stats_user';
		} else {
			$condition = '1';
			$table = $AJ_PRE.'stats';
		}
		if($fromtime) $condition .= " AND id>=$fromtime";
		if($totime) $condition .= " AND id<=$totime";
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$lists = array();
		$i = 0;
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY $dorder[$order] LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['time'] = datetotime($r['id']);
			$r['date'] = timetodate($r['time'], 3);
			$r['week'] = '星期'.$W[date('w', $r['time'])];
			if($page == 1 && $order == 0) {
				if($i == 0) {
					$r['week'] = '今天';
				} elseif($i == 1) {
					$r['week'] = '昨天';
				} elseif($i == 2) {
					$r['week'] = '前天';
				}
			}
			$i++;
			$lists[] = $r;
		}
		include tpl('stats');
	break;
}
?>