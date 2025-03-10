<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($AJ_PC) {
	$menu_id = 1;
} else {
	$foot = 'my';
}
$head_title = $action == 'add' ? $L['info_add'] : $L['info_manage'];
include template('my', $module);
?>