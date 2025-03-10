<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
isset($auth) or $auth = '';
$auth = $auth ? decrypt($auth, AJ_KEY.'MAP') : '';
list($addr, $name) = explode('|', $auth);
include AJ_ROOT.'/api/map/baidu/config.inc.php';
$map_key or $map_key = 'waKl9cxyGpfdPbon7PXtDXIf';
$template = 'address';
$head_title = $L['address_title'];
$head_keywords = $head_description = '';
if($AJ_PC) {	
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace(AJ_PATH, AJ_MOB, $AJ_URL);
} else {
	$foot = '';
	$head_name = $L['address_title'];
	$back_link = 'javascript:Dback();';
}
include template($template, $module);
?>