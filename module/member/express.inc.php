<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MG['express_limit'] > -1 or dalert(lang('message->without_permission_and_upgrade'), 'goback');
($mid && $MODULE[$mid]['module'] == 'mall') or dheader($AJ_PC ? $MOD['linkurl'] : $MOD['mobile']);
$head_title = $L['express_title'];
require AJ_ROOT.'/include/post.func.php';
require AJ_ROOT.'/module/'.$module.'/express.class.php';
$do = new express($mid);
switch($action) {
	case 'add':
		if($MG['express_limit']) {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}mall_express_{$mid} WHERE username='$_username' AND parentid=0");
			if($r['num'] >= $MG['express_limit']) dalert(lang($L['limit_add'], array($MG['express_limit'], $r['num'])), 'goback');
		}
		if($submit) {
			if($do->pass($post)) {
				$post['username'] = $_username;
				$do->add($post);
				dmsg($L['op_add_success'], '?mid='.$mid.'&action=index');
			} else {
				message($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				$$v = '';
			}
		}
	break;
	case 'edit':
		$itemid or message();
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		if($submit) {
			if($do->pass($post)) {
				$post['username'] = $_username;
				$do->edit($post);
				dmsg($L['op_edit_success'], $forward);
			} else {
				message($do->errmsg);
			}
		} else {
			extract($r);
		}
	break;
	case 'delete':
		$itemid or message($L['express_msg_choose']);
		$do->itemid = $itemid;
		$r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		$do->delete($itemid);
		dmsg($L['op_del_success'], $forward);
	break;
	case 'area':
		$itemid or message($L['express_msg_choose']);
		$do->itemid = $itemid;
		$I = $r = $do->get_one();
		if(!$r || $r['username'] != $_username) message();
		if($submit) {
			$do->area($post);
			dmsg($L['op_success'], '?mid='.$mid.'&action=area&itemid='.$itemid);
		} else {
			$lists = $do->get_list("parentid=$itemid");
			if($r['items'] != $items) $db->query("UPDATE {$AJ_PRE}mall_express_{$mid} SET items=$items WHERE itemid=$itemid");
			$area_select = ajax_area_select('post[0][areaid]', $L['choose']);
		}
	break;
	default:
		$condition = "username='$_username' AND parentid=0";
		if($keyword) $condition .= " AND express LIKE '%$keyword%'";
		$lists = $do->get_list($condition);
		$limit_used = $items;
		$limit_free = $MG['express_limit'] && $MG['express_limit'] > $limit_used ? $MG['express_limit'] - $limit_used : 0;	
	break;
}
if($AJ_PC) {
	$menu_id = 1;
} else {
	$foot = '';
	if($action == 'add' || $action == 'edit') {
		$back_link = '?mid='.$mid.'&action=index';
	} else {
		$pages = mobile_pages($items, $page, $pagesize);
		$back_link = ($kw || $page > 1) ? '?mid='.$mid.'&action=index' : $AJ['file_my'].'?mid='.$mid;
	}
}
include template('express', $module);
?>