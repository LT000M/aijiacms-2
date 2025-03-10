<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
$EXT['weixin'] or dheader('./');
$WX = cache_read('weixin.php');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$i = 0;
$result = $db->query("SELECT * FROM {$AJ_PRE}weixin_user WHERE username='$_username' ORDER BY logintime DESC");
while($r = $db->fetch_array($result)) {
	if($i++) {
		$db->query("UPDATE {$AJ_PRE}weixin_user SET username='' WHERE itemid=$r[itemid]");
	} else {
		$W = $r;
	}
}
switch($action) {
	case 'push':
		$W or message();
		$push = $W['push'] ? 0 : 1;
		$db->query("UPDATE {$AJ_PRE}weixin_user SET push=$push WHERE itemid=$W[itemid]");
		dmsg($push ? $L['weixin_push_open'] : $L['weixin_push_close'], '?action=index');
	break;
	default:
		if($W) {
			$W['headimgurl'] or $W['headimgurl'] = AJ_PATH.'api/weixin/image/headimg.jpg';
			$sign = ($W['credittime'] && timetodate($W['credittime'], 3) == timetodate($AJ_TIME, 3)) ? 1 : 0;
			$timeout = $AJ_TIME - $W['visittime'] > 172800 ? 1 : 0;
		}
		$auth = encrypt($_username.md5(AJ_IP.$_SERVER['HTTP_USER_AGENT']), AJ_KEY.'WXQR');
		$head_title = $L['weixin_title'];	
	break;
}
if($AJ_PC) {
	//
} else {
	$foot = '';
	$back_link = 'index.php';
}
include template('weixin', $module);
?>