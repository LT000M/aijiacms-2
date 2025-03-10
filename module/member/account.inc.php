<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
switch($action) {
	case 'line':
		$forward or $forward = $AJ_PC ? AJ_PATH : AJ_MOB;
		$online = $_online ? 0 : 1;
		$db->query("UPDATE {$AJ_PRE}member SET online=$online WHERE userid=$_userid");
		$db->query("UPDATE {$AJ_PRE}online SET online=$online WHERE userid=$_userid");
		dheader($forward);
	break;
	case 'promo':
		$code = dhtmlspecialchars(trim($code));
		if($code) {
			$p = $db->get_one("SELECT * FROM {$AJ_PRE}finance_promo WHERE number='$code' AND totime>$AJ_TIME");
			if($p && ($p['reuse'] || (!$p['reuse'] && !$p['username']))) {
				if($p['type']) {
					exit(lang($L['grade_msg_time_promo'], array($p['amount'])));
				} else {
					exit(lang($L['grade_msg_money_promo'], array($p['amount'])));
				}
			}
		}
		exit($L['grade_msg_bad_promo']);
	break;
	case 'grade':
		$GROUP = cache_read('group.php');
		$groupid = isset($groupid) ? intval($groupid) : 0;
		isset($GROUP[$groupid]) or $groupid = 0;
		$UP = $UG = array();
		if($_groupid > 2) {
			foreach($GROUP as $k=>$v) {
				if($v['listorder'] > $MG['listorder']) $UP[$k] = $v;
			}
		}
		array_key_exists($groupid, $UP) or $groupid = 0;
		$fee = 0;
		$could_up = $groupid;
		if($groupid) {
			$UG = cache_read('group-'.$groupid.'.php');
			$jdfee = $UG['jdfee'];
			$bnfee = $UG['bnfee'];
			$fee = $UG['fee'];
		}
   
		$buy_month = $_GET['buy_month'] ? $_GET['buy_month'] : $buy_month;
       
		if($_groupid < 5) $could_up = false;
		($could_up && $groupid) or dheader('grade.php');
		$r = $db->get_one("SELECT status FROM {$AJ_PRE}upgrade WHERE userid=$_userid ORDER BY itemid DESC");
		if($r && $r['status'] == 2) message($L['grade_msg_success']);
		$auto = 0;
		$auth = isset($auth) ? decrypt($auth, AJ_KEY.'CG') : '';
		if($auth && substr($auth, 0, 6) == 'grade|') {
			$_gid = intval(substr($auth, 6));
			if($_gid == $groupid) $auto = $submit = 1;
		}
		//$buy_month=$_GET['buy_month'];
   
    
		if($submit) {
       // $buy_month=$_POST['buy_month'];
     
			if($buy_month == $jdfee)
				{$buy_months=3;}
				elseif($buy_month == $bnfee)
				{$buy_months=6;}
				else
				{$buy_months=12;}
				
		

		 $fee=$buy_month;
         
			if($fee > 0) {
				//$fee >= $_money or message($L['money_not_enough']);
				if($fee<= $AJ['quick_pay']) $auto = 1;
				if(!$auto) {
					is_payword($_username, $password) or message($L['error_payword']);
				}
				
				
				money_add($_username, -$fee);
				money_record($_username, -$fee, $L['in_site'], 'system', $L['grade_title'], $GROUP[$groupid]['groupname']);
				$company = dhtmlspecialchars($_company);
			} else {
			//if(strlen($company) < 4) message($L['grade_pass_company']);
				$company = dhtmlspecialchars(trim($company));
			}
				$fromtime = strtotime(timetodate($AJ_TIME, 3));
			$days = $buy_months*30;
			$totime = strtotime(timetodate($AJ_TIME + 86400*$days, 3));
			if($groupid > 6) {
$db->query("INSERT INTO {$AJ_PRE}upgrade (userid,username,gid,groupid,company,addtime,ip,amount,status,amount,msg,editor,reason,note) VALUES ('$_userid','$_username','$_groupid','$groupid','$company','$AJ_TIME', '$AJ_IP','$fee','3','$amount','1','admin','升级申请','系统自动审核')");
$db->query("UPDATe {$AJ_PRE}company SET groupid='$could_up',vip='1',validated='1',validator='已通过本站机构认证',vipt='1',validtime='$AJ_TIME',fromtime='$AJ_TIME',totime='$totime' WHERe username='$_username'");
$db->query("UPDATE {$AJ_PRE}member SET groupid='$could_up' WHERe username='$_username'");
message('恭喜您升级成功！', '?action=index', 5);
} else {
$db->query("INSERT INTO {$AJ_PRE}upgrade (userid,username,gid,groupid,company,addtime,ip,amount,status) VALUES ('$_userid','$_username','$_groupid','$groupid','$company','$AJ_TIME', '$AJ_IP','$fee','2')");
message($L['grade_msg_success'], '?action=index', 5);
}
			//$db->query("INSERT INTO {$AJ_PRE}upgrade (userid,username,gid,groupid,company,addtime,ip,amount,status,fromtime,totime) VALUES ('$_userid','$_username','$_groupid','$groupid','$company','$AJ_TIME', '$AJ_IP','$fee','2', '$fromtime','$totime')");
			 message($L['grade_msg_success'], '?action=index', 5);
		} else {
			$GROUPS = array();
			foreach($GROUP as $k=>$v) {
				if($k > 4) {
					$G = cache_read('group-'.$k.'.php');
					$G['moduleids'] = isset($G['moduleids']) ? explode(',', $G['moduleids']) : array();
					if($G['grade']) $GROUPS[$k] = $G;
				}
			}
			$head_title = $L['grade_title'];
		}
	break;
	case 'vip':
		$user = userinfo($_username);
		if(!$MG['vip'] || !$MG['fee'] || $user['totime'] < $AJ_TIME) dheader('?action=index');
		$auto = 0;
		$auth = isset($auth) ? decrypt($auth, AJ_KEY.'CG') : '';
		if($auth && substr($auth, 0, 4) == 'vip|') {
			$auto = $submit = 1;
			$year = intval(substr($auth, 4));
		}
		if($submit) {
			$year = intval($year);
			
			in_array($year, array(1, 2, 3)) or $year = 1;
				if($buy_month==3){$fee=$jdfee;}
				elseif($buy_month==6)
				{$fee=$bnfee;}
				else
				{$fee=$fee;}
			$fee = dround($MG['fee']*$year);
			$fee > 0 or message($L['vip_msg_fee']);
			//$fee <= $_money or message($L['money_not_enough']);
			if($fee <= $AJ['quick_pay']) $auto = 1;
			if(!$auto) {
				is_payword($_username, $password) or message($L['error_payword']);
			}
			$days = $buy_month*30;
			$totime = $user['totime'] +  strtotime(timetodate($AJ_TIME + 86400*$days, 3));
			money_add($_username, -$fee);
			money_record($_username, -$fee, $L['in_site'], 'system', $L['vip_renew'], lang($L['vip_record'], array($year, timetodate($totime, 3))));
			$db->query("UPDATE {$AJ_PRE}company SET totime=$totime WHERE userid=$_userid");
			dmsg($L['vip_msg_success'], '?action=index');
		} else {
		$havedays = ceil(($user['totime'] - $AJ_TIME)/86400);
		$todate = timetodate($user['totime'], 3);
			$year = 1;
			if($sum > 1 && $sum < 4) $year = $sum;
			$fee = dround($MG['fee']*$year);
			$head_title = $L['vip_renew'];
		}
	break;
	default:
		$user = userinfo($_username);
		extract($user);
		$expired = $totime && $totime < $AJ_TIME ? true : false;
		$havedays = $expired ? 0 : ceil(($totime-$AJ_TIME)/86400);
		$head_title = $L['profile_title'];	
	break;
}
if($AJ_PC) {
	//
} else {
	$foot = '';
	if($action == 'grade' || $action == 'vip') {
		$back_link = '?action=index';
	} else {
		$back_link = 'index.php';
	}
}
include template('account', $module);
?>