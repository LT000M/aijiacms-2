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
$typename = array(
    '预约看房',
	'领取优惠',
	'申请算价',
	'变价通知',
	'开盘通知',
	'领取红包',
);
$typename =$typename[($_GET['type'])];
//if($_GET['type']==6)
$head_title = $head_name = '表单';
$foot = 'subscribe';
include template('subscribe', 'mobile');
?>