<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';


$from = isset($from) ? $from : '';
		$condition = 'groupid>5';//
	
		$sfields= array('姓名', '公司', '电话', '手机', '会员');
		$dfields = array( 'truename','company',  'telephone', 'mobile',  'username');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";

		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}member WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);		
		$lists = array();
	
		$result = $db->query("SELECT userid,username,truename,company FROM {$AJ_PRE}member WHERE $condition ORDER BY userid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$lists[] = $r;
		}
		$head_title = '置业顾问';
		include template('zhiye_my', $module);
		exit;

?>