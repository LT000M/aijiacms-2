<?php

require '../common.inc.php';
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
	$cityids=$r['areaid'];
	}
if($AJ['city']) $condition= 'where parentid=$cityids';
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
	
if($AJ['map']=='google'){include template('newhousegoogle', 'map');}
else
{
	
		include template('newhouse', 'map');}

?>