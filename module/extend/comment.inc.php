<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
isset($MODULE[$mid]) or dheader($AJ_PC ? AJ_PATH : AJ_MOB);
$itemid or dheader($AJ_PC ? $MODULE[$mid]['linkurl'] : $MODULE[$mid]['mobile']);
in_array($mid, explode(',', $MOD['comment_module'])) or dheader($AJ_PC ? $MODULE[$mid]['linkurl'] : $MODULE[$mid]['mobile']);
if(in_array($itemid, cache_read('bancomment-'.$mid.'.php'))) dheader(AJ_PATH.'api/redirect.php?mid='.$mid.'&itemid='.$itemid);
if(in_array($MODULE[$mid]['module'], array('mall', 'club'))) dheader($AJ_PC ? AJ_PATH : AJ_MOB);
if($mid == 4) {
	$item = $db->get_one("SELECT company,linkurl,username,groupid,comments FROM ".get_table($mid)." WHERE userid=$itemid");
	$item or dheader(AJ_PATH);
	$item['groupid'] > 4 or dheader(AJ_PATH);
	$item['title'] = $item['company'];
	$linkurl = $item['linkurl'];
} else {
	$item = $db->get_one("SELECT title,linkurl,username,status,comments FROM ".get_table($mid)." WHERE itemid=$itemid");
	
}

