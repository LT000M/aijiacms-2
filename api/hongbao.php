<?php  

require '../common.inc.php';
require AJ_ROOT.'/include/post.func.php';

$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);

//团购报名



$_POST['hname']=$hname;
$_POST['truename']=$truename;
$_POST['house']=$house;
$_POST['linkurl']=$linkurl;
$_POST['money']=$money;
$username=$_username ? $_username : '游客';
$_POST['phone']=$phone;
$_POST['name']=$name;


if(!empty($phone)){
 $db->query("UPDATE {$AJ_PRE}newhouse_6 SET hbnum=hbnum+1 WHERE itemid='$house'");
  $db->query("INSERT INTO {$AJ_PRE}hongbao (username,house,hname,money,addtime,status,mobile,truename) VALUES ('$username','$house','$hname','$money','$AJ_TIME',0,'$phone','$name')");	
	

		
   
$forward = $linkurl;
	dalert('报名成功', $forward);
      
}
	   else
	    { dalert('报名失败', $forward);}




?>