<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$pass = $img;
if(strpos($img, AJ_DOMAIN ? AJ_DOMAIN : AJ_PATH) !== false) {
	$pass = true;
} else {
	if($AJ['remote_url'] && strpos($img, $AJ['remote_url']) !== false) {
		$pass = true;
	} else {
		$pass = false;
	}
}
$pass or dheader($img);
$ext = file_ext($img);
in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'bmp')) or dheader($AJ_PC ? AJ_PATH : AJ_MOB);
$img = str_replace(array('.thumb.'.$ext, '.middle.'.$ext), array('', ''), $img);
$template = 'view';
$head_title = $L['view_title'];
$head_keywords = $head_description = '';
if($AJ_PC) {	
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace(AJ_PATH, AJ_MOB, $AJ_URL);
} else {
	$foot = '';
	$head_name = $L['view_title'];
	$back_link = 'javascript:Dback();';
}
include template($template, $module);
?>