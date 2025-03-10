<?php
/*
	
	This is NOT a freeware, use is subject to license.txt
*/
require '../../common.inc.php';
require AJ_ROOT.'/include/mobile.inc.php';
if($moduleid < 4) $moduleid = 4;
$AREA = cache_read('area.php');
$pid = isset($pid) ? intval($pid) : 0;
$back_link = $pid ? AJ_MOB.'api/area.php?moduleid='.$moduleid.'&pid='.$AREA[$pid]['parentid'] : $MODULE[$moduleid]['mobile'];
$lists = array();
foreach($AREA as $a) {
	if($a['parentid'] == $pid) $lists[] = $a;
}
$head_title = $MOD['name'];
include template('area', 'mobile');
?>