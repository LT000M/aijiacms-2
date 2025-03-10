<?php
$moduleid = 3;
require '../../common.inc.php';
require AJ_ROOT.'/include/mobile.inc.php';
$action = 'add';
$report = 1;
$content = isset($content) ? stripslashes($content) : '';
if($content) $content = strip_tags($content);
require AJ_ROOT.'/module/'.$module.'/guestbook.inc.php';
?>