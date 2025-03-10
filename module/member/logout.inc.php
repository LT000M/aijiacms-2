<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/module/'.$module.'/member.class.php';
$do = new member;
$do->logout();
$session = new dsession();
session_destroy();
if($AJ_PC) {
	$forward or $forward = AJ_PATH;
} else {
	$forward = AJ_MOB.'my.php';
}
$action = 'logout';
$api_msg = $api_url = '';
if($MOD['passport']) {
	include AJ_ROOT.'/api/'.$MOD['passport'].'.inc.php';
	if($api_url) $forward = $api_url;
}
#if($MOD['sso']) include AJ_ROOT.'/api/sso.inc.php';
if($api_msg) message($api_msg, $forward, -1);
message($api_msg, $forward);
?>