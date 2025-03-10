<?php  

require '../common.inc.php';
require AJ_ROOT.'/include/post.func.php';

$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);

//领取红包

$username=$_username ? $_username : '游客';
$truename=$_POST['user_name'];
$money=$_POST['money'];
$house=$_POST['house_id'];
$hname=$_POST['hname'];
$phone=$_POST['mobile'];
$type=$_POST['type'];
$typename=$_POST['typename'];
$content='['.$typename.']'.$hname;
$linkurl=$_POST['linkurl'];
 header('content-type:application/json;charset=utf-8');
if(!empty($phone)){
	if($type==1)
{
 $db->query("UPDATE {$AJ_PRE}newhouse_6 SET hbnum=hbnum+1 WHERE itemid='$house'");
  $db->query("INSERT INTO {$AJ_PRE}hongbao (username,house,hname,money,addtime,status,mobile,truename) VALUES ('$username','$house','$hname','$money','$AJ_TIME',0,'$phone','$truename')");	
}
else
{
$db->query("UPDATE {$AJ_PRE}member SET message=message+1 WHERE username='$touser'");
  $db->query("INSERT INTO {$AJ_PRE}message (title,typeid,touser,fromuser,content,addtime,ip,status,telephone,truename,sex,email,linkurl) VALUES ('$hname', 1,'$touser','$fromuser','$content','$AJ_TIME','$AJ_IP',3,'$phone','$truename','$sex','$email','$linkurl')");	
	}

  echo json_encode(array('code'=>'1','msg'=>'提交成功！'));

}
	   else
	    { 
		  echo json_encode(array('code'=>'0','msg'=>'提交失败！'));

		  }




?>