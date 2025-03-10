<?php
/*
	
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function daddslashes($string) {
	return is_array($string) ? array_map('daddslashes', $string) : addslashes($string);
}

function dstripslashes($string) {
	return is_array($string) ? array_map('dstripslashes', $string) : stripslashes($string);
}

function dtrim($string) {
	return str_replace(array(chr(10), chr(13), "\t", ' '), array('', '', '', ''), $string);
}

function dwrite($string) {
	return str_replace(array(chr(10), chr(13), "'"), array('', '', "\'"), $string);
}

function dheader($url) {
	global $AJ;	
	if(!defined('AJ_ADMIN') && $AJ['defend_reload']) sleep($AJ['defend_reload']);
	exit(header('location:'.$url));
}

function dmsg($dmsg = '', $dforward = '') {
	if(!$dmsg && !$dforward) {
		$dmsg = get_cookie('dmsg');
		if($dmsg) {
			echo '<script type="text/javascript">showmsg(\''.$dmsg.'\');</script>';
			set_cookie('dmsg', '');
		}
	} else {
		set_cookie('dmsg', $dmsg);
		$dforward = preg_replace("/(.*)([&?]rand=[0-9]*)(.*)/i", "\\1\\3", $dforward);
		$dforward = str_replace('.php&', '.php?', $dforward);
		$dforward = strpos($dforward, '?') === false ? $dforward.'?rand='.mt_rand(10, 99) : str_replace('?', '?rand='.mt_rand(10, 99).'&', $dforward);
		dheader($dforward);
	}
}

function dalert($dmessage = errmsg, $dforward = '', $extend = '') {
	global $AJ;
	exit(include template('alert', 'message'));
}

function dsubstr($string, $length, $suffix = '', $start = 0) {
	if($start) {
		$tmp = dsubstr($string, $start);
		$string = substr($string, strlen($tmp));
	}
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array('&quot;', '&lt;', '&gt;'), array('"', '<', '>'), $string);
	$length = $length - strlen($suffix);
	$str = '';
	if(AJ_CHARSET == 'UTF-8') {
		$n = $tn = $noc = 0;
		while($n < $strlen)	{
			$t = ord($string{$n});
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) break;
		}
		if($noc > $length) $n -= $tn;
		$str = substr($string, 0, $n);
	} else {
		for($i = 0; $i < $length; $i++) {
			$str .= ord($string{$i}) > 127 ? $string{$i}.$string{++$i} : $string{$i};
		}
	}
	$str = str_replace(array('"', '<', '>'), array('&quot;', '&lt;', '&gt;'), $str);
	return $str == $string ? $str : $str.$suffix;
}

function match_kw($key, $keyword) {
	$sign = substr($keyword, 0, 1);
	$kw = substr($keyword, 1);
	if($sign == '=') {
		return " AND ".$key."='".$kw."'";
	} else if($sign == '!') {
		return " AND ".$key."<>'".$kw."'";
	} else if($sign == '>') {
		if(is_numeric($kw)) return " AND ".$key.">'".$kw."'";
	} else if($sign == '<') {
		if(is_numeric($kw)) return " AND ".$key."<'".$kw."'";
	}
	return " AND ".$key." LIKE '%".$keyword."%'";
}

function cutstr($str, $mark1 = '', $mark2 = '') {
	if($mark1) {
		$p1 = strpos($str, $mark1);
		if($p1 !== false) $str = substr($str, $p1 + strlen($mark1));
	}
	if(!$mark2) return $str;
	$p2 = strpos($str, $mark2);
	if($p2 === false) return $str;
	return substr($str, 0, $p2);
}

function encrypt($txt, $key = '', $expiry = 0) {
	strlen($key) > 5 or $key = AJ_KEY;
	$str = $txt.substr($key, 0, 3);
	return str_replace(array('=', '+', '/', '0x', '0X'), array('-E-', '-P-', '-S-', '-Z-', '-X-'), mycrypt($str, $key, 'ENCODE', $expiry));
}

function decrypt($txt, $key = '') {
	strlen($key) > 5 or $key = AJ_KEY;
	$str = mycrypt(str_replace(array('-E-', '-P-', '-S-', '-Z-', '-X-'), array('=', '+', '/', '0x', '0X'), $txt), $key, 'DECODE');
	return substr($str, -3) == substr($key, 0, 3) ? substr($str, 0, -3) : '';
}

function mycrypt($string, $key, $operation = 'DECODE', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + AJ_TIME : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - AJ_TIME > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.base64_encode($result);
	}
}

function dround($var, $precision = 2, $sprinft = false) {
	$var = round(floatval($var), $precision);
	if($sprinft) $var = sprintf('%.'.$precision.'f', $var);
	return $var;
}

function dalloc($i, $n = 5000) {
	return ceil($i/$n);
}

function strip_nr($string, $js = false) {
	$string =  str_replace(array(chr(13), chr(10), "\n", "\r", "\t", '  '),array('', '', '', '', '', ''), $string);
	if($js) $string = str_replace("'", "\'", $string);
	return $string;
}

function template($template = 'index', $dir = '') {
	global $CFG, $AJ_PC;
	check_name($template) or exit('BAD TPL NAME');
	if($dir) check_name($dir) or exit('BAD TPL DIR');
	$tpl = $AJ_PC ? $CFG['template'] : $CFG['template_mobile'];
	$to = AJ_CACHE.'/tpl/'.$tpl.'/'.($dir ? $dir.'/' : '').$template.'.php';
	$isfileto = is_file($to);
	if($CFG['template_refresh'] || !$isfileto) {
		if($dir) $dir = $dir.'/';
        $from = AJ_ROOT.'/template/'.$tpl.'/'.$dir.$template.'.htm';
		if(!is_file($from)) $from = AJ_ROOT.'/template/'.($AJ_PC ? 'default' : 'mobile').'/'.$dir.$template.'.htm';
        if(!$isfileto || filemtime($from) > filemtime($to) || (filesize($to) == 0 && filesize($from) > 0)) {
			require_once AJ_ROOT.'/include/template.func.php';
			template_compile($from, $to);
		}
	}
	return $to;
}

function ob_template($template, $dir = '') {
	extract($GLOBALS, EXTR_SKIP);
	ob_start();
	include template($template, $dir);
	$contents = ob_get_contents();
	ob_clean();
	return $contents;
}

function message($dmessage = errmsg, $dforward = 'goback', $dtime = 1) {
	if(!$dmessage && $dforward && $dforward != 'goback') dheader($dforward);
	global $AJ, $AJ_PC;
	exit(include template('message', 'message'));
}

function login() {
	global $_userid, $MODULE, $AJ_URL, $AJ_PC, $AJ;
	$_userid or dheader(($AJ_PC ? $MODULE[2]['linkurl'] : $MODULE[2]['mobile']).$AJ['file_login'].'?forward='.rawurlencode($AJ_URL));
}

function random($length, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz') {
	if($chars == '0-9') {
		$chars = '0123456789';
	} else if($chars == 'a-z') {
		$chars = 'abcdefghijklmnopqrstuvwxyz';
	} else if($chars == 'A-Z') {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	} else if($chars == 'a-Z') {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	}
	$str = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++)	{
		$str .= $chars[mt_rand(0, $max)];
	}
	return $str;
}

function set_cookie($var, $value = '', $time = 0) {
	global $CFG;
	$time = $time > 0 ? $time : (empty($value) ? AJ_TIME - 3600 : 0);
	$port = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
	$var = $CFG['cookie_pre'].$var;
	return setcookie($var, $value, $time, $CFG['cookie_path'], $CFG['cookie_domain'], $port);
}

function get_cookie($var) {
	global $CFG;
	$var = $CFG['cookie_pre'].$var;
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : '';
}

function get_table($moduleid, $data = 0) {
	global $MODULE;
	$module = $MODULE[$moduleid]['module'];
	$M = array('company', 'member');
	if($data) {
		 if($moduleid==18){return  AJ_PRE.'newhouse_data_6';}else
		 {return in_array($module, $M) ? AJ_PRE.$module.'_data' : AJ_PRE.$module.'_data_'.$moduleid;}
	} else {
		 if($moduleid==18){return  AJ_PRE.'newhouse_6';}else
		 {return in_array($module, $M) ? AJ_PRE.$module : AJ_PRE.$module.'_'.$moduleid;}
	}
}

function get_process($fromtime, $totime) {
	if($fromtime && AJ_TIME < $fromtime) return 1;
	if($totime && AJ_TIME > $totime) return 3;
	return 2;
}

function send_message($touser, $title, $content, $typeid = 4, $fromuser = '') {
	if($touser == $fromuser) return false;
	if(check_name($touser) && $title && $content) {
		$title = addslashes($title);
		$content = addslashes($content);
		$r = DB::get_one("SELECT black FROM ".AJ_PRE."member_misc WHERE username='$touser'");
		if($r) {
			
			
			
			if($r['black'] && $typeid != 4) {
				$blacks = explode(' ', $r['black']);
				$_from = $fromuser ? $fromuser : 'Guest';
				if(in_array($_from, $blacks)) return false;
			}
			DB::query("INSERT INTO ".AJ_PRE."message (title,typeid,touser,fromuser,content,addtime,ip,status) VALUES ('$title', $typeid, '$touser','$fromuser','$content','".AJ_TIME."','".AJ_IP."',3)");			
			DB::query("UPDATE ".AJ_PRE."member SET message=message+1 WHERE username='$touser'");
			if($fromuser) {
				DB::query("INSERT INTO ".AJ_PRE."message (title,typeid,content,fromuser,touser,addtime,ip,status) VALUES ('$title','$typeid','$content','$fromuser','$touser','".AJ_TIME."','".AJ_IP."','2')");
			}
			return true;
		}
	}
	return false;
}

function send_mail($mail_to, $mail_subject, $mail_body, $mail_from = '', $mail_sign = true) {
	global $AJ;
	if(substr($mail_to, -4) == '.sns') return false;
	require_once AJ_ROOT.'/include/mail.func.php';
	$result = dmail(trim($mail_to), $mail_subject, $mail_body, $mail_from, $mail_sign);
	$success = $result == 'SUCCESS' ? 1 : 0;
	if($AJ['mail_log']) {
		$status = $success ? 3 : 2;
		$note = $success ? '' : addslashes($result);
		$mail_subject = stripslashes($mail_subject);
		$mail_body = stripslashes($mail_body);
		$mail_subject = addslashes($mail_subject);
		$mail_body = addslashes($mail_body);
		DB::query("INSERT INTO ".AJ_PRE."mail_log (email,title,content,addtime,status,note) VALUES ('$mail_to','$mail_subject','$mail_body','".AJ_TIME."','$status','$note')");
	}
	return $success;
}

function strip_sms($message) {
	global $AJ;
	$message = strip_tags($message);
	$message = trim($message);
	$message = preg_replace("/&([a-z]{1,});/", '', $message);
	if($AJ['sms_sign']) $message .= $AJ['sms_sign'];
	return $message;
}

function send_sms($mobile, $message, $word = 0, $time = 0) {
         global $db, $AJ, $AJ_TIME, $AJ_IP, $_username;
		 $id = urlencode($AJ['sms_uid']);
			$pwd = urlencode($AJ['sms_key']);
		  if($AJ['sms_type']==1){
		  
		  	$statusStr = array(
		"0" => "短信发送成功",
		"-1" => "参数不全",
		"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
		"30" => "密码错误",
		"40" => "账号不存在",
		"41" => "余额不足",
		"42" => "帐户已过期",
		"43" => "IP地址限制",
		"50" => "内容含有敏感词"
	);
		  
		  if(!$AJ['sms'] || !is_mobile($mobile) || strlen($message) < 5) return false;
	$word or $word = word_count($message);
	$sms_message = $message;
	$data = 'u='.$id.'&p='.md5($pwd).'&m='.$mobile.'&c='.rawurlencode($sms_message);
	$code = dcurl('http://api.smsbao.com/sms', $data);
    if($code == 0) {
		$code = $statusStr[$code];
	} else {
		$code = 'Can Not Connect SMS Server';
	}
		  
		  }
		  else
		  { 
         if(!$AJ['sms'] || !$AJ['sms_uid'] || !$AJ['sms_key']) return false;
			 $url="http://service.winic.org/sys_port/gateway/?";
	      $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
			$to = urlencode($mobile);
			 $word or $word = word_count($message);
			$content=$message;
			 $content = urlencode(iconv("UTF-8","GB2312",$content)); 
      $rdata = sprintf($data, $id, $pwd, $to, $content); 
      $ch = curl_init();
	  curl_setopt($ch, CURLOPT_POST,1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
	  curl_setopt($ch, CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	  //打印一下参数 可以看到 在GB2312编码模式的浏览器下 显示字符是正常的
      $result = curl_exec($ch);
      curl_close($ch);
		$code='';	
if(!$result==$AJ['sms_ok']){
    $code = 'Can Not Connect SMS Server';
}
else{
    $code =$AJ['sms_ok'];
}
}
DB::query("INSERT INTO ".AJ_PRE."sms (mobile,message,word,editor,sendtime,ip,code) VALUES ('$mobile','$message','$word','$_username','".AJ_TIME."','".AJ_IP."','$code')");

    return $code;   

}

function send_weixin($touser, $word) {
	if(check_name($touser) && strlen($word) > 1) {
		$user = DB::get_one("SELECT openid,push,visittime FROM ".AJ_PRE."weixin_user WHERE username='$touser'");
		if($user && $user['openid'] && $user['push'] && AJ_TIME - $user['visittime'] < 172800) {
			$openid = $user['openid'];
			$type = 'text';
			require_once AJ_ROOT.'/api/weixin/init.inc.php';
			if(!is_object($wx)) {
				$wx = new weixin;
				$wx->access_token = $wx->get_token();
			}
			$arr = $wx->send($openid, $type, $word);
			if($arr['errcode'] != 0) return false;
			$post = array();
			$post['content'] = $word;
			$post['type'] = 'push';
			$post['openid'] = $openid;
			$post['editor'] = 'system';
			$post['addtime'] = AJ_TIME;
			$post['misc'] = '';
			$post = daddslashes($post);
			$sql = '';
			foreach($post as $k=>$v) {
				$sql .= ",$k='$v'";
			}
			DB::query("INSERT INTO ".AJ_PRE."weixin_chat SET ".substr($sql, 1));
			return true;
		}
	}
	return false;
}

function word_count($string) {
	if(function_exists('mb_strlen')) return mb_strlen($string, AJ_CHARSET);
	$string = convert($string, AJ_CHARSET, 'gbk');
	$length = strlen($string);
	$count = 0;
	for($i = 0; $i < $length; $i++) {
		$t = ord($string[$i]);
		if($t > 127) $i++;
		$count++;
	}
	return $count;
}

function cache_read($file, $dir = '', $mode = '') {
	$file = $dir ? AJ_CACHE.'/'.$dir.'/'.$file : AJ_CACHE.'/'.$file;
	if(!is_file($file)) return $mode ? '' : array();
	return $mode ? file_get($file) : include $file;
}

function cache_write($file, $string, $dir = '') {
	if(is_array($string)) $string = "<?php defined('IN_AIJIACMS') or exit('Access Denied'); return ".strip_nr(var_export($string, true))."; ?>";
	$file = $dir ? AJ_CACHE.'/'.$dir.'/'.$file : AJ_CACHE.'/'.$file;
	$strlen = file_put($file, $string);
	return $strlen;
}

function cache_delete($file, $dir = '') {
	$file = $dir ? AJ_CACHE.'/'.$dir.'/'.$file : AJ_CACHE.'/'.$file;
	return file_del($file);
}

function cache_clear($str, $type = '', $dir = '') {
	$dir = $dir ? AJ_CACHE.'/'.$dir.'/' : AJ_CACHE.'/';
	$files = glob($dir.'*');
	if(is_array($files)) {
		if($type == 'dir') {
			foreach($files as $file) {
				if(is_dir($file)) {dir_delete($file);} else {if(file_ext($file) == $str) file_del($file);}
			}
		} else {
			foreach($files as $file) {
				if(!is_dir($file) && strpos(basename($file), $str) !== false) file_del($file);
			}
		}
	}
}

function content_table($moduleid, $itemid, $split, $table_data = '') {
	if($split) {
		return split_table($moduleid, $itemid);
	} else {
		$table_data or $table_data = get_table($moduleid, 1);
		return $table_data;
	}
}

function split_table($moduleid, $itemid) {
	$part = split_id($itemid);
	return AJ_PRE.$moduleid.'_'.$part;
}

function split_id($id) {
	return $id > 0 ? ceil($id/100000) : 1;
}

function ip2area($ip) {
	$area = '';
	if(is_ip($ip)) {
		$tmp = explode('.', $ip);
		if($tmp[0] == 10 || $tmp[0] == 127 || ($tmp[0] == 192 && $tmp[1] == 168) || ($tmp[0] == 172 && ($tmp[1] >= 16 && $tmp[1] <= 31))) {
			$area = 'LAN';
		} elseif($tmp[0] > 255 || $tmp[1] > 255 || $tmp[2] > 255 || $tmp[3] > 255) {
			$area = 'Unknown';
		} else {
			require_once AJ_ROOT.'/include/ip.class.php';
			$do = new ip($ip);
			$area = $do->area();
		}
	}
	return $area ? $area : 'Unknown';
}

function banip() {
	$IP = cache_read('banip.php');
	if($IP) {
		$ban = false;
		foreach($IP as $v) {
			if($v['totime'] && $v['totime'] < AJ_TIME) continue;
			if($v['ip'] == AJ_IP) { $ban = true; break; }
			if(stripos($_SERVER['HTTP_USER_AGENT'], $v['ip']) !== false) { $ban = true; break; }
			if(preg_match("/^".str_replace('*', '[0-9]{1,3}', $v['ip'])."$/", AJ_IP)) { $ban = true; break; }
		}
		if($ban) message(lang('include->msg_ip_ban'));
	}
}

function banword($WORD, $string, $extend = true, $goback = '') {
	$string = stripslashes($string);
	foreach($WORD as $v) {
		$v[0] = preg_quote($v[0]);
		$v[0] = str_replace('/', '\/', $v[0]);
		$v[0] = str_replace("\*", ".*", $v[0]);
		if($v[2] && $extend) {
			if(preg_match("/".$v[0]."/i", $string)) dalert(lang('include->msg_word_ban').($v[2] == 2 ? ':'.$v[0] : ''), $goback);
		} else {
			if($string == '') break;
			if(preg_match("/".$v[0]."/i", $string)) $string = preg_replace("/".$v[0]."/i", $v[1], $string);
		}
	}
	return addslashes($string);
}

function get_env($type, $par = '') {
	switch($type) {
		case 'ip':
			if(AJ_CDN) {
				if(isset($_SERVER['X-REAL-IP']) && is_ip($_SERVER['X-REAL-IP'])) return $_SERVER['X-REAL-IP'];
				if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && is_ip($_SERVER['HTTP_CF_CONNECTING_IP'])) return $_SERVER['HTTP_CF_CONNECTING_IP'];
			}
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				if(is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
				$ip = trim(end(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));
				if(is_ip($ip)) return $ip;
			}
			if(isset($_SERVER['REMOTE_ADDR']) && is_ip($_SERVER['REMOTE_ADDR'])) return $_SERVER['REMOTE_ADDR'];
			if(isset($_SERVER['HTTP_CLIENT_IP']) && is_ip($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
			return '0.0.0.0';
		break;
		case 'self':
			return isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
		break;
		case 'referer':
			return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		break;
		case 'domain':
			return $_SERVER['SERVER_NAME'];
		break;
		case 'scheme':			
			if(isset($_SERVER['HTTP_X_CLIENT_SCHEME']) && in_array($_SERVER['HTTP_X_CLIENT_SCHEME'], array('http', 'https'))) return $_SERVER['HTTP_X_CLIENT_SCHEME'].'://';
			return $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		break;
		case 'port':
			return ($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] == '443') ? '' : ':'.$_SERVER['SERVER_PORT'];
		break;
		case 'host':
			return preg_match("/^[a-z0-9_\-\.]{4,}$/i", $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
		break;
		case 'url':
			if(isset($_SERVER['HTTP_X_REWRITE_URL']) && $_SERVER['HTTP_X_REWRITE_URL']) {
				$uri = $_SERVER['HTTP_X_REWRITE_URL'];
			} else if(isset($_SERVER['HTTP_X_ORIGINAL_URL']) && $_SERVER['HTTP_X_ORIGINAL_URL']) {
				$uri = $_SERVER['HTTP_X_ORIGINAL_URL'];
			} else if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
				$uri = $_SERVER['REQUEST_URI'];
			} else {
				$uri = $_SERVER['PHP_SELF'];
				if(isset($_SERVER['argv'])) {
					if(isset($_SERVER['argv'][0])) $uri .= '?'.$_SERVER['argv'][0];
				} else {
					$uri .= '?'.$_SERVER['QUERY_STRING'];
				}
			}
			$uri = dhtmlspecialchars($uri);
			if(strpos($uri, '.php?') !== false && strpos($uri, '.html') !== false && strpos($uri, '=') === false) $uri = str_replace('.php?', '-htm-', $uri);
			return get_env('scheme').$_SERVER['HTTP_HOST'].(strpos($_SERVER['HTTP_HOST'], ':') === false ? get_env('port') : '').$uri;
		break;
		case 'mobile':
			$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
			$ck = get_cookie('mobile');
			$os = $browser = '';
			if(strpos($ua, 'android') !== false) {
				$os = 'android';
				if($ck == 'app') {
					$browser = 'app';
				} else if($ck == 'b2b') {
					$browser = 'b2b';
				} else {
					if(strpos($ua, 'micromessenger/') !== false) {
						$browser = 'weixin';
					} else if(strpos($ua, 'tim/') !== false) {
						$browser = 'tim';
					} else if(strpos($ua, 'qq/') !== false) {
						$browser = 'qq';
					}
				}
			} else if(strpos($ua, 'iphone') !== false || strpos($ua, 'ipod') !== false) {
				$os = 'ios';
				if($ck == 'app') {
					$browser = 'app';
				} else if($ck == 'b2b') {
					$browser = 'b2b';
				} else if($ck == 'screen') {
					$browser = 'screen';
				} else {
					if(strpos($ua, 'micromessenger/') !== false) {
						$browser = 'weixin';
					} else if(strpos($ua, 'tim/') !== false) {
						$browser = 'tim';
					} else if(strpos($ua, 'qq/') !== false) {
						$browser = 'qq';
					} else if(strpos($ua, 'safari') !== false) {
						$browser = 'safari';
					}
				}
			} else if(strpos($ua, 'adr') !== false && strpos($ua, 'ucbrowser') !== false) {
				$os = 'android';
				$browser = 'uc';
			}
			return array('os' => $os, 'browser' => $browser);
		break;
	}
}

function convert($str, $from = 'utf-8', $to = 'gb2312') {
	if(!$str) return '';
	$from = strtolower($from);
	$to = strtolower($to);
	if($from == $to) return $str;
	$from = str_replace('gbk', 'gb2312', $from);
	$to = str_replace('gbk', 'gb2312', $to);
	$from = str_replace('utf8', 'utf-8', $from);
	$to = str_replace('utf8', 'utf-8', $to);
	if($from == $to) return $str;
	$tmp = array();
	if(function_exists('mb_convert_encoding')) {
		if(is_array($str)) {
			foreach($str as $key => $val) {
				$tmp[$key] = mb_convert_encoding($val, $to, $from);
			}
			return $tmp;
		} else {
			return mb_convert_encoding($str, $to, $from);
		}
	} else if(function_exists('iconv')) {
		if(is_array($str)) {
			foreach($str as $key => $val) {
				$tmp[$key] = iconv($from, $to."//IGNORE", $val);
			}
			return $tmp;
		} else {
			return iconv($from, $to."//IGNORE", $str);
		}
	} else {
		require_once AJ_ROOT.'/include/convert.func.php';
		return dconvert($str, $from, $to);
	}
}

function get_type($item, $cache = 0) {
	$types = array();
	if($cache) {
		$types = cache_read('type-'.$item.'.php');
	} else {
		$result = DB::query("SELECT * FROM ".AJ_PRE."type WHERE item='$item' ORDER BY listorder ASC,typeid DESC ");
		while($r = DB::fetch_array($result)) {
			$types[$r['typeid']] = $r;
		}
	}
	return $types;
}

function get_cat($catid) {
	if(!is_numeric($catid)) return array();
	$catid = intval($catid);
	return $catid ? DB::get_one("SELECT * FROM ".AJ_PRE."category WHERE catid=$catid") : array();
}

function cat_pos($CAT, $str = ' &raquo; ', $target = '', $deep = 0, $start = 0) {
	global $MODULE;
	if(!$CAT) return '';
	$arrparentids = $CAT['arrparentid'].','.$CAT['catid'];
	$arrparentid = explode(',', $arrparentids);
	$pos = '';
	$target = $target ? ' target="_blank"' : '';	
	$CATEGORY = array();
	$result = DB::query("SELECT catid,moduleid,catname,linkurl FROM ".AJ_PRE."category WHERE catid IN ($arrparentids)", 'CACHE');
	while($r = DB::fetch_array($result)) {
		$CATEGORY[$r['catid']] = $r;
	}
	if($deep) $i = 1;
	$j = 0;
	foreach($arrparentid as $catid) {
		if(!$catid || !isset($CATEGORY[$catid])) continue;
		if($j++ < $start) continue;
		if($deep) {
			if($i > $deep) continue;
			$i++;
		}
		$pos .= '<a href="'.$MODULE[$CATEGORY[$catid]['moduleid']]['linkurl'].$CATEGORY[$catid]['linkurl'].'"'.$target.'>'.$CATEGORY[$catid]['catname'].'</a>'.$str;
	}
	$_len = strlen($str);
	if($str && substr($pos, -$_len, $_len) === $str) $pos = substr($pos, 0, strlen($pos) - $_len);
	return $pos;
}

function cat_url($catid, $pc = 1) {
	global $MODULE;
	$catid = intval($catid);
	$r = DB::get_one("SELECT moduleid,linkurl FROM ".AJ_PRE."category WHERE catid=$catid");
	return $r ? ($pc ? $MODULE[$r['moduleid']]['linkurl'] : $MODULE[$r['moduleid']]['mobile']).$r['linkurl'] : '';
}

function get_area($areaid) {
	if(!is_numeric($areaid)) return array();
	$areaid = intval($areaid);
	return $areaid ? DB::get_one("SELECT * FROM ".AJ_PRE."area WHERE areaid=$areaid") : array();
}

function area_pos($areaid, $str = ' &raquo; ', $deep = 0, $start = 0) {
	$areaid = intval($areaid);
	if($areaid) {
		global $AREA;
	} else {
		global $L;
		return $L['allcity'];
	}
	$AREA or $AREA = cache_read('area.php');
	$arrparentid = $AREA[$areaid]['arrparentid'] ? explode(',', $AREA[$areaid]['arrparentid']) : array();
	$arrparentid[] = $areaid;
	$pos = '';
	if($deep) $i = 1;
	$j = 0;
	foreach($arrparentid as $areaid) {
		if(!$areaid || !isset($AREA[$areaid])) continue;
		if($j++ < $start) continue;
		if($deep) {
			if($i > $deep) continue;
			$i++;
		}
		$pos .= $AREA[$areaid]['areaname'].$str;
	}
	$_len = strlen($str);
	if($str && substr($pos, -$_len, $_len) === $str) $pos = substr($pos, 0, strlen($pos)-$_len);
	return $pos;
}

function get_maincat($catid, $moduleid, $level = -1) {
	$catid = intval($catid);
	$condition = $catid ? "parentid=$catid" : "moduleid=$moduleid AND parentid=0";
	if($level >= 0) $condition .= " AND level=$level";
	$cat = array();
	$result = DB::query("SELECT catid,catname,child,style,linkurl,item FROM ".AJ_PRE."category WHERE $condition ORDER BY listorder,catid ASC", 'CACHE');
	while($r = DB::fetch_array($result)) {
		$cat[] = $r;
	}
	return $cat;
}

function get_mainarea($areaid) {
	$areaid = intval($areaid);
	$are = array();
	$result = DB::query("SELECT areaid,areaname,map FROM ".AJ_PRE."area WHERE parentid=$areaid ORDER BY listorder,areaid ASC", 'CACHE');
	while($r = DB::fetch_array($result)) {
		$are[] = $r;
	}
	return $are;
}

function get_user($value, $key = 'username', $from = 'userid') {
	$r = DB::get_one("SELECT `$from` FROM ".AJ_PRE."member WHERE `$key`='$value'");
	return $r[$from];
}

function check_group($groupid, $groupids) {
	if(!$groupids || $groupid == 1) return true;
	if($groupid == 4) $groupid = 3;
	return in_array($groupid, explode(',', $groupids));
}

function tohtml($htmlfile, $module = '', $parameter = '') {
	defined('TOHTML') or define('TOHTML', true);
    extract($GLOBALS, EXTR_SKIP);
	if($parameter) parse_str($parameter);
    include $module ? AJ_ROOT.'/module/'.$module.'/'.$htmlfile.'.htm.php' : AJ_ROOT.'/include/'.$htmlfile.'.htm.php';
}

function set_style($string, $style = '', $tag = 'span') {
	if(preg_match("/^#[0-9a-zA-Z]{6}$/", $style)) $style = 'color:'.$style;
	return $style ? '<'.$tag.' style="'.$style.'">'.$string.'</'.$tag.'>' : $string;
}

function crypt_action($action) {
	return md5(md5($action.AJ_KEY.AJ_IP));
}

function captcha($captcha, $enable = 1, $return = false) {
	global $AJ, $session;
	if($enable) {
		if($AJ['captcha_cn']) {
			if(strlen($captcha) < 4) {
				$msg = lang('include->captcha_missed');
				return $return ? $msg : message($msg);
			}
		} else {
			if(!preg_match("/^[0-9a-z]{4,}$/i", $captcha)) {
				$msg = lang('include->captcha_missed');
				return $return ? $msg : message($msg);
			}
		}
		if(!is_object($session)) $session = new dsession();
		if(!isset($_SESSION['captchastr'])) {
			$msg = lang('include->captcha_expired');
			return $return ? $msg : message($msg);
		}
		if(decrypt($_SESSION['captchastr'], AJ_KEY.'CPC') != strtoupper($captcha)) {
			$msg = lang('include->captcha_error');
			return $return ? $msg : message($msg);
		}
		unset($_SESSION['captchastr']);
	} else {
		return '';
	}
}

function question($answer, $enable = 1, $return = false) {
	global $session;
	if($enable) {
		if(!$answer) {
			$msg = lang('include->answer_missed');
			return $return ? $msg : message($msg);
		}
		$answer = stripslashes($answer);
		if(!is_object($session)) $session = new dsession();
		if(!isset($_SESSION['answerstr'])) {
			$msg = lang('include->question_expired');
			return $return ? $msg : message($msg);
		}
		if(decrypt($_SESSION['answerstr'], AJ_KEY.'ANS') != $answer) {
			$msg = lang('include->answer_error');
			return $return ? $msg : message($msg);
		}
		unset($_SESSION['answerstr']);
	} else {
		return '';
	}
}

function pages($total, $page = 1, $perpage = 20, $demo = '', $step = 3) {
	global $AJ_URL, $AJ, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	if($demo) {
		$demo_url = str_replace('%7Baijiacms_page%7D', '{aijiacms_page}', $demo);
		$home_url = str_replace('{aijiacms_page}', '1', $demo_url);
	} else {
		if(defined('AJ_REWRITE') && $AJ['rewrite'] && $_SERVER["SCRIPT_NAME"] && strpos($AJ_URL, '?') === false) {
			$demo_url = $_SERVER["SCRIPT_NAME"];
			$demo_url = str_replace('//', '/', $demo_url);//Fix Nginx
			$mark = false;
			if(substr($demo_url, -4) == '.php') {
				if(strpos($_SERVER['QUERY_STRING'], '.html') === false) {
					$qstr = '';
					if($_SERVER['QUERY_STRING']) {					
						if(substr($_SERVER['QUERY_STRING'], -5) == '.html') {
							$qstr = '-'.substr($_SERVER['QUERY_STRING'], 0, -5);
						} else {
							parse_str($_SERVER['QUERY_STRING'], $qs);
							foreach($qs as $k=>$v) {
								$qstr .= '-'.$k.'-'.rawurlencode($v);
							}
						}
					}
					$demo_url = substr($demo_url, 0, -4).'-htm-page-{aijiacms_page}'.$qstr.'.html';
				} else {
					$demo_url = substr($demo_url, 0, -4).'-htm-'.$_SERVER['QUERY_STRING'];
					$mark = true;
				}
			} else {
				$mark = true;
			}
			if($mark) {
				if(strpos($demo_url, '%') === false) $demo_url =  rawurlencode($demo_url);
				$demo_url = str_replace(array('%2F', '%3A'), array('/', ':'), $demo_url);
				if(strpos($demo_url, '-page-') !== false) {
					$demo_url = preg_replace("/page-([0-9]+)/", 'page-{aijiacms_page}', $demo_url);
				} else {
					$demo_url = str_replace('.html', '-page-{aijiacms_page}.html', $demo_url);
				}
			}
			$home_url = str_replace('-page-{aijiacms_page}', '-page-1', $demo_url);
		} else {
			$AJ_URL = str_replace('&amp;', '&', $AJ_URL);
			$demo_url = $home_url = preg_replace("/(.*)([&?]page=[0-9]*)(.*)/i", "\\1\\3", $AJ_URL);
			$s = strpos($demo_url, '?') === false ? '?' : '&';
			$demo_url = $demo_url.$s.'page={aijia'.'cms_page}';
			if(defined('AJ_ADMIN') && strpos($demo_url, 'sum=') === false) $demo_url = str_replace('page=', 'sum='.$items.'&page=', $demo_url);
		}
	}
	$pages = '';
	include AJ_ROOT.'/api/pages.'.((!$AJ['pages_mode'] && $page < 100) ? 'default' : 'sample').'.php';
	return $pages;
}

function listpages($CAT, $total, $page = 1, $perpage = 20, $step = 2) {
	global $AJ, $MOD, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	$home_url = $MOD['linkurl'].$CAT['linkurl'];
	$demo_url = $MOD['linkurl'].listurl($CAT, '{aijiacms_page}');
	$pages = '';
	include AJ_ROOT.'/api/pages.'.((!$AJ['pages_mode'] && $page < 100) ? 'default' : 'sample').'.php';
	return $pages;
}

function linkurl($linkurl) {
	return strpos($linkurl, '://') === false ? AJ_PATH.$linkurl : $linkurl;
}

function imgurl($url = '', $width = '') {
	if($url) {
		return strpos($url, '://') === false ? AJ_PATH.'file/upload/'.$url : $url;
	} else {
		return AJ_SKIN.'image/nopic'.$width.'.gif';
	}
}

function userurl($username, $qstring = '', $domain = '') {
	global $CFG, $AJ, $MODULE;
	$URL = '';
	$subdomain = 0;
	if($CFG['com_domain']) $subdomain = substr($CFG['com_domain'], 0, 1) == '.' ? 1 : 2;
	if($username) {
		if($subdomain || $domain) {
			$scheme = $AJ['com_https'] ? 'https://' : 'http://';
			$URL = $domain ? $scheme.$domain.'/' : ($subdomain == 1 ? $scheme.($AJ['com_www'] ? 'www.' : '').$username.$CFG['com_domain'].'/' : $scheme.$CFG['com_domain'].'/'.$username.'/');
			if($qstring) {
				parse_str($qstring, $q);
				if(isset($q['file'])) {
					$URL .= $CFG['com_dir'] ? $q['file'].'/' : 'company/'.$q['file'].'/';
					unset($q['file']);
				}
				if($q) {
					if($AJ['rewrite']) {
						foreach($q as $k=>$v) {
							$v = rawurlencode($v);
							$URL .= $k.'-'.$v.'-';
						}
						$URL = substr($URL, 0, -1).'.shtml';
					} else {
						$URL .= 'index.php?';
						$i = 0;
						foreach($q as $k=>$v) {
							$v = rawurlencode($v);
							$URL .= ($i++ == 0 ? '' : '&').$k.'='.$v;
						}
					}
				}
			}
		} else if($AJ['rewrite']) {
			$URL = AJ_PATH.'com/'.$username.'/';
			if($qstring) {
				parse_str($qstring, $q);
				if(isset($q['file'])) {
					$URL .= $CFG['com_dir'] ? $q['file'].'/' : 'company/'.$q['file'].'/';
					unset($q['file']);
				}
				if($q) {
					foreach($q as $k=>$v) {
						$v = rawurlencode($v);
						$URL .= $k.'-'.$v.'-';
					}
					$URL = substr($URL, 0, -1).'.html';
				}
			}
		} else {
			$URL = AJ_PATH.'index.php?homepage='.$username;
			if($qstring) $URL = $URL.'&'.$qstring;
		}
	} else {
		$URL = $MODULE[4]['linkurl'].'guest.php';
	}
	return $URL;
}

function useravatar($var, $size = '', $isusername = 1, $real = 0) {
	in_array($size, array('large', 'small')) or $size = 'middle';
	if($real) {
		$ext = 'x48.jpg';
		if($size == 'large') $ext = '.jpg';
		if($size == 'small') $ext = 'x20.jpg';
		$file = AJ_ROOT.'/api/avatar/default'.$ext;
		$md5 = md5($var);
		if($isusername) {
			$img = AJ_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/_'.$var.$ext;
			if(is_file($img) && check_name($var)) $file = $img;
		} else {
			$img = AJ_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/'.$var.$ext;
			if(is_file($img)) $file = $img;
		}
		if($real == 1) {
			$url = str_replace(AJ_ROOT.'/', AJ_PATH, $file);
			if(strpos($url, '/default') === false) {
				$remote = file_get(AJ_ROOT.'/file/avatar/remote.html');
				if(strlen($remote) > 10) $url = str_replace(AJ_ROOT.'/file/', $remote, $file);
			}
			return $url;
		}
		return strpos($file, '/api/') === false ? $file : '';
	} else {
		$name = $isusername ? 'username' : 'userid';
		return AJ_PATH.'api/avatar/show.php?'.$name.'='.$var.'&size='.$size;
	}
}

function userinfo($username, $cache = 1) {
	global $dc, $CFG;
	if(!check_name($username)) return array();
	$user = array();
	if($cache && $CFG['db_expires']) {
		$user = $dc->get('user-'.$username);
		if($user) return $user;
	}
	$r1 = DB::get_one("SELECT * FROM ".AJ_PRE."member WHERE username='$username'");
	if($r1) {
		$r2 = DB::get_one("SELECT * FROM ".AJ_PRE."member_misc WHERE username='$username'");
		$r3 = DB::get_one("SELECT * FROM ".AJ_PRE."company WHERE username='$username'");
		$user = array_merge($r1, $r2, $r3);
	}
	if($cache && $CFG['db_expires'] && $user) $dc->set('user-'.$username, $user, $CFG['db_expires']);
	return $user;
}

function userclean($username) {
	global $dc, $CFG;
	$user = array();
	if($CFG['db_expires']) $dc->rm('user-'.$username);
}

function listurl($CAT, $page = 0) {
	global $AJ, $MOD, $L;
	include AJ_ROOT.'/api/url.inc.php';
	$catid = $CAT['catid'];
	$file_ext = $AJ['file_ext'];
	$index = $AJ['index'];
	$catdir = $CAT['catdir'];
	$catname = file_vname($CAT['catname']);
	$prefix = $MOD['htm_list_prefix'];
	$urlid = $MOD['list_html'] ? $MOD['htm_list_urlid'] : $MOD['php_list_urlid'];
	$ext = $MOD['list_html'] ? 'htm' : 'php';
	isset($urls[$ext]['list'][$urlid]) or $urlid = 0;
	$url = $urls[$ext]['list'][$urlid];
	$url = $page ? $url['page'] : $url['index'];
    eval("\$listurl = \"$url\";");
	if(substr($listurl, 0, 1) == '/') $listurl = substr($listurl, 1);
	return $listurl;
}

function itemurl($item, $page = 0) {
	global $AJ, $MOD, $L;
	if(isset($item['islink']) && $item['islink']) return $item['linkurl'];
	if($MOD['show_html'] && $item['filepath']) {
		if($page === 0) return $item['filepath'];
		$ext = file_ext($item['filepath']);
		return str_replace('.'.$ext, '_'.$page.'.'.$ext, $item['filepath']);
	}
	include AJ_ROOT.'/api/url.inc.php';
	$file_ext = $AJ['file_ext'];
	$index = $AJ['index'];
	$itemid = $item['itemid'];
	$title = file_vname($item['title']);
	$addtime = $item['addtime'];
	$catid = $item['catid'];
	$year = date('Y', $addtime);
	$month = date('m', $addtime);
	$day = date('d', $addtime);
	$prefix = $MOD['htm_item_prefix'];
	$urlid = $MOD['show_html'] ? $MOD['htm_item_urlid'] : $MOD['php_item_urlid'];
	$ext = $MOD['show_html'] ? 'htm' : 'php';
	$alloc = dalloc($itemid);
	$url = $urls[$ext]['item'][$urlid];
	$url = $page ? $url['page'] : $url['index'];
	if(strpos($url, 'cat') !== false && $catid) {
		if(isset($item['gid'])) {
			$catid = $item['gid'];
			$cate = get_group($catid);
			$catdir = $cate['filepath'];
			$catname = $cate['title'];
		} else {
			$cate = get_cat($catid);
			$catdir = $cate['catdir'];
			$catname = $cate['catname'];
		}
	}
    eval("\$itemurl = \"$url\";");
	if(substr($itemurl, 0, 1) == '/') $itemurl = substr($itemurl, 1);
	return $itemurl;
}

function rewrite($url, $encode = 0) {
	if(!RE_WRITE) return $url;
	if(RE_WRITE == 1 && strpos($url, 'search.php') !== false) return $url;
	if(strpos($url, '.php?') === false || strpos($url, '=') === false) return $url;
	$url = str_replace(array('+', '-'), array('%20', '%20'), $url);
	$url = str_replace(array('.php?', '&', '='), array('-htm-', '-', '-'), $url).'.html';
	return $url;
}

function timetodate($time = 0, $type = 6) {
	if(!$time) $time = AJ_TIME;
	$types = array('Y-m-d', 'Y', 'm-d', 'Y-m-d', 'm-d H:i', 'Y-m-d H:i', 'Y-m-d H:i:s');
	if(isset($types[$type])) $type = $types[$type];
	$date = '';
	if($time > 2147212800) {		
		if(class_exists('DateTime')) {
			$D = new DateTime('@'.($time - 3600 * intval(str_replace('Etc/GMT', '', $GLOBALS['CFG']['timezone']))));
			$date = $D->format($type);
		}
	}
	return $date ? $date : date($type, $time);
}

function datetotime($date) {
	$time = strtotime($date);
	if($time === false) {
		if(class_exists('DateTime')) {
			$D = new DateTime($date);
			$time = $D->format('U');
		}
	}
	return $time;
}

function log_write($message, $type = 'php', $force = 0) {
	global $_username, $log_id;
	if(!AJ_DEBUG && !$force) return;
	if($log_id) {
		$log_id++;
	} else {
		$log_id = 1;
	}
	$user = $_username ? $_username : 'guest';
	check_name($type) or $type = 'php';
	$log = "<?php exit;?>\n<$type>\n";
	$log .= "\t<time>".timetodate()."</time>\n";
	$log .= "\t<ip>".AJ_IP."</ip>\n";
	$log .= "\t<user>".$user."</user>\n";
	$log .= "\t<php>".$_SERVER['SCRIPT_NAME']."</php>\n";
	$log .= "\t<querystring>".str_replace('&', '&amp;', $_SERVER['QUERY_STRING'])."</querystring>\n";
	$log .= "\t<message>".(is_array($message) ? var_export($message, true) : $message)."</message>\n";
	$log .= "</$type>";
	file_put(AJ_ROOT.'/file/log/'.timetodate(0, 'Ym/d').'/'.$type.'-'.timetodate(0, 'Y.m.d H.i.s').'-'.$log_id.'.php', $log);
}

function load($file) {
	$ext = file_ext($file);
	if($ext == 'css') {
		echo '<link rel="stylesheet" type="text/css" href="'.AJ_SKIN.$file.'" />';
	} else if($ext == 'js') {
		echo '<script type="text/javascript" src="'.AJ_STATIC.'file/script/'.$file.'"></script>';
	} else if($ext == 'htm') {
		$file = str_replace('ad_m', 'ad_t6_m', $file);
		if(is_file(AJ_CACHE.'/htm/'.$file)) {
			$content = file_get(AJ_CACHE.'/htm/'.$file);
			if(substr($content, 0, 4) == '<!--') $content = substr($content, 17);
			echo $content;
		} else {
			echo '';
		}
	} else if($ext == 'lang') {
		$file = str_replace('.lang', '.inc.php', $file);
		return AJ_ROOT.'/lang/'.AJ_LANG.'/'.$file;
	} else if($ext == 'inc' || $ext == 'func' || $ext == 'class') {
		return AJ_ROOT.'/include/'.$file.'.php';
	}
}

function ad($id, $cid = 0, $kw = '', $tid = 0) {
	global $cityid;
	if($tid) {
		if($kw) {
			$file = 'ad_t'.$tid.'_m'.$id.'_k'.urlencode($kw);
		} else if($cid) {
			$file = 'ad_t'.$tid.'_m'.$id.'_c'.$cid;
		} else {
			$file = 'ad_t'.$tid.'_m'.$id;
		}
		$a3 = 'ad_'.$id.'_d'.$tid.'.htm';
	} else {
		$file = 'ad_'.$id;
		$a3 = 'ad_'.$id.'_d0.htm';
	}
	$a1 = $file.'_'.$cityid.'.htm';
	if(is_file(AJ_CACHE.'/htm/'.$a1)) return load($a1);
	$a2 = $file.'_0.htm';
	if(is_file(AJ_CACHE.'/htm/'.$a2)) return load($a2);
	if(is_file(AJ_CACHE.'/htm/'.$a3)) return load($a3);
}

function lang($str, $arr = array()) {
	if(strpos($str, '->') !== false) {
		global $AJ;
		$t = explode('->', $str);
		include load($t[0].'.lang');
		$str = $L[$t[1]];
	}
	if($arr) {
		foreach($arr as $k=>$v) {
			$str = str_replace('{V'.$k.'}', $v, $str);
		}
	}
	return $str;
}

function check_name($username) {
	if(strpos($username, '__') !== false || strpos($username, '--') !== false) return false; 
	return preg_match("/^[a-z0-9]{1}[a-z0-9_\-]{0,}[a-z0-9]{1}$/", $username);
}

function check_post() {
	if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') return false;
	return check_referer();
}

function check_referer() {
	global $AJ_REF, $CFG, $AJ;
	if($AJ['check_referer']) {
		if(!$AJ_REF) return false;
		$R = parse_url($AJ_REF);
		if($CFG['cookie_domain'] && strpos($R['host'], $CFG['cookie_domain']) !== false) return true;
		if($CFG['com_domain'] && strpos($R['host'], $CFG['com_domain']) !== false) return true;
		if($AJ['safe_domain']) {
			$tmp = explode('|', $AJ['safe_domain']);
			foreach($tmp as $v) {
				if(strpos($R['host'], $v) !== false) return true;
			}
		}		
		$U = parse_url(AJ_PATH);
		if(strpos($R['host'], str_replace('www.', '.', $U['host'])) !== false) return true;
		return false;
	}
	return true;
}

function is_robot($ua = '') {
	return preg_match("/(spider|bot|crawl|slurp|lycos|robozilla)/i", $ua ? $ua : $_SERVER['HTTP_USER_AGENT']);
}

function is_url($url) {
	return preg_match("/^(http|https)\:\/\/[A-Za-z0-9_\-\/\.\#\&\?\;\,\=\%\:]{4,}$/", $url);
}

function is_ip($ip) {
	return preg_match("/^([0-9]{1,3}\.){3}[0-9]{1,3}$/", $ip);
}

function is_mobile($mobile) {
	return preg_match("/^1[3|4|5|6|7|8|9]{1}[0-9]{9}$/", $mobile);
}

function is_md5($password) {
	return preg_match("/^[a-f0-9]{32}$/", $password);
}

function is_openid($openid) {
	return preg_match("/^[0-9a-zA-Z\-_]{10,}$/", $openid);
}

function is_touch() {
	$ck = get_cookie('mobile');
	if($ck == 'pc') return 0;
	if($ck == 'touch' || $ck == 'screen') return 1;
	return preg_match("/(iPhone|iPad|iPod|Android)/i", $_SERVER['HTTP_USER_AGENT']) ? 1 : 0;
}

function is_mob($par = '') {
	return preg_match("/(iPhone|iPad|iPod|Android|Phone|mobile)/i", ($par ? $par : $_SERVER['HTTP_USER_AGENT'])) ? 1 : 0;
}

function is_founder($userid) {
	global $CFG;
	$userid = intval($userid);
	if($userid < 1) return false;
	if(strpos($CFG['founderid'], ',') === false) {
		return $userid == $CFG['founderid'] ? true : false;
	} else {
		return strpos(','.$CFG['founderid'].',', ','.$userid.',') === false ? false : true;
	}
}

function debug() {
	global $db, $debug_starttime;
	$mtime = explode(' ', microtime());
	$s = number_format(($mtime[1] + $mtime[0] - $debug_starttime), 3);
	echo 'Processed in '.$s.' second(s), '.$db->querynum.' queries';
    if(function_exists('memory_get_usage')) echo ', Memory '.round(memory_get_usage()/1024/1024, 2).' M';
}

function dhttp($status, $exit = 1) {
	switch($status) {
		case '301': @header("HTTP/1.1 301 Moved Permanently"); break;
		case '403': @header("HTTP/1.1 403 Forbidden"); break;
		case '404': @header("HTTP/1.1 404 Not Found"); break;
		case '503': @header("HTTP/1.1 503 Service Unavailable"); break;
	}
	if($exit) exit;
}

function dcurl($url, $par = '') {
	if(function_exists('curl_init')) {
		$cur = curl_init($url);
		if($par) {
			curl_setopt($cur, CURLOPT_POST, 1);
			curl_setopt($cur, CURLOPT_POSTFIELDS, $par);
		}
		curl_setopt($cur, CURLOPT_REFERER, AJ_PATH);
		curl_setopt($cur, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($cur, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($cur, CURLOPT_HEADER, 0);
		curl_setopt($cur, CURLOPT_TIMEOUT, 30);
		curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1);
		$rec = curl_exec($cur);
		curl_close($cur);
		return $rec;
	}
	return file_get($par ? $url.'?'.$par : $url);
}

function d301($url) {
	dhttp(301, 0);
	dheader($url);
}
//统计分类数量
function get_categorynum($itemid,$catid) {
	 


$CAT=get_cat($catid);

if($catid) $condition .= $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";	 
     $r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."photo_12 a  LEFT JOIN ".AJ_PRE."photo_item_12 b  ON b.item = a.itemid   where a.houseid=$itemid {$condition} ");
	$categorynum = $r['num'];
	return $categorynum;
}
/**
	 * 把浏览过的房源写入cookies
	 * @param id
	 * @return null
	 * 
	 */
	function rentcookies($id)
	{
		 $TempNum=5;  
		//setcookie("RecentlyGoods", "12,31,90,39");
		//RecentlyGoods 最近商品RecentlyGoods临时变量
		if (isset($_COOKIE['RRecentlyGoods'])) 
		{
		$RecentlyGoods=$_COOKIE['RRecentlyGoods']; 
		$RecentlyGoodsArray=explode(",", $RecentlyGoods);
		$RecentlyGoodsNum=count($RecentlyGoodsArray); //RecentlyGoodsNum 当前存储的变量个数
		}
		if($id!="")
		{
		if (strstr($RecentlyGoods,(string)$id))  
		   {
	      
		       }
		else
		{
		if($RecentlyGoodsNum<$TempNum) //如果COOKIES中的元素小于指定的大小，则直接进行输入COOKIES
		{
		if($RecentlyGoods=="")
		{
		setcookie("RRecentlyGoods",$id,time()+432000,"/");
		}
		else
		{
		$RecentlyGoodsNew=$RecentlyGoods.",".$id;
		setcookie("RRecentlyGoods", $RecentlyGoodsNew,time()+432000,"/"); 
		}
		}
		else //如果大于了指定的大小后，将第一个给删去，在尾部再加入最新的记录。
		{
		$pos=strpos($RecentlyGoods,",")+1; //第一个参数的起始位置
		$FirstString=substr($RecentlyGoods,0,$pos); //取出第一个参数
		$RecentlyGoods=str_replace($FirstString,"",$RecentlyGoods); //将第一个参数删除
		$RecentlyGoodsNew=$RecentlyGoods.",".$id; //在尾部加入最新的记录
		setcookie("RRecentlyGoods", $RecentlyGoodsNew,time()+432000,"/"); 
		}
		}
		}
	}
	
	/**
	 * 读取浏览过的房源信息

	 */
	function browseHouse($ids) {
		 
		if($ids)$where = ' where itemid in (' . $ids . ')';
		$result = DB::query("select * from ".AJ_PRE."rent_7 ".$where );
	while($c = DB::fetch_array($result)) {
	    $are[] = $c;
	      }
	return $are;
	}
