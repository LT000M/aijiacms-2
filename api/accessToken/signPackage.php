<?php
	// 实现微信分享功能
	// 通过script标签引入该文件，通过url参数传递原网页的完整url
	error_reporting(0);
	$queryString = $_SERVER["QUERY_STRING"];// 获取PHP后的网址参数，格式为：originUrl=...
	$url = substr($queryString,10);	// 截取原网页的完整url
	require '../../common.inc.php';
		$WX = cache_read('weixin.php');
if($WX['appid'] && $WX['appsecret'] && $WX['apptoken']){
define('GLWX_APPID', $WX['appid']);
define('GLWX_APPSECRET', $WX['appsecret']);
define('GLWX_APPTOKEN', $WX['apptoken']);
}

	require_once "jssdk.php";
	$jssdk = new JSSDK(GLWX_APPID, GLWX_APPSECRET, $url);// 改为自己公众号的AppID、AppSecret
	$signPackage = $jssdk->GetSignPackage();
	echo "var signPackage=";
 	die(json_encode($signPackage));// 返回微信分享所需参数
 ?>