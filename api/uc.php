<?php
$_SERVER['REQUEST_URI'] = '';
$moduleid = 2;
require '../common.inc.php';
if($AJ_BOT) dhttp(403);
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['passport'] == 'uc' or exit('Access Denied');
define("UC_DBHOST", $MOD['uc_dbhost']) ;
define("UC_DBUSER", $MOD['uc_dbuser']) ;
define("UC_DBPW", $MOD['uc_dbpwd']) ;
define("UC_DBNAME", $MOD['uc_dbname']) ;
define("UC_DBPRE", $MOD['uc_dbpre']) ;
define("UC_KEY", $MOD['uc_key']) ;
define('UC_APPID', $MOD['uc_appid']) ;
define("UC_API", $MOD['uc_api']) ;
define("UC_IP", $MOD['uc_ip']) ;
define("UC_DBTABLEPRE", $MOD['uc_dbpre']);
define("UC_CONNECT", $MOD['uc_mysql'] ? 'mysql' : '');
define('UC_DBCHARSET', $MOD['uc_charset']); 
define('API_RETURN_SUCCEED', 1);
define('API_UPDATEPW', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
require_once AJ_ROOT.'/api/ucenter/client.php';
$code = strip_sql($code, 0);
parse_str(uc_authcode($code, 'DECODE', UC_KEY), $uc_arr);
#log_write($uc_arr, 'uc', 1);
if($AJ_TIME - intval($uc_arr['time']) > 3600) exit('Authracation Has Expiried');
if(empty($uc_arr)) exit('Invalid Request');
$action = $uc_arr['action'];
switch($action) {
	case 'test':
		exit('1');
	break;
	case 'synlogin':
		$username = $uc_arr['username'];
		if($_username == $username) exit('1');
		$user = $db->get_one("SELECT userid,password,username,passport,groupid,admin FROM {$AJ_PRE}member WHERE passport='$username'");
		if($user) {
			if($user['groupid'] == 2 || $user['groupid'] == 4) exit('-1');
			if($_username == $user['username']) exit('1');
		} else {
			require AJ_ROOT.'/include/post.func.php';
			require AJ_ROOT.'/module/'.$module.'/member.class.php';
			$do = new member;			
			$post = $user = array();
			$post['groupid'] = $post['regid'] = 5;
			$post['username'] = $post['passport'] = $post['truename'] = $username;
			$post['password'] = $post['cpassword'] = random(10);
			$post['email'] = $post['username'].'@uc.sns';
			if($do->pass($post, 1)) {
				$userid = $do->add($post);
				if($userid) {
					$user['userid'] = $userid;
					$user['password'] = $post['password'];
				}
			}
			$user or exit('-1');
		}
		$cookietime = $AJ_TIME + ($cookietime ? $cookietime : 86400*7);
		$aijiacms_auth = encrypt($user['userid'].'|'.$user['password'], AJ_KEY.'USER');
		ob_clean();
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		set_cookie('auth', $aijiacms_auth, $cookietime);
		$db->query("UPDATE {$AJ_PRE}member SET loginip='$AJ_IP',logintime=$AJ_TIME,logintimes=logintimes+1 WHERE userid=$user[userid]");
		exit('1');
	break;
	case 'synlogout':
		if($_userid) {
			header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			set_cookie('auth', '');
		}
		exit('1');
	break;
	case 'deleteuser':
		$passport = $uc_arr['username'];/* 禁止访问 不直接删除 */
		$db->query("UPDATE {$AJ_PRE}member SET groupid=2 WHERE passport='$passport' AND groupid!=1");
		exit('1');
	break;
	case 'updatepw':
		exit('1');
	break;
	case 'getcreditsettings':	
		API_GETCREDITSETTINGS or exit(API_RETURN_FORBIDDEN);
		$credits = array(
			1 => array('积分', '分'),
		);
		echo uc_serialize($credits);
	break;
	case 'updatecredit':
		$credit = intval($uc_arr['amount']);
		if($credit) {
			$type = $uc_arr['credit'];
			$uid = $uc_arr['uid'];
			$user = uc_get_user($uid, 1);
			$username = $user[1];
			if($username) {
				credit_add($username, $credit);
				credit_record($username, $credit, 'system', 'UC Credits', 'extcredits'.$type);
				exit('1');
			} else {
				exit('0');
			}
		} else {
			exit('0');
		}
	break;
	case 'updatecreditsettings':
		exit('1');
	break;
	case 'updateapps':
		exit('1');
	break;
	default:
		exit('-1');
	break;
}
?>