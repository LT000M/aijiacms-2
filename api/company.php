<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
$_COOKIE = array();
require '../common.inc.php';
$url = AJ_PATH;
if($wd) $url = 'http://xin.baidu.com/s?q='.urlencode(strip_tags($wd));
dheader($url);
?>