<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class huxing {
	var $itemid;
	var $db;
	var $table;
	var $fields;
	

	function huxing() {
		global $db,$pid,$title;
		$this->table = $db->pre.'newhouse_huxing';
		$this->db = &$db;
		$this->fields = array('title','houseid','introduce','thumb','listorder','catid','status','username','addtime','edittime','bh','shi','ting','wei','mj','dj','zlhx','xszt');
	}

	function pass($post) {
		global  $L;
		if(!is_array($post)) return false;
		if(!$post['title']) return $this->_($L['msg_huxing']);
		return true;
	}

	function set($post) {
		global $MOD, $AJ_TIME, $AJ_IP, $_username;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : $AJ_TIME;
		$post['edittime'] = $AJ_TIME;
		if($this->itemid) {
			//
		} else {
			$post['ip'] = $AJ_IP;
		}
		if(!defined('AJ_ADMIN')) $post = dhtmlspecialchars($post);
		return array_map("trim", $post);
	}

	function get_one($condition = '') {
	 
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid' $condition");
	}
 
	function get_list($condition = '1', $order = 'addtime DESC') {
		global $pages, $page, $pagesize, $offset, $pagesize, $MOD, $item, $sum;
		if($page > 1 && $sum) {
			$item = $sum;
		} else {
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$item = $r['num'];
		}
	
		$pages = pages($item, $page, $pagesize);
		$lists = $pids = $P = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['adddate'] = timetodate($r['addtime'], 5);
		    $catids[$r['catid']] = $r['catid'];
			$r['linkurl'] = $MOD['linkurl'].$r['houseid'];
			$lists[] = $r;
		}
		if($catids) {
			$result = $this->db->query("SELECT catid,catname,linkurl FROM {$this->db->pre}category WHERE catid IN (".implode(',', $catids).")");
			while($r = $this->db->fetch_array($result)) {
				$CATS[$r['catid']] = $r;
			}
			if($CATS) {
				foreach($lists as $k=>$v) {
					$lists[$k]['catname'] = $v['catid'] ? $CATS[$v['catid']]['catname'] : '';
					$lists[$k]['caturl'] = $v['catid'] ? $MOD['linkurl'].$CATS[$v['catid']]['linkurl'] : '';
				}
			}
		}
		return $lists;
	}

	function add($post) {
		global $MOD, $L;
		
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = $this->db->insert_id();
		//$this->update($this->itemid, $post);
		return $this->itemid;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		//$this->update($this->itemid, $post);
		return true;
	}

	function update($itemid, $item = array()) {
		$item or $item = $this->db->get_one("SELECT * FROM {$this->table} WHERE itemid=$itemid");
		$sql = '';
		if($item['username']) {
			$m = daddslashes(userinfo($item['username']));
			if($m) $sql = "company='$m[company]',telephone='$m[telephone]',qq='$m[qq]'";
		}
		if($sql) $this->db->query("UPDATE {$this->table} SET $sql WHERE itemid=$itemid");
	}

	function check($itemid) {
		global $_username, $AJ_TIME;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->check($v); }
		} else {
			$this->db->query("UPDATE {$this->table} SET status=3,editor='$_username',edittime=$AJ_TIME WHERE itemid=$itemid");
			return true;
		}
	}

	function delete($itemid) {
		global $MOD, $L;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->delete($v); }
		} else {
			$this->itemid = $itemid;
			$t = $this->get_one();
			$pid = $t['pid'];
			$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
		}
	}



	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
function housename($houseid) {
	global $db, $dc, $CFG;
  if($houseid) $r = $db->get_one("SELECT title FROM {$db->pre}newhouse_6 WHERE itemid=$houseid ");
      $title=$r['title'];
	return $title;
}
?>