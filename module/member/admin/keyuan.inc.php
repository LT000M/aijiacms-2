<?php
defined('AJ_ADMIN') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/keyuan.class.php';

$do = new keyuan();
$menus = array (
    array('添加客源', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
	array('客源列表', '?moduleid='.$moduleid.'&file='.$file),
);

switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				
				$do->add($post);
				$post['lurusj'] = $AJ_TIME;
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$content = '';
			$status = 3;
			
			$item = array();
			$menuid = 0;
		
			$pagebreak = 0;
			include tpl('keyuan_edit', $module);
		}
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
			include tpl('keyuan_edit', $module);
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
			if($username)
			{$yyuesql = DB::query("SELECT * FROM ".AJ_PRE."message WHERE fromuser='$username' ORDER BY addtime desc ");
			
		while($r = DB::fetch_array($yyuesql)) {
		
			$yyue[] = $r;
		}
		}
			if($username)
			{$stats_pvsql = DB::query("SELECT * FROM ".AJ_PRE."stats_pv WHERE username='$username' ORDER BY addtime desc ");
			
		while($r = DB::fetch_array($stats_pvsql)) {
		
			$browse_record[] = $r;
		}
		}
		include tpl('keyuan_show', $module);		
	break;
	case 'genjin':
		$kyid or msg();
		
		extract($item);
		include tpl('genjin', $module);		
	break;
	case 'bgkyzt':
		$kyid or msg();
		$do->id = $kyid;
		extract($item);
			extract($do->get_one());
		include tpl('bgkyzt', $module);		
	break;
	case 'daikan':
		$kyid or msg();
		
		extract($item);
		include tpl('daikan', $module);		
	break;
	case 'tixing':
		$kyid or msg();
		
		extract($item);
		include tpl('tixing', $module);		
	break;
	
	case 'bgwhr':
		$kyid or msg();
		
		extract($item);
		include tpl('bgwhr', $module);		
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
		if($userid) $condition .= " AND userid=$userid";
		
		$lists = $do->get_list($condition);
		include tpl('keyuan', $module);
	break;
}
?>