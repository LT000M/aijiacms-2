<?php
defined('AJ_ADMIN') or exit('Access Denied');

require AJ_ROOT.'/module/'.$module.'/appnav.class.php';
$do = new dappnav();
$menus = array (
    array('添加导航', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('导航列表', '?moduleid='.$moduleid.'&file='.$file),
);
if($_catids || $_areaids) require AJ_ROOT.'/admin/admin_check.inc.php';
$this_forward = '?moduleid='.$moduleid.'&file='.$file;
if(in_array($action, array('', 'check'))) {
	$sfields = array('按条件', '名称');
	$dfields = array('name','name');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序');
	$dorder  = array('listorder ASC,id DESC', 'upd_time DESC', 'upd_time ASC');
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
	
	$condition = '';
	
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			
			$is_enable = 1;
			$add_time = timetodate($AJ_TIME);
			$menuid = 0;
			include tpl('appnav_edit', $module);
		}
	break;
	case 'edit':
		$id or msg();
		$do->id = $id;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$menuid = $is_enable == 1 ? 0 : 1;
			include tpl('appnav_edit', $module);
		}
	break;
	
	case 'order':
		$do->order($listorder); 
		dmsg('排序成功', $forward);
	break;
	case 'delete':
		$id or msg('请选择链接');
		$do->delete($id);
		dmsg('删除成功', $forward);
	break;
	
	default:
		$menuid = 1;
		$lists = $do->get_list("is_enable=1".$condition, $dorder[$order]);
		include tpl('appnav', $module);
	break;
}
?>