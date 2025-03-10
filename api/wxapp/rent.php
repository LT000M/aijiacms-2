<?php
require_once('wxapp.php');
 $id = $_GET['id'];


$wxapp = new Response;
 
//返回数据
if($id)
{
 $wxapp ->getrent();}
 { $wxapp -> rentlist();}