<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
class member {
	var $userid;
	var $db;
	var $table;
	var $fields;
	var $errmsg = errmsg;

     function __construct() {
		global $db;
		$this->table = AJ_PRE.'member';
		$this->table_company = AJ_PRE.'company';
		$this->table_company_data = AJ_PRE.'company_data';
		$this->table_member_misc = AJ_PRE.'member_misc';
		$this->table_member_check = AJ_PRE.'member_check';
		$this->db = &$db;
		$this->fields = array('username','company','passport', 'password','payword','email','sound','gender','truename','mobile','msn','qq','ali','skype','department','career','groupid','regid','areaid','edittime','inviter','passsalt', 'paysalt','companyid');
		
    }
	function member() {
		$this->__construct();
    }
	
	function pass($post) {
		global $L;
		if(!is_array($post)) return false;
	
		return true;
	}

	function set($post) {
         global $AJ_TIME, $_company, $AJ_IP, $MOD, $L;
        $post['edittime'] = $AJ_TIME;
		$post['company'] = $post['company'];	
		$post['groupid'] = 6;	
		$userid=$post['companyid'];
		$post['linkurl'] = userurl($post['username']);
		$password = $post['password'];
		$post['passsalt'] = random(8);
		$post['paysalt'] = random(8);
		$post['password'] = dpassword($password, $post['passsalt']);
		$post['payword'] = dpassword($password, $post['paysalt']);
		//$post['password'] = $post['payword'] = md5(md5($post['password']));		
		$post = dhtmlspecialchars($post);		
		return $post;
	}
    function get_one($condition = '') {
        return $this->db->get_one("SELECT * FROM {$this->table} WHERE userid=$this->userid $condition");
	}

	function get_list($condition, $order = 'userid ASC') {
	
		global $MOD, $pages, $page, $pagesize, $offset;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
		$pages = pages($r['num'], $page, $pagesize);		
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['logindate'] = timetodate($r['logintime'], 5);
			$r['editdate'] = timetodate($r['edittime'], 5);
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
		$this->db->query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		$this->userid = $this->db->insert_id();	
		$userid=$post['companyid'];
		$username=$post['username'];
		$company=$post['company'];
		$areaid=$post['areaid'];
		$linkurl = userurl($post['username']);
		
		  $this->db->query("INSERT INTO {$this->table_company} (userid,username,groupid,areaid,company,linkurl) VALUES ('$this->userid','$username','6','$areaid','$company','$linkurl')");	
          $this->db->query("INSERT INTO {$this->table_member_misc} (userid, username,banktype,send) VALUES ('$this->userid' ,'$username','0','1')");
          $this->db->query("INSERT INTO {$this->table_company_data} (userid, content) VALUES ('$this->userid', '$member[content]')");
		return $this->userid;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    $this->db->query("UPDATE {$this->table} SET $sql WHERE userid=$this->userid");
		return true;
	}

    function delete($userid) {
		global  $L;
	     $this->db->query("UPDATE {$this->table} SET companyid=0 WHERE userid=$this->userid");
		 echo "UPDATE {$this->table} SET companyid=0 WHERE userid=$this->userid";
		return true;
	}
	function deleted($userid, $all = true) {
		global  $L;
		if(is_array($userid)) {
			foreach($userid as $v) { $this->delete($v); }
		} else {
			$this->userid = $userid;
			$this->username = $username;
			  $this->db->query("UPDATE {$this->table} SET companyid=0 WHERE userid=$this->userid");
		}
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>