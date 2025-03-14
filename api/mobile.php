<?php
$moduleid = 3;
require '../common.inc.php';
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['mobile_enable'] or dheader(AJ_PATH);
require AJ_ROOT.'/include/post.func.php';
$ck = get_cookie('mobile');
$url = AJ_MOB;
if(isset($uri) && is_url($uri)) {
	if($action == 'device') $url = AJ_PATH;
	if(AJ_DOMAIN) {
		if(strpos(cutstr($uri, '://', '/'), AJ_DOMAIN) !== false) $url = $uri;
	} else {
		if(substr($uri, 0, strlen(AJ_PATH)) == AJ_PATH) $url = $uri;
	}
}
if($action == 'pc') {
	set_cookie('mobile', 'pc', $AJ_TIME + 30*86400);
	dheader(AJ_PATH);
} else if($action == 'screen') {
	$AJ_MOB['os'] == 'ios' or exit;
	if($ck != 'screen') set_cookie('mobile', 'screen', $AJ_TIME + 86400*30);
} else {
	if(strpos($AJ_URL, 'action=sync&auth=') !== false && strpos($AJ_URL, 'goto=') !== false) {
		if($AJ_MOB['os'] == 'ios') {
			isset($auth) or $auth = '';
			$auth = decrypt($auth, AJ_KEY.'SCREEN');
			if($auth) {
				$arr = explode('|', $auth);
				if(check_name($arr[0]) && $_username != $arr[0] && $AJ_IP == $arr[1] && $AJ_TIME - $arr[2] < 600) {
					include load('member.lang');
					$MOD = cache_read('module-2.php');
					include AJ_ROOT.'/module/member/member.class.php';
					$do = new member;
					$user = $do->login($arr[0], '', 0, true);
				}
			}
			$tmp = explode('goto=', $AJ_URL);
			$goto = $tmp[1];
			if(preg_match("/^[a-z0-9_\.\?\&\=\-]{5,}$/", $goto)) {
				if(strpos($goto, '://') === false) $goto = $MODULE[2]['linkurl'].$goto;
				$url = $goto;
			}
		}
		dheader($url);
	}
	if($ck != 'pc') {
		if(preg_match("/(iPhone|iPod|Android)/i", $_SERVER['HTTP_USER_AGENT'])) dheader($url);
		if(preg_match("/(Phone|Mobile)/i", $_SERVER['HTTP_USER_AGENT'])) dheader($url);
		set_cookie('mobile', 'pc', $AJ_TIME + 30*86400);
	}
	$ios_app = $EXT['mobile_ios'] ? AJ_PATH.'api/qrcode.png.php?auth='.urlencode(AJ_PATH.'api/app.php') : '';
	$android_app = $EXT['mobile_adr'] ? AJ_PATH.'api/qrcode.png.php?auth='.urlencode(AJ_PATH.'api/app.php') : '';
	$aijiacms_task = rand_task();
	$head_title = $L['mobile_title'];
	$head_mobile = $url;
	include template('mobile', $module);
}
?>