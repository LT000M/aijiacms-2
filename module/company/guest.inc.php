<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$head_title = $L['guest_title'];
if($AJ_PC) {
	if($EXT['mobile_enable']) $head_mobile = str_replace($MOD['linkurl'], $MOD['mobile'], $AJ_URL);
} else {
	$foot = '';
}
include template('guest', 'message');
?>