<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$parentid = isset($parentid) ? intval($parentid) : 0;
$navmenus = array (
    array('添加菜单', '?file='.$file.'&action=add&parentid='.$parentid),
    array('管理菜单', '?file='.$file),
  
);

$AREA = cache_read('navmenu.php');
$navid = isset($navid) ? intval($navid) : 0;
$do = new navmenu($navid);


$table = $AJ_PRE.'navmenu';
$this_forward = '?file='.$file.'&parentid='.$parentid;

switch($action) {
	case 'add':
		if($submit) {
			if(!$post['title']) msg('菜单名不能为空');
			$post['title'] = trim($post['title']);
			if(strpos($post['title'], "\n") === false) {
				$do->add($post);
			} else {
				$titles = explode("\n", $post['title']);
				foreach($titles as $title) {
					$title = trim($title);
					if(!$title) continue;
					$post['title'] = $title;
					$do->add($post);
				}
			}
			$do->repair();
			dmsg('添加成功', $this_forward);
		} else {
			include tpl('navmenu_add');
		}
	break;
	case 'edit':
		$navid or msg();
		if($submit) {
			if(!$post['title']) msg('菜单名不能为空');
			if($post['parentid'] == $navid) msg('上级菜单不能与当前菜单相同');
			$do->edit($post);
			$post['navid'] = $navid;
			
			dmsg('修改成功', '?file='.$file.'&parentid='.$post['parentid']);
		} else {
			extract($db->get_one("SELECT * FROM {$table} WHERE navid=$navid"));
			include tpl('navmenu_edit');
		}
	break;
	
	case 'delete':
		if($navid) $navids = $navid;
		$navids or msg();
		$do->delete($navids);
		dmsg('删除成功', $this_forward);
	break;
	case 'update':
		if(!$post || !is_array($post)) msg();
		$do->update($post);
		dmsg('更新成功', $this_forward);
	break;
	default:
		$AJCAT = array();
		$condition = $keyword ? "title LIKE '%$keyword%'" : "parentid=$parentid";
	
		$result = $db->query("SELECT * FROM {$table} WHERE $condition ORDER BY listorder,navid");
		while($r = $db->fetch_array($result)) {
			$r['childs'] = substr_count($r['arrchildid'], ',');
			$AJCAT[$r['navid']] = $r;
		}
		include tpl('navmenu');
	break;
}

class navmenu {
	var $navid;
	var $navmenu = array();
	var $table;

	function __construct($navid = 0)	{
		global $AREA;
		$this->navid = $navid;
		$this->navmenu = $AREA;
		$this->table = AJ_PRE.'navmenu';
	}

	function navmenu($navid = 0)	{
		$this->__construct($navid);
	}

	function add($post)	{
		if(!is_array($post)) return false;
		$sql1 = $sql2 = $s = '';
		foreach($post as $key=>$value) {
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ',';
		}
		DB::query("INSERT INTO {$this->table} ($sql1) VALUES($sql2)");		
		$this->navid = DB::insert_id();
		if($post['parentid']) {
			$post['navid'] = $this->navid;
			$this->navmenu[$this->navid] = $navmenu;
			$arrparentid = $this->get_arrparentid($this->navid, $this->navmenu);
		} else {
			$arrparentid = 0;
		}
		DB::query("UPDATE {$this->table} SET arrchildid='$this->navid',listorder=$this->navid,arrparentid='$arrparentid' WHERE navid=$this->navid");
		return true;
	}
function edit($post) {
		
		if($post['parentid']) {
			$post['navid'] = $this->navid;
			$this->post[$this->navid] = $navmenu;
			$post['arrparentid'] = $this->get_arrparentid($this->navid, $this->post);
		} else {
			$post['arrparentid'] = 0;
		}
		
		
		$sql = '';
		foreach($post as $k=>$v) {
			$sql .= ",$k='$v'";
		}
		$sql = substr($sql, 1);
		DB::query("UPDATE {$this->table} SET $sql WHERE navid=$this->navid");
		return true;
	}
	function delete($navids) {
		if(is_array($navids)) {
			foreach($navids as $navid) {
				if(isset($this->navmenu[$navid])) {
					$arrchildid = $this->navmenu[$navid]['arrchildid'];
					DB::query("DELETE FROM {$this->table} WHERE navid IN ($arrchildid)");
				}
			}
		} else {
			$navid = $navids;
			if(isset($this->navmenu[$navid])) {
				$arrchildid = $this->navmenu[$navid]['arrchildid'];
				DB::query("DELETE FROM {$this->table} WHERE navid IN ($arrchildid)");
			}
		}
		$this->repair();
		return true;
	}

	function update($post) {
	    if(!is_array($post)) return false;
		foreach($post as $k=>$v) {
			if(!$v['title']) continue;
			$v['parentid'] = intval($v['parentid']);
			if($k == $v['parentid']) continue;
			if($v['parentid'] > 0 && !isset($this->navmenu[$v['parentid']])) continue;
			$v['listorder'] = intval($v['listorder']);
			DB::query("UPDATE {$this->table} SET  title='$v[title]',href='$v[href]',listorder='$v[listorder]',icon='$v[icon]' WHERE navid=$k");
		}
		cache_navmenu();
		return true;
	}

	function repair() {		
		$query = DB::query("SELECT * FROM {$this->table} ORDER BY listorder,navid");
		$AREA = array();
		while($r = DB::fetch_array($query)) {
			$AREA[$r['navid']] = $r;
		}
		$childs = array();
		foreach($AREA as $navid => $navmenu) {
			$arrparentid = $this->get_arrparentid($navid, $AREA);
			DB::query("UPDATE {$this->table} SET arrparentid='$arrparentid' WHERE navid=$navid");
			if($arrparentid) {
				$arr = explode(',', $arrparentid);
				foreach($arr as $a) {
					if($a == 0) continue;
					isset($childs[$a]) or $childs[$a] = '';
					$childs[$a] .= ','.$navid;
				}
			}
		}
		foreach($AREA as $navid => $post) {
			if(isset($childs[$navid])) {
				$arrchildid = $navid.$childs[$navid];
				DB::query("UPDATE {$this->table} SET arrchildid='$arrchildid',child=1 WHERE navid='$navid'");
			} else {
				DB::query("UPDATE {$this->table} SET arrchildid='$navid',child=0 WHERE navid='$navid'");
			}
		}
		cache_navmenu();
        return true;
	}

	function get_arrparentid($navid, $AREA) {
		if($AREA[$navid]['parentid'] && $AREA[$navid]['parentid'] != $navid) {
			$parents = array();
			$aid = $navid;
			while($navid) {
				if($AREA[$aid]['parentid']) {
					$parents[] = $aid = $AREA[$aid]['parentid'];
				} else {
					break;
				}
			}
			$parents[] = 0;
			return implode(',', array_reverse($parents));
		} else {
			return '0';
		}
	}

	function get_arrchildid($navid, $AREA) {
		$arrchildid = '';
		foreach($AREA as $post) {
			if(strpos(','.$post['arrparentid'].',', ','.$navid.',') !== false) $arrchildid .= ','.$post['navid'];
		}
		return $arrchildid ? $navid.$arrchildid : $navid;
	}
}
?>