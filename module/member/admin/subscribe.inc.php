<?php
defined('AJ_ADMIN') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/message.class.php';
$menus = array (
    array('新房预约', '?moduleid='.$moduleid.'&file='.$file.'&action=house'),
    array('二手房预约', '?moduleid='.$moduleid.'&file='.$file.'&action=sale'),
    array('租房预约', '?moduleid='.$moduleid.'&file='.$file.'&action=rent'),
  
);
$do = new message;
$this_forward = '?moduleid='.$moduleid.'&file='.$file;

$NAME = array('选择类型','新房预约', '二手房预约', '租房预约');

switch($action) {
	
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			$do->_edit($message);
			dmsg('修改成功', '?moduleid='.$moduleid.'&file='.$file.'&action=system');
		} else {
			extract($do->get_one());
			include tpl('message_edit', $module);
		}
	break;
	
	case 'choosebroker':
		$itemid or msg();
		$do->itemid = $itemid;
		DB::query("UPDATE ".AJ_PRE."message SET fromuser='$username' WHERE itemid='$itemid'");
		dalert('设置成功', '', 'parent.window.location="?moduleid='.$moduleid.'&file='.$file.'"');
			
	break;
	
	case 'broker':
	
			$lists = array();
			$pages = '';
			$tname = '选择经纪人';
			
				$table = $AJ_PRE.'member';
				$condition = 'groupid>5';
				if($keyword) $condition .= " AND username LIKE '%$keyword%'";
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
				$items = $r['num'];
				$pages = pages($items, $page, $pagesize);
				$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY userid DESC LIMIT $offset,$pagesize");
			
				while($r = $db->fetch_array($result)) {
					
					$lists[] = $r;
				
			}	
			include tpl('broker', $module);
		
	break;
	//看跟进
	case 'befollow':
	
			$lists = array();
			$pages = '';
			
				$table = $AJ_PRE.'subscribe_follow';
				$condition = 'subid='.$subid;
			
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition");
				$items = $r['num'];
				$pages = pages($items, $page, $pagesize);
				$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
			
				while($r = $db->fetch_array($result)) {
					
					$lists[] = $r;
				
			}	
			include tpl('befollow', $module);
		
	break;
	//增加跟进
	case 'addbefollow':
	if($submit) {
		$db->query("INSERT INTO {$AJ_PRE}subscribe_follow (subid,content,username,addtime) VALUES ('$subid','$content','$username','$AJ_TIME')");
		dalert('设置成功', '', 'parent.window.location="?moduleid='.$moduleid.'&file='.$file.'"');
			//dmsg('添加成功', $forward);
	}
	else
	{
		include tpl('addbefollow', $module);}
			
	break;
	// 状态
		case 'status':
		if(!$itemid) msg();
		$do->itemid = $itemid;
		DB::query("UPDATE ".AJ_PRE."message SET status=$status WHERE itemid='$itemid'");
		dmsg('设置成功', $forward);
	break;
	case 'delete':
		if(!$itemid) msg();
		$do->itemid = $itemid;
		$do->delete();
		dmsg('删除成功', $forward);
	break;

   case 'house':
			$lists = $do->get_list('typeid=1 and telephone !=""'.$condition);
			$menuid = 0;
			include tpl('subscribe', $module);
	break;
	case 'sale':
			$lists = $do->get_list('typeid=2'.$condition);
			$menuid = 1;
			include tpl('subscribe', $module);
	break;
	case 'rent':
			$lists = $do->get_list('typeid=3'.$condition);
			$menuid = 2;
			include tpl('subscribe', $module);
	break;
	default:
		$sfields = array('标题', '联系人', '联系电话',  );
		$dfields = array('title', 'truename', 'telephone');
		$S = array('状态', '未联系', '已联系');

		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$typeid = isset($typeid) ? intval($typeid) : -1;
		
		$status = isset($status) ? intval($status) : 0;

		$fields_select = dselect($sfields, 'fields', '', $fields);
		$status_select = dselect($S, 'status', '', $status);

		$condition = "groupids=''";
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		if($status) $condition .= " AND status=$status";
		
		if($typeid == -1) $condition .= " AND typeid=1";
		if($typeid > -1) $condition .= " AND typeid=$typeid";
	
		
		$menuid = 0;
        	if($title) $condition .= " AND title='$title'";
		$lists = $do->get_list($condition);
		include tpl('subscribe', $module);
	break;
}
?>