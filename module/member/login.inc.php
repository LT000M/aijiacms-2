<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$forward or $forward = $AJ_PC ? $MOD['linkurl'] : AJ_MOB.'my.php';
if($_userid && !$MOD['passport']) dheader($forward);
$_forward = $forward ? urlencode($forward) : '';
require AJ_ROOT.'/include/post.func.php';
require AJ_ROOT.'/module/'.$module.'/member.class.php';
$do = new member;
$OAUTH = cache_read('oauth.php');
$could_sms = ($MOD['login_sms'] && $AJ['sms']) ? 1 : 0;
$could_scan = ($MOD['login_scan'] && ($EXT['mobile_ios'] || $EXT['mobile_adr']) && $AJ_PC) ? 1 : 0;
$could_child = $MOD['child'] ? 1 : 0;
$could_weixin = ($MOD['login_weixin'] && $OAUTH['wechat']['enable'] && $AJ_PC) ? 1 : 0;
switch($action) {
	case 'child':
		$could_child or dheader('?action=login&forward='.$_forward);
		if($submit) {
			captcha($captcha, $MOD['captcha_login']);
			$username = trim($username);
			$password = trim($password);
			if(!check_name($username)) message($L['login_msg_username']);
			if(strlen($password) < 5) message($L['login_msg_password']);
			$r = $db->get_one("SELECT itemid,parent,password,passsalt,status FROM {$AJ_PRE}member_child WHERE username='$username'");
			if($r) {
				if($r['status'] != 3) message($L['member_login_member_ban']);
				if($r['password'] != dpassword($password, $r['passsalt'])) message($L['member_login_password_bad']);
				$cookietime = isset($cookietime) ? 86400*7 : 0;
				$user = $do->login($r['parent'], $cookietime, 0, 'child', $r['itemid']);
				if($user) dheader($forward);
				message($do->errmsg);
			} else {
				message($L['login_msg_not_member']);
			}
		}		
		$head_title = $L['login_title_child'];
	break;
	case 'sms':
		$could_sms or dheader('?action=login&forward='.$_forward);
		if($submit) {
			$session = new dsession();
			$_SESSION['mobile_oppo'] = $_SESSION['mobile_oppo'] + 1;
			if($_SESSION['mobile_oppo'] > 3) $_SESSION['mobile_code'] = '';
			(is_mobile($mobile) && preg_match("/^[0-9]{6}$/", $code) && isset($_SESSION['mobile_code']) && $_SESSION['mobile_code'] == md5($mobile.'|'.$code)) or message($L['login_msg_bad_code']);
			$_SESSION['mobile_code'] = '';
			$cookietime = $MOD['login_time'] >= 86400 ? $MOD['login_time'] : 0;
			$password = $code;
			if($_SESSION['mobile_auto']) {
				$post = array();
				$post['groupid'] = $post['regid'] = 5;
				$post['username'] = 'uid-'.get_uid();
				$post['passport'] = $post['username'];
				$post['password'] = $post['cpassword'] = random(10);
				$post['email'] = $post['username'].'@mob.sns';
				$post['mobile'] = $mobile;
				if($do->pass($post, 1)) {
					if($do->add($post)) {
						$username = $post['username'];
						$db->query("UPDATE {$AJ_PRE}member SET vmobile=0 WHERE mobile='$mobile'");
						$db->query("UPDATE {$AJ_PRE}member SET vmobile=1 WHERE username='$username'");
						$db->query("INSERT INTO {$AJ_PRE}validate (title,history,type,username,ip,addtime,status,editor,edittime) VALUES ('$mobile','$mobile','mobile','$username','$AJ_IP','$AJ_TIME','3','login','$AJ_TIME')");
						$user = $do->login($username, $password, $cookietime, 'sms');
						if($user) dheader($forward);
					}
				}
				message($do->errmsg);
			} else {
				$user = $db->get_one("SELECT username,groupid,passsalt FROM {$AJ_PRE}member WHERE mobile='$mobile' AND vmobile=1 ORDER BY userid");
				($user && !in_array($user['groupid'], array(2,3,4))) or message($L['login_msg_bad_mobile']);
				$username = $user['username'];
				$user = $do->login($username, $password, $cookietime, 'sms');
				if($user) {
					dheader($forward);
				} else {
					if($AJ['login_log'] == 2) $do->login_log($username, $password, $user['passsalt'], 0, $do->errmsg);
					message($do->errmsg);
				}
			}
		} else {
			$verfiy = 0;
			if(isset($auth)) {
				$auth = decrypt($auth, AJ_KEY.'VSMS');
				if(is_mobile($auth)) {
					$verfiy = 1;
					$mobile = $auth;
				}
			}
			$head_title = $L['login_title_sms'];
		}
	break;
	case 'send':
		$could_sms or exit('close');
		is_mobile($mobile) or exit('format');
		$msg = captcha($captcha, 1, true);
		if($msg) exit('captcha');
		$auto = 0;
		$user = $db->get_one("SELECT groupid FROM {$AJ_PRE}member WHERE mobile='$mobile' AND vmobile=1 ORDER BY userid");
		if($user) {
			if(in_array($user['groupid'], array(2,3,4))) exit('exist');
		} else {
			if($MOD['login_sms'] > 1) {
				$auto = 1;
			} else {
				exit('exist');
			}
		}
		$session = new dsession();
		isset($_SESSION['mobile_send']) or $_SESSION['mobile_send'] = 0;
		isset($_SESSION['mobile_time']) or $_SESSION['mobile_time'] = 0;
		if($_SESSION['mobile_send'] > 4) exit('max');
		if($_SESSION['mobile_time'] && (($AJ_TIME - $_SESSION['mobile_time']) < 180)) exit('fast');
		if(max_sms($mobile)) exit('max');
		
		
	
		//阿里云短信
				 if($AJ['sms_type']==2){
				 $mobilecode = random($AJ['sms_code_number'], '0-9');
				 $_SESSION['mobile_code'] = md5($mobile.'|'.$mobilecode);
		$_SESSION['mobile_time'] = $AJ_TIME;
		$_SESSION['mobile_oppo'] = 0;
		$_SESSION['mobile_send'] = $_SESSION['mobile_send'] + 1;
		$_SESSION['mobile_auto'] = $auto;
$content = lang('sms->sms_code', array($mobilecode, $MOD['auth_days']*10)).$AJ['sms_sign'];
				 $data = array('code'=>$mobilecode);
                  ali_sms($mobile, $AJ['sms_login'], $data);
                  //	send_sms($mobile, $content);
				 }else
				 {
				 $mobilecode = random(6, '0-9');
				 $_SESSION['mobile_code'] = md5($mobile.'|'.$mobilecode);
		$_SESSION['mobile_time'] = $AJ_TIME;
		$_SESSION['mobile_oppo'] = 0;
		$_SESSION['mobile_send'] = $_SESSION['mobile_send'] + 1;
		$_SESSION['mobile_auto'] = $auto;
				$content = lang('sms->sms_code', array($mobilecode, $MOD['auth_days']*10)).$AJ['sms_sign'];
				send_sms($mobile, $content);
				}
		#log_write($content, 'sms', 1);
		exit('ok');
	break;
	case 'weixin':
		$could_weixin or dheader('?action=login&forward='.$_forward);
		require AJ_ROOT.'/api/oauth/wechat/init.inc.php';
		$head_title = $L['login_title_weixin'];
	break;
	case 'scan':
		$could_scan or dheader('?action=login&forward='.$_forward);
		$session = new dsession();
		$sid = md5(AJ_IP.AJ_KEY.session_id());
		if($job == 'ajax') {
			$t = $db->get_one("SELECT * FROM {$AJ_PRE}app_scan WHERE sid='$sid'");
			if($t) {
				if($t['username'] == 'sc') {
					exit('scan');
				} else if($t['username']) {
					$db->query("DELETE FROM {$AJ_PRE}app_scan WHERE sid='$sid'");
					$user = $do->login($t['username'], '', 0, 'app-scan');
					exit($user ? 'ok' : 'ko');
				}
				exit('wait');
			} else {
				exit('out');
			}
		} else {
			$expire = $AJ_TIME - 600;
			$db->query("DELETE FROM {$AJ_PRE}app_scan WHERE lasttime<$expire");
			if(strpos($forward, 'api/') !== false) $forward = '';
			$forward or $forward = $MODULE[2]['linkurl'];
			$db->query("REPLACE INTO {$AJ_PRE}app_scan (sid,username,lasttime) VALUES ('$sid','','$AJ_TIME')");
			$auth = encrypt('SCAN:'.$sid, AJ_KEY.'QRCODE');
		}
		$head_title = $L['login_title_scan'];
	break;
	default:
		$LOCK = cache_read($AJ_IP.'.php', 'ban');
		if($LOCK && $AJ_TIME - $LOCK['time'] < 3600 && $LOCK['times'] >= 2) $MOD['captcha_login'] = 1;
		isset($auth) or $auth = '';
		if($_userid) $auth = '';
		if($auth) {
			$auth = decrypt($auth, AJ_KEY.'LOGIN');
			$_auth = explode('|', $auth);
			if($_auth[0] == 'LOGIN' && check_name($_auth[1]) && strlen($_auth[2]) >= $MOD['minpassword'] && $AJ_TIME >= intval($_auth[3]) && $AJ_TIME - intval($_auth[3]) < 30) {
				$submit = 1;
				$username = $_auth[1];
				$password = $_auth[2];
				$MOD['captcha_login'] = $captcha = 0;
			}
		}
		$action = 'login';
		if($submit) {
			captcha($captcha, $MOD['captcha_login']);
			$username = trim($username);
			$password = trim($password);
			if(strlen($username) < 3) message($L['login_msg_username']);
			if(strlen($password) < 5) message($L['login_msg_password']);
			$goto = isset($goto) ? true : false;
			if($goto) $forward = $MOD['linkurl'];
			$api_msg = $api_url = '';
			$cookietime = $MOD['login_time'] >= 86400 ? $MOD['login_time'] : 0;
			if(is_email($username)) {
				$condition = "email='$username' AND vemail=1";
			} else if(is_mobile($username)) {
				$condition = "mobile='$username' AND vmobile=1";
			} else if(check_name($username)) {
				$condition = "username='$username'";
			} else {
				if($MOD['passport']) {
					if(strlen($username) > $MOD['maxusername']) message($L['login_msg_username']);
					$condition = "passport='$username'";
				} else {
					message($L['login_msg_not_member']);
				}
			}
			$r = $db->get_one("SELECT username,passport,password,passsalt,loginip,mobile,vmobile FROM {$AJ_PRE}member WHERE {$condition} ORDER BY userid");
			if($r) {
				if($MOD['verfiy_login'] && $could_sms && is_mobile($r['mobile']) && $r['vmobile'] && $r['loginip'] != AJ_IP) {
					if(ip2area($r['loginip']) != ip2area(AJ_IP)) {
						if($r['password'] != dpassword($password, $r['passsalt'])) message($L['member_login_password_bad']);
						dheader('?action=sms&auth='.encrypt($r['mobile'], AJ_KEY.'VSMS').'&forward='.$_forward);
					}
				}
				$username = $r['username'];
				$passport = $r['passport'];
				if($MOD['passport'] == 'uc') include AJ_ROOT.'/api/'.$MOD['passport'].'.inc.php';
			} else {
				$passport = $username;
				if($MOD['passport'] == 'uc') include AJ_ROOT.'/api/'.$MOD['passport'].'.inc.php';
				message($L['login_msg_not_member']);
			}			
			$user = $do->login($username, $password, $cookietime);
			if($user) {
				if($MOD['passport'] && $MOD['passport'] != 'uc') {
					$api_url = '';
					$user['password'] = is_md5($password) ? $password : md5($password);
					if(strtoupper($MOD['passport_charset']) != AJ_CHARSET) $user = convert($user, AJ_CHARSET, $MOD['passport_charset']);
					extract($user);
					include AJ_ROOT.'/api/'.$MOD['passport'].'.inc.php';
					if($api_url) $forward = $api_url;
				}
				if($AJ['login_log'] == 2) $do->login_log($username, $password, $user['passsalt'], 0);
				if($api_msg) message($api_msg, $forward, -1);
				message($api_msg, $forward);
			} else {
				if($AJ['login_log'] == 2) $do->login_log($username, $password, $user['passsalt'], 0, $do->errmsg);
				message($do->errmsg, '?action=login&forward='.urlencode($forward));
			}
		}
		$register = isset($register) && $username ? 1 : 0;
		$head_title = $register ? $L['login_title_reg'] : $L['login_title'];
	break;
}
isset($username) or $username = $_username;
isset($password) or $password = '';
$username or $username = get_cookie('username');
check_name($username) or $username = '';
$oa = 0;
foreach($OAUTH as $v) {
	if($v['enable']) {
		$oa = 1;
		break;
	}
}
if($AJ_PC) {
	//
} else {
	if($oa) {
		if(in_array($AJ_MBS, array('weixin', 'wxxcx'))) {
			$OAUTH = array_merge(array('wechat' => $OAUTH['wechat']), $OAUTH);
		} else if(in_array($AJ_MBS, array('qq', 'tim'))) {
			$OAUTH = array_merge(array('qq' => $OAUTH['qq']), $OAUTH);
		} else if(in_array($AJ_MBS, array('weibo'))) {
			$OAUTH = array_merge(array('sina' => $OAUTH['sina']), $OAUTH);
		}
	}
	$js_pull = 0;
	$head_name = $head_title;
	$foot = 'my';
}
include template('login', $module);
?>