<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
$AJ['im_web'] or dheader('index.php');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$chatid = (isset($chatid) && is_md5($chatid)) ? $chatid : '';
$table = $AJ_PRE.'chat';
$chat_poll = intval($MOD['chat_poll']);
function emoji_encode($str){
    $string = '';
    $length = mb_strlen($str, AJ_CHARSET);
    for($i = 0; $i < $length; $i++) {
        $tmp = mb_substr($str, $i, 1, AJ_CHARSET);    
        if(strlen($tmp) >= 4) {
            $string .= '[emoji]'.rawurlencode($tmp).'[/emoji]';
        } else {
            $string .= $tmp;
        }
    }
    return $string;
}

switch($action) {
	case 'send':		
		$chatid or exit('ko');
		trim($word) or exit('ko');
		if($MOD['chat_maxlen'] && strlen($word) > $MOD['chat_maxlen']*3) exit('max');
		$word = stripslashes(trim($word));
		$word = strip_tags($word);
		$word = dsafe($word);
		$word = nl2br($word);
		$word = strip_nr($word);
		if(!$AJ_PC) $word = emoji_encode($word);
		$word = str_replace('|', ' ', $word);
		if($MOD['chat_file'] && $MG['upload']) clear_upload($word, $_userid, $table);
		$chat = $db->get_one("SELECT * FROM {$table} WHERE chatid='$chatid'");
		if($chat) {
			$lastmsg = strip_tags($word);
			if(!$AJ_PC) $lastmsg = preg_replace('/\[emoji\](.+?)\[\/emoji\]/', "(:emoji:)", $lastmsg);
			$lastmsg = dsubstr($lastmsg, 50);
			$lastmsg = addslashes($lastmsg);
			if($chat['touser'] == $_username) {
				$sql = "fgettime=$AJ_TIME,lasttime=$AJ_TIME,lastmsg='$lastmsg'";
				if($AJ_TIME - $chat['freadtime'] > $chat_poll) {
					$db->query("UPDATE {$AJ_PRE}member SET chat=chat+1 WHERE username='$chat[fromuser]'");
					$sql .= ",fnew=fnew+1";
				}
				$tonick = $_cid ? $_child['nickname'] : '';
				$sql .= ",tonick='$tonick'";
				$db->query("UPDATE {$table} SET {$sql} WHERE chatid='$chatid'");
			} else if($chat['fromuser'] == $_username) {
				$sql = "tgettime=$AJ_TIME,lasttime=$AJ_TIME,lastmsg='$lastmsg'";
				if($AJ_TIME - $chat['treadtime'] > $chat_poll) {
					$db->query("UPDATE {$AJ_PRE}member SET chat=chat+1 WHERE username='$chat[touser]'");
					$sql .= ",tnew=tnew+1";
				}
				$fromnick = $_cid ? $_child['nickname'] : '';
				$sql .= ",fromnick='$fromnick'";
				$db->query("UPDATE {$table} SET {$sql} WHERE chatid='$chatid'");
			} else {
				exit('ko');
			}
		} else {
			exit('ko');
		}
		$font_s = $font_s ? intval($font_s) : 0;
		$font_c = $font_c ? intval($font_c) : 0;
		$font_b = $font_b ? 1 : 0;
		$font_i = $font_i ? 1 : 0;
		$font_u = $font_u ? 1 : 0;
		$css = '';
		if($font_s) $css .= ' s'.$font_s;
		if($font_c) $css .= ' c'.$font_c;
		if($font_b) $css .= ' fb';
		if($font_i) $css .= ' fi';
		if($font_u) $css .= ' fu';
		if($css) $word = '<span class="'.trim($css).'">'.$word.'</span>';
		if($word) {
			$content = addslashes($word);
			$nickname = $_cid ? addslashes($_child['nickname']) : '';
			$db->query("INSERT INTO ".get_chat_tb($chatid)." (chatid,username,nickname,addtime,content) VALUES ('$chatid','$_username','$nickname','$AJ_TIME','$content')");
			exit('ok');
		}
		exit('ko');
	break;
	case 'load':
		$chatid or exit;
		$tb = get_chat_tb($chatid);
		$chat_nick = '';
		$chat = $db->get_one("SELECT * FROM {$table} WHERE chatid='$chatid'");
		if($chat) {
			if($chat['touser'] == $_username) {
				$chat_nick = $chat['fromnick'];
				$db->query("UPDATE {$table} SET treadtime=$AJ_TIME,tnew=0 WHERE chatid='$chatid'");
			} else if($chat['fromuser'] == $_username) {
				$chat_nick = $chat['tonick'];
				$db->query("UPDATE {$table} SET freadtime=$AJ_TIME,fnew=0 WHERE chatid='$chatid'");
				if($AJ_TIME - $chat['lasttime'] > 86400*7) {
					$r = $db->get_one("SELECT reply FROM {$AJ_PRE}member_misc WHERE username='$chat[touser]'");
					if($r['reply']) {
						$content = addslashes(nl2br($r['reply']));
						$time = $AJ_TIME + 10;
						$db->query("INSERT INTO {$tb} (chatid,username,addtime,content) VALUES ('$chatid','$chat[touser]','$time','$content')");
						$db->query("UPDATE {$table} SET lasttime=$time WHERE chatid='$chatid'");
					}
				}
			} else {
				exit('0');
			}
		} else {
			exit('0');
		}
		$chatlast = $_chatlast = isset($chatlast) ? intval($chatlast) : 0;
		$first = isset($first) ? intval($first) : 0;
		$i = $j = 0;
		$chat_lastuser = '';
		$chat_repeat = 0;
		$json = '';
		$time1 = 0;
		if($chatlast < 1 || $chat['lasttime'] > $chatlast) {
			if($chatlast < 1) {				
				$result = $db->query("SELECT addtime FROM {$tb} WHERE chatid='$chatid' ORDER BY addtime DESC LIMIT $pagesize");
				while($r = $db->fetch_array($result)) {
					$chatlast = $r['addtime'];
				}
				if($chatlast > 1) $chatlast--;
			}
			$result = $db->query("SELECT itemid,addtime,username,nickname,content FROM {$tb} WHERE chatid='$chatid' AND addtime>$chatlast ORDER BY addtime ASC LIMIT $pagesize");
			while($r = $db->fetch_array($result)) {
				$id = $r['itemid'];
				$time = $r['addtime'];
				$name = $r['username'];
				$word = $r['content'];
				if($_username == $name) { $chat_repeat++; } else { $chat_repeat = 0; }
				$chat_lastuser = $name;
				$chatlast = $time;
				$time2 = $time;
				if($time2 - $time1 < 600) {
					$date = '';
				} else {
					$date = timetodate($time2, 5);
					$time1 = $time2;
				}
				if($MOD['chat_url'] || $MOD['chat_img']) {
					if(preg_match_all("/([http|https]+)\:\/\/([a-z0-9\/\-\_\.\,\?\&\#\=\%\+\;]{4,})/i", $word, $m)) {
						foreach($m[0] as $u) {
							if($MOD['chat_img'] && preg_match("/^(jpg|jpeg|gif|png|bmp)$/i", file_ext($u)) && !preg_match("/([\?\&\=]{1,})/i", $u)) {
								$word = str_replace($u, '<img src="'.$u.'" onload="if(this.width>320)this.width=320;" onclick="'.($AJ_PC ? 'window.open(this.src)' : 'chat_view(this.src)').';"/>', $word);
							} else if($MOD['chat_img'] && preg_match("/^(mp4)$/i", file_ext($u)) && !preg_match("/([\?\&\=]{1,})/i", $u)) {
								$word = str_replace($u, '<video src="'.$u.'" width="320" height="180" controls="controls"></video>', $word);
							} else if($MOD['chat_url']) {
								$word = str_replace($u, '<a href="'.$u.'" target="_blank">'.$u.'</a>', $word);
							}
						}
					}
				}				
				if(strpos($word, ')') !== false) $word = parse_face($word);
				if(strpos($word, '[emoji]') !== false) $word = emoji_decode($word);
				$word = str_replace(array('"', "\r", "\n"), array('\"', "\\r", "\\n"), $word);
				$self = $_username == $name ? 1 : 0;
				if($self) {
					//$name = 'Me';
				} else {
					$j++;
				}
				$json .= ($i ? ',' : '').'{id:"'.$id.'",time:"'.$time.'",date:"'.$date.'",name:"'.$name.'",word:"'.$word.'",self:"'.$self.'"}';
				$i = 1;
			}
		}
		if($_chatlast == 0) $j = 0;
		$json = '{chat_msg:['.$json.'],chat_new:"'.$j.'",chat_last:"'.$chatlast.'",chat_nick:"'.$chat_nick.'"}';
		exit($json);
	break;
	case 'down':
		if($data && check_name($username) && is_md5($chatid)) {
			$chat = $db->get_one("SELECT * FROM {$table} WHERE chatid='$chatid'");
			if($chat['fromuser'] == $_username) {
				$chat['touser'] == $username or exit;
			} else {
				$chat['fromuser'] == $username or exit;
			}
			$data = stripslashes(dsafe($data));
			$css = file_get('image/chat.css');
			$css = str_replace('#chat {width:auto;height:366px;overflow:auto;', '#chat {width:700px;margin:auto;', $css);
			$css = str_replace('margin:100px 0 0 0;', 'margin:0;', $css);
			$css = str_replace("url('", "url('".$MOD['linkurl']."image/", $css);
			$data = str_replace('<i></i>', '', $data);
			$data = '<!DOCTYPE html><html><head><meta charset="'.AJ_CHARSET.'"/><title>'.lang($L['chat_record'], array($username)).'</title><style type="text/css">'.$css.'</style><base href="'.$MOD['linkurl'].'"/></head><body><div id="chat">'.$data.'</div></body></html>';
			file_down('', 'chat-'.$username.'-'.timetodate($AJ_TIME, 'YmdHi').'.html', $data);
		}
		exit;
	break;
	default:
		$item = array();
		if(isset($touser) && check_name($touser)) {
			if($touser == $_username) dalert($L['chat_msg_self'], 'im.php');
			$MG['chat'] or dalert($L['chat_msg_no_rights'], 'grade.php');
			$user = userinfo($touser);
			$user or dalert($L['chat_msg_user'], 'im.php');
			$chatid = get_chat_id($_username, $touser);
			$chat_id = $chatid;
			if($user['black']) {
				$black = explode(' ', $user['black']);
				if(in_array($_username, $black)) {
					$db->query("DELETE FROM {$table} WHERE chatid='$chatid'");
					dalert($L['chat_msg_refuse'], 'im.php');
				}
			}
			$online = online($user['userid']);
			$head_title = lang($L['chat_with'], array($user['company']));
			$forward = is_url($forward) ? addslashes(dhtmlspecialchars($forward)) : '';
			if(strpos($forward, $MOD['linkurl']) !== false) $forward = '';
			$chat = $db->get_one("SELECT * FROM {$table} WHERE chatid='$chatid'");
			if($chat) {
				$db->query("UPDATE {$table} SET forward='$forward' WHERE chatid='$chatid'");
			} else {
				$db->query("INSERT INTO {$table} (chatid,fromuser,touser,tgettime,forward) VALUES ('$chat_id','$_username','$touser','0','$forward')");
			}
			$type = 1;
			if($mid > 4 && $itemid) {
				$r = DB::get_one("SELECT * FROM ".get_table($mid)." WHERE itemid=$itemid");
				if($r && $r['status'] > 2 && $touser==$r['username']) {
					if(strpos($r['linkurl'], '://') == false) $r['linkurl'] = $MODULE[$mid]['linkurl'].$r['linkurl'];
					$item = $r;
				}
			}
		} else if(isset($chatid) && is_md5($chatid)) {
			$chat = $db->get_one("SELECT * FROM {$table} WHERE chatid='$chatid'");
			if($chat && ($chat['touser'] == $_username || $chat['fromuser'] == $_username)) {
				if($chat['touser'] == $_username) {
					$user = userinfo($chat['fromuser']);
				} else if($chat['fromuser'] == $_username) {
					$user = userinfo($chat['touser']);
				}
				if($user['black']) {
					$black = explode(' ', $user['black']);
					if(in_array($_username, $black)) {						
						$db->query("DELETE FROM {$table} WHERE chatid='$chatid'");
						dalert($L['chat_msg_refuse'], 'im.php');
					}
				}
				$online = online($user['userid']);
				$chat_id = $chatid;
				$head_title = lang($L['chat_with'], array($user['company']));
			} else {
				dheader('im.php');
			}
			$type = 2;
		} else {
			dheader('im.php');
		}
		$faces = get_face();
	break;
}
if($AJ_PC) {
	//
} else {
	$js_pull = 0;
	$head_name = $head_title;	
	if($sns_app) $seo_title = $L['chat_title'];
}
include template('chat', $module);
?>