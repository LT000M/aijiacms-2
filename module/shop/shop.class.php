<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class shop {
	var $moduleid;
	var $itemid;
	var $table;
	var $table_data;
	var $table_search;
	var $table_item;
	var $split;
	var $errmsg = errmsg;

    function __construct($moduleid) {
		global $db,$table, $table_data, $table_search, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->table_data = $table_data;
		$this->table_search = $table_search;
		$this->table_item = AJ_PRE.'house_pic';
		$this->split = $MOD['split'];
		$this->fields = array('catid','mycatid','areaid','typeid','level','title','tag','style','fee','introduce','price','days','thumb','thumbs','video','thumb1','thumb2','thumb3','thumb4','tag','status','hits','username','totime','editor','addtime','adddate','edittime','editdate','ip','template','linkurl','filepath','elite','note','company','truename','telephone','mobile','address','email','msn','qq','wx','ali','skype','housename','houseid','shopstate','facewidth','depth','floorheight','houseearm','floor1','floor2','fenge','fitment','paytype','map','wuye','payinfo','bus','transferfee','freetime','leasetime','zongjia','wuyefei','fenge','leibie');
   
		
    }

    function shop($moduleid) {
		$this->__construct($moduleid);
    }

	function pass($post) {
		global $MOD;
		if(!is_array($post)) return false;
		if(!$post['catid']) return $this->_(lang('message->pass_cate'));
		if(strlen($post['title']) < 3) return $this->_(lang('message->pass_title'));
		//	if(!$post['thumb']) return $this->_(lang('message->pass_thumb'));
			if(strlen($post['content']) < 3) return $this->_(lang('message->pass_content'));
		if($post['totime']) {
			if(!is_time($post['totime'])) return $this->_(lang('message->pass_date'));
			if(strtotime($post['totime']) < AJ_TIME) return $this->_(lang('message->pass_todate'));
		}
		if(AJ_MAX_LEN && strlen(clear_img($post['content'])) > AJ_MAX_LEN) $this->_(lang('message->pass_max'));
		return true;
	}

	function set($post) {
		global $MOD, $TYPE, $_username, $_userid;
		 $newhouse=AJ_PRE.'newhouse_6';
	  $newhouse_data=AJ_PRE.'newhouse_data_6';
	   $borough_name= $post['housename'];
	   $borough_info = DB::get_one("select itemid,map from $newhouse where title = '".$borough_name."'");
		 $borough_map =	$borough_info['map'];
	  if($borough_info){
	  $result = DB::query("SELECT * FROM $newhouse WHERE title = '".$borough_name."'");
		while($r = DB::fetch_array($result)) {
			//$r['borough_id'] = $r['itemid'];
			$borough_id=$r['itemid'];
			//$lists[] = $r;
		} 
		}
	  
	  else{
   	 $post['letter'] = GetPinyin($post['housename']);
	 $post['catids']=$post['catid']-12;
	 	 $MODx = cache_read('module-18.php');
$need_check =  $MODx['check_add'] == 2 ? $MG['check'] : $MODx['check_add'];
$status = get_status(3, $need_check);
		$insertField = array(
			'title'=>$post['housename'],
			'letter'=>$post['letter'],
			'areaid'=>$post['areaid'],
			'status'=>$status,
			'catid'=>$post['catids'],
			'username'=>$post['username'],
			'address'=>$post['address'],
			'map'=>$post['map'],
			 'editor' =>$_username,
		    'addtime'=> AJ_TIME,
			'adddate' => timetodate($post['addtime'], 3),);
		
		$fieldNameList = array();
		$fieldValueList = array();
		foreach ($insertField as $fieldName => $fieldValue) {
			if (!is_int($fieldName)) {
				$fieldNameList[] = $fieldName;
				$fieldValueList[] = '\'' . $fieldValue . '\'';
			}
		}
		$fieldName = implode(',', $fieldNameList);
		$fieldValue = implode(',', $fieldValueList);
		
		DB::query("INSERT INTO  $newhouse ($fieldName) VALUES ($fieldValue)");
	    $this->houseid = DB::insert_id();
       $borough_id=$this->houseid;
			DB::query("INSERT INTO $newhouse_data (itemid) VALUES ($this->houseid)");
			$linkurl = $borough_id.'/';
			DB::query("UPDATE $newhouse SET  linkurl='$linkurl' where itemid=$this->houseid");
			
			} 
		$thumbs = array();
		foreach($post['thumbs'] as $v) {
			if(is_url($v)) $thumbs[] = $v;
		}
		if($thumbs) {
			$post['thumb'] = $thumbs[0];
			array_shift($thumbs);
			$post['thumbs'] = implode('|', $thumbs);
		} else {
			$post['thumb'] = $post['thumbs'] = '';
		}
		is_url($post['video']) or $post['video'] = '';
		$post['filepath'] = (isset($post['filepath']) && is_filepath($post['filepath'])) ? file_vname($post['filepath']) : '';
		$post['editor'] = $_username;
		$post['addtime'] = (isset($post['addtime']) && is_time($post['addtime'])) ? strtotime($post['addtime']) : AJ_TIME;
		$post['adddate'] = timetodate($post['addtime'], 3);
		$post['edittime'] = AJ_TIME;
		$post['editdate'] = timetodate($post['edittime'], 3);
		$post['totime'] = is_time($post['totime']) ? strtotime($post['totime']) : 0;
		$post['fee'] = dround($post['fee']);
		//$post['price'] = dround($post['price']);
		$post['telephone'] = trim($post['mobile']);
		$post['minamount'] = dround($post['minamount']);
		$post['amount'] = dround($post['amount']);
		$post['mycatid'] = intval($post['mycatid']);
			$post['houseid'] = $borough_id;
		$post['days'] = intval($post['days']);
		$post['elite'] = $post['elite'] ? 1 : 0;
		$post['content'] = stripslashes($post['content']);
		$post['content'] = save_local($post['content']);
		if($MOD['clear_link']) $post['content'] = clear_link($post['content']);
		if($MOD['save_remotepic']) $post['content'] = save_remote($post['content']);
		if($MOD['introduce_length']) $post['introduce'] = addslashes(get_intro($post['content'], $MOD['introduce_length']));
		if($this->itemid) {
			$new = $post['content'];
			$new .= '<img src="'.$post['thumb'].'"/>';
			foreach($thumbs as $v) {
				$new .= '<img src="'.$v.'"/>';
			}
			$r = $this->get_one();
			$old = $r['content'];
			$old .= '<img src="'.$r['thumb'].'"/>';
			foreach(explode('|', $r['thumbs']) as $v) {
				$old .= '<img src="'.$v.'"/>';
			}
			delete_diff($new, $old);
			if($r['video'] != $post['video']) delete_upload($r['video'], match_userid($r['video']));
		} else {
			$post['ip'] = AJ_IP;
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

	function get_list($condition = 'status=3', $order = 'edittime DESC', $cache = '') {
		global $MOD, $pages, $page, $pagesize, $offset, $items, $sum;
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
			$houseid = $r['itemid'];
			 $isappo = DB::get_one("SELECT * FROM ".AJ_PRE."appolist WHERE   house_id = $houseid AND appo_site='rent'");
			$r['is_appo'] = $isappo ? 1 : 0;
		
			$r['linkurl'] = $MOD['linkurl'].$r['linkurl'];
			$catids[$r['catid']] = $r['catid'];
			$lists[] = $r;
		}
		if($catids) {
			$result = DB::query("SELECT catid,catname,linkurl FROM ".AJ_PRE."category WHERE catid IN (".implode(',', $catids).")");
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
			clear_upload($post['content'].$post['thumb'].$post['thumbs'].$post['video'], $this->itemid);
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
			clear_upload($post['content'].$post['thumb'].$post['thumbs'].$post['video'], $this->itemid);
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
					if($r['video']) delete_upload($r['video'], $userid);
				if($r['thumb']) delete_upload($r['thumb'], $userid);
				if($r['thumbs']) {
					foreach(explode('|', $r['thumbs']) as $v) {
						if($v) delete_upload($v, $userid);
					}
				}
				if($r['content']) delete_local($r['content'], $userid);
				DB::query("DELETE FROM {$this->table} WHERE itemid=$itemid");
				DB::query("DELETE FROM {$this->table_search} WHERE itemid=$itemid");
				$content_table = content_table($this->moduleid, $this->itemid, $this->split, $this->table_data);
				DB::query("DELETE FROM {$content_table} WHERE itemid=$itemid");
				if($MOD['cat_property']) DB::query("DELETE FROM ".AJ_PRE."category_value WHERE moduleid=$this->moduleid AND itemid=$itemid");
				if($r['username'] && $MOD['credit_del']) {
					credit_add($r['username'], -$MOD['credit_del']);
					credit_record($r['username'], -$MOD['credit_del'], 'system', lang('my->credit_record_del', array($MOD['name'])), 'ID:'.$this->itemid);
				}
			}
		}
	}

	function check($itemid) {
		global $_username, $MOD;
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
			DB::query("UPDATE {$this->table} SET status=3,editor='$_username',edittime=".AJ_TIME.",editdate='$editdate' WHERE itemid=$itemid");
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
			DB::query("UPDATE {$this->table} SET status=4 WHERE itemid=$itemid");
			DB::query("UPDATE {$this->table_search} SET status=4 WHERE itemid=$itemid");
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
		DB::query("UPDATE {$this->table} SET typeid=$typeid WHERE itemid IN ($itemids)");
	}

	function refresh($itemid) {
		$editdate = timetodate(AJ_TIME, 3);
		if(is_array($itemid)) {
			foreach($itemid as $v) { $this->refresh($v); }
		} else {			
			DB::query("UPDATE {$this->table} SET edittime='".AJ_TIME."',editdate='$editdate' WHERE itemid=$itemid");	
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
function renttop($itemid,$to_time) {
	       $rent=AJ_PRE.'rent_7';
			DB::query("UPDATE $rent SET istop=1,to_time=$to_time WHERE itemid=$itemid");
			return true;
          	}
	function renthot($itemid,$to_time) {
	       $rent=AJ_PRE.'rent_7';
			DB::query("UPDATE $rent SET ishot=1,hot_time=$to_time WHERE itemid=$itemid");
			return true;
     }
    
	function item_list($condition = 'status=3', $order = 'listorder ASC,itemid ASC', $cache = '') {
		global $MOD, $pages, $page, $pagesize, $offset, $items, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(*) AS num FROM {$this->table_item} WHERE $condition", $cache);
			$items = $r['num'];
		}
		$pages =  pages($items, $page, $pagesize);
		$lists = $catids = $CATS = array();
		$result = DB::query("SELECT * FROM {$this->table_item} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize", $cache);
		while($r = DB::fetch_array($result)) {
			$lists[] = $r;
		}
		return $lists;
	}
	

	
	
	function item_delete($itemid = 0) {
		global $_userid;
		if($itemid) {
			$r = DB::get_one("SELECT thumb FROM {$this->table_item} WHERE itemid=$itemid");
			if($r) {
				delete_upload($r['thumb'], $_userid);
				DB::query("DELETE FROM {$this->table_item} WHERE itemid=$itemid");
			}
		} else {
			$result = DB::query("SELECT thumb FROM {$this->table_item} WHERE item=$this->itemid");
			while($r = DB::fetch_array($result)) {
				delete_upload($r['thumb'], $_userid);
			}
			DB::query("DELETE FROM {$this->table_item} WHERE item=$this->itemid");
		}
	}
   function item_index($itemid) {
		$item = DB::get_one("SELECT * FROM {$this->table_item} WHERE itemid=$itemid");
		$update = '';
		$thumb = $item['thumb'];
		$item = $item['item'];
		DB::query("UPDATE {$this->table} SET thumb='$thumb' WHERE itemid=$item");
	}
	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>