$ext = 'comment';
$url = $EXT[$ext.'_url'];
$mob = $EXT[$ext.'_mob'];
$template = $message = $forward = '';
$username = $item['username'];
$title = $item['title'];
$could_del = false;
if($_groupid == 1) {
	if($MOD['comment_admin_del']) $could_del = true;
} else if($username && $_username == $username) {
	if($MOD['comment_user_del'] && in_array($mid, explode(',', $MOD['comment_user_del']))) $could_del = true;
}
$iframe = 0;
switch($action) {
	case 'vote':
		if(!check_group($_groupid, $MOD['comment_vote_group']) || !$MOD['comment_vote']) exit('-2');
		$cid = isset($cid) ? intval($cid) : 0;
		$cid or exit('0');
		$op = $op ? 1 : 0;
		$f = $op ? 'agree' : 'against';
		if(get_cookie('comment_vote_'.$mid.'_'.$itemid.'_'.$cid)) exit('-1');
		$db->query("UPDATE {$AJ_PRE}comment SET `{$f}`=`{$f}`+1 WHERE itemid=$cid");
		set_cookie('comment_vote_'.$mid.'_'.$itemid.'_'.$cid, 1, $AJ_TIME + 86400);
		exit('1');
	break;
	case 'count':
		if($EXT['comment_api'] == 'changyan') {
			$comments = $dc->get('comments-'.$mid.'-'.$itemid);
			if(strlen($comments) > 0) {
				echo $comments;
				exit;
			}
			$rec = dcurl('http://changyan.sohu.com/api/2/topic/load?client_id='.$EXT['comment_api_id'].'&topic_source_id='.$mid.'-'.$itemid.'&topic_url='.urlencode($linkurl));
			if(strpos($rec, 'cmt_sum') !== false) {
				$arr = json_decode($rec, true);
				$comments = intval($arr['cmt_sum']);
			} else {
				$comments = 0;
			}
			$dc->set('comments-'.$mid.'-'.$itemid, $comments, $CFG['db_expires'] ? $CFG['db_expires'] : 1800);
		} else if($EXT['comment_api'] == 'duoshuo') {
			$comments = $dc->get('comments-'.$mid.'-'.$itemid);
			if(strlen($comments) > 0) {
				echo $comments;
				exit;
			}
			$rec = dcurl('http://api.duoshuo.com/threads/counts.json?short_name='.$EXT['comment_api_id'].'&threads='.$mid.'-'.$itemid);
			if(strpos($rec, 'comments') !== false) {
				$arr = json_decode($rec, true);
				$comments = intval($arr['response'][$mid.'-'.$itemid]['comments']);
			} else {
				$comments = 0;
			}
			$dc->set('comments-'.$mid.'-'.$itemid, $comments, $CFG['db_expires'] ? $CFG['db_expires'] : 1800);
		} else {
			$condition = "item_mid=$mid AND item_id=$itemid AND status=3";
			$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}comment WHERE {$condition}", 'CACHE');
			$comments = $r['num'];
		}
		if($comments != $item['comments']) $db->query("UPDATE ".get_table($mid)." SET comments=$comments WHERE ".($mid == 4 ? 'userid' : 'itemid')."=$itemid", 'UNBUFFERED');
		echo $comments;
		exit;
	break;
	case 'delete':
		$could_del or dalert($L['comment_msg_del']);
		$cid = isset($cid) ? intval($cid) : 0;
		$cid or dalert($L['comment_msg_cid']);
		$r = $db->get_one("SELECT * FROM {$AJ_PRE}comment WHERE itemid='$cid' LIMIT 1");
		if($r) {
			$star = 'star'.$r['star'];
			$db->query("UPDATE {$AJ_PRE}comment_stat SET comment=comment-1,`{$star}`=`{$star}`-1 WHERE itemid=$r[item_id] AND moduleid=$r[item_mid]");
			$db->query("DELETE FROM {$AJ_PRE}comment WHERE itemid=$cid");
			$forward = rewrite('index.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99));
			dalert($L['comment_msg_del_success'], '', 'parent.window.location="'.$forward.'";');
		} else {
			dalert($L['comment_msg_not_comment']);
		}
	break;
	default:
		if($EXT['comment_api']) {
			//
		} else {
			if(check_group($_groupid, $MOD['comment_group'])) {
				$user_status = 3;
			} else {
				if($_userid) {
					$user_status = 1;
				} else {
					$user_status = 2;
				}
			}
			$need_captcha = $MOD['comment_captcha_add'] == 2 ? $MG['captcha'] : $MOD['comment_captcha_add'];
			if($MOD['comment_pagesize']) {
				$pagesize = $MOD['comment_pagesize'];
				$offset = ($page-1)*$pagesize;
			}
			if($submit) {
				if($user_status != 3) dalert($L['comment_msg_permission']);
				if($username && $username == $_username) dalert($L['comment_msg_self']);
				$sql = $_userid ? "username='$_username'" : "ip='$AJ_IP'";
				if($MOD['comment_limit']) {
					$today = $today_endtime - 86400;
					$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}comment WHERE $sql AND addtime>$today");
					$r['num'] < $MOD['comment_limit'] or dalert(lang($L['comment_msg_limit'], array($MOD['comment_limit'], $r['num'])));
				}
				if($MOD['comment_time']) {
					$r = $db->get_one("SELECT addtime FROM {$AJ_PRE}comment WHERE $sql ORDER BY addtime DESC");
					if($r && $AJ_TIME - $r['addtime'] < $MOD['comment_time']) dalert(lang($L['comment_msg_time'], array($MOD['comment_time'])));
				}

				if($need_captcha) {
					$msg = captcha($captcha, 1, true);
					if($msg) dalert($msg);
				}
				$content = dhtmlspecialchars(trim($content));
				$content = preg_replace("/&([a-z]{1,});/", '', $content);
				$len = word_count($content);
				if($len < $MOD['comment_min']) dalert(lang($L['comment_msg_min'], array($MOD['comment_min'])));
				if($len > $MOD['comment_max']) dalert(lang($L['comment_msg_max'], array($MOD['comment_max'])));
				$BANWORD = cache_read('banword.php');
				if($BANWORD) $content = banword($BANWORD, $content, false);
				$star = intval($star);
				in_array($star, array(1, 2, 3)) or $star = 3;
				$status = get_status(3, $MOD['comment_check'] == 2 ? $MG['check'] : $MOD['comment_check']);
				$hidden = isset($hidden) ? 1 : 0;
				$title = addslashes($title);
				$content = nl2br($content);
				$quotation = '';
				$qid = isset($qid) ? intval($qid) : 0;
				if($qid) {
					$r = $db->get_one("SELECT ip,hidden,username,passport,content,quotation,addtime FROM {$AJ_PRE}comment WHERE itemid=$qid");
					if($r) {
						if($r['username']) {
							$r['name'] = $r['hidden'] ? $MOD['comment_am'] : $r['passport'];
						} else {
							$r['name'] = 'IP:'.hide_ip($r['ip']);
						}
						$r['addtime'] = timetodate($r['addtime'], 6);
						if($r['quotation']) $r['content'] = $r['quotation'];
						$floor = substr_count($r['content'],'quote_content') + 1;
						if($floor == 1) {
							$quotation = addslashes('<div class="quote"><div class="quote_title"><span class="quote_floor">'.$floor.'</span>'.$r['name'].' '.$L['comment_quote_at'].' <span class="quote_time">'.$r['addtime'].'</span> '.$L['comment_quote_or'].'</div><div class="quote_content">'.$r['content'].'</div><!----></div>').$content;
						} else {
							$quotation = str_replace('<!----></div>', '</div><div class="quote_title"><span class="quote_floor">'.$floor.'</span>'.$r['name'].' '.$L['comment_quote_at'].' <span class="quote_time">'.$r['addtime'].'</span> '.$L['comment_quote_or'].'</div><div class="quote_content">', $r['content']);
							$quotation = '<div class="quote">'.$quotation.'</div><!----></div>';
							$quotation = addslashes($quotation).$content;
						}
					}
					$db->query("UPDATE {$AJ_PRE}comment SET quote=quote+1 WHERE itemid=$qid");
				}
				$db->query("INSERT INTO {$AJ_PRE}comment (item_mid,item_id,item_title,item_username,content,quotation,qid,addtime,username,passport,hidden,star,ip,status) VALUES ('$mid','$itemid','$title','$username','$content','$quotation','$qid','$AJ_TIME','$_username','$_passport','$hidden','$star','$AJ_IP','$status')");
				$cid = $db->insert_id();
				$r = $db->get_one("SELECT sid FROM {$AJ_PRE}comment_stat WHERE moduleid=$mid AND itemid=$itemid");
				$star = 'star'.$star;
				if($r) {
					$db->query("UPDATE {$AJ_PRE}comment_stat SET comment=comment+1,`{$star}`=`{$star}`+1 WHERE sid=$r[sid]");
				} else {
					$db->query("INSERT INTO {$AJ_PRE}comment_stat (moduleid,itemid,{$star},comment) VALUES ('$mid','$itemid','1','1')");
				}
				if($status == 3) {
					if($_username && $MOD['credit_add_comment']) {
						credit_add($_username, $MOD['credit_add_comment']);
						credit_record($_username, $MOD['credit_add_comment'], 'system', $L['comment_record_add'], 'ID:'.$cid);
					}
					$items = isset($items) ? intval($items)+1 : 1;
					$page = ceil($items/$pagesize);
					$forward = rewrite('index.php?mid='.$mid.'&itemid='.$itemid.'&page='.$page.'&rand='.mt_rand(10, 99)).'#last';
					dalert('', '', 'parent.window.location="'.$forward.'";');
				} else {
					dalert($L['comment_check'], '', 'parent.window.location=parent.window.location;');
				}
			} else {
				$lists = array();
				$pages = '';
				$r = $db->get_one("SELECT COUNT(*) AS num FROM {$AJ_PRE}comment WHERE item_mid=$mid AND item_id=$itemid AND status=3");
				$items = $r['num'];
				if($items != $item['comments']) $db->query("UPDATE ".get_table($mid)." SET comments=$items WHERE ".($mid == 4 ? 'userid' : 'itemid')."=$itemid", 'UNBUFFERED');
				$pages = pages($items, $page, $pagesize);
				$result = $db->query("SELECT * FROM {$AJ_PRE}comment WHERE item_mid=$mid AND item_id=$itemid AND status=3 ORDER BY itemid ASC LIMIT $offset,$pagesize");
				$floor = $page == 1 ? 0 : ($page-1)*$pagesize;
				while($r = $db->fetch_array($result)) {
					$r['floor'] = ++$floor;
					$r['addtime'] = timetodate($r['addtime'], 5);
					$r['replytime'] = $r['replytime'] ? timetodate($r['replytime'], 5) : '';
					if($r['username']) {
						$r['name'] = $r['hidden'] ? $MOD['comment_am'] : $r['passport'];
						$r['uname'] = $r['hidden'] ? '' : $r['username'];
					} else {
						$r['name'] = $MOD['comment_am'];
						$r['uname'] = '';
					}
					if(strpos($r['content'], ')') !== false) $r['content'] = parse_face($r['content']);
					if(strpos($r['quotation'], ')') !== false) $r['quotation'] = parse_face($r['quotation']);
					$lists[] = $r;
				}
				$stat = $r = $db->get_one("SELECT * FROM {$AJ_PRE}comment_stat WHERE moduleid=$mid AND itemid=$itemid");
				if($stat && $stat['comment']) {
					$stat['pc1'] = dround($stat['star1']*100/$stat['comment'], 2, true).'%';
					$stat['pc2'] = dround($stat['star2']*100/$stat['comment'], 2, true).'%';
					$stat['pc3'] = dround($stat['star3']*100/$stat['comment'], 2, true).'%';
				} else {
					$stat['star1'] = $stat['star2'] = $stat['star3'] = 0;
					$stat['pc1'] = $stat['pc2'] = $stat['pc3'] = '0%';
				}
				$faces = array();
				$face = glob(AJ_ROOT.'/file/face/*.gif');
				if($face) {
					foreach($face as $k=>$v) {
						$faces[$k] = basename($v, '.gif');
					}
				}
			}
		}
		$moduleid = $mid;
		$head_title = $title.$L['comment_title'].$AJ['seo_delimiter'].$MODULE[$mid]['name'];
	break;
}
$template = $ext;
if($AJ_PC) {
	$CSS = array('comment');
	$aijiacms_task = rand_task();
	if($EXT['mobile_enable']) $head_mobile = str_replace($url, $mob, $AJ_URL);
} else {
	$foot = '';
	$pages = mobile_pages($items, $page, $pagesize);
	$back_link = $linkurl;
}
include template($template, $module);
?>