//二手房浏览
function salecookies($id)
	{
			$RecentlyGoods = isset($RecentlyGoods) ? intval($RecentlyGoods) : '';
		 $TempNum=5;  
		//setcookie("RecentlyGoods", "12,31,90,39");
		//RecentlyGoods 最近商品RecentlyGoods临时变量
		if (isset($_COOKIE['SRecentlyGoods'])) 
		{
		$RecentlyGoods=$_COOKIE['SRecentlyGoods']; 
		$RecentlyGoodsArray=explode(",", $RecentlyGoods);
		$RecentlyGoodsNum=count($RecentlyGoodsArray); //RecentlyGoodsNum 当前存储的变量个数
		}
		if($id!="")
		{
		if (strstr($RecentlyGoods,(string)$id))  
		   {
	      
		       }
		else
		{
		if($RecentlyGoodsNum<$TempNum) //如果COOKIES中的元素小于指定的大小，则直接进行输入COOKIES
		{
		if($RecentlyGoods=="")
		{
		setcookie("SRecentlyGoods",$id,time()+432000,"/");
		}
		else
		{
		$RecentlyGoodsNew=$RecentlyGoods.",".$id;
		setcookie("SRecentlyGoods", $RecentlyGoodsNew,time()+432000,"/"); 
		}
		}
		else //如果大于了指定的大小后，将第一个给删去，在尾部再加入最新的记录。
		{
		$pos=strpos($RecentlyGoods,",")+1; //第一个参数的起始位置
		$FirstString=substr($RecentlyGoods,0,$pos); //取出第一个参数
		$RecentlyGoods=str_replace($FirstString,"",$RecentlyGoods); //将第一个参数删除
		$RecentlyGoodsNew=$RecentlyGoods.",".$id; //在尾部加入最新的记录
		setcookie("SRecentlyGoods", $RecentlyGoodsNew,time()+432000,"/"); 
		}
		}
		}
	}
	
	/**
	 * 读取浏览过的房源信息

	 */
	function browsesale($ids) {
		 
		if($ids)$where = ' where itemid in (' . $ids . ')';
		$result = DB::query("select * from ".AJ_PRE."sale_5 ".$where );
	while($c = DB::fetch_array($result)) {
	    $are[] = $c;
	      }
	return $are;
	}
