<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
($mid > 4 && isset($MODULE[$mid]) && !$MODULE[$mid]['islink']) or dheader($AJ_PC ? AJ_PATH : AJ_MOB);
$awards = $MOD['awards'] ? explode('|', $MOD['awards']) : array();
$moduleid = $mid;
$MOD = cache_read('module-'.$mid.'.php');
$fee_award = min(abs(dround($MOD['fee_award'])), 100);
($itemid && $fee_award) or dheader($AJ_PC ? $MOD['linkurl'] : $MOD['mobile']);
$table = $MOD['module'] == 'job' ? $AJ_PRE.'job_resume_'.$mid : get_table($mid);
$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if(!$item || $item['status'] < 3) dheader($AJ_PC ? $MOD['linkurl'] : $MOD['mobile']);
$title = $item['title'];
$username = $item['username'];
if($MOD['module'] == 'know') {
	$aid = intval($item['aid']);
	$best = $aid ? $db->get_one("SELECT * FROM {$AJ_PRE}know_answer_{$mid} WHERE itemid=$aid") : array();
	if($best && $best['username']) $username = $best['username'];
}
if($_username == $username) message($L['award_msg_self']);
$forward = strpos($item['linkurl'], '://') === false ? ($AJ_PC ? $MOD['linkurl'] : $MOD['mobile']).$item['linkurl'] : $item['linkurl'];
$note = $MOD['name'].($MOD['module'] == 'job' ? $L['resume_name'] : '').':'.$itemid;
$auto = 0;
$auth = isset($auth) ? decrypt($auth, AJ_KEY.'CG') : '';
if($auth && substr($auth, 0, 6) == 'award|') {
	$t = explode('|', $auth);
	$_mid = intval($t[1]);
	$_itemid = intval($t[2]);
	$fee = dround($t[3]);
	if($_mid == $mid && $_itemid == $itemid && $fee > 0) $auto = $submit = 1;
}
if($submit) {
	$fee > 0 or message($L['award_msg_fee']);
	$fee <= $_money or message($L['money_not_enough']);
	if($fee <= $AJ['quick_pay']) $auto = 1;
	if(!$auto) {
		is_payword($_username, $password) or message($L['error_payword']);
	}
	money_add($_username, -$fee);
	money_record($_username, -$fee, $L['in_site'], 'system', $L['award_record_view'], $note);
	$fee_back = dround($fee*$fee_award/100);
	if($username && $fee_back) {
		money_add($username, $fee_back);
		money_record($username, $fee_back, $L['in_site'], 'system', $L['award_record_back'], $note);
	}
	$db->query("INSERT INTO {$AJ_PRE}finance_award (mid,tid,username,fee,paytime,ip,title) VALUES ('$mid','$itemid','$_username','$fee','$AJ_TIME','$AJ_IP','".addslashes($title)."')");
	message($L['award_msg_success'], $forward);
} else {
	$head_title = $L['award_title'];
	if($AJ_PC) {
		if($EXT['mobile_enable']) $head_mobile = str_replace($MODULE[2]['linkurl'], $MODULE[2]['mobile'], $AJ_URL);
	} else {
		$foot = '';
		$head_name = $L['award_title'];
		$back_link = $forward;
	}
	include template('award', $module);
}
?>