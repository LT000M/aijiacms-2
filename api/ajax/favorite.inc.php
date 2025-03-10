<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$_userid or exit('请登录');
$mid = intval($mid);
if($mid > 3 && $itemid > 0) {
	$table = get_table($mid);
	if($table) {
		$f = $db->get_one("SELECT itemid FROM {$AJ_PRE}favorite WHERE userid=$_userid AND mid=$mid AND tid=$itemid");
		if($f) exit('ok');
		$id = $mid == 4 ? 'userid' : 'itemid';
		$t = $db->get_one("SELECT * FROM {$table} WHERE `{$id}`=$itemid");
		if($t) {
			$post = array();
			if($mid == 4) {
				if($t['groupid'] > 5) {
					$post['title'] = $t['company'];
					$post['url'] = $t['linkurl'];
				}
			} else {
				if($t['status'] > 2) {
					$post['title'] = $t['title'];
					$post['url'] = strpos($t['linkurl'], '://') === false ? $MODULE[$mid]['linkurl'].$t['linkurl'] : $t['linkurl'];
				}
			}
			if($post) {
				require AJ_ROOT.'/module/member/favorite.class.php';
				$do = new favorite();
				if(isset($t['thumb']) && is_url($t['thumb'])) $post['thumb'] = $t['thumb'];
				$post['userid'] = $_userid;
				$post['addtime'] = $AJ_TIME;
				$post['mid'] = $mid;
				$post['tid'] = $itemid;
				$post = daddslashes($post);
				$do->add($post);
				exit('ok');
			}
		}
	}
}
exit('收藏失败');
?>