//统计小区租房数量
function get_rent($itemid) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."rent_7 WHERE houseid=$itemid and status=3");
	$rentnum = $r['num'];
	return $rentnum;
}
//统计小区售房数量
function get_sale($itemid) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."sale_5 WHERE houseid=$itemid and status=3");
	$rentnum = $r['num'];
	return $rentnum;
}
//统计经纪人租房数量
function get_arent($username) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."rent_7 WHERE username='$username' and status=3");
	$rentnum = $r['num'];
	return $rentnum;
}
//统计经纪人售房数量
function get_asale($username) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."sale_5 WHERE username='$username' and status=3");
	$rentnum = $r['num'];
	return $rentnum;
}
//统计小区均价
function get_avg_price($itemid) {
	 
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."sale_5 as t where status=3 and  price!='' and houseearm!=''  and houseid=$itemid and status=3");
	 $sum_arrays=DB::fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		
	return $avg_price;
}
//统计小区上1月均价
function get_avg_priceb($itemid) {
	 
	$pb= mktime(0,0,0,date('m')-1,date('d'),date('Y'));
   $lb=date("m",$pb);
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."sale_5 as t where status=3 and addtime <=$pb and price!='' and houseearm!=''  and houseid=$itemid and status=3");
	 $sum_arrays=DB::fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		
	return $avg_price;
}
//统计小区上2月均价
function get_avg_pricec($itemid) {
	 
	$pb= mktime(0,0,0,date('m')-2,date('d'),date('Y'));
   $lb=date("m",$pb);
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."sale_5 as t where status=3 and addtime <=$pb and price!='' and houseearm!=''  and houseid=$itemid and status=3");
	 $sum_arrays=DB::fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		
	return $avg_price;
}
//统计小区上3月均价
function get_avg_priced($itemid) {
	 
	$pb= mktime(0,0,0,date('m')-3,date('d'),date('Y'));
   $lb=date("m",$pb);
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."sale_5 as t where status=3 and addtime <=$pb and price!='' and houseearm!=''  and houseid=$itemid and status=3");
	 $sum_arrays=DB::fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		
	return $avg_price;
}
//统计小区上4月均价
function get_avg_pricee($itemid) {
	 
	$pb= mktime(0,0,0,date('m')-4,date('d'),date('Y'));
   $lb=date("m",$pb);
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."sale_5 as t where status=3 and addtime <=$pb and price!='' and houseearm!=''  and houseid=$itemid and status=3");
	 $sum_arrays=DB::fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		
	return $avg_price;
}
//统计小区走势均价
function get_lineprice($itemid) {
	 
	$pae=get_avg_pricee($itemid);
	$pad=get_avg_priced($itemid);
	$pac=get_avg_pricec($itemid);
	$pab=get_avg_priceb($itemid);
	$paa=get_avg_price($itemid);
	 $lineprice="$pae,$pad,$pac,$pab,$paa";
	return $lineprice;
}
//统计小区走势月份
function get_linedate($itemid) {
	 
	 $pa= mktime(0,0,0,date('m')-0,date('d'),date('Y'));
   $la=date("m",$pa);
    $pb= mktime(0,0,0,date('m')-1,date('d'),date('Y'));
   $lb=date("m",$pb);
    $pc= mktime(0,0,0,date('m')-2,date('d'),date('Y'));
   $lc=date("m",$pc);
    $pd= mktime(0,0,0,date('m')-3,date('d'),date('Y'));
   $ld=date("m",$pd);
    $pe= mktime(0,0,0,date('m')-4,date('d'),date('Y'));
   $le=date("m",$pe);
 $linedate="\"".$le."\",\"".$ld."\",\"".$lc."\",\"".$lb."\",\"".$la."\"";
	return $linedate;
}
//统计小区上月均价
function get_percent_change($itemid) {
	 
	$percent_change = round((get_avg_price($itemid)-get_avg_priceb($itemid))/get_avg_priceb($itemid)*100,2);
	return $percent_change;
}


