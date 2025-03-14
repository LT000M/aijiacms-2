<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
class dsession {
	function __construct() {
		if(AJ_DOMAIN) @ini_set('session.cookie_domain', '.'.AJ_DOMAIN);
		@ini_set('session.gc_maxlifetime', 1800);
    	if(is_dir(AJ_ROOT.'/file/session/')) {
			$dir = AJ_ROOT.'/file/session/'.strtolower(substr(md5(AJ_KEY), 2, 6)).'/';
			if(is_dir($dir)) {
				session_save_path($dir);
			} else {
				dir_create($dir);
			}
		}
		session_cache_limiter('private, must-revalidate');
		@session_start();
		header("cache-control: private");
    }

    function dsession() {
		$this->__construct();
    }
}
?>