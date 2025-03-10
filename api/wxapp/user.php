<?php
require_once('Wechat.php');
require('Response.php');
$s = $_GET['s'];
//获取数据
$data = Wechat::$s();
//输出结果
Response::sendResponse($data);

 
?>