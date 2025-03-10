<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class dappnav {
	var $id;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function __construct() {
		$this->table = AJ_PRE.'app_nav';
		$this->fields = array('event_type','event_value','platform','name','is_enable','listorder','images_url','add_time','upd_time','template');
    }

    function dappnav() {
		$this->__construct();
    }

	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
		
		//if(!$post['name']) return $this->_($L['appnav_pass_site']);
		
		return true;
	}

	function set($post) {
		global $MOD, $_username, $_userid;
		if(!$this->id) $post['add_time'] = AJ_TIME;
		if($post['images_url'] && !is_url($post['images_url'])) $post['images_url'] = '';
		$post['upd_time'] = AJ_TIME;
		$post['editor'] = $_username;
		$post = dhtmlspecialchars($post);
		return array_map("trim", $post);
	}

	function get_one() {
        return DB::get_one("SELECT * FROM {$this->table} WHERE id='$this->id'");
	}

	function get_list($condition = '1', $order = 'listorder DESC, id DESC') {
		global $MOD, $TYPE, $pages, $page, $pagesize, $offset, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = array();
		$result = DB::query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = DB::fetch_array($result)) {
			
			$r['adddate'] = timetodate($r['add_time'], 5);
			$r['editdate'] = timetodate($r['upd_time'], 5);
		
			
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		global $AJ, $MOD, $module;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		DB::query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->id = DB::insert_id();
		clear_upload($post['images_url'], $this->id, $this->table);
		return $this->id;
	}

	function edit($post) {
		global $AJ, $MOD, $module;
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    DB::query("UPDATE {$this->table} SET $sql WHERE id=$this->id");
		clear_upload($post['images_url'], $this->id, $this->table);
		return true;
	}

	function delete($id, $all = true) {
		if(is_array($id)) {
			foreach($id as $v) { 
				$this->delete($v, $all); 
			}
		} else {
			$this->id = $id;
			$r = $this->get_one();
			if($all) {
				$userid = get_user($r['editor']);
				if($r['images_url']) delete_upload($r['images_url'], $userid);
				DB::query("DELETE FROM {$this->table} WHERE id=$id");
			}
		}
	}

	function check($id) {
		global $_username;
		if(is_array($id)) {
			foreach($id as $v) { $this->check($v); }
		} else {
			DB::query("UPDATE {$this->table} SET status=3,editor='$_username',upd_time=".AJ_TIME." WHERE id=$id");
			return true;
		}
	}

	function order($listorder) {
		if(!is_array($listorder)) return false;
		foreach($listorder as $k=>$v) {
			$k = intval($k);
			$v = intval($v);
			DB::query("UPDATE {$this->table} SET listorder=$v WHERE id=$k");
		}
		return true;
	}

	
	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>