//物业类型

function get_cats($catid,  $moduleid = 1) {
	global $MODULE, $db;
	$condition = $catid ? "moduleid=$moduleid AND parentid=0 AND catid IN ($catid)" : "moduleid=$moduleid AND parentid=0";
	$result = DB::query("SELECT catid,moduleid,catname FROM ".AJ_PRE."category where $condition");
	
	while($c = DB::fetch_array($result)) {
		    
			 $html .= $c['catname'] . "&nbsp;";
			
		
		}
       $html = rtrim($html, '&nbsp;');  
	return $html;
}
//搜索物业类型
function search_cats($catid,  $moduleid = 1) {
	global $MODULE, $db;
		$condition = $catid ? "moduleid=$moduleid AND parentid=0 AND catid IN ($catid)" : "moduleid=$moduleid AND parentid=0";
	$result = DB::query("SELECT catid,moduleid,catname FROM ".AJ_PRE."category where $condition");
	
	while($c = DB::fetch_array($result)) {
		    
			 $html .= $c['catname'] . " ";
			
		
		}
       $html = rtrim($html, ','); 
	return $html;
}
function search_catss($catid,  $moduleid = 1) {
	global $MODULE, $db;
	$condition = "moduleid=$moduleid AND parentid=0 AND catid IN ($catid)";
	$result = DB::query("SELECT catid,moduleid,catname FROM ".AJ_PRE."category where $condition limit 0,1");
	
	while($c = DB::fetch_array($result)) {
		    
			 $html .= $c['catname'] . "&nbsp;";
			
		
		}
       $html = rtrim($html, ','); 
	return $html;
}
function get_xiqoqu($areaid,$pagesize) {
	 
	$are = array();
	$result = DB::query("SELECT areaid,areaname FROM ".AJ_PRE."area WHERE parentid=$areaid ORDER BY listorder,areaid ASC limit 0,$pagesize", 'CACHE');
	while($r = DB::fetch_array($result)) {
		$are[] = $r;
	}
	return $are;
}
function get_maincats($catid, $moduleid, $level = -1) {
	 
	$condition = $catid ? "parentid=$catid" : "moduleid=$moduleid AND parentid=0";
	if($level >= 0) $condition .= " AND level=$level";
	$cat = array();
	$result = DB::query("SELECT catid,catname,child,style,linkurl,item FROM ".AJ_PRE."category WHERE $condition ORDER BY listorder,catid ASC limit 0,6", 'CACHE');
	while($r = DB::fetch_array($result)) {
		$cat[] = $r;
	}
	return $cat;
}
function get_maincatmenu($catid, $moduleid, $level = -1) {
	 
	$condition = $catid ? "parentid=$catid" : "moduleid=$moduleid AND parentid=0";
	if($level >= 0) $condition .= " AND level=$level";
	$cat = array();
	$result = DB::query("SELECT catid,catname,child,style,linkurl,item FROM ".AJ_PRE."category WHERE $condition ORDER BY listorder,catid ASC limit 0,10", 'CACHE');
	while($r = DB::fetch_array($result)) {
		$cat[] = $r;
	}
	return $cat;
}
function area_poss($areaid, $str = ' &raquo; ', $deep = 0) {
	if($areaid) {
		global $AREA;
	} else {
		global $AJ;
		return $AJ[city_sitename];
	}
	$AREA or $AREA = cache_read('area.php');
	$arrparentid = $AREA[$areaid]['arrparentid'] ? explode(',', $AREA[$areaid]['arrparentid']) : array();
	$arrparentid[] = $areaid;
	$nums=count($arrparentid);
	if($nums==3){$arrparentids=array_slice($arrparentid,-1,1);}
	else{$arrparentids=array_slice($arrparentid,-2,1);}

	
	$pos = '';
	if($deep) $i = 1;
	foreach($arrparentids as $areaid) {
		if(!$areaid || !isset($AREA[$areaid])) continue;
		if($deep) {
			if($i > $deep) continue;
			$i++;
		}
		$pos .= $AREA[$areaid]['areaname'].$str;
	}
	$_len = strlen($str);
	if($str && substr($pos, -$_len, $_len) === $str) $pos = substr($pos, 0, strlen($pos)-$_len);
	return $pos;
}
//板块
function get_mainarea2($areaid) {
	 
	$are = array();
	if($areaid) {
		$r = DB::get_one("SELECT child,arrparentid,arrchildid FROM ".AJ_PRE."area WHERE areaid=$areaid");
		$parents =  $r['arrparentid'];  
		
	if($r['child']) $parents = $areaid;
	} else {
		$parents = 0;
	}

	//if($cityid==''){$condition='and child =0 ';}else {$condition='and  parentid =!0';};
	 $result = DB::query("SELECT areaid,areaname,arrchildid,arrparentid FROM ".AJ_PRE."area WHERE parentid IN  (".$parents.")  and child =0 ORDER BY listorder,areaid ASC", 'CACHE');
		   while($r = DB::fetch_array($result)) {
				$parents =  $r['arrparentid'];  
		if(strlen($parents)==5) $are[] = $r;
				
	}
	
	return $are;
}
//板块
//板块
function get_mainarea4($areaid) {
	 
	$are = array();
	 $result = DB::query("SELECT areaid,areaname,arrchildid,arrparentid FROM ".AJ_PRE."area ");
		   while($r = DB::fetch_array($result)) {
				$parents =  $r['arrparentid'];  
		if(strlen($parents)==5) $are[] = $r;
	 } 	
	return $are;
}
function get_mainarea3($areaid) {

	 
	$are = array();
	if($areaid) {

		$r = DB::get_one("SELECT child,arrparentid,arrchildid FROM ".AJ_PRE."area WHERE areaid=$areaid");
		$parents =  $r['arrparentid'];  
	if($r['child']) $parents = $areaid;
	} else {

		$parents = 0;
	}

	//if($cityid==''){$condition='and child =0 ';}else {$condition='and  parentid =!0';};
	 $result = DB::query("SELECT areaid,areaname,arrchildid,arrparentid FROM ".AJ_PRE."area WHERE parentid IN  (".$parents.")  and  parentid !=0 ORDER BY listorder,areaid ASC", 'CACHE');
		   while($r = DB::fetch_array($result)) {
				
				
				$are[] = $r;
				
	}
	
	return $are;
}
//分站
function get_city($areaid) {
	 
	$city = array();
	$result = DB::query("SELECT areaid,name,style,domain,letter FROM ".AJ_PRE."city  ORDER BY listorder ASC", 'CACHE');
	
	while($r = DB::fetch_array($result)) {
		$city[] = $r;
		$r['domain'] = $r['domain'] ? $r['domain'] : '';

		
		
	}
	return $city;
}
function imgurl240($imgurl = '', $absurl = 1) {
	return $imgurl ? $imgurl : AJ_SKIN.'image/nopic240.gif';
}
function twoCode($wap_url,$moduleid,$itemid){
$urlToEncode=$wap_url.'index.php?moduleid='.$moduleid.'&itemid='.$itemid;
generateQRfromGoogle($urlToEncode);

}
function generateQRfromGoogle($chl,$widhtHeight ='90',$EC_level='L',$margin='0')
{
 $url = urlencode($url);
 echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="" widhtHeight="'.$size.'" widhtHeight="'.$size.'"widht="75" height="75"/>';
}
function tupianurl($item, $page = 0) {
	global $AJ, $MOD, $L;
	if($MOD['show_html'] && $item['filepath']) {
		if($page === 0) return $item['filepath'];
		$ext = file_ext($item['filepath']);
		return str_replace('.'.$ext, '_'.$page.'.'.$ext, $item['filepath']);
	}
	include AJ_ROOT.'/api/url.inc.php';
	$file_ext = $AJ['file_ext'];
	$index = $AJ['index'];
	$itemid = $item['itemid'];
	$title = file_vname($item['title']);
	$addtime = $item['addtime'];
	$houseid = $item['houseid'];
	$year = date('Y', $addtime);
	$month = date('m', $addtime);
	$day = date('d', $addtime);
	$prefix = $MOD['htm_item_prefix'];
	$urlid = $MOD['show_html'] ? $MOD['htm_item_urlid'] : $MOD['php_item_urlid'];
	$ext = $MOD['show_html'] ? 'htm' : 'php';
	$alloc = dalloc($itemid);
	$url = $urls[$ext]['item'][6];
	$url = $page ? $url['page'] : $url['index'];
	if(strpos($url, 'cat') !== false && $catid) {
		$cate = get_cat($catid);
		$catdir = $cate['catdir'];
		$catname = $cate['catname'];
	}
    eval("\$itemurl = \"$url\";");
	if(substr($itemurl, 0, 1) == '/') $itemurl = substr($itemurl, 1);
	return $itemurl;
}
//统计数量
function get_num($biao,$username) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."$biao WHERE username='$username' and status=3");
	$num = $r['num'];
	return $num;
}
//会员统计数量
function get_mnum($biao,$username) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM $biao WHERE username='$username' and status=3");
	$num = $r['num'];
	return $num;
}
//房价走势
function get_priceS($module) {
	 
	for ($i=4; $i>=0; $i--)
    {
	$pb= mktime(0,0,0,date('m')-$i,date('d'),date('Y'));
	$la=date("m",$pb);
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."$module as t where status=3 and addtime <=$pb and price!='' and houseearm!='' and status=3");
	while($sum_arrays = DB::fetch_array($sum_array)) {
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		  $strp .=$avg_price.',';  
		  $lineprice = substr($strp,0,strlen($strp)-1); 
		  $strd .="\"".$la."月\",";
		  $linedate = substr($strd,0,strlen($strd)-1); 
	                                             }
	}
	$lineprice="[".$linedate."],[".$lineprice."]";
	return $lineprice;
}
//统计本月小区均价
function get_avg_prices() {
	 
	$sum_array = DB::query("select sum( t.price/t.houseearm ) as sum_p,count(*) as sum_c from ".AJ_PRE."sale_5 as t where status=3 and  price!='' and houseearm!='' ");
	 $sum_arrays=DB::fetch_array($sum_array);
		  $avg_price = intval($sum_arrays['sum_p']*10000/$sum_arrays['sum_c']);
		
	return $avg_price;
}
//统计楼盘相关数量
function get_housenum($biao,$houseid) {
	 
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."$biao WHERE houseid='$houseid' and status=3");
	$num = $r['num'];
	return $num;

}
//统计问房
function get_buynum($title) {
	 
	$buynum = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."message WHERE title='$title' AND typeid=1 AND status=3");
	$buynum = $buynum['num'];
	return $buynum;
}
//统计评论
function get_dpnum($houseid) {
	 
	$buynum = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."comment WHERE item_id='$houseid' AND status=3");
	$buynum = $buynum['num'];
	return $buynum;
}
//统计问房
function get_wfnum($houseid) {
	 
	$buynum = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."wenfang WHERE item_id='$houseid' AND status=3");
	$buynum = $buynum['num'];
	return $buynum;
}
function checkdomain(){

}
function userinfos($username) {
	global $db, $dc, $CFG;

	$result = DB::query("SELECT * FROM ".AJ_PRE."member m, ".AJ_PRE."company c WHERE m.userid=c.userid AND m.username='$username'");
	while($r = DB::fetch_array($result)) {
		$city[] = $r;
		$r['truename'] = $r['truename'] ;
	
      $truename=$r['truename'];
		
	}
	return $truename;
}
//表单
function getbox_name($name,$tb) {
	 
	$options = array();
	$v = DB::get_one("SELECT * FROM ".AJ_PRE."fields WHERE name='$name' and tb='$tb' ");
	$file=$v['option_value'];
	$str = rtrim( trim($file), '*' );
	$options = explode("*", $str);
	foreach($options as $_k) {
$v = explode("|",$_k);
$k = trim($v[0]);
$option[$k] = $v[1];
}
	return $option ;
}
//价格区间
function mixprice($range,$name,$tb) {
	 
	$options = array();
	$v = DB::get_one("SELECT * FROM ".AJ_PRE."fields WHERE name='$name' and tb='$tb' ");
	$file=$v['option_value'];
	$str = rtrim( trim($file), '*' );
	$options = explode("*", $str);
	foreach($options as $_k) {
$v = explode("|",$_k);
$k = trim($v[0]);
$option[$k] = $v[1];
$jiages=$option[$range];
if(strpos($jiages,'上')) {$mixprice=findNum($jiages);}
	else
	{$mixprice=substr($jiages,0,strpos($jiages,'-'));}
}

	return $mixprice ;
}
function maxprice($range,$name,$tb) {
	 
	$options = array();
	$v = DB::get_one("SELECT * FROM ".AJ_PRE."fields WHERE name='$name' and tb='$tb' ");
	$file=$v['option_value'];
	$str = rtrim( trim($file), '*' );
	$options = explode("*", $str);
	foreach($options as $_k) {
$v = explode("|",$_k);
$k = trim($v[0]);
$option[$k] = $v[1];
$jiages=$option[$range];
if($range==1){ $maxprice=findNum($jiages);}
	else
	{$maxprice=substr(substr($jiages,strpos($jiages,'-')+1,strpos($jiages,'元')),0,strpos(substr($jiages,strpos($jiages,'-')+1,strpos($jiages,'元')),'元'));}
}
	return $maxprice ;
}
function salemaxprice($range,$name,$tb) {
	 
	$options = array();
	$v = DB::get_one("SELECT * FROM ".AJ_PRE."fields WHERE name='$name' and tb='$tb' ");
	$file=$v['option_value'];
	$str = rtrim( trim($file), '*' );
	$options = explode("*", $str);
	foreach($options as $_k) {
$v = explode("|",$_k);
$k = trim($v[0]);
$option[$k] = $v[1];
$jiages=$option[$range];
if($range==1){ $maxprice=findNum($jiages);}
	else
	{$maxprice=substr(substr($jiages,strpos($jiages,'-')+1,strpos($jiages,'万')),0,strpos(substr($jiages,strpos($jiages,'-')+1,strpos($jiages,'万')),'万'));}
}
	return $maxprice ;
}
function findNum($str=''){
   $str=trim($str);
   if(empty($str)){return '';}
	    $result='';
    for($i=0;$i<strlen($str);$i++){
        if(is_numeric($str[$i])){
            $result.=$str[$i];
        }
   }
	    return $result;
	}
