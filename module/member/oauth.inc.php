<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
switch($action) {
	case 'delete':
		login();
		$MOD['oauth'] or dheader('index.php');
		$itemid or message();
		$U = $db->get_one("SELECT * FROM {$AJ_PRE}oauth WHERE itemid=$itemid");
		if(!$U || $U['username'] != $_username) message();
		$db->query("DELETE FROM {$AJ_PRE}oauth WHERE itemid=$itemid");
		dmsg($L['oauth_quit'], '?action=index');
	break;
	case 'bind':
		$avatar = '';
		if(!$_userid) {
			$auth = decrypt(get_cookie('bind'), AJ_KEY.'BIND');
			$openid = decrypt(get_cookie('weixin_openid'), AJ_KEY.'WXID');
			if(is_openid($openid) && $AJ_MOB['browser'] == 'weixin') {
				$U = $db->get_one("SELECT * FROM {$AJ_PRE}weixin_user WHERE openid='$openid'");
				if($U) {
					$OAUTH = cache_read('oauth.php');
					$nohead = AJ_PATH.'api/weixin/image/headimg.jpg';
					$avatar = $U['headimgurl'] ? $U['headimgurl'] : $nohead;
					$nickname = $U['nickname'] ? $U['nickname'] : 'USER';
					$site = $OAUTH['wechat']['name'];
					$connect = AJ_MOB.'api/weixin.php?action=connect';
				}
			} else if(strpos($auth, '|') !== false) {
				$t = explode('|', $auth);
				$itemid = intval($t[0]);
				$U = $db->get_one("SELECT * FROM {$AJ_PRE}oauth WHERE itemid=$itemid");
				if($U && $U['site'] = $t[1]) {
					$OAUTH = cache_read('oauth.php');
					$nohead = AJ_PATH.'api/oauth/avatar.png';
					$avatar = $U['avatar'] ? $U['avatar'] : $nohead;
					$nickname = $U['nickname'] ? $U['nickname'] : 'USER';
					$site = $OAUTH[$U['site']]['name'];
					$connect = AJ_PATH.'api/oauth/'.$U['site'].'/connect.php';
				}
			}
		}
		$avatar or dheader($AJ_PC ? 'index.php' : AJ_MOB.'my.php');
		$head_title = $L['oauth_bind'];
	break;
	default:
		login();
		$MOD['oauth'] or dheader('index.php');
		$lists = $tags = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}oauth WHERE username='$_username' ORDER BY logintime DESC");
		while($r = $db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['logindate'] = timetodate($r['logintime'], 5);
			$r['nickname'] or $r['nickname'] = '-';
			$tags[$r['site']][] = $r;
		}
		foreach($tags as $kk=>$vv) {
			foreach($vv as $k=>$v) {
				if($k) {
					$db->query("UPDATE {$AJ_PRE}oauth SET username='' WHERE itemid=$v[itemid]");
				} else {
					$lists[$kk] = $v;
				}
			}
		}
		$OAUTH = cache_read('oauth.php');
		$head_title = $L['oauth_title'];	
	break;
}
if($AJ_PC) {
	//
} else {
	$foot = '';
	if($action == 'bind') {
		$back_link = AJ_MOB.'my.php';
	} else {
		$back_link = 'index.php';
	}
}
include template('oauth', $module);
?>