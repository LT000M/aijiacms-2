<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
($MG['biz'] && $MG['homepage'] && $MG['link_limit'] > -1) or dalert(lang('message->without_permission_and_upgrade'), 'goback');
if($MG['type'] && !$_edittime && $action == 'add') dheader('edit.php?tab=2');
require AJ_ROOT.'/include/post.func.php';
include load('my.lang');
require AJ_ROOT.'/module/'.$module.'/link.class.php';
$do = new dlink();
switch($action) {
	case 'add':
		if($_credit < 0 && $MOD['credit_less']) dheader('credit.php?action=less');
		if($MG['hour_limit']) {
			$today = $AJ_TIME - 3600;
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}link WHERE username='$_username' AND addtime>$today");
			if($r && $r['num'] >= $MG['hour_limit']) dalert(lang($L['hour_limit'], array($MG['hour_limit'])), '?action=index');
		}
		if($MG['day_limit']) {
			$today = $today_endtime - 86400;
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}link WHERE username='$_username' AND addtime>$today");
			if($r && $r['num'] >= $MG['day_limit']) dalert(lang($L['day_limit'], array($MG['day_limit'])), '?action=index');
		}
		if($MG['link_limit']) {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}link WHERE username='$_username' AND status>0");
			if($r['num'] >= $MG['link_limit']) dalert(lang($L['limit_add'], array($MG['link_limit'], $r['num'])), '?action=index');
		}
		if($submit) {
			$post['username'] = $_username;
			if($do->pass($post)) {
				$need_check =  $MOD['link_check'] == 2 ? $MG['check'] : $MOD['link_check'];
				$post['status'] = get_status(3, $need_check);
				$do->add($post);
				dmsg($L['op_add_success'], '?status='.$post['status']);
			} else {
				message($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				$$v = '';
			}
			$head_title = $L['link_title_add'];
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		if($submit) {
			$post['username'] = $_username;
			if($do->pass($post)) {
				$need_check =  $MOD['link_check'] == 2 ? $MG['check'] : $MOD['link_check'];
				$post['status'] = get_status($r['status'], $need_check);
				$do->edit($post);
				dmsg($L['op_edit_success'], '?status='.$post['status']);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
			$head_title = $L['link_title_edit'];
		}
	break;
	case 'delete':
		$itemid or message($L['link_msg_choose']);
		$itemids = is_array($itemid) ? $itemid : array($itemid);
		foreach($itemids as $itemid) {
			$do->itemid = $itemid;
			$item = $do->get_one();
			if($item && $item['username'] == $_username) $do->delete($itemid);
		}
		dmsg($L['op_del_success'], $forward);
	break;
	default:
		$status = isset($status) ? intval($status) : 3;
		in_array($status, array(2, 3)) or $status = 3;
		$condition = "username='$_username'";
		$condition .= " AND status=$status";
		if($keyword) $condition .= " AND title LIKE '%$keyword%'";
		$lists = $do->get_list($condition);
		$head_title = $L['link_title'];
	break;
}
$nums = array();
$limit_used = 0;
for($i = 2; $i < 4; $i++) {
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}link WHERE username='$_username' AND status=$i");
	$nums[$i] = $r['num'];
	$limit_used += $r['num'];
}
$limit_free = $MG['link_limit'] && $MG['link_limit'] > $limit_used ? $MG['link_limit'] - $limit_used : 0;
if($AJ_PC) {	
	$menu_id = 2;
} else {
	$foot = '';
	if($action == 'add' || $action == 'edit') {
		$back_link = '?action=index';
	} else {
		$time = 'addtime';
		foreach($lists as $k=>$v) {
			$lists[$k]['linkurl'] = str_replace($MOD['linkurl'], $MOD['mobile'], $v['linkurl']);
			$lists[$k]['date'] = timetodate($v[$time], 5);
		}
		$pages = mobile_pages($items, $page, $pagesize);
		$back_link = ($kw || $page > 1) ? '?status='.$status : 'biz.php';
	}
}
include template('link', $module);
?>