<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
if($action == 'logout' && $admin_user) {
	set_cookie('admin_user', '');
	dmsg($L['index_msg_logout'], '?reload='.$AJ_TIME);
}
if($AJ_PC) {
	require AJ_ROOT.'/include/post.func.php';
	if($submit) {
		if(word_count($note) > 5000) message($L['index_msg_note_limit']);
		$note = '<?php exit;?>'.dhtmlspecialchars(stripslashes($note));
		file_put(AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php', $note);
		dmsg($L['op_update_success'], $MODULE[2]['linkurl']);
	}
	$user = userinfo($_username);
	extract($user);
	if($vemail && $vmobile && $vbank && $vtruename && $vcompany && !$validated) {
		$db->query("UPDATE {$AJ_PRE}company SET validated=1 WHERE userid=$_userid");
		userclean($_username);
	}
	$expired = $totime && $totime < $AJ_TIME ? true : false;
	$havedays = $expired ? 0 : ceil(($totime - $AJ_TIME)/86400);
	$sys = array();
	$i = 0;
	$result = $db->query("SELECT itemid,title,addtime,groupids FROM {$AJ_PRE}message WHERE groupids<>'' ORDER BY itemid DESC", 'CACHE');
	while($r = $db->fetch_array($result)) {
		$groupids = explode(',', $r['groupids']);
		if(!in_array($_groupid, $groupids)) continue;
		if($i > 2) continue;
		$i++;
		$sys[] = $r;
	}
	$note = AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php';
	$note = file_get($note);
	if($note) {
		$note = substr($note, 13);
	} else {
		$note = $MOD['usernote'];
	}
	$t = explode('.', $_money);
	$my_money = $t[0].'<span>.'.$t[1].'</span>';
	$head_title = '';
} else {
	$head_title = $MOD['name'];
	$foot = 'my';
}
include template('index', $module);
?>