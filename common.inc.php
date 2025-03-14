<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
define('AJ_DEBUG', 0);
if(AJ_DEBUG) {
	error_reporting(E_ALL);
	$mtime = explode(' ', microtime());
	$debug_starttime = $mtime[1] + $mtime[0];
} else {
	error_reporting(0);
}
if(isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) exit('Request Denied');
if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
$MQG = get_magic_quotes_gpc();
foreach(array('_POST', '_GET') as $__R) {
	if($$__R) { 
		foreach($$__R as $__k => $__v) {
			if(substr($__k, 0, 1) == '_') if($__R == '_POST') { unset($_POST[$__k]); } else { unset($_GET[$__k]); }
			if(isset($$__k) && $$__k == $__v) unset($$__k);
		}
	}
}
define('IN_AIJIACMS', true);
define('IN_ADMIN', defined('AJ_ADMIN') ? true : false);
define('AJ_ROOT', str_replace("\\", '/', dirname(__FILE__)));
if(defined('AJ_REWRITE')) include AJ_ROOT.'/include/rewrite.inc.php';
$CFG = array();
require AJ_ROOT.'/config.inc.php';
define('AJ_PATH', $CFG['url']);
define('AJ_STATIC', $CFG['static'] ? $CFG['static'] : $CFG['url']);
define('AJ_DOMAIN', $CFG['cookie_domain'] ? substr($CFG['cookie_domain'], 1) : '');
define('AJ_WIN', strpos(strtoupper(PHP_OS), 'WIN') !== false ? true: false);
define('AJ_CHMOD', ($CFG['file_mod'] && !AJ_WIN) ? $CFG['file_mod'] : 0);
define('AJ_LANG', $CFG['language']);
define('AJ_KEY', $CFG['authkey']);
define('AJ_PRE', $CFG['tb_pre']);
define('AJ_EDITOR', $CFG['editor']);
define('AJ_CDN', $CFG['cdn'] ? 1 : 0);
define('AJ_CLOUD_UID', $CFG['cloud_uid']);
define('AJ_CLOUD_KEY', $CFG['cloud_key']);
define('AJ_CHARSET', strtoupper($CFG['charset']));
define('AJ_CACHE', $CFG['cache_dir'] ? $CFG['cache_dir'] : AJ_ROOT.'/file/cache');
define('AJ_SKIN', AJ_STATIC.'skin/'.$CFG['skin'].'/');
define('VIP', $CFG['com_vip']);
define('errmsg', 'Invalid Request');
$L = array();
include AJ_ROOT.'/lang/'.AJ_LANG.'/lang.inc.php';
require AJ_ROOT.'/version.inc.php';
require AJ_ROOT.'/include/global.func.php';
require AJ_ROOT.'/include/safe.func.php';
require AJ_ROOT.'/include/cloud.func.php';
require AJ_ROOT.'/include/tag.func.php';
require AJ_ROOT.'/api/im.func.php';
require AJ_ROOT.'/api/extend.func.php';
require AJ_ROOT.'/api/plug.php';
if(!$MQG) {
	if($_POST) $_POST = daddslashes($_POST);
	if($_GET) $_GET = daddslashes($_GET);
	if($_COOKIE) $_COOKIE = daddslashes($_COOKIE);
}
if(function_exists('date_default_timezone_set')) date_default_timezone_set($CFG['timezone']);
$AJ_PRE = $CFG['tb_pre'];
$AJ_QST = addslashes($_SERVER['QUERY_STRING']);
$AJ_TIME = time() + $CFG['timediff'];
$AJ_IP = get_env('ip');
$AJ_URL = get_env('url');
$AJ_REF = get_env('referer');
$AJ_MOB = get_env('mobile');
$AJ_BOT = is_robot();
$AJ_TOUCH = is_touch();
$AJ_PC = $GLOBALS['AJ_PC'] = 1;
define('AJ_TIME', $AJ_TIME);
define('AJ_IP', $AJ_IP);
define('AJ_TOUCH', $AJ_TOUCH);
header("Content-Type:text/html;charset=".AJ_CHARSET);
require AJ_ROOT.'/include/db_'.$CFG['database'].'.class.php';
require AJ_ROOT.'/include/cache_'.$CFG['cache'].'.class.php';
require AJ_ROOT.'/include/session_'.$CFG['session'].'.class.php';
require AJ_ROOT.'/include/file.func.php';
if(!empty($_SERVER['REQUEST_URI'])) strip_uri($_SERVER['REQUEST_URI']);
if($_POST) { $_POST = strip_sql($_POST); strip_key($_POST); }
if($_GET) { $_GET = strip_sql($_GET); strip_key($_GET); }
if($_COOKIE) { $_COOKIE = strip_sql($_COOKIE); strip_key($_COOKIE); }
if(!IN_ADMIN) {
	$BANIP = cache_read('banip.php');
	if($BANIP) banip($BANIP);
	$aijiacms_task = '';
}
if($_POST) extract($_POST, EXTR_SKIP);
if($_GET) extract($_GET, EXTR_SKIP);
$db_class = 'db_'.$CFG['database'];
$db = new $db_class;
$db->halt = (AJ_DEBUG || IN_ADMIN) ? 1 : 0;
$db->pre = $CFG['tb_pre'];
$db->connect($CFG['db_host'], $CFG['db_user'], $CFG['db_pass'], $CFG['db_name'], $CFG['db_expires'], $CFG['db_charset'], $CFG['pconnect']);
$dc = new dcache();
$dc->pre = $CFG['cache_pre'];
require AJ_ROOT.'/include/db.class.php';
$AJ = $MOD = $EXT = $CSS = $JS = $AJMP = $CAT = $ARE = $AREA = array();
$CACHE = cache_read('module.php');
if(!$CACHE) {
	require_once AJ_ROOT.'/admin/global.func.php';
	require_once AJ_ROOT.'/include/post.func.php';
	require_once AJ_ROOT.'/include/cache.func.php';
    cache_all();
	$CACHE = cache_read('module.php');
}
$AJ = $CACHE['dt'];
$MODULE = $CACHE['module'];
$EXT = cache_read('module-3.php');
define('AJ_MAX_LEN', $AJ['max_len']);
define('AJ_MOB', $EXT['mobile_url']);
define('RE_WRITE', $AJ['rewrite'] ? ($AJ['search_rewrite'] ? 2 : 1) : 0);
$lazy = $AJ['lazy'] ? 1 : 0;
if(!IN_ADMIN && ($AJ['close'] || $AJ['defend_cc'] || $AJ['defend_reload'] || $AJ['defend_proxy'])) include AJ_ROOT.'/include/defend.inc.php';
unset($CACHE, $CFG['db_host'], $CFG['db_user'], $CFG['db_pass'], $db_class, $db_file);
$moduleid = isset($moduleid) ? intval($moduleid) : 1;
if($moduleid > 1) {
	isset($MODULE[$moduleid]) or dheader(AJ_PATH);
	$module = $MODULE[$moduleid]['module'];
	$MOD = $moduleid == 3 ? $EXT : cache_read('module-'.$moduleid.'.php');
	include AJ_ROOT.'/lang/'.AJ_LANG.'/'.$module.'.inc.php';
} else {
	$moduleid = 1;
	$module = 'aijiacms';
}
$cityid = 0;
$city_name = $L['allcity'];
$city_domain = $city_template = $city_sitename = '';
if($AJ['city']){
$map_mid = $map_mid ? $map_mid : $AJ['map_mid'];

}else{
$map_mid=$AJ['map_mid'];}
if($AJ['city']) include AJ_ROOT.'/include/city.inc.php';
($AJ['gzip_enable'] && !$_POST && !defined('AJ_MOBILE')) ? ob_start('ob_gzhandler') : ob_start();
if(isset($forward)) {
	if(isset($_GET['forward'])) $forward = urldecode($forward);
} else if($AJ_REF) {
	$forward = strpos(dirname($AJ_REF).'/', (AJ_DOMAIN ? AJ_DOMAIN : AJ_PATH)) === false ? AJ_PATH : $AJ_REF;
} else {
	$forward = AJ_PATH;
}
strip_uri($forward);
(isset($action) && check_name($action)) or $action = '';
(isset($job) && check_name($job)) or $job = '';
$submit = isset($_POST['submit']) ? 1 : 0;
if($submit) {
	isset($captcha) or $captcha = '';
	isset($answer) or $answer = '';
}
$mid = isset($mid) ? intval($mid) : 0;
$sum = isset($sum) ? intval($sum) : 0;
$page = isset($page) ? max(intval($page), 1) : 1;
$catid = isset($catid) ? intval($catid) : 0;
$areaid = isset($areaid) ? intval($areaid) : 0;
$itemid = isset($itemid) ? (is_array($itemid) ? array_map('intval', $itemid) : intval($itemid)) : 0;
$pagesize = $AJ['pagesize'] ? $AJ['pagesize'] : 30;
$offset = ($page-1)*$pagesize;
$kw = isset($_GET['kw']) ? strip_kw($_GET['kw'], $AJ['max_kw']) : '';
$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
$today_endtime = strtotime(date('Y-m-d', $AJ_TIME).' 23:59:59');
$seo_file = $seo_title = $head_title = $head_keywords = $head_description = $head_canonical = $head_mobile = '';
$head_pc = $moduleid > 1 ? str_replace(AJ_MOB.$MODULE[$moduleid]['moduledir'].'/', $MODULE[$moduleid]['linkurl'], $AJ_URL) : str_replace(AJ_MOB, AJ_PATH, $AJ_URL);
if($catid) $CAT = get_cat($catid);
if($areaid) $ARE = get_area($areaid);
//$_userid = $_admin = $_aid = $_message = $_chat = $_sound = $_online = $_money = $_credit = $_sms = 0;
$_userid = $_admin = $_aid = $_cid = $_message = $_chat = $_sound = $_online = $_money = $_credit = $_sms = 0;
$_username = $_company = $_passport = $_truename = '';
$_groupid = 3;
$aijiacms_auth = get_cookie('auth');
if($aijiacms_auth) $aijiacms_auth = decrypt($aijiacms_auth, AJ_KEY.'USER');
if($aijiacms_auth) {	
	$_dauth = explode('|', $aijiacms_auth);
	$_userid = isset($_dauth[0]) ? intval($_dauth[0]) : 0;
	if($_userid) {
		$_password = isset($_dauth[1]) ? trim($_dauth[1]) : '';
		$_cid = isset($_dauth[2]) ? intval($_dauth[2]) : 0;
		$USER = $db->get_one("SELECT username,passport,company,truename,mobile,password,groupid,email,message,chat,sound,online,sms,credit,money,loginip,admin,aid,edittime,trade FROM {$AJ_PRE}member WHERE userid=$_userid");
		if($USER && $USER['password'] == $_password) {
			if($USER['groupid'] == 2) dalert(lang('message->common_forbidden'));
			if($USER['loginip'] != $AJ_IP && ($AJ['ip_login'] == 2 || ($AJ['ip_login'] == 1 && IN_ADMIN))) {
				$_userid = 0; set_cookie('auth', '');
				dalert(lang('message->common_login', array($USER['loginip'])), AJ_PATH);
			}
			extract($USER, EXTR_PREFIX_ALL, '');
		} else {
			$_userid = 0;
			if($db->linked && !isset($swfupload) && strpos($_SERVER['HTTP_USER_AGENT'], 'Flash') === false) set_cookie('auth', '');
		}
		unset($aijiacms_auth, $USER, $_dauth, $_password);
	}
}
if($_userid == 0) { $_groupid = 3; $_username = ''; }
if(!IN_ADMIN) {
	if($_groupid == 1) include AJ_ROOT.'/module/member/admin.inc.php';
	if($_userid) $db->query("REPLACE INTO {$AJ_PRE}online (userid,username,ip,moduleid,online,lasttime) VALUES ('$_userid','$_username','$AJ_IP','$moduleid','$_online','$AJ_TIME')");
	if($AJ_BOT && $moduleid >= 4) $MOD['order'] = $moduleid == 4 ? 'userid DESC' : 'addtime DESC';
}
/**
 * 预约刷新配置
 * @author 房产
 */

