<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['guestbook_enable'] or dheader(AJ_PATH);
$TYPE = explode('|', trim($MOD['guestbook_type']));
require AJ_ROOT.'/include/post.func.php';
$ext = 'guestbook';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
require AJ_ROOT.'/module/'.$module.'/'.$ext.'.class.php';
$do = new $ext();
$aijiacms_task = rand_task();
if($action == 'add') {
	if($submit) {
		captcha($captcha, $MOD['guestbook_captcha']);
		if($do->pass($post)) {
			$post['areaid'] = $cityid;
			$do->add($post);
			message($L['gbook_success'], $AJ_PC ? $url : $mob);
		} else {
			message($do->errmsg);
		}
	} else {
		$content = isset($content) ? dhtmlspecialchars(stripslashes($content)) : '';
		$truename = $telephone = $email = $qq = $wx = $ali = $skype = '';
		if($_userid) {
			$user = userinfo($_username);
			$truename = $user['truename'];
			$telephone = $user['telephone'] ? $user['telephone'] : $user['mobile'];
			$email = $user['mail'] ? $user['mail'] : $user['email'];
			$qq = $user['qq'];
			$wx = $user['wx'];
			$ali = $user['ali'];
			$skype = $user['skype'];
		}
	}
} else {
	$type = '';
	$condition = "status=3 AND reply<>''";
	if($keyword) $condition .= " AND content LIKE '%$keyword%'";
	if($cityid) $condition .= ($AREA[$cityid]['child']) ? " AND areaid IN (".$AREA[$cityid]['arrchildid'].")" : " AND areaid=$cityid";
	$lists = $do->get_list($condition);
}
$template = $ext;
$head_title = $L['gbook_title'];
if($AJ_PC) {	
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = strpos($AJ_URL, '/api/') === false ? str_replace($url, $mob, $AJ_URL) : str_replace(AJ_PATH, AJ_MOB, $AJ_URL);
} else {
	$foot = '';
	if($action == 'add') {
		$back_link = $mob;
	} else {
		$pages = mobile_pages($items, $page, $pagesize);
		$back_link = ($kw || $page > 1) ? $mob : AJ_MOB.'more.php';
	}
}
include template($template, $module);
?>