<?php
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/keyuan.class.php';
require AJ_ROOT.'/include/post.func.php';
$do = new keyuan();
$menus = array (
    array('添加客源', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
	array('客源列表', '?moduleid='.$moduleid.'&file='.$file),
);

switch($action) {
	case 'add':

			include template('keyuan_save', $module);
	
	break;
	
	case 'edit':
		$id or msg();
		$do->id = $id;
		if($submit) {
			if($do->pass($post)) {
					$post['xiugaisj'] = $AJ_TIME;
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			include template('keyuan_edit', $module);
		}
	break;
	case 'show':
		$id or msg();
		$do->id = $id;
		$item = $do->get_one();
		$item or msg();
		extract($item);
		$kygenjinsql = DB::query("SELECT * FROM ".AJ_PRE."kygenjin WHERE kyid=$id ORDER BY gjshijian desc ");
		while($r = DB::fetch_array($kygenjinsql)) {
		$r['gjshijian'] = timetodate($r['gjshijian'], 5);
			$kygenjin[] = $r;
		}
		
		$kydaikansql = DB::query("SELECT * FROM ".AJ_PRE."kydaikan WHERE kyid=$id ORDER BY dkshijian desc ");
		while($r = DB::fetch_array($kydaikansql)) {
		$r['dkshijian'] = timetodate($r['dkshijian'], 5);
			$kydaikan[] = $r;
		}
		$kytixingsql = DB::query("SELECT * FROM ".AJ_PRE."kytixing WHERE kyid=$id ORDER BY txshijian desc ");
		while($r = DB::fetch_array($kytixingsql)) {
		$r['txshijian'] = timetodate($r['txshijian'], 5);
			$kytixing[] = $r;
		}
		
		include template('keyuan_show', $module);		
	break;
	case 'genjin':
		$kyid or msg();
		
		extract($item);
		include template('genjin', $module);		
	break;
	case 'bgkyzt':
		$kyid or msg();
		
		$do->id = $kyid;
		extract($item);
			extract($do->get_one());
		include template('bgkyzt', $module);		
	break;
	case 'daikan':
		$kyid or msg();
		
		extract($item);
		include template('daikan', $module);		
	break;
	case 'tixing':
		$kyid or msg();
		
		extract($item);
		include template('tixing', $module);		
	break;
	
	case 'bgwhr':
		$kyid or msg();
		
		
		include template('bgwhr', $module);		
	break;
	case 'delete':
		$id or msg('请选择客源');
		$do->delete($id);
		dmsg('删除成功', $forward);
	break;
	default:
	    $NAME = array('私客', '公客', '成交', '他人成交', '暂缓委托');
		$sfields = array('按条件', '需求用途', '客户姓名', '咨询电话', '维护人');
		$dfields = array('xqbianhao', 'xqyongtu', 'khxingming', 'dianhua', 'weihuren');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$userid = isset($userid) ? intval($userid) : '';
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		
			if($_userid) $condition .= " AND lururenid=$_userid";
		$lists = $do->get_list($condition);
		include template('keyuan', $module);
	break;
}
?>