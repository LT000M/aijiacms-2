<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
require 'common.inc.php';
if($AJ_BOT) dhttp(403);
if($action != 'mobile') {
	check_referer() or exit;
}
require AJ_ROOT.'/include/post.func.php';
@include AJ_ROOT.'/api/ajax/'.$action.'.inc.php';
?>