//表单值
function getbox_val($name,$boxtype,$value,$tb){
 
    $options = array();
	$v = DB::get_one("SELECT * FROM ".AJ_PRE."fields WHERE name='$name' and tb='$tb' ");
	$file=$v['option_value'];
	$str = rtrim( trim($file), '*' );
	$options = explode("*", $str);
	foreach($options as $_k) {
     $v = explode("|",$_k);
      $k = trim($v[0]);
    $option[$k] = $v[1];
		//$string .= '<a href="'.$MODULE['moduleid']['linkurl'].'list-t'.$k.'"'.$target.'>'.$v[1].'</a>';
    }
//$color = '#'.sprintf('%02X',rand(0,255)).sprintf('%02X',rand(0,255)).sprintf('%02X',rand(0,255)); 	
$string = '';
switch($boxtype) {
case 'radio':
$string = $option[$value];
break;
case 'checkbox':
$value_arr = explode(',',$value);
foreach($value_arr as $_v) {
//$string .= ' <span style="background:'.$color.';"><a href="'.$MODULE['moduleid']['linkurl'].rentser('l',$_v).'"'.$target.'>'.$option[$_v].'</a></span>';
$string .= ' <span style="background:'.$color.';">'.$option[$_v].'</span>';
//if($_v) $string .= $option[$_v].' ';
}
break;
case 'select':
$string = $option[$value];
break;
}
return $string;
}
//表单调用值
function getbox_diaoval($name,$boxtype,$value,$tb){

 
    $options = array();
	$v = DB::get_one("SELECT * FROM ".AJ_PRE."fields WHERE name='$name' and tb='$tb' ");
	$file=$v['option_value'];
	$str = rtrim( trim($file), '*' );
	$options = explode("*", $str);
	foreach($options as $_k) {
     $v = explode("|",$_k);
      $k = trim($v[0]);
    $option[$k] = $v[1];
		//$string .= '<a href="'.$MODULE['moduleid']['linkurl'].'list-t'.$k.'"'.$target.'>'.$v[1].'</a>';
    }
$string = '';
switch($boxtype) {
case 'radio':
$string = $option[$value];
break;
case 'checkbox':
$value_arr = explode(',',$value);
foreach($value_arr as $_v) {
$string .= $option[$_v].'&nbsp;&nbsp;';
$string = rtrim($string, '&nbsp;&nbsp;'); 
//if($_v) $string .= $option[$_v].' ';
}
break;
case 'select':
$string = $option[$value];
break;
}
return $string;
}

