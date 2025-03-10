<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
require '../common.inc.php';
check_referer() or exit;
if($AJ_BOT) dhttp(403);
$session = new dsession();
require AJ_ROOT.'/include/captcha.class.php';
$do = new captcha;
$do->font = AJ_ROOT.'/file/font/'.$AJ['water_font'];
if($AJ['captcha_cn']) $do->cn = is_file($do->font);
if($action == 'question') {
	$id = isset($id) ? trim($id) : 'questionstr';
	$do->question($id);
} else {
	if($AJ['captcha_chars']) $do->chars = trim($AJ['captcha_chars']);
	$do->image();
}
?>