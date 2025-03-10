<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$AJ_LICENSE = md5(file_get(AJ_ROOT.'/license.txt'));
//$AJ_LICENSE == '8eeca25dd358b9b996b631923776f1ed' or msg('网站根目录license.txt不允许修改或删除，请检查');
$forward or $forward = '?action=dashboard';
if($_aijiacms_admin && $_userid && $_aijiacms_admin == $_userid) dheader($forward);
if($AJ['admin_area']) {
	$AA = explode("|", trim($AJ['admin_area']));
	$A = ip2area($AJ_IP);
	$pass = false;
	foreach($AA as $v) {
		if(strpos($A, $v) !== false) { $pass = true; break; }
	}
	if(!$pass) dalert('未被允许的地区', $MODULE[2]['linkurl'].'logout.php?forward='.urlencode(AJ_PATH));
}
if($AJ['admin_ip']) {
	$IP = explode("|", trim($AJ['admin_ip']));
	$pass = false;
	foreach($IP as $v) {
		if($v == $AJ_IP) { $pass = true; break; }
		if(preg_match("/^".str_replace('*', '[0-9]{1,3}', $v)."$/", $AJ_IP)) { $pass = true; break; }
	}
	if(!$pass) dalert('未被允许的IP段', $MODULE[2]['linkurl'].'logout.php?forward='.urlencode(AJ_PATH));
}
$LOCK = cache_read($AJ_IP.'.php', 'ban');
if($LOCK && $AJ_TIME - $LOCK['time'] < 3600 && $LOCK['times'] >= 1) $AJ['captcha_admin'] = 1;
if($AJ['close']) $AJ['captcha_admin'] = 0;
if($submit) {
	$msg = captcha($captcha, $AJ['captcha_admin'], true);
	if($msg) msg('验证码填写错误');
	if(!check_name($username)) msg('请输入正确的用户名');
	if(strlen($password) < 6 || strlen($password) > 32) msg('请输入正确的密码');
	include load('member.lang');
	$MOD = cache_read('module-2.php');
	require AJ_ROOT.'/include/module.func.php';
	require AJ_ROOT.'/module/member/member.class.php';
	$do = new member;
	$user = $do->login($username, $password);
	if($user) {
		if($user['groupid'] != 1 || $user['admin'] < 1) dalert('您无权限访问后台', $MODULE[2]['linkurl'].'logout.php?forward='.urlencode(AJ_PATH));
		if(!is_founder($user['userid'])) {
			if(($AJ['admin_week'] && !check_period(','.$AJ['admin_week'])) || ($AJ['admin_hour'] && !check_period($AJ['admin_hour']))) dalert('未被允许的管理时间', $MODULE[2]['linkurl'].'logout.php?forward='.urlencode(AJ_PATH));
		}
		if($CFG['authadmin'] == 'cookie') {
			set_cookie($secretkey, $user['userid']);
		} else {
			$_SESSION[$secretkey] = $user['userid'];
		}
		require AJ_ROOT.'/admin/admin.class.php';
		$admin = new admin;
		$admin->cache_right($user['userid']);
		$admin->cache_menu($user['userid']);
		if($AJ['login_log']) $do->login_log($username, $password, $user['passsalt'], 1);
		dheader($forward);
	} else {
		if($AJ['login_log']) $do->login_log($username, $password, $user['passsalt'], 1, $do->errmsg);
		msg($do->errmsg, '?file=login&forward='.urlencode($forward));
	}
} else {
	//if(strpos($AJ_URL, AJ_PATH) === false) dheader(AJ_PATH.basename(get_env('self')));
	$username = isset($username) ? $username : $_username;
	include tpl('login');
}
?>