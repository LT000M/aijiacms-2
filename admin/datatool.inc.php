<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
require AJ_ROOT.'/include/module.func.php';
$menus = array (
     array('数据备份', '?file=database'),
    array('数据恢复', '?file=database&action=import'),
    array('执行SQL', '?file=database&action=execute'),
    array('显示进程', '?file=database&action=process'),
    array('字符替换', '?file=database&action=replace'),
    array('数据导入', '?file=data&action=import'),
	array('第三方数据导入', '?file=datatool'),
    array('数据导出', '?file=data'),
);
$this_forward = '?file='.$file;
isset($name) or $name = '';
if($name && !preg_match("/^[0-9a-z_\-\.]+$/i", $name)) msg('不是一个有效的文件名');
function parse_dict($table) {
	$names = array();	
	if(is_file(AJ_ROOT.'/file/setting/'.$table.'.csv')) {
		$tmp = file_get(AJ_ROOT.'/file/setting/'.$table.'.csv');
		$arr = explode("\n", $tmp);
		foreach($arr as $v) {
			$t = explode(',', $v);
			$names[$t[0]] = $t[1];
		}
	}
	return $names;
}
switch($action) {
	case 'config':
		if($submit) {
			$data['name'] = $name;
			$data['edittime'] = timetodate($AJ_TIME, 5);
			file_put(AJ_ROOT.'/file/data/'.$data['name'].'.php', '<?php $data = '.var_export($data, true).'; ?>');
			dmsg('保存成功', '?file='.$file);
		} else {
			$title = $db_host = $db_user = $db_pass = $db_name = $db_table = $db_condition = $db_key = $db_charset = $code = $lasttime = $lastid = '';
			$database = 'mysql';
			$fields = $fields_d = $_fields = array();
			$edit = false;
			if($name) {
				@include AJ_ROOT.'/file/data/'.$name.'.php';
				$data = dstripslashes($data);
				extract($data);
				$edit = true;
				$_fields = $fields;
				$fields = array();
				$inc = AJ_ROOT.'/file/data/'.$name.'.inc.php';
				if(is_file($inc) && $code = file_get($inc)) $code = substr($code, 53, -3);
			}
			if($type == 0 && $mid == 0) msg('请选择模型');
			if($type == 2 && $tb == '') msg('请选择表');
			if($type == 0) {
				$sc_table = get_table($mid);
				$names = parse_dict(substr($sc_table, strlen($AJ_PRE)));
				$names['content'] = $MODULE[$mid]['name'].'内容';
				$fields_d['content']['name'] = $edit ? $_fields['content']['name'] : '';
				$fields_d['content']['value'] = $edit ? $_fields['content']['value'] : '';
			} else if($type == 1) {
				$sc_table = $AJ_PRE.'member';
				$result = $db->query("SHOW COLUMNS FROM `{$AJ_PRE}company`");
				while($r = $db->fetch_array($result)) {
					if(in_array($r['Field'], array('userid', 'username', 'groupid'))) continue;
					$k = $r['Field'];
					$fields_d[$k]['name'] = $edit ? $_fields[$k]['name'] : '';
					$fields_d[$k]['value'] = $edit ? $_fields[$k]['value'] : '';
				}
				$names = array_merge(parse_dict('member'), parse_dict('company'));
				$names['content'] = '公司介绍';
				$fields_d['content']['name'] = $edit ? $_fields['content']['name'] : '';
				$fields_d['content']['value'] = $edit ? $_fields['content']['value'] : '';
			} else if($type == 2) {
				$sc_table = $AJ_PRE.$tb;
				$names = parse_dict($tb);
			}
			$result = $db->query("SHOW COLUMNS FROM `$sc_table`");
			while($r = $db->fetch_array($result)) {
				$k = $r['Field'];
				$fields[$k]['name'] = $edit ? $_fields[$k]['name'] : '';
				$fields[$k]['value'] = $edit ? $_fields[$k]['value'] : '';
			}
			include tpl('data_config');
		}
	break;
	case 'download':
		if($name) file_down(AJ_ROOT.'/file/data/'.$name.'.php');
		msg();
	break;
	case 'delete':
		 if($name) {
			file_del(AJ_ROOT.'/file/data/'.$name.'.php');
			file_del(AJ_ROOT.'/file/data/'.$name.'.inc.php');
		}
		dmsg('删除成功', '?file='.$file);
	break;
	case 'view':
		$data = array();
		@include AJ_ROOT.'/file/data/'.$name.'.php';
		$data = dstripslashes($data);
		extract($data);
		if($database == 'mysqli') {
			if($db_host && $db_user && $db_name) {
				$sc = new db_mysqli;
				$sc->connect($db_host, $db_user, $db_pass, $db_name, $CFG['db_expires'], $CFG['db_charset'], $CFG['pconnect']);
			} else {
				$sc = &$db;
			}
		} else if($database == 'mssql') {
			require AJ_ROOT.'/include/db_mssql.class.php';
			$sc = new db_mssql;
			$sc->connect($db_host, $db_user, $db_pass, $db_name);
		} else if($database == 'access') {
			require AJ_ROOT.'/include/db_access.class.php';
			$sc = new db_access;
			$sc->connect(AJ_ROOT.'/'.$db_host, $db_user, $db_pass, $db_table);
		} else {
			msg('配置文件错误');
		}
		$result = $sc->query("SELECT * FROM {$db_table} WHERE $db_key>$lastid $db_condition");
		while($F = $sc->fetch_array($result)) {
			$T = array();
			if($database == 'access') {
				$_F = array();
				foreach($F as $k=>$v) {
					if(!is_numeric($k)) $_F[$k] = $v;
				}
				$F = $_F;
			}
			if($db_charset) $F = convert($F, $db_charset, AJ_CHARSET);
			foreach($fields as $k=>$v) {
				if($v['value']) {
					if(strpos($v['value'], '*') !== false || strpos($v['value'], '$') !== false) {
						$a = $v['name'] ? (isset($F[$v['name']]) ? $F[$v['name']] : '') : '';
						$tmp = str_replace('*', '$a', $v['value']);
						$b = NULL;
						eval("\$b = $tmp;");
						if($b != NULL) $T[$k] = $b;
					} else {
						$T[$k] = $v['value'];
					}
				} else if($v['name']) {
					if(isset($F[$v['name']])) $T[$k] = $F[$v['name']];
				}
			}
			@include AJ_ROOT.'/file/data/'.$name.'.inc.php';
			include tpl('data_view');
			exit;
		}
	break;
	case 'import':
		$data = array();
		@include AJ_ROOT.'/file/data/'.$name.'.php';
		$data = dstripslashes($data);
		extract($data);
		if($database == 'mysqli') {
			if($db_host && $db_user && $db_name) {
				$sc = new db_mysqli;
				$sc->connect($db_host, $db_user, $db_pass, $db_name, $CFG['db_expires'], $CFG['db_charset'], $CFG['pconnect']);
			} else {
				$sc = &$db;
			}
		} else if($database == 'mssql') {
			require AJ_ROOT.'/include/db_mssql.class.php';
			$sc = new db_mssql;
			$sc->connect($db_host, $db_user, $db_pass, $db_name);
		} else if($database == 'access') {
			require AJ_ROOT.'/include/db_access.class.php';
			$sc = new db_access;
			$sc->connect(AJ_ROOT.'/'.$db_host, $db_user, $db_pass, $db_table);
		} else {
			msg('配置文件错误');
		}
		$key = strpos($db_key, '.') !== false ? trim(substr(strrchr($db_key, '.'), 1)) : $db_key;
		if(!isset($fid)) {
			$r = $sc->get_one("SELECT min($db_key) AS fid FROM {$db_table} WHERE $db_key>$lastid $db_condition");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		if(!isset($tid)) {
			$r = $sc->get_one("SELECT max($db_key) AS tid FROM {$db_table} WHERE $db_key>$lastid $db_condition");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		isset($total) or $total = 0;
		isset($num) or $num = 3000;
		if($fid <= $tid) {
			$result = $sc->query("SELECT * FROM {$db_table} WHERE $db_key>$lastid AND $db_key>=$fid $db_condition ORDER BY $db_key LIMIT 0,$num ");
			if($sc->affected_rows($result)) {
				while($F = $sc->fetch_array($result)) {
					if($db_charset) $F = convert($F, $db_charset, AJ_CHARSET);
					$keyid = $F[$key];
					$T = array();
					foreach($fields as $k=>$v) {
						if($v['value']) {
							if(strpos($v['value'], '*') !== false || strpos($v['value'], '$') !== false) {
								$a = $v['name'] ? (isset($F[$v['name']]) ? $F[$v['name']] : '') : '';
								$tmp = str_replace('*', '$a', $v['value']);
								$b = NULL;
								eval("\$b = $tmp;");
								if($b != NULL) $T[$k] = $b;
							} else {
								$T[$k] = $v['value'];
							}
						} else if($v['name']) {
							if(isset($F[$v['name']])) $T[$k] = $F[$v['name']];
						}
					}
					@include AJ_ROOT.'/file/data/'.$name.'.inc.php';
					$T = daddslashes($T);
					if($type == 0) {
						if(isset($T['content'])) {
							$content = $T['content'];
							unset($T['content']);
						} else {
							$content = '';
						}
						$sqlk = $sqlv = '';
						foreach($T as $k=>$v) {
							$sqlk .= ','.$k; $sqlv .= ",'$v'";
						}
						$sqlk = substr($sqlk, 1);
						$sqlv = substr($sqlv, 1);
						$db->query("INSERT INTO ".get_table($mid)." ($sqlk) VALUES ($sqlv)");
						$itemid = $db->insert_id();
						$db->query("INSERT INTO ".get_table($mid, 1)." (itemid,content)  VALUES ('$itemid', '$content')");
					} else if($type == 1) {
						if(isset($T['content'])) {
							$content = $T['content'];
							unset($T['content']);
						} else {
							$content = '';
						}
						$table_member = $AJ_PRE.'member';
						$table_company = $AJ_PRE.'company';
						$table_company_data = $AJ_PRE.'company_data';
						$m = $db->get_one("SELECT userid FROM {$table_member} WHERE username='$T[username]' OR email='$T[email]'");
						if($m) continue;
						$mfs = cache_read($table_member.'.php');
						if(!$mfs) {
							$mfs = array();
							$result = $db->query("SHOW COLUMNS FROM `$table_member`");
							while($r = $db->fetch_array($result)) {
								$mfs[] = $r['Field'];
							}
							cache_write($table_member.'.php', $mfs);
						}
						$cfs = cache_read($table_company.'.php');
						if(!$cfs) {
							$cfs = array();
							$result = $db->query("SHOW COLUMNS FROM `$table_company`");
							while($r = $db->fetch_array($result)) {
								$cfs[] = $r['Field'];
							}
							cache_write($table_company.'.php', $cfs);
						}
						$sqlk = $sqlv = '';
						foreach($T as $k=>$v) {
							if(!in_array($k, $mfs)) continue;
							$sqlk .= ','.$k; $sqlv .= ",'$v'";
						}
						$sqlk = substr($sqlk, 1);
						$sqlv = substr($sqlv, 1);
						$db->query("INSERT INTO {$table_member} ($sqlk) VALUES ($sqlv)");
						$userid = $db->insert_id();
						$T['userid'] = $userid;
						$sqlk = $sqlv = '';
						foreach($T as $k=>$v) {
							if(!in_array($k, $cfs)) continue;
							$sqlk .= ','.$k; $sqlv .= ",'$v'";
						}
						$sqlk = substr($sqlk, 1);
						$sqlv = substr($sqlv, 1);
						$db->query("INSERT INTO {$table_company} ($sqlk) VALUES ($sqlv)");
						$content_table = content_table(4, $userid, is_file(AJ_CACHE.'/4.part'), $table_company_data);
						$db->query("INSERT INTO {$content_table} (userid,content)  VALUES ('$userid', '$content')");
					} else if($type == 2) {
						$sqlk = $sqlv = '';
						foreach($T as $k=>$v) {
							$sqlk .= ','.$k; $sqlv .= ",'$v'";
						}
						$sqlk = substr($sqlk, 1);
						$sqlv = substr($sqlv, 1);
						$db->query("INSERT INTO {$AJ_PRE}{$tb} ($sqlk) VALUES ($sqlv)");
					}
					$total++;
				}
				$keyid += 1;
			} else {
				$keyid = $fid + $num;
			}
		} else {
			$data = array();
			$cf = AJ_ROOT.'/file/data/'.$name.'.php';
			@include $cf;
			$data['lasttime'] = timetodate($AJ_TIME, 5);
			$data['lastid'] = $tid;
			file_put($cf, '<?php $data = '.var_export($data, true).'; ?>');
			msg('转换成功,成功导入 <strong>'.$total.'</strong> 条数据', "?file=$file", 10);
		}
		msg('ID从'.$fid.'至'.($keyid-1).'转换成功 当前已导入 <strong>'.$total.'</strong> 条数据', "?file=$file&action=$action&name=$name&fid=$keyid&tid=$tid&num=$num&total=$total");
	break;
	default:
		$files = glob(AJ_ROOT.'/file/data/*.php', GLOB_NOSORT);
		$lists = $tables = array();
		foreach($files as $f) {
			if(strpos(basename($f), '.inc.') !== false) continue;
			$data = array();
			include $f;
			$lists[] = $data;
		}
		$i = 0;
		$result = $db->query("SHOW TABLES FROM `".$CFG['db_name']."`");
		while($rr = $db->fetch_row($result)) {
			$r = $db->get_one("SHOW TABLE STATUS FROM `".$CFG['db_name']."` LIKE '".$rr[0]."'");
			if(preg_match('/^'.$AJ_PRE.'/', $rr[0])) {
				$tables[$i]['name'] = str_replace($AJ_PRE, '', $r['Name']);
				$tables[$i]['note'] = $r['Comment'];
				$i++;
			}
		}
		include tpl('datatool');
	break;
}
?>