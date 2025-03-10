<?php
/*
	[aijiacms System] Copyright (c) 2008-2011 aijiacms.com
	This is NOT a freeware, use is subject to license.txt
*/
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
require '../../../common.inc.php';
require AJ_ROOT.'/include/mobile.inc.php';
$map_mid=explode(",",$map_mid);
		foreach($map_mid as $key =>$value){
		if($AJ['map']=='google'){
		   $lan=$map_mid['1'];
		   $lat=$map_mid['0'];
		   }
		   else
		   {
		    $lan=$map_mid['0'];
		   $lat=$map_mid['1'];}
		   }
		   $area=$db->pre.'area';
$sql1 = "SELECT * FROM $area where parentid=0 ";		
   $result = $db->query($sql1);
	while($r = $db->fetch_array($result)) {
	//$cityid=$r['areaid'];
	}
if($AJ['city']) $condition= 'where parentid=$cityid';
$sql = "SELECT * FROM $area where parentid=0";
$result = $db->query($sql);
	while($r = $db->fetch_array($result)) {
	$arr=$r['map'];
	$map=explode(",",$arr);
		foreach($map as $key =>$value){
		  $r['x'] =$map['1'];
		   $r['y']=$map['0']; 
		   }
		  
	
		  $mainareas[] = $r;
	}
	if($AJ['city']){
$mainarea = get_mainarea($cityid);
}else{
$mainarea = get_mainarea(0);
}

include template('sale', 'ditu');

?>