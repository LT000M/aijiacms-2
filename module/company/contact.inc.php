<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
$could_contact or dalert($L['msg_contact_deny'], 'goback');
$could_message = check_group($_groupid, $MOD['group_message']);
if($username == $_username || $domain) $could_message = true;
if($AJ_PC) {
	//
} else {
	$head_name = $head_title;
}
include template('contact', $template);
?>