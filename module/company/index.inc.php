<?php
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$username = $domain = '';

if(isset($homepage) && check_name($homepage)) {
	$username = $homepage;
} else {
	$host = get_env('host');
	if(substr($host, 0, 4) == 'www.') {
		$whost = $host;
		$host = substr($host, 4);
	} else {
		$whost = $host;
	}
	if($host && strpos($MODULE[4]['linkurl'], $host) === false && strpos(AJ_MOB, $host) === false) {
		if(substr($host, -strlen($CFG['com_domain'])) == $CFG['com_domain']) {
			$www = substr($host, 0, -strlen($CFG['com_domain']));
			if(check_name($www)) {
				$username = $homepage = $www;
			} else {
				$head_title = $L['not_company'];
				if($AJ_BOT) dhttp(404, $AJ_BOT);
				include template('com-notfound', 'message');
				exit;
			}
		} else {
			if($whost == $host) {//301 xxx.com to www.xxx.com
				$w3 = 'www.'.$host;
				$c = $db->get_one("SELECT userid FROM {$AJ_PRE}company WHERE domain='$w3'");
				if($c) d301('http://'.$w3);
			}
			$c = $db->get_one("SELECT username,domain FROM {$AJ_PRE}company WHERE domain='$whost'".($host == $whost ? '' : " OR domain='$host'"), 'CACHE');
			if($c) {
				$username = $homepage = $c['username'];
				$domain = $c['domain'];
			}
		}
	}
}
if($username) {
	include AJ_ROOT.'/module/'.$module.'/init.inc.php';
} else {
	if($AJ_PC) {
		if(strpos($AJ_URL, $MOD['linkurl']) === false) dhttp(404);
		if($AJ['safe_domain']) {
			$safe_domain = explode('|', $AJ['safe_domain']);
			$pass_domain = false;
			foreach($safe_domain as $v) {
				if(strpos($AJ_URL, $v) !== false) { $pass_domain = true; break; }
			}
			$pass_domain or dhttp(404);
		}
		if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
		if($MOD['index_html']) {	
			$html_file = AJ_CACHE.'/htm/company.htm';
			if(!is_file($html_file)) tohtml('index', $module);
			if(is_file($html_file)) exit(include($html_file));
		}
		if($page == 1) $head_canonical = $MOD['linkurl'];
		if($EXT['mobile_enable']) $head_mobile = $MOD['mobile'];
		$aijiacms_task = "moduleid=$moduleid&html=index";
		$CSS = array('catalog');
	} else {
		$condition = "groupid>5";
		if($cityid) {
			$areaid = $cityid;
			$ARE = get_area($areaid);
			$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
		}
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
		$items = $r['num'];
		$pages = mobile_pages($items, $page, $pagesize);
		$lists = array();
		if($items) {
			$order = $MOD['order'];
			$result = $db->query("SELECT ".$MOD['fields']." FROM {$table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
			while($r = $db->fetch_array($result)) {
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
}
?>