function deal_str($str,$s)
{
if(stripos($str,'-'.$s)!==false)
{
if($s=='e'||$s=='m')
{
$str = preg_replace ( '/\-'.$s.'[0-9_]+/','',$str );
}
else
{
$str = preg_replace ( '/\-'.$s.'[\d]+/','',$str );
}
if($s=='j'|| $s=='e'){
$str = preg_replace ( '/\-'.$s.'[0-9A-Z_]+/','',$str );
}
if($s=='r')
{
$str = deal_str($str,'b');
}
elseif($s=='p')
{
$str = deal_str($str,'e');
}
elseif($s=='c')
{
$str = deal_str($str,'m');
}
}
elseif($s=='p')
{
$str = deal_str($str,'e');
}
elseif($s=='c')
{
$str = deal_str($str,'m');
}
elseif($s=='u')
{
$str = deal_str($str,'h');
}
return $str;
}
function deal_str2($str)
{
$str = preg_replace ( '/\-r[\d]+/','',$str );
$str = preg_replace ( '/\-k[^/]+/','',$str );
return $str;
}
function safe_replace($string) {
$string = str_replace('%20','',$string);
$string = str_replace('%27','',$string);
$string = str_replace('%2527','',$string);
$string = str_replace('*','',$string);
$string = str_replace('"','&quot;',$string);
$string = str_replace("'",'',$string);
$string = str_replace('"','',$string);
$string = str_replace(';','',$string);
$string = str_replace('<','&lt;',$string);
$string = str_replace('>','&gt;',$string);
$string = str_replace("{",'',$string);
$string = str_replace('}','',$string);
$string = str_replace('\\','',$string);
return $string;
}

