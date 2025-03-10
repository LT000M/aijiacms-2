<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class subscribe {
	var $itemid;
	var $userid;
	var $username;
	var $pre;
	var $errmsg = errmsg;

    function __construct() {
		global $_userid, $_username;
		$this->userid = $_userid;
		$this->username = $_username;
    }

    function subscribe()	{
		$this->__construct();
    }

	function is_subscribe($subscribe) {
		global $L;
		if(!is_array($subscribe)) return false;
		if(empty($subscribe['title'])) return $this->_($L['pass_title']);
		if(empty($subscribe['content'])) return $this->_($L['pass_content']);
		if(AJ_MAX_LEN && strlen(clear_img($subscribe['content'])) > AJ_MAX_LEN) return $this->_(lang('subscribe->pass_max'));
		return true;
	}

	function is_member($username) {
		return DB::get_one("SELECT userid FROM ".AJ_PRE."member WHERE username='$username'");
	}


	
	function edit($subscribe) {
		global $L;
		if(!$this->is_subscribe($subscribe)) return false;
		$r = $this->get_one();
		if($r['status'] != 1 || $r['fromuser'] != $this->username) return $this->_($L['subscribe_msg_edit']);
		clear_upload($subscribe['content'], $this->itemid, 'subscribe');
		$subscribe['title'] = dhtmlspecialchars(trim($subscribe['title']));
		$subscribe['content'] = dsafe(addslashes(save_remote(save_local(stripslashes($subscribe['content'])))));
		delete_diff($subscribe['content'], $r['content']);
		DB::query("UPDATE ".AJ_PRE."subscribe SET title='$subscribe[title]',content='$subscribe[content]' WHERE itemid='$this->itemid' ");
		if(isset($subscribe['send'])) return $this->send($subscribe);
		return true;
	}

	function get_one() {
        return DB::get_one("SELECT * FROM ".AJ_PRE."subscribe WHERE itemid='$this->itemid'");
	}

	function get_list($condition, $order = 'itemid DESC') {
		global $MODULE, $pages, $page, $pagesize, $offset, $items, $L, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(*) AS num FROM ".AJ_PRE."subscribe WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		if($items < 1) return array();
		$subscribes = array();
		$result = DB::query("SELECT * FROM ".AJ_PRE."subscribe WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = DB::fetch_array($result)) {
		
			
			$subscribes[] = $r;
		}
		return $subscribes;
	}

	



	function delete($recycle = 0) {
		if(!$this->itemid) return false;
		$itemids = is_array($this->itemid) ? implode(',', $this->itemid) : intval($this->itemid);
		$result = DB::query("SELECT * FROM ".AJ_PRE."subscribe WHERE itemid IN($itemids) ORDER BY itemid DESC");
		while($r = DB::fetch_array($result)) {
			if(defined('AJ_ADMIN')) {
				
				DB::query("DELETE FROM ".AJ_PRE."subscribe WHERE itemid='$r[itemid]'");
			} else {
				if($r['status'] == 4) {
					if($this->username == $r['touser']) $this->_delete($r['itemid']);
				} else if($r['status'] == 3) {
					if($this->username == $r['touser']) {
						if($recycle) {
							DB::query("UPDATE ".AJ_PRE."subscribe SET status=4 WHERE itemid='$r[itemid]' ");
						} else {
							$this->_delete($r['itemid']);
						}
						
					}
				} else if($r['status'] == 2 || $r['status'] == 1) {
					if($this->username == $r['fromuser']) $this->_delete($r['itemid']);
				}
			}
		}
	}

	

	function _is_subscribe($subscribe) {
		global $L;
		if(!is_array($subscribe)) return false;
		if($subscribe['type']) {
			if(!isset($subscribe['groupids']) || !is_array($subscribe['groupids']) || empty($subscribe['groupids'])) return $this->_($L['subscribe_pass_groupid']);
		} else {
			if(!$subscribe['touser']) return $this->_($L['subscribe_pass_touser']);
		}
		if(!$subscribe['title'] || !$subscribe['content']) return $this->_($L['subscribe_pass_title']);
		return true;
	}



	


	function _delete($itemid) {
		$this->itemid = $itemid;
		$r = $this->get_one();
		if($r['fromuser']) {
			$userid = get_user($r['fromuser']);
			if($r['content']) delete_local($r['content'], $userid);
		}
		DB::query("DELETE FROM ".AJ_PRE."subscribe WHERE itemid='$itemid' ");
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>