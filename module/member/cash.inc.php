<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
$MG['cash'] or dheader(($AJ_PC ? $MOD['linkurl'] : $MOD['mobile']).'account.php?action=group&itemid=1');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$member = userinfo($_username);
$BANKS = explode('|', trim($MOD['cash_banks']));
switch($action) {
	case 'record':
		$condition = "username='$_username'";
		$BANKS = explode('|', trim($MOD['cash_banks']));
		$_status = $L['cash_status'];
		(isset($fromdate) && is_time($fromdate)) or $fromdate = '';
		$fromtime = is_date($fromdate) ? datetotime($fromdate.' 0:0:0') : 0;
		(isset($todate) && is_time($todate)) or $todate = '';
		$totime = is_date($todate) ? datetotime($todate.' 23:59:59') : 0;
		isset($type) or $type = 0;
		isset($bank) or $bank = '';
		if($bank) $condition .= " AND bank='$bank'";
		if($fromtime) $condition .= " AND addtime>=$fromtime";
		if($totime) $condition .= " AND addtime<=$totime";
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}finance_cash WHERE $condition");
		$items = $r['num'];
		$pages = $AJ_PC ? pages($items, $page, $pagesize) : mobile_pages($items, $page, $pagesize);
		$lists = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}finance_cash WHERE $condition ORDER BY itemid DESC LIMIT $offset,$pagesize");
	
		$amount = $fee = 0;
		while($r = $db->fetch_array($result)) {
			$r['addtime'] = timetodate($r['addtime'], 5);
			$r['edittime'] = $r['edittime'] ? timetodate($r['edittime'], 5) : '--';
			$r['dstatus'] = $_status[$r['status']];
			$amount += $r['amount'];
			$fee += $r['fee'];
			$lists[] = $r;
		}
		$head_title = $L['cash_title_record'];
	break;
	case 'setting':
		$vbank = $member['vbank'];
		if($submit && !$vbank) {
			is_payword($_username, $password) or message($L['error_payword']);
			in_array($bank, $BANKS) or message($L['cash_pass_bank']);
			$banktype = $banktype ? 1 : 0;
			$account = str_replace(array(' ', '-'), array('', ''), $account);
			(preg_match("/^[0-9]{6,}$/", $account) || is_email($account)) or message($L['cash_pass_account']);
			$branch = trim(dhtmlspecialchars($branch));
			strlen($branch) > 8 or message($L['cash_pass_branch']);
			$db->query("UPDATE {$AJ_PRE}member_misc SET bank='$bank',banktype='$banktype',branch='$branch',account='$account' WHERE username='$_username'");
			userclean($_username);
			dmsg($L['op_set_success'], '?action=setting');
		} else {
			$bank_select = '<select name="bank" id="bank"><option value="">'.$L['choose'].'</option>';
			foreach($BANKS as $k=>$v) {
				$bank_select .= '<option value="'.$v.'"'.($v == $member['bank'] ? 'selected' : '').'>'.$v.'</option>';
			}
			$bank_select .= '</select>';
			$head_title = $L['cash_title_setting'];
		}
	break;
	case 'confirm':
		$amount or message($L['cash_pass_amount']);
		if($amount > $_money) message($L['cash_pass_amount_large']);
		if($MOD['cash_min'] && $amount < $MOD['cash_min']) message($L['cash_pass_amount_min'].$MOD['cash_min']);
		if($MOD['cash_max'] && $amount > $MOD['cash_max']) message($L['cash_pass_amount_max'].$MOD['cash_max']);
		if($MOD['cash_times']) {
			$r = $db->get_one("SELECT COUNT(*) as num FROM {$AJ_PRE}finance_cash WHERE username='$_username' AND addtime>$AJ_TODAY-86400");
			if($r['num'] >= $MOD['cash_times']) message(lang($L['cash_pass_amount_day'], array($MOD['cash_times'])), '?action=record', 5);
		}
		$amount = dround($amount);
		$fee = 0;
		if($MOD['cash_fee']) {
			$fee = dround($amount*$MOD['cash_fee']/100);
			if($MOD['cash_fee_min'] && $fee < $MOD['cash_fee_min']) $fee = $MOD['cash_fee_min'];
			if($MOD['cash_fee_max'] && $fee > $MOD['cash_fee_max']) $fee = $MOD['cash_fee_max'];
		}
		$money = $amount - $fee;
		if($submit) {
			is_payword($_username, $password) or message($L['error_payword']);
			$member = daddslashes($member);
			$name = $member['banktype'] ? $member['company'] : $member['truename'];
			$db->query("INSERT INTO {$AJ_PRE}finance_cash (username,bank,banktype,branch,account,truename,amount,fee,addtime,ip) VALUES ('$_username','$member[bank]','$member[banktype]','$member[branch]','$member[account]','$name','$money','$fee','$AJ_TIME','$AJ_IP')");
			echo "INSERT INTO {$AJ_PRE}finance_cash (username,bank,banktype,branch,account,truename,amount,fee,addtime,ip) VALUES ('$_username','$member[bank]','$member[banktype]','$member[branch]','$member[account]','$name','$money','$fee','$AJ_TIME','$AJ_IP')";
			$cid = $db->insert_id();
			money_add($_username, -$amount);
			money_record($_username, -$amount, $L['in_site'], 'system', $L['cash_title'], $L['charge_id'].$cid);
			message($L['cash_msg_success'], '?action=record', 5);
		} else {
			$head_title = $L['cash_title_confirm'];
		}
	break;
	default:
		$MOD['cash_enable'] or message($L['feature_close'], $AJ_PC ? $MOD['linkurl'] : $MOD['mobile'], 3);
		if(!$member['bank'] || !$member['account']) message($L['cash_msg_account'], '?action=setting');
		$head_title = $L['cash_title'];
	break;
}
if($AJ_PC) {
	//
} else {
	if((!$action || $action == 'index') && !$kw)$back_link = $MODULE[2]['mobile'].($_cid ? 'child.php' : '');
	$head_name = $head_title;
}
include template('cash', $module);
?>