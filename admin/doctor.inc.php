<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
    array('系统体检', '?file='.$file),
    array('MySQL进程', '?file=database&action=process', ' target="_blank"'),
    array('PHP信息', '?file='.$file.'&action=phpinfo', ' target="_blank"'),
);
if($CFG['cache'] == 'memcache' || $CFG['session'] == 'memcache') $menus[] = array('Memcache', '?file='.$file.'&action=memcache', ' target="_blank"');
if($action == 'phpinfo') {
	phpinfo();
} else if($action == 'memcache') {
	dheader(AJ_PATH.'api/memcache.php');
} else {
	include tpl('doctor');
}
?>