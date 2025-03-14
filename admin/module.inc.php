<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
    array('添加模块', '?file='.$file.'&action=add'),
    array('模块管理', '?file='.$file),
    array('系统模型', '?file='.$file.'&action=sys'),
    array('更新缓存', '?file='.$file.'&action=cache'),
);
require AJ_ROOT.'/include/sql.func.php';
$this_forward = '?update=1&file='.$file;
$modid = isset($modid) ? intval($modid) : 0;
function get_modules() {
	$moduledirs = glob(AJ_ROOT.'/module/*');
	$sysmodules = array();
	foreach($moduledirs as $k=>$v) {
		if(is_file($v.'/admin/config.inc.php')) {
			include $v.'/admin/config.inc.php';
			$sysmodules[$MCFG['module']] = $MCFG;
		}
	}
	return $sysmodules;
}
switch($action) {
	case 'add':
		if($submit) {
			if(!$post['name']) msg('请填写模块名称');
			if($post['islink']) {
				if(!$post['linkurl']) msg('请填写链接地址');
			} else {
				$dir = $post['moduledir'];
				$module = $post['module'];
				if(!$module) msg('请选择所属模型');
				$module_cfg = AJ_ROOT.'/module/'.$module.'/admin/config.inc.php';
				if(!is_file($module_cfg)) msg('此模型无法安装，请检查');
				include $module_cfg;
				if($MCFG['uninstall'] == false) msg('此模型无法安装，请检查');
				if($MCFG['copy'] == false) {
					$r = $db->get_one("SELECT moduleid FROM {$AJ_PRE}module WHERE module='$module' AND islink=0");
					if($r) msg('此模型已经安装过，请检查');
				}
				if(!$dir) msg('请填写安装目录');
				if(!preg_match("/^[0-9a-z_-]+$/i", $dir)) msg('目录名不合法,请更换一个再试');
				$r = $db->get_one("SELECT moduleid FROM {$AJ_PRE}module WHERE moduledir='$dir' AND islink=0");
				if($r) msg('此目录名已经被其他模块使用,请更换一个再试');
				$sysdirs = array('ad', 'admin', 'announce', 'api', 'archiver', 'comment', 'feed', 'file', 'gift', 'guestbook', 'include', 'install', 'lang', 'link', 'module', 'poll', 'sitemap', 'skin', 'spread', 'template', 'upgrade', 'vote', 'mobile', 'form');
				if(in_array($dir, $sysdirs)) msg('安装目录与系统目录冲突，请更换安装目录');
				if(!dir_create(AJ_ROOT.'/'.$dir.'/')) msg('无法创建'.$dir.'目录，请检查PHP是否有创建权限或手动创建');
				if(!is_write(AJ_ROOT.'/'.$dir.'/')) msg('目录'.$dir.'无法写入，请设置此目录可写权限');
				if(!file_put(AJ_ROOT.'/'.$dir.'/config.inc.php', "AIJIACMS")) msg('目录'.$dir.'无法写入，请设置此目录可写权限');
			}
			if($post['domain']) $post['domain'] = fix_domain($post['domain']);
			if($post['mobile']) $post['mobile'] = fix_domain($post['mobile']);
			$post['linkurl'] = $post['islink'] ? $post['linkurl'] : ($post['domain'] ? $post['domain'] : linkurl($post['moduledir']."/"));
			if($post['islink']) $post['module'] = 'aijiacms';
			$post['installtime'] = $AJ_TIME;
			if($MCFG['moduleid']) {
				$db->query("DELETE FROM {$AJ_PRE}module WHERE moduleid=".$MCFG['moduleid']);
				$post['moduleid'] = $MCFG['moduleid'];
			}
			$sql1 = $sql2 = $s = "";
			foreach($post as $key=>$value) {
				$sql1 .= $s.$key;
				$sql2 .= $s."'".$value."'";
				$s = ",";
			}
			$db->query("INSERT INTO {$AJ_PRE}module ($sql1) VALUES ($sql2)");
			$moduleid = $db->insert_id();
			$db->query("UPDATE {$AJ_PRE}module SET listorder=$moduleid WHERE moduleid=$moduleid");
			if($post['islink']) {
			} else {
				$module = $post['module'];
				$dir = $post['moduledir'];
				$modulename = $post['name'];
				file_put(AJ_ROOT.'/'.$dir.'/config.inc.php', "<?php\n\$moduleid = ".$moduleid.";\n?>");
				@include AJ_ROOT.'/module/'.$module.'/admin/install.inc.php';
			}
			cache_module();
			dmsg('模块添加成功', $this_forward);
		} else {
			$imodules = array();
			$result = $db->query("SELECT module FROM {$AJ_PRE}module");
			while($r = $db->fetch_array($result)) {
				$imodules[$r['module']] = $r['module'];
			}
			$modules = get_modules();
			$module_select = '<select name="post[module]"  id="module"><option value="0">请选择</option>';
			foreach($modules as $k=>$v) {
				if($v['copy'] == false) {
					if(in_array($v['module'], $imodules)) continue;
				}
				$module_select .= '<option value="'.$v['module'].'">'.$v['name'].'</option>';
			}
			$module_select .= '</select>';
			include tpl('module_add');
		}
	break;
	case 'edit':
		if(!$modid) msg('模块ID不能为空');
		if($modid == 1 || $modid == 3) msg('系统模型，不可修改');
		$r = $db->get_one("SELECT * FROM {$AJ_PRE}module WHERE moduleid='$modid'");
		if(!$r) msg('模块不存在');
		extract($r);
		if($submit) {
			if(!$post['name']) msg('请填写模块名称');
			if($islink) {
				if(!$post['linkurl']) msg('请填写链接地址');
			} else {
				if($modid == 4) $post['moduledir'] = 'company';
				if(!$post['moduledir']) msg('请填写安装目录');
				if(!preg_match("/^[0-9a-z_-]+$/i", $post['moduledir'])) msg('目录名不合法,请更换一个再试');
				$sysdirs = array('ad', 'admin', 'announce', 'api', 'archiver', 'comment', 'feed', 'file', 'gift', 'guestbook', 'include', 'install', 'lang', 'link', 'module', 'poll', 'sitemap', 'skin', 'spread', 'template', 'upgrade', 'vote', 'mobile', 'form');
				if(in_array($post['moduledir'], $sysdirs)) msg('安装目录与系统目录冲突，请更换安装目录');
				$r = $db->get_one("SELECT moduleid FROM {$AJ_PRE}module WHERE moduledir='$post[moduledir]' AND moduleid!=$modid");
				if($r) msg('此目录名已经被其他模块使用,请更换一个再试');
				if($post['domain']) $post['domain'] = fix_domain($post['domain']);
				if($post['mobile']) $post['mobile'] = fix_domain($post['mobile']);
				$post['linkurl'] = $post['domain'] ? $post['domain'] : linkurl($post['moduledir']."/");
			}			
			$sql = $s = "";
			foreach($post as $key=>$value) {
				$sql .= $s.$key."='".$value."'";
				$s = ",";
			}
			$db->query("UPDATE {$AJ_PRE}module SET $sql WHERE moduleid=$modid");
			if(!$islink && $moduledir != $post['moduledir']) {
				rename(AJ_ROOT.'/'.$moduledir, AJ_ROOT.'/'.$post['moduledir']) or msg('无法重命名目录'.$moduledir.'为'.$post['moduledir'].',请手动修改');
				rename(AJ_ROOT.'/mobile/'.$moduledir, AJ_ROOT.'/mobile/'.$post['moduledir']);
			}
			cache_module();
			dmsg('模块修改成功', $this_forward);
		} else {
			@include AJ_ROOT.'/module/'.$module.'/admin/config.inc.php';
			$modulename = isset($MCFG['name']) ? $MCFG['name'] : '';
			include tpl('module_edit');
		}
	break;
	case 'delete':
		if(!$modid) msg('模块ID不能为空');	
		if($modid < 5) msg('系统模型不可删除');
		#if($modid < 23) dheader('?file='.$file.'&action=disable&value=1&modid='.$modid);
		$r = $db->get_one("SELECT * FROM {$AJ_PRE}module WHERE moduleid='$modid'");
		if(!$r) msg('此模块不存在');
		if(!$r['islink']) {
			$moduleid = $r['moduleid'];
			$module = $r['module'];
			$dir = $r['moduledir'];
			$module_cfg = AJ_ROOT.'/module/'.$module.'/admin/config.inc.php';
			if(!is_file($module_cfg)) msg('此模型不可卸载，请检查');
			include $module_cfg;
			if($MCFG['uninstall'] == false) msg('此模型不可卸载，请检查');
			@include AJ_ROOT.'/module/'.$module.'/admin/uninstall.inc.php';			
			$result = $db->query("SHOW TABLES FROM `".$CFG['db_name']."`");
			while($r = $db->fetch_row($result)) {
				$tb = $r[0];
				$pt = str_replace($AJ_PRE.$moduleid.'_', '', $tb);
				if(is_numeric($pt)) $db->query("DROP TABLE IF EXISTS `".$tb."`");
			}
			$db->query("DELETE FROM `".$AJ_PRE."category` WHERE moduleid=$moduleid");
			$db->query("DELETE FROM `".$AJ_PRE."keylink` WHERE item=$moduleid");
			$db->query("DELETE FROM `".$AJ_PRE."setting` WHERE item=$moduleid");
			$tb = str_replace($AJ_PRE, '', get_table($moduleid));
			$db->query("DELETE FROM `".$AJ_PRE."fields` WHERE tb='$tb'");
			dir_delete(AJ_ROOT.'/'.$dir);
			dir_delete(AJ_ROOT.'/mobile/'.$dir);
		}
		$db->query("DELETE FROM {$AJ_PRE}module WHERE moduleid='$modid'");
		cache_module();
		dmsg('模块删除成功', $this_forward);
		break;
	case 'remkdir':
		if(!$modid) msg('模块ID不能为空');
		$r = $db->get_one("SELECT * FROM {$AJ_PRE}module WHERE moduleid='$modid'");
		$remkdir = AJ_ROOT.'/module/'.$r['module'].'/admin/remkdir.inc.php';
		if(is_file($remkdir)) {
			$moduleid = $r['moduleid'];
			$module = $r['module'];
			$dir = $r['moduledir'];
			if(!dir_create(AJ_ROOT.'/'.$dir)) msg('无法创建'.$dir.'目录，请检查PHP是否有创建权限或手动创建');
			if(!file_put(AJ_ROOT.'/'.$dir.'/ajax.php', "AIJIACMS TEST")) msg('目录'.$dir.'无法写入，如果是Linux/Unix服务器，请设置此目录可写权限');
			file_del(AJ_ROOT.'/'.$dir.'/config.inc.php');
			file_copy(AJ_ROOT.'/api/ajax.php', AJ_ROOT.'/'.$dir.'/ajax.php');
			file_copy(AJ_ROOT.'/api/ajax.php', AJ_ROOT.'/mobile/'.$dir.'/ajax.php');
			include $remkdir;			
			cache_module();
			dmsg('目录重建成功', '?file='.$file);
		} else {
			msg('此模型无需重建目录', '?file='.$file);
		}
	break;
	case 'disable':
		if(!$modid) msg('模块ID不能为空');
		if($modid < 5) msg('系统模型不可禁用');
		$value = $value ? 1 : 0;
		$db->query("UPDATE {$AJ_PRE}module SET disabled='$value' WHERE moduleid=$modid");
		cache_module();
		dmsg('模块状态已经修改', $this_forward);
	break;
	case 'order':
		foreach($listorder as $k=>$v) {
			$k = intval($k);
			$v = intval($v);
			$db->query("UPDATE {$AJ_PRE}module SET listorder='$v' WHERE moduleid=$k");
		}
		cache_module();
		dmsg('更新成功', $this_forward);
	break;
	case 'cache':
		cache_module();
		dmsg('更新成功', $this_forward);
	break;
	case 'ckdir':
		if(!preg_match("/^[0-9a-z_-]+$/i", $moduledir)) dialog('不是一个合法的目录名,请更换一个再试');
		$r = $db->get_one("SELECT moduleid FROM {$AJ_PRE}module WHERE moduledir='$moduledir'");
		if($r || is_dir(AJ_ROOT.'/'.$moduledir.'/')) dialog('该目录名已经被使用,请更换一个再试');
		dialog('目录名可以使用');
	break;
	case 'sys':
		$sysmodules = get_modules();
		include tpl('module_sys');
	break;
	default:
		$sysmodules = get_modules();
		$modules = $_modules = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}module ORDER BY listorder ASC,moduleid DESC");
		while($r = $db->fetch_array($result)) {
			if($r['moduleid'] == 1) continue;
			$r['installdate'] = timetodate($r['installtime'], 3);
			$r['modulename'] = isset($sysmodules[$r['module']]) ? $sysmodules[$r['module']]['name'] : '<span class="f_red">外链</span>';
			if($r['disabled']) {
				$_modules[] = $r;
			} else {
				$modules[] = $r;
			}
		}
		include tpl('module');
	break;
}
?>