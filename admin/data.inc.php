<?php

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
isset($table) or $table = '';
if($table) $table = strip_sql($table, 0);
isset($name) or $name = '';
if($name && !preg_match("/^[0-9a-z_\-\.]+$/i", $name)) msg('不是一个有效的文件名');
function table_get_key($table) {
	$key = '';
	if($table) {
		$result = DB::query("SHOW COLUMNS FROM `$table`");
		while($r = DB::fetch_array($result)) {
			if($r['Key'] == 'PRI' && stripos($r['Type'], 'int') !== false) {
				$key = $r['Field'];
				break;
			}
		}
	}
	return $key;
}
function parse_dict($table) {
	if(strpos($table, AJ_PRE) === false) {
		$rtable = $table;
	} else {
		$rtable = substr($table, strlen(AJ_PRE));
		$rtable = preg_replace("/_[0-9]{1,}/", '', $rtable);
	}
	$names = array();	
	if(is_file(AJ_ROOT.'/file/setting/'.$rtable.'.csv')) {
		$tmp = file_get(AJ_ROOT.'/file/setting/'.$rtable.'.csv');
		$arr = explode("\n", $tmp);
		foreach($arr as $v) {
			$t = explode(',', $v);
			$names[$t[0]] = $t[1];
		}
	}
	return $names;
}
switch($action) {
	case 'move':
		if($submit) {
			($fmid > 0 && $tmid > 0 && $fmid != $tmid) or msg('来源模块或目标模块设置错误');
			$catid or msg('请选择新分类');
			$condition = str_replace('and', 'AND', trim($condition));
			if($condition) $condition = strpos($condition, 'AND') === false ? "itemid IN ($condition)" : substr($condition, 3);
			$post = array();
			$post['fmid'] = $fmid;
			$post['tmid'] = $tmid;
			$post['condition'] = $condition;
			$post['catid'] = $catid;
			$post['delete'] = $delete;
			$post = dstripslashes($post);
			cache_write('table-move-'.$_userid.'.php', $post);
			msg('正在开始转移', '?file='.$file.'&action=move_table');
		} else {
			include tpl('data_move');
		}
	break;
	case 'move_table':
		$post = cache_read('table-move-'.$_userid.'.php');
		$post or msg('数据配置不存在', '?file='.$file.'&action=move');
		$fmid = $post['fmid'];
		$tmid = $post['tmid'];
		$ftb = get_table($fmid);
		$ftb_data = get_table($fmid, 1);
		$ttb = get_table($tmid);
		$ttb_data = get_table($tmid, 1);
		$table = $ftb;
		$id = 'itemid';
		$condition = $post['condition'];
		$delete = $post['delete'];
		isset($num) or $num = 1000;
		if(!isset($fid)) {
			$r = $db->get_one("SELECT min({$id}) AS fid FROM {$table}");
			$fid = $r['fid'] ? $r['fid'] : 0;
		}
		if(!isset($tid)) {
			$r = $db->get_one("SELECT max({$id}) AS tid FROM {$table}");
			$tid = $r['tid'] ? $r['tid'] : 0;
		}
		isset($$id) or $$id = 1;
		$fs = array();
		$result = $db->query("SHOW COLUMNS FROM `$ttb`");
		while($r = $db->fetch_array($result)) {
			$fs[] = $r['Field'];
		}
		if($fid <= $tid) {
			$result = $db->query("SELECT * FROM {$table} WHERE `{$id}`>=$fid {$condition} ORDER BY `{$id}` LIMIT 0,$num");
			if($db->affected_rows($result)) {
				while($r = $db->fetch_array($result)) {
					$$id = $fitemid = $r[$id];
					unset($r[$id]);
					$r['catid'] = $catid;
					$r = daddslashes($r);
					if(is_file(AJ_CACHE.'/'.$fmid.'.part')) $ftb_data = split_table($fmid, $fitemid);
					$t = $db->get_one("SELECT content FROM {$ftb_data} WHERE itemid=$fitemid");
					$content = daddslashes($t['content']);			
					$sqlk = $sqlv = '';
					foreach($r as $k=>$v) {
						if($fs && !in_array($k, $fs)) continue;
						$sqlk .= ','.$k; $sqlv .= ",'$v'";
					}
					$sqlk = substr($sqlk, 1);
					$sqlv = substr($sqlv, 1);
					$db->query("INSERT INTO {$ttb} ($sqlk) VALUES ($sqlv)");
					$titemid = $db->insert_id();
					if(is_file(AJ_CACHE.'/'.$tmid.'.part')) $ttb_data = split_table($tmid, $titemid);
					$db->query("INSERT INTO {$ttb_data} (itemid,content)  VALUES ('$titemid','$content')");
					$linkurl = str_replace($fitemid, $titemid, $r['linkurl']);
					$db->query("UPDATE {$ttb} SET linkurl='$linkurl' WHERE itemid=$titemid");
					if($delete) {
						$db->query("UPDATE {$ftb} SET status=0 WHERE itemid=$fitemid");
						$html = AJ_ROOT.'/'.$MODULE[$fmid]['moduledir'].'/'.$r['linkurl'];
						if(is_file($html)) @unlink($html);
					}
				}
				$$id += 1;
			} else {
				$$id = $fid + $num;
			}
		} else {
			cache_delete('table-move-'.$_userid.'.php');
			msg('转移成功', '?file='.$file.'&action=move');
		}
		msg('ID '.$fid.'~'.($$id-1).'转移成功', '?file='.$file.'&action='.$action.'&fid='.$$id.'&tid='.$tid.'&num='.$num);
	break;
	/*
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
	case 'xdownload':
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
		if($database == 'mysql') {
			if($db_host && $db_user && $db_name) {
				$sc = new db_mysql;
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
	case 'ximport':
		$data = array();
		@include AJ_ROOT.'/file/data/'.$name.'.php';
		$data = dstripslashes($data);
		extract($data);
		if($database == 'mysql') {
			if($db_host && $db_user && $db_name) {
				$sc = new db_mysql;
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
		isset($num) or $num = 500;
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
	*/
	case 'save':
		$table or msg('请选择导入目标表');
		$name or msg('数据文件不存在');
		$xlsfile = AJ_ROOT.'/file/temp/'.$name.'.xls';
		is_file($xlsfile) or msg('数据文件不存在');
		function table_get_fields($table) {
			$arr = array();
			$result = DB::query("SHOW COLUMNS FROM `{$table}`");
			while($r = DB::fetch_array($result)) {
				$arr[] = $r['Field'];
			}
			return $arr;
		}
		function table_get_query($fields, $arr) {
			$sqlk = $sqlv = '';
			foreach($arr as $k=>$v) {
				if(!in_array($k, $fields)) continue;
				$sqlk .= ',`'.$k.'`'; $sqlv .= ",'$v'";
			}
			if($sqlk) $sqlk = substr($sqlk, 1);
			if($sqlv) $sqlv = substr($sqlv, 1);
			return array($sqlk, $sqlv);
		}
		function data_get_name($fields, $lists) {
			$arr = array();
			foreach($fields as $k=>$v) {
				if(isset($lists[$k])) {
					if(strpos($v, 'time') === false) {
						$arr[$v] = convert($lists[$k], 'GBK', 'UTF-8');
					} else {
						$arr[$v] = is_numeric($lists[$k]) ? $lists[$k] : datetotime($lists[$k]);
					}
				}
			}
			return $arr;
		}
		$type = 'table';
		$tb = cutstr($table, AJ_PRE);
		$table_data = '';
		if($tb == 'member') {
			$type = 'member';
			$split = is_file(AJ_CACHE.'/4.part') ? 1 : 0;
			$table_member_misc = AJ_PRE.'member_misc';
			$fields_member_misc = table_get_fields($table_member_misc);
			$table_company = AJ_PRE.'company';
			$fields_company = table_get_fields($table_company);
			$table_data = AJ_PRE.'company_data';
			$fields_data = table_get_fields($table_data);
		} else if(substr_count($tb, '_') == 1) {
			list($mod, $mid) = explode('_', $tb);
			if(is_numeric($mid) && isset($MODULE[$mid]) && $MODULE[$mid]['module'] == $mod) {
				$type = 'module';
				$split = is_file(AJ_CACHE.'/'.$mid.'.part') ? 1 : 0;
				$table_data = get_table($mid, 1);
				$fields_data = table_get_fields($table_data);
			}
		}
		if($type == 'table') {
			if($tb == 'news' || $tb == 'page') $table_data = $table.'_data';
			if(strpos($tb, 'resume_') !== false && strpos($tb, 'resume_data_') === false) $table_data = str_replace('resume_', 'resume_data_', $table);
			if($table_data) $fields_data = table_get_fields($table_data);
		}
		require AJ_ROOT.'/api/excel/loader.inc.php';
		$xls = new ExcelParser(AJ_ROOT.'/file/temp/'.$name.'.xls');
		$arr = $xls->main();
		isset($arr[1][0]) or msg('未读取到有效数据');
		$lists = $arr[1][0];
		$names = $lists[1];
		$j = 0;
		$fields = table_get_fields($table);
		for($i = 2; $i < 12; $i++) {
			if(isset($lists[$i]) && $lists[$i]) {
				$data = data_get_name($names, $lists[$i]);
				list($sqlk, $sqlv) = table_get_query($fields, $data);
				if($sqlk && $sqlv) {
					$db->query("INSERT INTO {$table} ($sqlk) VALUES ($sqlv)");
					$id = $db->insert_id();
					if($id) {
						$j++;
						if($type == 'table') {							
							if($table_data) {
								$data['itemid'] = $id;
								list($sqlk, $sqlv) = table_get_query($fields_data, $data);
								if($sqlk && $sqlv) $db->query("INSERT INTO {$table_data} ($sqlk) VALUES ($sqlv)");
							}
						} else if($type == 'member') {
							$data['userid'] = $id;

							list($sqlk, $sqlv) = table_get_query($fields_member_misc, $data);
							if($sqlk && $sqlv) $db->query("INSERT INTO {$table_member_misc} ($sqlk) VALUES ($sqlv)");

							list($sqlk, $sqlv) = table_get_query($fields_company, $data);
							if($sqlk && $sqlv) $db->query("INSERT INTO {$table_company} ($sqlk) VALUES ($sqlv)");

							list($sqlk, $sqlv) = table_get_query($fields_data, $data);
							if($sqlk && $sqlv) {
								$tb_data = content_table(4, $id, $split, $table_data);
								$db->query("INSERT INTO {$tb_data} ($sqlk) VALUES ($sqlv)");
							}
						} else if($type == 'module') {
							$data['itemid'] = $id;
							list($sqlk, $sqlv) = table_get_query($fields_data, $data);
							if($sqlk && $sqlv) {
								$tb_data = content_table($mid, $id, $split, $table_data);
								$db->query("INSERT INTO {$tb_data} ($sqlk) VALUES ($sqlv)");
							}
						}
					}
				}
			}
		}
		file_del($xlsfile);
		msg('成功导入'.$j.'条数据', '?file='.$file.'&action=import');
	break;
	case 'upload':
		$table or msg('请选择导入目标表');
		$_FILES['uploadfile']['size'] or msg('请上传xls数据文件');
		require AJ_ROOT.'/include/upload.class.php';
		$name = date('YmdHis').mt_rand(10, 99).$_userid;
		$upload = new upload($_FILES, 'file/temp/', $name.'.xls', 'xls');
		$upload->adduserid = false;
		if($upload->save()) {
			require AJ_ROOT.'/api/excel/loader.inc.php';
			$xls = new ExcelParser(AJ_ROOT.'/file/temp/'.$name.'.xls');
			$arr = $xls->main();
			isset($arr[1][0]) or msg('未读取到有效数据');
			$lists = $arr[1][0];
			$T = $D = array();
			$T = $lists[0];
			for($i = 1; $i < 12; $i++) {
				if(isset($lists[$i]) && $lists[$i]) $D[] = $lists[$i];
			}
			$t1 = count($lists) - 2;
			$t2 = count($D) - 1;
			include tpl('data_view');
		} else {
			msg($upload->errmsg);
		}
	break;
	case 'import':
		$tables = array();
		$i = 0;
		$result = $db->query("SHOW TABLE STATUS FROM `".$CFG['db_name']."`");
		while($r = $db->fetch_array($result)) {
			if(preg_match('/^'.$AJ_PRE.'/', $r['Name'])) {
				$tables[$i]['name'] = $r['Name'];
				$tables[$i]['note'] = $r['Comment'];
				$i++;
			}
		}
		include tpl('data_import');
	break;
	case 'fields':
		$table or exit;
		$N = parse_dict($table);
		$fields_select = '';
		$result = $db->query("SHOW COLUMNS FROM `$table`");
		while($r = $db->fetch_array($result)) {
			$fields_select .= '<option value="'.$r['Field'].'">'.$r['Field'].(isset($N[$r['Field']]) ? ' ('.$N[$r['Field']].')' : '').'</option>';
		}
		$select = '<select name="fields[]" id="fd" multiple="multiple" size="2" style="height:500px;width:300px;"><option value="">选择字段(按Ctrl多选)</option>'.$fields_select.'</select>';
		$key = table_get_key($table);
		$order = $key ? $key.' DESC' : '';
		exit(json_encode(array('select' => $select, 'order' => $order)));
	break;
	case 'pages':
		$psize > 0 or $psize = 5000;
		$total = $db->count($table, '1 '.$condition);
		$page = ceil(intval($total)/$psize);
		exit('{"page":"'.$page.'","total":"'.$total.'","ok":"1"}');
	break;
	case 'download':
		$table or msg('请选择数据表');
		$ismember = strpos($table, 'member') === false ? 0 : 1;
		isset($fields) or $fields = array();
		$fields = $fields ? implode(',', $fields) : '*';
		$condition = '1 '.$condition;
		if(strpos($condition, AJ_PRE) !== false) $condition = '1';
		if($ismember) $condition .= ' AND groupid>1';
		if(!$order) {
			$key = table_get_key($table);
			if($key) $order = $key.' DESC';
		}
		$order = $order ? 'ORDER BY '.$order : '';
		in_array($ext, array('csv', 'xml', 'json')) or $ext = 'csv';
		$data = '';
		$lists = $list = array();
		$result = $db->query("SELECT {$fields} FROM {$table} WHERE {$condition} {$order} LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			if($ismember) {
				foreach(array('password', 'passsalt', 'payword', 'paysalt') as $v) {
					if(isset($r[$v])) unset($r[$v]);
				}
			}
			if(!$data) $list = $r;
			if($ext == 'csv') {
				foreach($r as $k=>$v) {
					if(strpos($k, 'time') !== false) $v = timetodate($v, 6);
					$data .= '"'.$v.'",';
				}
				$data .= "\n";
			} else if($ext == 'xml') {
				$data .= "\t".'<item>'."\n";
				foreach($r as $k=>$v) {
					if(strpos($k, 'time') !== false) $v = timetodate($v, 6);
					if(strpos($v, '<') !== false || strpos($v, "\n") !== false) {
						$data .= "\t\t".'<'.$k.'><![CDATA['.$v.']]></'.$k.'>'."\n";
					} else {
						$data .= "\t\t".'<'.$k.'>'.$v.'</'.$k.'>'."\n";
					}
				}
				$data .= "\t".'</item>'."\n";
			} else {
				$data = 'json';
				foreach($r as $k=>$v) {
					if(strpos($k, 'time') !== false) $r[$k] = timetodate($v, 6);
				}
				$lists[] = $r;
			}
		}
		if($list) {
			if($ext == 'csv') {
				$N = parse_dict($table);
				$T = '';
				foreach($list as $k=>$v) {
					$T .= '"'.(isset($N[$k]) ? $N[$k] : $k).'",';
				}
				$T .= "\n";
				foreach($list as $k=>$v) {
					$T .= '"'.$k.'",';
				}
				$data = $T."\n".$data;
				$data = convert($data, AJ_CHARSET, 'GBK');
			} else if($ext == 'xml') {
				$N = parse_dict($table);
				$T = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
				$T .= '<'.$table.'>'."\n";
				$T .= "\t".'<item>'."\n";
				foreach($list as $k=>$v) {
					$T .= "\t\t".'<'.$k.'>'.(isset($N[$k]) ? $N[$k] : $k).'</'.$k.'>'."\n";
				}
				$T .= "\t".'</item>'."\n";
				$data = $T.$data;
				$data .= '</'.$table.'>'."\n";
				$data .= '</xml>';
			} else {
				$data = json_encode($lists);
			}
		}
		if($data) file_down('', $table.'_'.$page.'.'.$ext, $data);
		msg('没有符合条件的数据');
	break;
	default:
		$table_select = '';
		$tables = array();
		$result = $db->query("SHOW TABLE STATUS FROM `".$CFG['db_name']."`");
		while($r = $db->fetch_array($result)) {
			$table = $r['Name'];
			if(preg_match("/^".$AJ_PRE."/i", $table)) {
				$table_select .= '<option value="'.$table.'">'.$table.' ('.$r['Comment'].')</option>';
				$tables[] = $table;
			}
		}
		include tpl('data');
	break;
}
?>