<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$table=$AJ_PRE.'newhouse_yushou';
if($AJ_PC) {
	$tags = array();
			$condition = "status=3 ".$condition;
		if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
		$keyword = $kw ? $kw : $k;
		if ($type==1)
		{ $fields='title';
		}
		else if($type==2)
		{ $fields='project';
		}
		else if($type==3)
		{ $fields='kfs';
		}	
		if($keyword) $condition .= " AND $fields LIKE '%$keyword%'";
	
		$pagesize = 20;
		$offset = ($page-1)*$pagesize;
		$items = $db->count($table, $condition, $AJ['cache_search']);
		$pages = pages($items, $page, $pagesize);
		if($items) {
			$result = $db->query("SELECT * FROM {$table} WHERE {$condition} ORDER BY addtime DESC LIMIT {$offset},{$pagesize}");
			while($r = $db->fetch_array($result)) {
				$r['adddate'] = timetodate($r['addtime'], 5);
				if(!$r['islink']) $r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
				$tags[] = $r;
			}
			$db->free_result($result);
			if($page == 1 && $kw) keyword($kw, $items, $moduleid);
		}

	$showpage = 1;
	$datetype = 5;
	$target = '_blank';
	$cols = 5;
	$class = '';
	if($EXT['mobile_enable']) $head_mobile = str_replace($MOD['linkurl'], $MOD['mobile'], $AJ_URL);
} else {
	
	$head_title = '预售许可证'.$AJ['seo_delimiter'].$head_title;
	if($kw) $head_title = $kw.$AJ['seo_delimiter'].$head_title;
	if(!$areaid && $cityid && strpos($AJ_URL, 'areaid') === false) {
		$areaid = $cityid;
		$ARE = get_area($areaid);
	}
	$condition = "status=3";
	if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	if($catid) $condition .= $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
	$items = $r['num'];
	$pagesize = $MOD['pagesize'];
		$offset = ($page-1)*$pagesize;
	
	$pages = mobile_pages($items, $page, $pagesize);
	$lists = array();
	if($items) {
		$order = $MOD['order'];
		$time = strpos($MOD['order'], 'add') !== false ? 'addtime' : 'edittime';
		$result = $db->query("SELECT * FROM {$table} WHERE {$condition} ORDER BY addtime DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
		
			if(!$r['islink']) $r['linkurl'] = $MOD['mobile'].$r['linkurl'];
			$r['date'] = timetodate($r[$time], 3);
			$lists[] = $r;
		}
		$db->free_result($result);
	}
	$back_link = $MOD['mobile'];
	$head_name = $MOD['name'].$L['search'];
}
	$head_title = '预售许可证'.$AJ['seo_delimiter'].$head_title;
include AJ_ROOT.'/include/seo.inc.php';
include template('yushou', $module);
?>