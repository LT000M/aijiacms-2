<?php
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
array('系统首页', '?action=main'),
array('修改密码', '?action=password'),
array('会员中心', $MODULE[2]['linkurl'], 'target="_blank"'),
array('网站首页', AJ_PATH, 'target="_blank"'),
array('安全退出', "javascript:Dconfirm('确定要退出管理后台吗?', '?file=logout');"),
);
if ($_admin > 1) {
    unset($menus[1]);
}

switch ($action) {
    case 'cache':
		dheader('?file=html&action=caches');
		break;
    case 'html':
		dheader('?file=html&action=homepage');
		break;
    case 'home':
		$url = '';
		if ($job) {
			list($mid, $file) = explode('-', $job);
			$mid = intval($mid);
			check_name($file) or $file = '';
			if ($mid == 3) {
				if (isset($EXT[$file.'_url'])) {
					$url = $EXT[$file.'_url'];
				}
			} else {
				if (isset($MODULE[$mid])) {
					$url = $MODULE[$mid]['linkurl'];
				}
			}
		}
		dheader(is_url($url) ? $url : AJ_PATH);
		break;
    case 'password':
		if ($submit) {
			if (!$oldpassword) {
				msg('请输入现有密码');
			}
			if (!$password) {
				msg('请输入新密码');
			}
			if (strlen($password) < 6) {
				msg('新密码最少6位，请修改');
			}
			if ($password != $cpassword) {
				msg('两次输入的密码不一致，请检查');
			}
			$r = $db->get_one("SELECT password,passsalt FROM {$AJ_PRE}member WHERE userid='$_userid'");
			if ($r['password'] != dpassword($oldpassword, $r['passsalt'])) {
				msg('现有密码错误，请检查');
			}
			if ($password == $oldpassword) {
				msg('新密码不能与现有密码相同');
			}
			$passsalt = random(8);
			$password = dpassword($password, $passsalt);
			$db->query("UPDATE {$AJ_PRE}member SET password='$password',passsalt='$passsalt' WHERE userid='$_userid'");
			userclean($_username);
			msg('管理员密码修改成功', '?action=main');
		} else {
			include tpl('password');
		}
		break;
	case 'cron':
		@header('Content-type:text/javascript');
		include AJ_ROOT.'/api/cron.inc.php';
		break;
	case 'left':
		$mymenu = cache_read('menu-'.$_userid.'.php');
		include tpl('left');
		break;
	case 'side':
		include tpl('side');
		break;
	case 'menu':
		$mymenu = cache_read('menu-'.$_userid.'.php');
		foreach ($mymenu as $m) {
			echo '<dd onclick="c(this);"><a href="'.(substr($m['url'], 0, 1) == '?' ? $m['url'] : AJ_PATH.'api/redirect.php?url='.$m['url'].'" target="_blank').'">'.set_style($m['title'], $m['style']).'</a></dd>';
		}
		break;
	case 'logout':
		if ($CFG['authadmin'] == 'cookie') {
			set_cookie($secretkey, '');
		} else {
			session_destroy();
		}
		$db->query("DELETE FROM {$db->pre}online WHERE userid=$_userid");
		set_cookie('auth', '');
		set_cookie('userid', '');
		msg('已经安全退出网站后台管理', '?');
		break;
	case 'login':
		$forward or $forward = '?action=dashboard';
		$logout = $MODULE[2]['linkurl'].'logout.php?forward='.urlencode(AJ_PATH);
		if ($_aijiacms_admin && $_userid && $_aijiacms_admin == $_userid) {
			dheader($forward);
		}
		if ($AJ['admin_area']) {
			$AA = explode('|', trim($AJ['admin_area']));
			$A = ip2area($AJ_IP);
			$pass = false;
			foreach ($AA as $v) {
				if (strpos($A, $v) !== false) {
					$pass = true;
					break;
				}
			}
			if (!$pass) {
				dalert('未被允许的地区', $logout);
			}
		}
		$LOCK = cache_read($AJ_IP.'.php', 'ban');
		if ($LOCK && $AJ_TIME - $LOCK['time'] < 3600 && $LOCK['times'] >= 1) {
			$AJ['captcha_admin'] = 1;
		}
		if ($AJ['close']) {
			$AJ['captcha_admin'] = 0;
		}
		$MOD = cache_read('module-2.php');
		$_forward = $forward ? urlencode($forward) : '';
		$could_sms = ($MOD['login_sms'] && $AJ['sms']) ? 1 : 0;
		$could_name = $could_sms && $AJ['sms_admin'] ? 0 : 1;
		if ($CFG['authadmin'] == 'cookie') {
			$session = new dsession();
		}
		switch ($job) {
			case 'sms':
				$could_sms or dheader('?action=login&forward='.$_forward);
				if ($submit) {
					(is_mobile($mobile) && preg_match('/^[0-9]{6}$/', $code) && isset($_SESSION['mobile_code']) && $_SESSION['mobile_code'] == md5($mobile.'|'.$code)) or msg('短信验证失败');
					$password = $code;
					$user = $db->get_one("SELECT username,groupid,passsalt FROM {$AJ_PRE}member WHERE mobile='$mobile' AND vmobile=1 ORDER BY userid");
					($user && $user['groupid'] == 1) or msg('管理账号不存在');
					include load('member.lang');
					require AJ_ROOT.'/include/module.func.php';
					require AJ_ROOT.'/module/member/member.class.php';
					$do = new member;
					$_SESSION['mobile_code'] = '';
					$username = $user['username'];
					$user = $do->login($username, $password, 0, 'sms');
					if ($user) {
						if ($user['groupid'] != 1 || $user['admin'] < 1) {
							dalert('您无权限访问后台', $logout);
						}
						if (!is_founder($user['userid'])) {
							if (($AJ['admin_week'] && !check_period(','.$AJ['admin_week'])) || ($AJ['admin_hour'] && !check_period($AJ['admin_hour']))) {
								dalert('未被允许的管理时间', $logout);
							}
						}
						if ($CFG['authadmin'] == 'cookie') {
							set_cookie($secretkey, $user['userid']);
						} else {
							$_SESSION[$secretkey] = $user['userid'];
						}
						require AJ_ROOT.'/admin/admin.class.php';
						$admin = new admin;
						$admin->cache_right($user['userid']);
						$admin->cache_menu($user['userid']);
						if ($AJ['login_log']) {
							$do->login_log($username, $password, $user['passsalt'], 1);
						}
						dheader($forward);
					} else {
						if ($AJ['login_log']) {
							$do->login_log($username, $password, $user['passsalt'], 1, $do->errmsg);
						}
						msg($do->errmsg, '?action=login&job=sms&forward='.$_forward);
					}
				} else {
					$verfiy = 0;
					if (isset($auth)) {
						$auth = decrypt($auth, AJ_KEY.'VSMS');
						if (is_mobile($auth)) {
							$verfiy = 1;
							$mobile = $auth;
						}
					}
				}
				break;
			case 'send':
				include load('member.lang');
				require AJ_ROOT.'/module/member/global.func.php';
				$could_sms or exit('close');
				is_mobile($mobile) or exit('format');
				$user = $db->get_one("SELECT groupid FROM {$AJ_PRE}member WHERE mobile='$mobile' AND vmobile=1 ORDER BY userid");
				($user && $user['groupid'] == 1) or exit('exist');
				isset($_SESSION['mobile_send']) or $_SESSION['mobile_send'] = 0;
				isset($_SESSION['mobile_time']) or $_SESSION['mobile_time'] = 0;
				if ($_SESSION['mobile_send'] > 9) {
					exit('max');
				}
				if ($_SESSION['mobile_time'] && (($AJ_TIME - $_SESSION['mobile_time']) < 60)) {
					exit('fast');
				}
				if (max_sms($mobile)) {
					exit('max');
				}
				
				
			
				
				//阿里云短信
				 if($AJ['sms_type']==2){
				 $mobilecode = random($AJ['sms_code_number'], '0-9');
				 $_SESSION['mobile_code'] = md5($mobile.'|'.$mobilecode);
				$_SESSION['mobile_time'] = $AJ_TIME;
				$_SESSION['mobile_send'] = $_SESSION['mobile_send'] + 1;
				 $data = array('code'=>$mobilecode);
                  ali_sms($mobile, $AJ['sms_code'], $data);
				 }else
				 {
				 $mobilecode = random(6, '0-9');
				 $_SESSION['mobile_code'] = md5($mobile.'|'.$mobilecode);
				$_SESSION['mobile_time'] = $AJ_TIME;
				$_SESSION['mobile_send'] = $_SESSION['mobile_send'] + 1;
				$content = lang('sms->sms_code', array($mobilecode, $MOD['auth_days']*10)).$AJ['sms_sign'];
				send_sms($mobile, $content);
				}
				exit('ok');
				break;
			default: if (!$could_name) {
				$job = 'sms';
				$submit = $verfiy = 0;
			}
			if ($submit) {
				$msg = captcha($captcha, $AJ['captcha_admin'], true);
				if ($msg) {
					msg('验证码填写错误');
				}
				if (strlen($username) < 3) {
					msg('请输入正确的用户名');
				}
				if (strlen($password) < 6 || strlen($password) > 32) {
					msg('请输入正确的密码');
				}
				if (is_email($username)) {
					$condition = "email='$username' AND vemail=1";
				} elseif (is_mobile($username)) {
					$condition = "mobile='$username' AND vmobile=1";
				} elseif (check_name($username)) {
					$condition = "username='$username'";
				} else {
					msg('账号格式错误');
				}
				$r = $db->get_one("SELECT username,passport,groupid,admin,password,passsalt,loginip,mobile,vmobile FROM {$AJ_PRE}member WHERE {$condition} ORDER BY userid");
				if ($r && $r['groupid'] == 1 && $r['admin'] > 0) {
					if ($MOD['verfiy_login'] && $could_sms && is_mobile($r['mobile']) && $r['vmobile'] && $r['loginip'] != AJ_IP) {
						if (ip2area($r['loginip']) != ip2area(AJ_IP)) {
							if ($r['password'] != dpassword($password, $r['passsalt'])) {
								message($L['member_login_password_bad']);
							}
							dheader('?action=login&job=sms&auth='.encrypt($r['mobile'], AJ_KEY.'VSMS').'&forward='.$_forward);
						}
					}
					$username = $r['username'];
				} else {
					msg('管理账号不存在');
				}
				include load('member.lang');
				require AJ_ROOT.'/include/module.func.php';
				require AJ_ROOT.'/module/member/member.class.php';
				$do = new member;
				$user = $do->login($username, $password);
				if ($user) {
					if ($user['groupid'] != 1 || $user['admin'] < 1) {
						dalert('您无权限访问后台', $logout);
					}
					if (!is_founder($user['userid'])) {
						if (($AJ['admin_week'] && !check_period(','.$AJ['admin_week'])) || ($AJ['admin_hour'] && !check_period($AJ['admin_hour']))) {
							dalert('未被允许的管理时间', $logout);
						}
					}
					if ($CFG['authadmin'] == 'cookie') {
						set_cookie($secretkey, $user['userid']);
					} else {
						$_SESSION[$secretkey] = $user['userid'];
					}
					require AJ_ROOT.'/admin/admin.class.php';
					$admin = new admin;
					$admin->cache_right($user['userid']);
					$admin->cache_menu($user['userid']);
					if ($AJ['login_log']) {
						$do->login_log($username, $password, $user['passsalt'], 1);
					}
					dheader($forward);
				} else {
					if ($AJ['login_log']) {
						$do->login_log($username, $password, $user['passsalt'], 1, $do->errmsg);
					}
					msg($do->errmsg, '?action=login&forward='.$_forward);
				}
			} else {
				if (strpos($AJ_URL, AJ_PATH) === false) {
					dheader(AJ_PATH.basename(get_env('self')));
				}
				$username = isset($username) ? $username : $_username;
			}
			break;
			}
		include tpl('login');
		break;
	case 'main':
		if ($submit) {
			$note = '<?php exit;?>'.dhtmlspecialchars(stripslashes($note));
			file_put(AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php', $note);
			dmsg('保存成功', '?action=main');
		} else {
			$user = $db->get_one("SELECT loginip,logintime,logintimes FROM {$AJ_PRE}member WHERE userid=$_userid");
			$note = AJ_ROOT.'/file/user/'.dalloc($_userid).'/'.$_userid.'/note.php';
			$note = file_get($note);
			if ($note) {
				$note = substr($note, 13);
			} else {
				$note = '';
			}
			$install = file_get(AJ_CACHE.'/install.lock');
			if (!$install) {
				$install = $AJ_TIME;
				file_put(AJ_CACHE.'/install.lock', $AJ_TIME);
			}
			$install = timetodate($install, 5);
			$edition = edition(1);
			
			$lists = array();
		$result = DB::query("SELECT * FROM {$AJ_PRE}announce ORDER BY itemid LIMIT 0,6");
		while($r = DB::fetch_array($result)) {
			$r['title'] = set_style($r['title'], $r['style']);
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
			$r['fromdate'] = $r['fromtime'] ? timetodate($r['fromtime'], 3) : $L['timeless'];
			$r['todate'] = $r['totime'] ? timetodate($r['totime'], 3) : $L['timeless'];
			
			$lists[] = $r;
		}
			
			$db->halt = 0;
		$today = strtotime(timetodate($AJ_TIME, 3).' 00:00:00');
		$htm = '';

		$num = $db->count($AJ_PRE.'finance_charge', "status=0");
		if($num) $htm .= '<li><a href="?moduleid=2&file=charge&status=0">待受理在线充值 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'finance_cash', "status=0");
		if($num) $htm .= '<li><a href="?moduleid=2&file=cash&status=0">待受理资金提现 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'keyword', "status=2");
		if($num) $htm .= '<li><a href="?file=keyword&status=2">待审核搜索关键词 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'guestbook', "edittime=0");
		if($num) $htm .= '<li><a href="?moduleid=3&file=guestbook">待回复网站留言 (<b>'.$num.'</b>)</a></li>';

		$num = $db->count($AJ_PRE.'member_check', "1");//待审核资料修改
		if($num) $htm .= '<li><a href="?moduleid=2&file=validate&action=member">待审核资料修改 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'ask', "status=0");
		if($num) $htm .= '<li><a href="?moduleid=2&file=ask&status=0">待受理客服中心 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'alert', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=alert&action=check">待审核房源提醒 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'gift_order', "status='处理中'");
		if($num) $htm .= '<li><a href="?moduleid=3&file=gift&action=order&fields=3&kw=%E5%A4%84%E7%90%86%E4%B8%AD">待处理礼品订单 (<b>'.$num.'</b>)</a></li>';

		$num = $db->count($AJ_PRE.'news', "status=2");//待审核公司新闻
		if($num) $htm .= '<li><a href="?moduleid=2&file=news&action=check">待审核公司新闻 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'honor', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=honor&action=check">待审核荣誉资质 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'page', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=page&action=check">待审核公司单页 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'link', "status=2 AND username<>''");
		if($num) $htm .= '<li><a href="?moduleid=2&file=link&action=check">待审核公司链接 (<b>'.$num.'</b>)</a></li>';

		$num = $db->count($AJ_PRE.'validate', "type='company' AND status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=validate&action=company&status=2">待审核公司认证 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'validate', "type='truename' AND status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=validate&action=truename&status=2">待核审实名认证 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'validate', "type='mobile' AND status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=validate&action=mobile&status=2">待审核手机认证 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'validate', "type='email' AND status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=validate&action=email&status=2">待审核邮件认证 (<b>'.$num.'</b>)</a></li>';

		$num = $db->count($AJ_PRE.'ad', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=3&file=ad&action=list&job=check">待审广告购买 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'spread', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=3&file=spread&action=check">待审核排名推广 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'comment', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=3&file=comment&action=check">待审核评论 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'link', "status=2 AND username=''");
		if($num) $htm .= '<li><a href="?moduleid=3&file=link&action=check">待审核友情链接 (<b>'.$num.'</b>)</a></li>';

		$num = $db->count($AJ_PRE.'upgrade', "status=2");
		if($num) $htm .= '<li><a href="?moduleid=2&file=grade&action=check">待审核会员升级 (<b>'.$num.'</b>)</a></li>';
		$num = $db->count($AJ_PRE.'member', "groupid=4");
		if($num) $htm .= '<li><a href="?moduleid=2&action=check">待审核会员注册 (<b>'.$num.'</b>)</a></li>';
		
		foreach($MODULE as $m) {
			if($m['moduleid'] < 5 || $m['islink']) continue;
			$mid = $m['moduleid'];
			$table = get_table($mid);
			$num = $db->count($table, "status=2");
			if($num) $htm .= '<li><a href="?moduleid='.$mid.'&action=check">待审核'.$m['name'].' (<b>'.$num.'</b>)</a></li>';

			if( $m['module'] == 'sale') {
				$num = $db->count($AJ_PRE.'order', "mid=$mid AND status=5");
				if($num) $htm .= '<li><a href="?moduleid='.$mid.'&file=order&status=5">待受理'.$m['name'].'订单 (<b>'.$num.'</b>)</a></li>';
			}
			if($m['module'] == 'group') {
				$num = $db->count($AJ_PRE.'group_order_'.$mid, "status=4");
				if($num) $htm .= '<li><a href="?moduleid='.$mid.'&file=order&status=4">待受理'.$m['name'].'订单 (<b>'.$num.'</b>)</a></li>';
			}
		
		}
		
	
$num = 20;

	(isset($todate) && is_time($todate)) or $todate = '';
	$totime = is_date($todate) ? datetotime($todate) : AJ_TIME;
	if($totime > AJ_TIME) $totime = AJ_TIME;
	$fromtime = timetodate($totime - 86400*30, 'Ymd');
	$totime = timetodate($totime, 'Ymd');
	$data = $pv = $pv_pc = $pv_mb = '';
	$result = $db->query("SELECT * FROM {$AJ_PRE}stats WHERE id>$fromtime AND id<=$totime ORDER BY id ASC LIMIT 30", 'CACHE');
	while($r = $db->fetch_array($result)) {
		$data .= "'".substr($r['id'], 4, 2).'-'.substr($r['id'], 6, 2)."',";
		$pv .= $r['pv'].',';
		$uv .= $r['uv'].',';
		$pv_pc .= $r['pv_pc'].',';
		$pv_mb .= $r['pv_mb'].',';
	}
	if($data) {
		$data = substr($data, 0, -1);
		$pv = substr($pv, 0, -1);
		$pv_pc = substr($pv_pc, 0, -1);
		$pv_mb = substr($pv_mb, 0, -1);
	}

		$subscribelist = $db->query("SELECT * FROM {$AJ_PRE}message   ORDER BY itemid DESC LIMIT 0,6");
		
			while($r = $db->fetch_array($subscribelist)) {
		
			
			$subscribes[] = $r;
		}
		
		include tpl('main');
			//include tpl('footer');
		}
	
		break;
	default:
	$mymenu = cache_read('menu-'.$_userid.'.php');

	include tpl('index');
		break;
}
