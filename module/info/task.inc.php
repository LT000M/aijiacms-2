<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
if($html == 'show') {
	$itemid or exit;
	$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
	if(!$item || $item['status'] < 3) exit;
	extract($item);
	$fee = get_fee($item['fee'], $MOD['fee_view']);
	$currency = $MOD['fee_currency'];
	$unit = $currency == 'money' ? $AJ['money_unit'] : $AJ['credit_unit'];
	$name = $currency == 'money' ? $AJ['money_name'] : $AJ['credit_name'];
	$member = array();
	if(check_group($_groupid, $MOD['group_contact'])) {
		if($fee) {
			if($MG['fee_mode'] && $MOD['fee_mode']) {
				$user_status = 3;
			} else {
				$mid = $moduleid;
				if($_userid) {
					if(check_pay($mid, $itemid)) {
						$user_status = 3;
					} else {
						$user_status = 2;
						$pay_url = $MODULE[2]['linkurl'].'pay.php?mid='.$mid.'&itemid='.$itemid;
					}
				} else {
					$user_status = 0;
				}
			}
		} else {
			$user_status = 3;
		}
	} else {
		$user_status = $_userid ? 1 : 0;
	}
	if($_username && $_username == $item['username']) $user_status = 3;
	if($user_status == 3 && $item['username']) $member = userinfo($item['username']);
	$contact = strip_nr(ob_template('contact', 'chip'), true);
	echo 'Inner("contact", \''.$contact.'\');';
	if($MOD['hits']) echo 'Inner("hits", \''.$item['hits'].'\');';	
	$update = '';
	if($item['totime'] && $item['totime'] < $AJ_TIME && $item['status'] == 3) $update .= ",status=4";
	if($member) {
		unset($item['areaid']);
		$update_user = update_user($member, $item);
		if($update_user) $db->query("UPDATE {$table} SET ".substr($update_user, 1)." WHERE username='$username'");
	}
	if(!$AJ_BOT) include AJ_ROOT.'/include/update.inc.php';
	if($MOD['show_html'] && $task_item && $AJ_TIME - @filemtime(AJ_ROOT.'/'.$MOD['moduledir'].'/'.$item['linkurl']) > $task_item) tohtml('show', $module);
} else if($html == 'list') {
	$catid or exit;
	if($MOD['list_html'] && $task_list && $CAT) {
		$num = 1;
		$totalpage = max(ceil($CAT['item']/$MOD['pagesize']), 1);
		$demo = AJ_ROOT.'/'.$MOD['moduledir'].'/'.listurl($CAT, '{DEMO}');
		$fid = $page;
		if($fid >= 1 && $fid <= $totalpage && $AJ_TIME - @filemtime(str_replace('{DEMO}', $fid, $demo)) > $task_list) tohtml('list', $module);
		$fid = $page + 1;
		if($fid >= 1 && $fid <= $totalpage && $AJ_TIME - @filemtime(str_replace('{DEMO}', $fid, $demo)) > $task_list) tohtml('list', $module);
		$fid = $totalpage + 1 - $page;
		if($fid >= 1 && $fid <= $totalpage && $AJ_TIME - @filemtime(str_replace('{DEMO}', $fid, $demo)) > $task_list) tohtml('list', $module);
	}
} else if($html == 'index') {
	if($AJ['cache_hits'] && $MOD['hits']) {
		$file = AJ_CACHE.'/hits-'.$moduleid;
		if($AJ_TIME - @filemtime($file.'.dat') > $AJ['cache_hits'] || @filesize($file.'.php') > 102400) update_hits($moduleid, $table);
	}
	if($MOD['index_html']) {
		$file = AJ_ROOT.'/'.$MOD['moduledir'].'/'.$AJ['index'].'.'.$AJ['file_ext'];
		if($AJ_TIME - @filemtime($file) > $task_index) tohtml('index', $module);
	}
}
?>