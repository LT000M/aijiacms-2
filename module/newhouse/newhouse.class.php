<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class newhouse {
	var $moduleid;
	var $itemid;
	var $db;
	var $table;
	var $table_data;
	var $table_search;
	var $split;
	var $errmsg = errmsg;

   function __construct($moduleid) {
		global $db, $table, $table_data, $table_search, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->table_data = $table_data;
		$this->table_search = $table_search;
		$this->split = $MOD['split'];
		$this->db = &$db;
		$this->fields = array('catid','mycatid','areaid','typeid','level','title','tag','style','fee','introduce','tedian','price','days','thumb','thumb1','thumb2','tag','status','hits','username','editor','addtime','totime','adddate','edittime','editdate','ip','template','linkurl','filepath','elite','note','company','truename','telephone','mobile','address','email','msn','qq','ali','skype','map','selltime','lp_year','lp_company','lp_costs','lp_totalarea','lp_area','lp_number','lp_car','lp_volume','lp_green','lp_edu','lp_hospital','lp_bank','lineprice','linedate','completion','sell_address','lp_bus','letter','lp_dianping','isnew','pinyin','isfx','yongjin','star0','star1','star4','ishb','hongbao','hbtime','hbnum','zhiye','video');}
 
function newhouse($moduleid) {
		$this->__construct($moduleid);
    }
	function pass($post) {
		global  $MOD;
		if(!is_array($post)) return false;
		if(!$post['catid']) return $this->_(lang('message->pass_cate'));
		if(strlen($post['title']) < 3) return $this->_(lang('message->pass_title'));
		if($post['totime']) {
			//if(!is_date($post['totime'])) return $this->_(lang('message->pass_date'));
			//if(strtotime($post['totime'].' 23:59:59') < AJ_TIME) return $this->_(lang('message->pass_todate'));
		}
		if(AJ_MAX_LEN && strlen($post['content']) > AJ_MAX_LEN) return $this->_(lang('message->pass_max'));
		return true;
	}

	function set($post) {
		global $MOD,  $AJ_IP, $TYPE, $_username, $_userid;
		is_url($post['thumb']) or $post['thumb'] = '';
		$post['filepath'] = (isset($post['filepath']) && is_filepath($post['filepath'])) ? file_vname($post['filepath']) : '';
		$post['editor'] = $_username;
		$post['addtime'] = (isset($post['addtime']) && $post['addtime']) ? strtotime($post['addtime']) : AJ_TIME;
		$post['adddate'] = timetodate($post['addtime'], 3);
		$post['edittime'] = AJ_TIME;
		//$post['letter'] = GetPinyin($post['title']);
		$post['pinyin'] = pinyin($post['title']);
		$post['editdate'] = timetodate($post['edittime'], 3);
		$post['totime'] = is_time($post['totime']) ? strtotime($post['totime']) : 0;
		$post['hbtime'] = $post['hbtime'] ? strtotime($post['hbtime'].' 23:59:59') : 0;
		$post['fee'] = dround($post['fee']);
		$post['price'] = dround($post['price']);
		$post['mycatid'] = intval($post['mycatid']);
		if(is_array($post['catid']))$post['catid'] =implode(',',$post['catid']); 
		$post['elite'] = $post['elite'] ? 1 : 0;
		$post['content'] = stripslashes($post['content']);
		$post['content'] = save_local($post['content']);
		if($MOD['clear_link']) $post['content'] = clear_link($post['content']);
		if($MOD['save_remotepic']) $post['content'] = save_remote($post['content']);
		if($MOD['introduce_length']) $post['introduce'] = addslashes(get_intro($post['content'], $MOD['introduce_length']));
		if($this->itemid) {
			$new = $post['content'];
			if($post['thumb']) $new .= '<img src="'.$post['thumb'].'"/>';

			$r = $this->get_one();
			$old = $r['content'];
			if($r['thumb']) $old .= '<img src="'.$r['thumb'].'"/>';
			delete_diff($new, $old);
		} else {
			$post['ip'] = $AJ_IP;
		}
		$content = $post['content'];
		unset($post['content']);
		$post = dhtmlspecialchars($post);
		$post['content'] = addslashes(dsafe($content));
		return array_map("trim", $post);
	}

	function get_one() {
		$r = DB::get_one("SELECT * FROM {$this->table} WHERE itemid=$this->itemid");
		if($r) {
			$content_table = content_table($this->moduleid, $this->itemid, $this->split, $this->table_data);
			$t = DB::get_one("SELECT content FROM {$content_table} WHERE itemid=$this->itemid");
			$r['content'] = $t ? $t['content'] : '';
			return $r;
		} else {
			return array();
		}
	}

	function get_list($condition = 'status=3 and isnew=1', $order = 'edittime DESC', $cache = '') {
		global $MOD, $pages, $page, $pagesize, $offset, $items, $sum,$catid;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition", $cache);
			$items = $r['num'];
		}
		$pages = defined('CATID') ? listpages(1, CATID, $items, $page, $pagesize, 10, $MOD['linkurl']) : pages($items, $page, $pagesize);
		if($items < 1) return array();
		$lists = $catids = $CATS = array();
		$result = DB::query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize", $cache);
		while($r = DB::fetch_array($result)) {
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['userurl'] = userurl($r['username']);
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$catids[$r['catid']] = $r['catid'];
			$lists[] = $r;
		}
		
		if($catids && $catid<>'') {
				$result = DB::query("SELECT catid,catname,linkurl FROM {DB::pre}category WHERE catid IN (".implode(',', $catids).")");
			while($r = DB::fetch_array($result)) {
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
		global $MOD;
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		DB::query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->itemid = DB::insert_id();
		$content_table = content_table($this->moduleid, $this->itemid, $this->split, $this->table_data);
		DB::query("REPLACE INTO {$content_table} (itemid,content) VALUES ('$this->itemid', '$post[content]')");
		$this->update($this->itemid);
		if($post['status'] == 3 && $post['username'] && $MOD['credit_add']) {
			credit_add($post['username'], $MOD['credit_add']);
			credit_record($post['username'], $MOD['credit_add'], 'system', lang('my->credit_record_add', array($MOD['name'])), 'ID:'.$this->itemid);
		}
		clear_upload($post['content'].$post['thumb'].$post['thumb1'].$post['thumb2'], $this->itemid);
		return $this->itemid;
	}

	function edit($post) {
		$this->delete($this->itemid, false);
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    DB::query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		$content_table = content_table($this->moduleid, $this->itemid, $this->split, $this->table_data);
		DB::query("REPLACE INTO {$content_table} (itemid,content) VALUES ('$this->itemid', '$post[content]')");
		$this->update($this->itemid);
		clear_upload($post['content'].$post['thumb'], $this->itemid);
		if($post['status'] > 2) $this->tohtml($this->itemid, $post['catid']);
		return true;
	}

	function tohtml($itemid = 0, $catid = 0) {
		global $module, $MOD;
		if($MOD['show_html'] && $itemid) tohtml('show', $module, "itemid=$itemid");
	}

	function update($itemid) {
		global $TYPE;
		$item = DB::get_one("SELECT * FROM {$this->table} WHERE itemid=$itemid");
		$update = '';
		$keyword = $item['title'].','.$TYPE[$item['typeid']].','.strip_tags(cat_pos(get_cat($item['catid']), ','));
		if($keyword != $item['keyword']) {
			$keyword = str_replace("//", '', addslashes($keyword));
			$update .= ",keyword='$keyword'";
		} else {
			$keyword = str_replace("//", '', addslashes($keyword));
		}
		$item['itemid'] = $itemid;
		$linkurl = itemurl($item);
		if($linkurl != $item['linkurl']) $update .= ",linkurl='$linkurl'";
		$member = $item['username'] ? userinfo($item['username']) : array();
		//if($member) $update .= update_user($member, $item);
		if($update) DB::query("UPDATE {$this->table} SET ".(substr($update, 1))." WHERE itemid=$itemid");
		$sorttime = $this->get_sorttime($item['edittime'], $item['vip']);
		DB::query("REPLACE INTO {$this->table_search} (itemid,catid,areaid,status,content,sorttime) VALUES ($itemid,'$item[catid]','$item[areaid]','$item[status]','$keyword','$sorttime')");
	}

	function recycle($itemid) {
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->recycle($v); }
		} else {
			DB::query("UPDATE {$this->table} SET status=0 WHERE itemid=$itemid");
			DB::query("UPDATE {$this->table_search} SET status=0 WHERE itemid=$itemid");
			$this->delete($itemid, false);
			return true;
		}		
	}

	function restore($itemid) {
		global $module, $MOD;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->restore($v); }
		} else {
			DB::query("UPDATE {$this->table} SET status=3 WHERE itemid=$itemid");
			DB::query("UPDATE {$this->table_search} SET status=3 WHERE itemid=$itemid");
			if($MOD['show_html']) tohtml('show', $module, "itemid=$itemid");
			return true;
		}		
	}

	function delete($itemid, $all = true) {
		global $MOD;
		if(is_array($itemid)) {
			foreach($itemid as $v) {
				$this->delete($v, $all);
			}
		} else {
			$this->itemid = $itemid;
			$r = $this->get_one();
			if($MOD['show_html']) {
				$_file = AJ_ROOT.'/'.$MOD['moduledir'].'/'.$r['linkurl'];
				if(is_file($_file)) unlink($_file);
			}
			if($all) {
				$userid = get_user($r['username']);
				if($r['thumb']) delete_upload($r['thumb'], $userid);
				
				if($r['content']) delete_local($r['content'], $userid);
				DB::query("DELETE FROM {$this->table} WHERE itemid=$itemid");
				DB::query("DELETE FROM {$this->table_search} WHERE itemid=$itemid");
				$content_table = content_table($this->moduleid, $this->itemid, $this->split, $this->table_data);
				DB::query("DELETE FROM {$content_table} WHERE itemid=$itemid");
				if($MOD['cat_property']) DB::query("DELETE FROM {$AJ_PRE}category_value WHERE moduleid=$this->moduleid AND itemid=$itemid");
				if($r['username'] && $MOD['credit_del']) {
					credit_add($r['username'], -$MOD['credit_del']);
					credit_record($r['username'], -$MOD['credit_del'], 'system', lang('my->credit_record_del', array($MOD['name'])), 'ID:'.$this->itemid);
				}
			}
		}
	}

	function check($itemid) {
		global $_username,  $MOD;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->check($v); }
		} else {
			$this->itemid = $itemid;
			$item = $this->get_one();
			if($MOD['credit_add'] && $item['username'] && $item['hits'] < 1) {
				credit_add($item['username'], $MOD['credit_add']);
				credit_record($item['username'], $MOD['credit_add'], 'system', lang('my->credit_record_add', array($MOD['name'])), 'ID:'.$this->itemid);
			}
			$editdate = timetodate(AJ_TIME, 3);
			DB::query("UPDATE {$this->table} SET status=3,hits=hits+1,editor='$_username',edittime=".AJ_TIME.",editdate='$editdate' WHERE itemid=$itemid");
			$sorttime = $this->get_sorttime(AJ_TIME, $item['vip']);
			DB::query("UPDATE {$this->table_search} SET status=3,sorttime='$sorttime' WHERE itemid=$itemid");
			$this->tohtml($itemid);
			return true;
		}
	}

	function reject($itemid) {
		global $_username;
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->reject($v); }
		} else {
			DB::query("UPDATE {$this->table} SET status=1,editor='$_username' WHERE itemid=$itemid");
			DB::query("UPDATE {$this->table_search} SET status=1 WHERE itemid=$itemid");
			return true;
		}
	}

	function expire($condition = '') {
		$result = DB::query("SELECT itemid FROM {$this->table} WHERE status=3 AND totime>0 AND totime<".AJ_TIME." $condition");
		while($r = DB::fetch_array($result)) {
			$itemid = $r['itemid'];
			DB::query("UPDATE {$this->table} SET isfx=0 WHERE itemid=$itemid");
			//DB::query("UPDATE {$this->table_search} SET status=4 WHERE itemid=$itemid");
		}		
	}

	function clear($condition = 'status=0') {		
		$result = DB::query("SELECT itemid FROM {$this->table} WHERE $condition");
		while($r = DB::fetch_array($result)) {
			$this->delete($r['itemid']);
		}
	}

	function level($itemid, $level) {
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		DB::query("UPDATE {$this->table} SET level=$level WHERE itemid IN ($itemids)");
	}

	function type($itemid, $typeid) {
		$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
		DB::query("UPDATE {$this->table} SET typeid=$typeid+1 WHERE itemid IN ($itemids)");
	}

	function refresh($itemid) {
		$editdate = timetodate(AJ_TIME, 3);
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->refresh($v); }
		} else {			
			DB::query("UPDATE {$this->table} SET edittime='AJ_TIME',editdate='$editdate' WHERE itemid=$itemid");	
			$this->itemid = $itemid;
			$item = DB::get_one("SELECT vip FROM {$this->table} WHERE itemid=$itemid");
			$sorttime = $this->get_sorttime(AJ_TIME, $item['vip']);
			DB::query("UPDATE {$this->table_search} SET sorttime='$sorttime' WHERE itemid=$itemid");
		}
	}

	function get_sorttime($edittime, $vip) {
		$sorttime = timetodate($edittime, 'Y-m-d').' '.sprintf('%02d', $vip).':'.timetodate($edittime, 'H:i');
		return strtotime($sorttime);
	}

	
	function _($e) {
		$this->errmsg = $e;
		return false;
	}
	}

?>