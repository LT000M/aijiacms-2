<?php  

require '../common.inc.php';
require AJ_ROOT.'/include/post.func.php';

$_GET = safe_replace($_GET);
$_POST = safe_replace($_POST);


$MOD = cache_read('module-3.php');
$username=$_username ? $_username : '游客';
$house=$_POST['house_id'];
$hname=$_POST['hname'];
$content=$_POST['content'];
$linkurl=$_POST['linkurl'];
$status = get_status(3, $MOD['wenfang_check'] == 2 ? $MG['check_add'] : $MOD['wenfang_check']);
if(!empty($content)){
	
$db->query("INSERT INTO {$AJ_PRE}wenfang (item_mid,item_id,item_title,item_linkurl,item_username,content,quotation,qid,addtime,username,hidden,star,ip,status) VALUES (6,'$house','$hname','$linkurl','$username','$content','$quotation','$qid','$AJ_TIME','$_username','$hidden','$star','$AJ_IP','$status')");
 

 header('content-type:application/json;charset=utf-8');
  echo json_encode(array('code'=>'1','msg'=>'提交成功！'));

}
	   else
	    { 
		 header('content-type:application/json;charset=utf-8');
		  echo json_encode(array('code'=>'0','msg'=>'提交失败！'));

		  }




?>