$time = time();
$updateDate = strtotime(date('Y-m-d H:i',$time));
if(date('i',$time)%2==0){
 $result = $db->query("SELECT * FROM {$AJ_PRE}appolist WHERE update_time <= '{$updateDate}'");
    while($rel = $db->fetch_array($result)) {
            if (get_jfen($rel['username']) <=0) {
                continue;
            }
        if($rel['appo_site']=='rent'){
           yyrefresh('rent_7',$rel['house_id'],$rel['update_time']);
			
        }else{
          yyrefresh('sale_5',$rel['house_id'],$rel['update_time']);
        }
		  $db->query("DELETE FROM {$AJ_PRE}appolist WHERE update_time <= '{$updateDate}'");
		yycredit_add($rel['username'], -$AJ['yycredit_refresh']);
		yycredit_record($rel['username'], -$AJ['yycredit_refresh'], 'system', '预约刷新', $rel['house_title'], $rel['appo_site']);
    }
	
 

}

	$devip = DB::get_one("SELECT totime,userid,groupid FROM {$AJ_PRE}company WHERE userid=$_userid");
	$memvip = DB::get_one("SELECT regid,userid FROM {$AJ_PRE}member WHERE userid=$_userid");
	
if($devip['groupid']>4 &&  $devip['totime']>0 &&   $devip['totime']<$AJ_TIME) {
		$regid = $memvip['regid'] ? $memvip['regid'] : 6;
			DB::query("UPDATE {$AJ_PRE}company SET groupid=$regid,vip=0,vipr=0,vipt=0 WHERE userid=$_userid");
			DB::query("UPDATE {$AJ_PRE}member SET groupid=$regid,regid=$regid WHERE userid=$_userid");
	}
	
$MG = cache_read('group-'.$_groupid.'.php');
?>