<?php
require_once('Baidu.php');
require('Response.php');
$s = $_GET['s'];
//获取数据
$data = Baidu::$s();
//输出结果
Response::sendResponse($data);

 
?>