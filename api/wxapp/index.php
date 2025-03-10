<?php
require_once('indexclass.php');
require('Response.php');

//获取数据
$data = indexclass::index();
//输出结果
Response::sendResponse($data);

 
?>