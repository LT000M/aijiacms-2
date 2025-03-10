<?php
require('path.inc.php');

$page->title =  $page->title.' - 虚假举报';

if($page->action == 'save'){
	//保存在ajax页面	
	$house_id = intval($_POST['house_id']);

	$house = new HouseSell($query);
	$report_target = $house->getInfo($house_id,'broker_id');
	
	$member = new Member($query);
	$member_id = $member->getAuthInfo('id');
	$reason = iconv('utf-8','gbk',$_POST['reason']);
	$report = new Report($query);
	$dataFiled = array(
		'house_type'=>'sell',
		'house_id'=>$house_id,
		'report_target'=>$report_target,
		'reason'=>$reason,
		'reporter'=>$member_id,
	);
	try{
		$report->save($dataFiled);
		echo 1;	
	}catch (Exception $e){
		echo 0;
	}
	exit;
}else{
	$page->name = 'report';
}

$page->show();
?>