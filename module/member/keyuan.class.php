<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class keyuan {
	var $id;
	var $table;
	var $fields;
	var $errmsg = errmsg;

    function __construct() {
		$this->table = AJ_PRE.'keyuan';
		
		
		$this->fields = array('khxingming','kehulx','dianhua','xqhuxing1','xqhuxing2','xqjiage1','xqjiage2','xqmianji1','xqmianji2','xqyongtu','khlaiyuan','xqquyu','xqxiaoqu','chaoxiang','zhuangxiu','peitao','xqyuanyin','louceng1','louceng2','fangling1','fangling2','fukuan','gtjieduan','guoji','minzu','xflinian','kydengji','sfzheng','qqhao','youxiang','weixin','jtgongju','chexing','beizhu','xiugaisj','lurusj','lurusj','xqbianhao','weihuren','weihurenid','lururenid','dkusername');
    }

    function keyuan() {
		$this->__construct();
    }

	function pass($post) {
		global $_userid, $L;
		if(!is_array($post)) return false;
		return true;
	}

	function set($post) {
		global $MOD,  $AJ_IP, $TYPE, $_truename, $_userid;
		$post['weihuren'] =$_truename;
		$post['weihurenid'] =$_userid;
		$post['lururenid'] =$_userid;
	    $post['chaoxiang']=implode(',',$post['chaoxiang']);
		$post['zhuangxiu']=implode(',',$post['zhuangxiu']);
		$post['peitao']=implode(',',$post['peitao']);
		$post = dhtmlspecialchars($post);
		return array_map("trim", $post);
	}

	function get_one($condition = '') {
        return DB::get_one("SELECT * FROM {$this->table} WHERE id=$this->id $condition");
	}

	function get_list($condition = 'dshenhe=0', $order = 'id DESC') {
		global $TYPE, $pages, $page, $pagesize, $offset, $L, $items, $sum;
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
			$r['adddate'] = timetodate($r['addtime'], 5);
			$r['dcompany'] = set_style($r['company'], $r['style']);
			$r['type'] = $r['typeid'] && isset($TYPE[$r['typeid']]) ? set_style($TYPE[$r['typeid']]['typename'], $TYPE[$r['typeid']]['style']) : $L['default_type'];
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) { $sqlk .= ','.$k; $sqlv .= ",'$v'"; }
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		DB::query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->id = DB::insert_id();
		$xqbianhao='MK'.$this->id;
		  DB::query("UPDATE {$this->table} SET xqbianhao='$xqbianhao' WHERE id=$this->id");
		return $this->id;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    DB::query("UPDATE {$this->table} SET $sql WHERE id=$this->id");
		
		return true;
	}

	function delete($id) {
		$ids = is_array($id) ? implode(',', $id) : $id;
		DB::query("DELETE FROM {$this->table} WHERE id IN ($ids)");
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>