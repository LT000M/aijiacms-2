<?php
/*

*/
defined('IN_AIJIACMS') or exit('Access Denied');
class dftp {
	var $connected = 0;
	var $ak;
	var $sk;
	var $bk;

	function __construct($ftphost, $ftpuser, $ftppass, $ftpport = 21, $root = '/', $pasv = 0, $ssl = 0) {
		$this->connected = 1;
		$this->endpoint = $ftphost;
		$this->ak = $ftpuser;
		$this->sk = $ftppass;
		$this->bk = $root;
	}

	function dftp($ftphost, $ftpuser, $ftppass, $ftpport = 21, $root = '/', $pasv = 0, $ssl = 0) {
		$this->__construct($ftphost, $ftpuser, $ftppass, $ftpport, $root, $pasv, $ssl);
	}

	function dftp_delete($file) {
		global $AJ;
		require_once AJ_ROOT.'/api/ftpos/alioss/autoload.php';
        $accessKeyId        = $this->ak;
        $accessKeySecret    = $this->sk;
        $endpoint           = $this->endpoint;
        $bucket             = $AJ['ftp_path'];
        $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
        $result = $ossClient->deleteObject($bucket, $file);
	}

	function dftp_put($local, $remote = '') {
		global $AJ_TIME, $AJ;
		$remote or $remote = $local;
		$local = AJ_ROOT.'/'.$local;
		$key = $remote;
		require_once AJ_ROOT.'/api/ftpos/alioss/autoload.php';
        $accessKeyId        = $this->ak;
        $accessKeySecret    = $this->sk;
        $endpoint           = $this->endpoint;
        $bucket             = $AJ['ftp_path'];
        $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
        try{
            $result = $ossClient->uploadFile($bucket, $remote, $local);
            return true;
        } catch(OssException $e) {
            return false;
        }
	}

	function dftp_chdir() {
		if(!function_exists('hash_hmac')) return false;
		if(!function_exists('curl_init')) return false;
		return true;
	}

	function dftp_encode($str) {
		return str_replace(array('+', '/'), array('-', '_'), base64_encode($str));
	}
}
?>