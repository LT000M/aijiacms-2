<?php
defined('IN_AIJIACMS') or exit('Access Denied');

login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';

require AJ_ROOT.'/include/post.func.php';

require AJ_ROOT.'/module/'.$module.'/xiangce.class.php';
$do = new xiangce;


if(in_array($action, array('', 'check'))) {
	$sfields = array( '标题', );
	$dfields = array( 'title');
	$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序', '更新时间降序', '更新时间升序');
	$dorder  = array('addtime DESC', 'addtime DESC', 'addtime ASC', 'edittime DESC', 'edittime ASC');
		
	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	$itemid or $itemid = '';
	$market = isset($market) ? intval($market) : 0;	
	$minxiangce = isset($minxiangce) ? dround($minxiangce) : '';
	$minxiangce or $minxiangce = '';
	$maxxiangce = isset($maxxiangce) ? dround($maxxiangce) : '';
	$maxxiangce or $maxxiangce = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$order_select  = dselect($sorder, 'order', '', $order);
	$condition = '';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
	
	if($itemid) $condition .= " AND itemid=$itemid";
	 if($houseid) $condition .= " AND houseid=$houseid";
	
	$timetype = strpos($dorder[$order], 'edit') === false ? 'add' : '';
}
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$post['thumb']=implode(',',$post['thumb']);
				foreach(explode(',', $post['thumb']) as $v) {
					if($v) {
						$v=str_replace('../','',$v); 
						if($AJ['ftp_remote'] && $AJ['remote_url']) {
							$post['thumb']=$v;
							}
							else {$post['thumb']=$MODULE[1][linkurl].$v;}
				$do->add($post);
					}
				}
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&houseid='.$post['houseid']);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$username = $_username;
			$status = 3;
			$addtime = timetodate($AJ_TIME);
			$menuid = 0;
			
		
			include template('xiangce_add', $module);
		}
	break;
	case 'edit':
		$itemid or msg('请选择信息');
		
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			$menuid = 1;
			include template('xiangce_edit', $module);
		}
	break;
	case 'delete':
		$itemid or msg('请选择信息');
		$do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition, $dorder[$order]);
			$menuid = 2;
			include template('xiangce', $module);
		}
	break;
	default:
		$item = 0;
		$lists = $do->get_list('status=3'.$condition, $dorder[$order]);
	
		$menuid = 1;
		include template('xiangce', $module);
	break;
}
?>