//housepage
function housepages( $total, $page = 1 ,$lst, $perpage = 20) {
	global $AJ, $MOD, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	//$urlrule=rentser('p',$page);
	//echo $urlrule;
	$urlrule=rentser('p',1,'','',$nowurl);
	
	$urlrule = str_replace('$page',$page,$urlrule);
	$findme = '{$page}';
    $replaceme = '1';
     $demo_url = str_replace($findme,$replaceme,$urlrule);

	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);
    $demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
    $url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
    if($page >1)$pages .= '<a class="prev" href="'.rentser('p',$_page,'','',$nowurl).'"><span class="pre-page">'.$L['prev_page'].'</span></a> ';
         if($total <= 7) { $min=1; $max=$total; }
		 if($total >7) {
		if($page < 5) {$min = 1; $max = 7;}
		if($page >= 5)  { $min=$page-3; $max=$page+3; }
		if($page >= $total-3)  { $min=$total-6; $max=$total; }
		}
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
			//$pages .= $page == $_page ? ''.$_page.'</span>' : ' <a href="'.rentser('p',$_page,'','',$nowurl).'"><span>'.$_page.'</span></a>  ';
			$pages .= $page == $_page ? '<span>'.$_page.'</span>' : ' <a href="'.rentser('p',$_page,'','',$nowurl).'">'.$_page.'</a>  ';
		}

