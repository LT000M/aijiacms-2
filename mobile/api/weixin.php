<?php
require '../../common.inc.php';
$AJ_MOB['browser'] == 'weixin' or exit('Not IN WeiXin');
if($action == 'login') {
	$openid = get_cookie('weixin_openid');
	$url = get_cookie('weixin_url');
	if($openid) {
		$openid = decrypt($openid, AJ_KEY.'WXID');
		if(is_openid($openid)) {
			$U = $db->get_one("SELECT username FROM {$AJ_PRE}weixin_user WHERE openid='$openid'");
			if($U) {
				include load('member.lang');
				$MOD = cache_read('module-2.php');
				include AJ_ROOT.'/include/post.func.php';
				include AJ_ROOT.'/include/module.func.php';
				include AJ_ROOT.'/module/member/member.class.php';
				$do = new member;
				if($U['username']) {
					$user = $do->login($U['username'], '', 0, 'weixin');
					$db->query("UPDATE {$AJ_PRE}weixin_user SET logintime=$AJ_TIME,logintimes=logintimes+1 WHERE openid='$openid'");
				} else {
					$post = array();
					$post['groupid'] = $post['regid'] = 5;
					$post['username'] = 'uid-'.get_uid();
					$post['passport'] = $U['nickname'];
					$post['password'] = $post['cpassword'] = random(10);
					$post['email'] = $post['username'].'@weixin.sns';
					if(!$do->is_passport($post['passport'], 1)) $post['passport'] = $post['username'];
					if($do->pass($post, 1)) {
						if($do->add($post)) {
							$db->query("UPDATE {$AJ_PRE}weixin_user SET username='$post[username]' WHERE itemid=$U[itemid]");
							$user = $do->login($post['username'], '', 0, 'weixin');
							if($user) dheader($url ? $url : AJ_MOB.'my.php');
						}
					}
					dheader($MODULE[2]['mobile'].'oauth.php?action=bind');
				}
			}
		}
	}
	dheader($url ? $url : AJ_MOB.'my.php');
} else if($action == 'member') {
	isset($auth) or $auth = '';
	if($auth) {
		$openid = decrypt($auth, AJ_KEY.'WXID');
		if(is_openid($openid)) {
			set_cookie('weixin_openid', $auth);
			set_cookie('weixin_url', AJ_MOB.'my.php');
			dheader(AJ_MOB.'api/weixin.php?action=login&reload='.$AJ_TIME);
		}
	}
} else if($action == 'callback') {
	if($code) {
		include AJ_ROOT.'/api/weixin/config.inc.php';
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.WX_APPID.'&secret='.WX_APPSECRET.'&code='.$code.'&grant_type=authorization_code';
		$rec = dcurl($url);
		$arr = json_decode($rec, true);
		if($arr['openid'] && is_openid($arr['openid'])) {
			$openid = $arr['openid'];
			$U = $db->get_one("SELECT * FROM {$AJ_PRE}weixin_user WHERE openid='$openid'");
			if($U) {
				$itemid = $U['itemid'];
				if($U['nickname']) $arr['access_token'] = '';
				if($_userid) {
					if($U['username']) {
						if($U['username'] != $_username) {
							$db->query("UPDATE {$AJ_PRE}weixin_user SET username='' WHERE username='$_username'");
							$db->query("UPDATE {$AJ_PRE}weixin_user SET username='$_username' WHERE itemid=$itemid");
						}
					} else {
						$db->query("UPDATE {$AJ_PRE}weixin_user SET username='' WHERE username='$_username'");
						$db->query("UPDATE {$AJ_PRE}weixin_user SET username='$_username' WHERE itemid=$itemid");
					}
				}
			} else {
				$db->query("INSERT INTO {$AJ_PRE}weixin_user (username,openid,subscribe,addtime,edittime) VALUES ('$_username','$openid','2','$AJ_TIME','$AJ_TIME')");
				$itemid = $db->insert_id();
			}
			if($_userid) {
				$url = get_cookie('weixin_url');
				if(strpos($url, 'openid.php') !== false) dheader($url);
			}
			if($arr['access_token']) {
				$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$openid.'&lang=zh_CN';
				$rec = dcurl($url);
				$info = json_decode($rec, true);
				$sql = "edittime=$AJ_TIME";
				if(isset($info['nickname'])) {
					foreach(array('nickname', 'sex', 'city', 'province', 'country', 'language', 'headimgurl') as $v) {
						if(isset($info[$v])) $sql .= ",".$v."='".addslashes($info[$v])."'";
					}
				}
				$db->query("UPDATE {$AJ_PRE}weixin_user SET $sql WHERE itemid=$itemid");
			}
			set_cookie('weixin_openid', encrypt($openid, AJ_KEY.'WXID'));
			dheader(AJ_MOB.'api/weixin.php?action=login&reload='.$AJ_TIME);
		}
	}
} else {
	isset($url) or $url = AJ_MOB.'my.php';
	if($moduleid > 3) $url = $MODULE[$moduleid]['mobile'];
	if($_userid && strpos($url, 'openid.php') === false) dheader($url);
	set_cookie('weixin_url', $url);
	if(get_cookie('weixin_openid')) dheader(AJ_MOB.'api/weixin.php?action=login&reload='.$AJ_TIME);
	include AJ_ROOT.'/api/weixin/config.inc.php';
	$scope = $action == 'connect' ? 'snsapi_userinfo' : 'snsapi_base';
	dheader('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WX_APPID.'&redirect_uri='.urlencode(($EXT['mobile_domain'] ? $EXT['mobile_domain'] : AJ_PATH.'mobile/').'api/weixin.php?action=callback').'&response_type=code&scope='.$scope.'&state=1#wechat_redirect');
}
dheader(AJ_MOB.'index.php?reload='.$AJ_TIME);
?>