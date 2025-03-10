<?php
require '../common.inc.php';
require AJ_ROOT.'/include/mobile.inc.php';
$app = '';
if(!in_array($AJ_MOB['browser'], array('app', 'b2b'))) {
	if($AJ_MOB['os'] == 'ios') {
		if($EXT['mobile_ios']) $app = AJ_PATH.'api/app.php';
	} else if($AJ_MOB['os'] == 'android') {
		if($EXT['mobile_adr']) $app = AJ_PATH.'api/app.php';
	}
}
$head_title = $head_name = '贷款计算器';
$foot = 'tool';
include template('toolhelp', 'mobile');
?>