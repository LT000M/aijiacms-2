<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$task_item or $task_item = 3600;
if($html == 'webpage') {
	$itemid or exit;
	$r = $db->get_one("SELECT linkurl,islink FROM {$AJ_PRE}webpage WHERE itemid=$itemid");
	$r or exit;
	$r['islink'] and exit;
	if(!$AJ_BOT) $db->query("UPDATE LOW_PRIORITY {$AJ_PRE}webpage SET hits=hits+1 WHERE itemid=$itemid", 'UNBUFFERED');
	if($AJ_TIME - @filemtime(AJ_ROOT.'/'.$r['linkurl']) > $task_item) tohtml('webpage', $module);
} else if($html == 'spread') {
	$r = $db->get_one("SELECT * FROM {$AJ_PRE}spread ORDER BY rand()");
	$r or exit;
	$itemid = $r['itemid'];
	$filename = AJ_CACHE.'/htm/m'.$r['mid'].'_k'.urlencode($r['word']).'.htm';
	if($AJ_TIME - @filemtime($filename) > $task_item) {
		$MOD = cache_read('module-'.$r['mid'].'.php');
		tohtml('spread', $module);
	}
} else if($html == 'ad') {
	$a = $db->get_one("SELECT * FROM {$AJ_PRE}ad ORDER BY rand()");
	$a or exit;
	$aid = $a['aid'];
	if($AJ_TIME - @filemtime(AJ_CACHE.'/htm/'.ad_name($a)) > $task_item) {
		if($a['typeid'] == 6) {
			$MOD['linkurl'] = $MODULE[$a['key_moduleid']]['linkurl'];
		}
		tohtml('ad', $module);
	}
} else if($html == 'xml') {
	$MOD = $EXT;
	if($MOD['sitemaps'] && ($AJ_TIME - @filemtime(AJ_ROOT.'/sitemaps.xml') > $MOD['sitemaps_update']*60)) tohtml('sitemaps', $module);
	if($MOD['baidunews'] && ($AJ_TIME - @filemtime(AJ_ROOT.'/baidunews.xml') > $MOD['baidunews_update']*60)) tohtml('baidunews', $module);
	if(!$_userid) $dc->expire();
}
?>