$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
if($page<>$total)$pages .= '<a  class="next" href="'.rentser('p',$_page,'','',$nowurl).'">'.$L['next_page'].'<i>&gt;</i></a>';
//if($page<>$total)$pages .= '<a  class="next" href="'.rentser('p',$_page,'','',$nowurl).'"><span class="next-page">'.$L['next_page'].'</span></a>';

	return $pages;
}
//板块
function get_arrchildids($areaid) {
	 
	if($areaid) {
		$r = DB::get_one("SELECT child,arrparentid,arrchildid FROM ".AJ_PRE."area WHERE areaid=$areaid");
		$arrchildid =  $r['arrchildid'];  
	}	
	return $arrchildid;
}
//问房page
function wenfangpages( $total, $page = 1 ,$lst, $perpage = 20) {
	global $AJ, $MOD, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	$urlrule='{$lst}-g{$page}.html';
	$urlrule = str_replace('{$lst}',$lst,$urlrule);
	$findme = '{$page}';
    $replaceme = '1';
     $demo_url = str_replace($findme,$replaceme,$urlrule);

	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);
    $demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
    $url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
    if($page >1)$pages .= '<a class="prev" href="'.$url.'"><i>&lt;</i>'.$L['prev_page'].'</a> ';
         if($total <= 7) { $min=1; $max=$total; }
		 if($total >7) {
		if($page < 5) {$min = 1; $max = 7;}
		if($page >= 5)  { $min=$page-3; $max=$page+3; }
		if($page >= $total-3)  { $min=$total-6; $max=$total; }
		}
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
			$pages .= $page == $_page ? '<span>'.$_page.'</span>' : ' <a href="'.$url.'">'.$_page.'</a>  ';
		}

$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
if($page<>$total)$pages .= '<a  class="next" href="'.$url.'">'.$L['next_page'].'<i>&gt;</i></a>';

	return $pages;
}
//新房房价走势
function get_houseprice($pid) {
	$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."newhouse_price WHERE status=3 and pid =$pid");
	$pagesize=$r['num'];
	if($pagesize>6) {$offset =$pagesize-6;}
	else
	{$offset =0;}
	$result = DB::query("select  price,addtime from ".AJ_PRE."newhouse_price  where status=3 and pid =$pid ORDER BY addtime ASC LIMIT $offset,$pagesize");
	while($r = DB::fetch_array($result)) {
	      $r['adddate'] = timetodate($r['addtime'], 3);
		  $date.= '"'.$r['adddate'].'",'; 
		  $linedate = substr($date,0,strlen($date)-1); 
		  $avg_price.= $r['price'].',';  
		  $lineprice = substr($avg_price,0,strlen($avg_price)-1); 

	}
	$lineprice="[".$linedate."],[".$lineprice."]";
	return $lineprice;
}
//屏蔽电话号码中间的四位数字
function hidtel($phone)
{
 $IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i',$phone); //固定电话
 if($IsWhat == 1)
 {
  return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$phone);

 }
 else
 {
  return  preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
 }
}
//关联中介
function get_agent($userid) {
		global $db, $dc, $CFG;
		$companyid=get_companyid($userid);
	$r = DB::get_one("SELECT * FROM  ".AJ_PRE."company  WHERE userid='$companyid'");
      $username=$r['username'];
	return $username;
}
//获取会员companyid
function get_companyid($userid) {
	global $db, $dc, $CFG;
	$user=DB::get_one("SELECT * FROM ".AJ_PRE."member WHERE userid='$userid'");
      $companyid=$user['companyid'];
	return $companyid;
}
function getFirstLetter($str){     
	$fchar = ord($str{0});  
	if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($str{0});  
	$s1 = iconv("UTF-8","GBK", $str); 
	//$s1 = mb_convert_encoding($str, "UTF-8", "GBK"); 
	//$s2 = mb_convert_encoding($s1, "gb2312", "UTF-8"); 
	$s2 = iconv("gb2312","UTF-8", $s1);  
	if($s2 == $str){$s = $s1;}
	else{$s = $str;}  
	$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;  
	if($asc >= -20319 and $asc <= -20284) return "a";  
	if($asc >= -20283 and $asc <= -19776) return "b";  
	if($asc >= -19775 and $asc <= -19219) return "c";  
	if($asc >= -19218 and $asc <= -18711) return "d";  
	if($asc >= -18710 and $asc <= -18527) return "e";  
	if($asc >= -18526 and $asc <= -18240) return "f";  
	if($asc >= -18239 and $asc <= -17923) return "g";
	if($asc >= -17922 and $asc <=- 17418) return "h";   
	if($asc >= -17922 and $asc <= -17418) return "i";  
	if($asc >= -17417 and $asc <= -16475) return "j";  
	if($asc >= -16474 and $asc <= -16213) return "k";  
	if($asc >= -16212 and $asc <= -15641) return "l";  
	if($asc >= -15640 and $asc <= -15166) return "m";  
	if($asc >= -15165 and $asc <= -14923) return "n";  
	if($asc >= -14922 and $asc <= -14915) return "o";  
	if($asc >= -14914 and $asc <= -14631) return "p";  
	if($asc >= -14630 and $asc <= -14150) return "q";  
	if($asc >= -14149 and $asc <= -14091) return "r";  
	if($asc >= -14090 and $asc <= -13319) return "s";  
	if($asc >= -13318 and $asc <= -12839) return "t";  
	if($asc >= -12838 and $asc <= -12557) return "w";  
	if($asc >= -12556 and $asc <= -11848) return "x";  
	if($asc >= -11847 and $asc <= -11056) return "y";  
	if($asc >= -11055 and $asc <= -10247) return "z";  
	return null;  
}
function GetPinyin($zh){  
     $ret = "";  
    // $s1 = iconv("UTF-8","gb2312", $zh);  
    // $s2 = iconv("gb2312","UTF-8", $s1);  
     if($s2 == $zh){$zh = $s1;}  
     for($i = 0; $i < strlen($zh); $i++){  
         $s1 = substr($zh,$i,1);  
         $p = ord($s1);  
         if($p > 160){  
             $s2 = substr($zh,$i++,2);  
             $ret .= getFirstLetter($s2);  
         }else{  
             $ret .= $s1;  
         }  
     }  
     return $ret;  
}
function pinyin($words) {
	global $Pinyin;
	include AJ_ROOT."/include/Pinyin.class.php";
	
	$Pinyin = new ChinesePinyin();
	$result = $Pinyin->TransformWithoutTone($words,'');
		return $result;
	}  
function userinfoaddress($username) {
	global $db, $dc, $CFG;

	$result = DB::query("SELECT * FROM ".AJ_PRE."member m, ".AJ_PRE."company c WHERE m.userid=c.userid AND m.username='$username'");
	while($r = DB::fetch_array($result)) {
		$city[] = $r;
		$r['address'] = $r['address'] ;
	
      $address=$r['address'];
		
	}
	return $address;
}


function _get($str){
$val = !empty($_GET[$str]) ? $_GET[$str] : null;
return $val;
} 
function decryptp($txt, $key = '') {
	$key or $key = AJ_KEY;
	$txt = kecryptp(base64_decode($txt), $key);
	$len = strlen($txt);
	$str = '';
	for($i = 0; $i < $len; $i++) {
		$tmp = $txt[$i];
		$str .= $txt[++$i] ^ $tmp;
	}
	return $str;
}
function kecryptp($txt, $key) {
	$key = md5($key);
	$len = strlen($txt);
	$ctr = 0;
	$str = '';
	for($i = 0; $i < $len; $i++) {
		$ctr = $ctr == 32 ? 0 : $ctr;
		$str .= $txt[$i] ^ $key[$ctr++];
	}
	return $str;
}

function timetodate2($show_time) {
	$now_time = date("Y-m-d H:i:s",time());
	$now_time = strtotime($now_time);
	$dur = $now_time - $show_time;
	if($dur < 0){
		return $the_time;
	}else{
		if($dur < 60){
			return $dur.'秒前';
		}else{
			if($dur < 3600){
				return floor($dur/60).'分钟前';
			}else{
					if($dur < 86400){
						return floor($dur/3600).'小时前';
					}else{
						if($dur < 259200){//3天内
							return floor($dur/86400).'天前';
						}else{
							return date("m-d",$show_time);
						}
					}
			}
		}
	}
}
//中介经纪人
function get_broker($userid) {
	global $MODULE, $db,$html;
	$result = DB::query("SELECT username FROM ".AJ_PRE."member where companyid='$userid'");
	while($r = DB::fetch_array($result)) {
	      
		  $username .= '"'.$r['username'].'"' . ",";
	}
	 $username = rtrim($username, ','); 

	return $username;

     }
function maplng($map,$lng){
	$map = explode(',',$map);
foreach($map as $key =>$value){
		  $lngX =$map[$lng];
		  
		   }
		   return $lngX;
	}
	
	//mobilehousepages
function mobilehousepages( $total, $page = 1 ,$lst, $perpage = 20) {
	global $AJ, $MOD, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	//$urlrule=rentser('p',$page);
	//echo $urlrule;
	$urlrule=rentser('p',1,'','',$nowurl);
	
	$urlrule = str_replace('$page',$page,$urlrule);
	$findme = '{$page}';
    $replaceme = '1';
     $demo_url = str_replace($findme,$replaceme,$urlrule);

	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);
    $demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
    $url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
    if($page >1)$pages .= '<a class="prev" href="'.rentser('p',$_page,'','',$nowurl).'"><span class="pre-page">'.$L['prev_page'].'</span></a> ';
         if($total <= 7) { $min=1; $max=$total; }
		 if($total >7) {
		if($page < 5) {$min = 1; $max = 7;}
		if($page >= 5)  { $min=$page-3; $max=$page+3; }
		if($page >= $total-3)  { $min=$total-6; $max=$total; }
		}
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
			$pages .= $page == $_page ? '<span class=" currents">'.$_page.'</span>' : ' <a href="'.rentser('p',$_page,'','',$nowurl).'"><span>'.$_page.'</span></a>  ';
		}

$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
if($page<>$total)$pages .= '<a  class="next" href="'.rentser('p',$_page,'','',$nowurl).'"><span class="next-page">'.$L['next_page'].'</span></a>';

	return $pages;
}
?>