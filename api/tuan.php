<?php  

require '../common.inc.php';
require AJ_ROOT.'/include/post.func.php';

$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);

//团购报名


$_POST['title']=addslashes($title);
$_POST['touser']=$touser;
$_POST['fromuser']=$fromuser;
$_POST['content']=addslashes($title);
//$_POST['mobile']=$mobile;
$_POST['telephone']=$telephone;
$_POST['truename']=$truename;
$_POST['email']=$email;
$_POST['linkurl']=$linkurl;
if(!empty($telephone)){
$db->query("UPDATE {$AJ_PRE}member SET message=message+1 WHERE username='$touser'");
  $db->query("INSERT INTO {$AJ_PRE}message (title,typeid,touser,fromuser,content,addtime,ip,status,telephone,truename,sex,email,linkurl) VALUES ('$title', 1,'$touser','$fromuser','$content','$AJ_TIME','$AJ_IP',3,'$telephone','$truename','$sex','$email','$linkurl')");
		
   
$forward = $linkurl;
	dalert('报名成功', $forward);
      
}
	   else
	    { dalert('报名失败', $forward);}




?>