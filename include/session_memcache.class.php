<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
class dsession {
	var $obj;

    function __construct() {
		$this->obj = new Memcache;
		include AJ_ROOT.'/file/config/memcache.inc.php';
		$num = count($MemServer);		
		$key = $num == 1 ? 0 : abs(crc32(AJ_IP))%$num;
		$this->obj->connect($MemServer[$key]['host'], $MemServer[$key]['port'], 2);

		if(AJ_DOMAIN) @ini_set('session.cookie_domain', '.'.AJ_DOMAIN);
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_cache_limiter('private, must-revalidate');
		session_start();
		header("cache-control: private");
    }

    function dsession() {
		$this->__construct();
    }

	function open($path, $name) {
		return true;
	}

	function close() {
		return true;
	}

	function read($sid) {
		return $this->obj->get($sid);
	}

	function write($sid, $data) {
		return $this->obj->set($sid, $data, 0, 1800);
	}

	function destroy($sid) {
	     return $this->obj->delete($sid);
	}

	function gc() {
	    return true;
	}
}
?>