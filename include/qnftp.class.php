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
		$this->ak = $ftpuser;
		$this->sk = $ftppass;
		$this->bk = $root;
	}

	function dftp($ftphost, $ftpuser, $ftppass, $ftpport = 21, $root = '/', $pasv = 0, $ssl = 0) {
		$this->__construct($ftphost, $ftpuser, $ftppass, $ftpport, $root, $pasv, $ssl);
	}

	function dftp_delete($file) {
		$key = $file;
		$entry = $this->bk.':'.$key;
		$encodedEntryURI = $this->dftp_encode($entry);
		$signingStr = "/delete/".$encodedEntryURI."\n";
		$sign = hash_hmac('sha1', $signingStr, $this->sk, true);
		$encodedSign = $this->dftp_encode($sign);
		$accessToken = $this->ak.':'.$encodedSign;
		$headers = array();
		$headers[] = 'Authorization: QBox '.$accessToken;
		$cur = curl_init('http://rs.qiniu.com/delete/'.$encodedEntryURI);
		curl_setopt($cur, CURLOPT_POST, 1);
		curl_setopt($cur, CURLOPT_POSTFIELDS, '');
		curl_setopt($cur, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($cur, CURLOPT_HEADER, 0);
		curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cur, CURLOPT_HTTPHEADER, $headers);
		$rec = curl_exec($cur);
		curl_close($cur);
	}

	function dftp_put($local, $remote = '') {
		global $AJ_TIME;
		$remote or $remote = $local;
		$local = AJ_ROOT.'/'.$local;
		$key = $remote;
		$P = array();
		$P['scope'] = $this->bk.':'.$key;
		$P['deadline'] = $AJ_TIME + 3600;
		$putPolicy = json_encode($P);
		$encodedPutPolicy = $this->dftp_encode($putPolicy);
		$sign = hash_hmac('sha1', $encodedPutPolicy, $this->sk, true);
		$encodedSign = $this->dftp_encode($sign);
		$uploadToken = $this->ak.':'.$encodedSign.':'.$encodedPutPolicy;
		$headers = array();
		$headers[] = 'Expect: ';
		$par = array();
		$par['key'] = $key;
		$par['token'] = $uploadToken;
		$par['file'] = '@'.$local;
		$cur = curl_init('http://up-z2.qiniu.com/');
		curl_setopt($cur, CURLOPT_POST, 1);
		curl_setopt($cur, CURLOPT_POSTFIELDS, $par);
		curl_setopt($cur, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($cur, CURLOPT_HEADER, 0);
		curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cur, CURLOPT_HTTPHEADER, $headers);
		$rec = curl_exec($cur);
		curl_close($cur);
		if(strpos($rec, 'key') !== false) {
			$arr = json_decode($rec, true);
			if($arr['key'] == $key) return true;
		}
		return false;
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