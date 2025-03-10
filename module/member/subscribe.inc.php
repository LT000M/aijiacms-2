<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
switch($action) {
	case 'addbefollow':	
		if($submit) {
			$fields = array(
				'subid' => $subid,
				);
			$fields = dhtmlspecialchars($fields);
			$content = dsafe(addslashes(save_remote(save_local(stripslashes($content)))));
			$fields['content'] = $content;
			$fields['subid'] = $subid;
			$fields['username'] = $_username;
			$fields['addtime'] = $AJ_TIME;
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			$db->query("INSERT INTO {$AJ_PRE}subscribe_follow ($sqlk) VALUES ($sqlv)");
			$itemid = $db->insert_id();
			dmsg($L['ask_add_success'], '?action=index');
		} else {
			$head_title = '增加预约根进';
		}
	break;	
	case 'show':	
		$result= $db->query("SELECT * FROM {$AJ_PRE}subscribe_follow WHERE subid=$itemid");
		while($r = $db->fetch_array($result)) {
			$followlist[] = $r;
		}
		$head_title = '预约跟进记录';
	break;	
	default:
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$condition = "fromuser='$_username'";
		$typeid = isset($typeid) ? intval($typeid) : 1;
		if($typeid > -1) $condition .= " AND typeid=$typeid";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}message WHERE $condition");
		$items = $r['num'] <= $MG['subscribe_limit'] ? $r['num'] : $MG['subscribe_limit'];
		$pagesize = $r['num'] <= $MG['subscribe_limit'] ? $r['num'] : $MG['subscribe_limit'];
		$pages = pages($items, $page, $pagesize);		
		$lists = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}message WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = $r['edittime'] ? timetodate($r['edittime'], 5) : 'N/A';
			$r['dstatus'] = $dstatus[$r['status']];
			$lists[] = $r;
		}
		$head_title = '预约管理';
	break;
}
include template('subscribe', $module);
?>