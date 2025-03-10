<?php
require('../common.inc.php');

$p2=$_REQUEST[p2];
$p3=$_REQUEST[p3];
$p4=$_REQUEST[p4];
$p5=$_REQUEST[p5];
$p6=$_REQUEST[p6];
$p7=$_REQUEST[p7];
$p8=$_REQUEST[p8];
$p9=$_REQUEST[p9];
$p10=$_REQUEST[p10];
$p11=$_REQUEST[p11];
$p12=$_REQUEST[p12];
$p13=$_REQUEST[p13];
$newhouse=$db->pre.'rent_7';
//輸出地圖點的位置
if($p11==0){
$condition = "status=3 and map<>''";
if($p3){
	//$condition .= ' and lat>'.$p3.' and lat<'.$p4.' and lng>'.$p5.' and lng<'.$p6;
}
if($p7){
	$mix=mixprice($p7,'range','rent_7');
		$max=maxprice($p7,'range','rent_7');
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$condition.=" and $mix<=price AND price<$max ";}
		else
		{$condition.=" and $mix <= price ";}
} 
if($p8){
			//面積範圍
	if($p8== 1 ){
			$condition.=' AND houseearm<20';
		}
	if($p8== 2){
			$condition.=" AND houseearm>=20  AND houseearm<30";}
	if($p8== 3){
			$condition.=' AND 30<=houseearm AND houseearm<40';
			
		}
	if($p8== 4){
			$condition.=' AND 40<=houseearm AND houseearm<50';
		}
	if($p8== 5){
			$condition.=' AND 50<=houseearm ';
		}
}
if($p9){
 	//間隔範圍
	if($p9== 1){
			$condition.=' AND room=1';
		}
	if($p9 == 2){
			$condition.=" AND room=2";}
	if($p9 == 3){
			$condition.=' AND room=3';
			
		}
	if($p9== 4){
			$condition.=' AND room=4';
		}
		if($p9== 5){
			$condition.=' AND room=5';
		}
	if($p9 == 6){
			$condition.=' AND 5<=room ';
		}
}
if($p10){
    $condition .= " AND FIND_IN_SET('$p10',`catid`)" ;

}

	$result = $db->query("SELECT * FROM $newhouse WHERE {$condition} ");
	$total = $db->count($newhouse, $condition);
	echo "this.markersNum = ".$total.";";
	while($r = $db->fetch_array($result)) {
	/*$map = explode(',',$r['map']);
foreach($map as $key =>$value){
		  $lngX =$map['0'];
		   $latY=$map['1']; 
		   }
	if(($lngX>$p3) &&($lngX<$p4) &&($latY>$p5) &&($latY<$p6))*/
	if($r["itemid"] == null)
	 {
 }
 else{
	$cnum=$r['num'];
	$arr=$r['map'];
	$map=explode(",",$arr);
		foreach($map as $key =>$value){
		  $x =$map['0'];
		   $y=$map['1']; 
		   }
		   $title=dsubstr($r[title], 14, $suffix = '.');
	?>
this.metaMarkers.set("<?php echo $r['itemid'] ?>", {id:"<?php echo $r['itemid'] ?>", num:"<?php echo $r['num'] ?>", name:"<?php echo  $title ?>", lat:"<?php echo $x ?>", lng:"<?php echo $y ?>"});
<?php
}
}
}
 //輸出彈窗
else
{

if($p11){
$conditions .= '  itemid = '.$p11;
$result = $db->query("SELECT * FROM $newhouse where $conditions  ");
$r = $db->fetch_array($result);
$thumb=imgurl($r[thumb]);
$linkurl=$MODULE[7][linkurl].$r['linkurl'];
$title=dsubstr($r[title], 48, $suffix = '..');
if($r['price'])
		{$price=$r['price'].'元';}
		 else 
		 {$price='面議';}
$sell_phone=$r['telephone'];
$houseearm=$r['houseearm'];
$address=$r['address'];

}

?>

<div class="mapFinddingExtInofWind">
  <div class="mapFinddingExtInofWind_TopLine"> <span class="mapFinddingExtInofWind_CommName"><a href="<?php echo $linkurl; ?>" target="_blank" ><?php echo $title;?></a></span>  </div>
  <div class="mapFinddingExtInofWind_TopLine1"></div>
  <div class="mapFinddingExtInofWind_TopLine"><span style="float:left;width:200px;margin-left:5px;" class="newhouseview"><ul>
								<li>租金：<span class="familyAlpha colorF90 size14px weightBold"><?php echo $price;?></span></li>
								<li>電話：<span class="familyAlpha colorF90 size14px"><?php echo $sell_phone;?></span></li>
								<li>面積：<span class="familyAlpha"><?php echo $houseearm;?></span>呎</li>
								<li>地址：<span class="familyAlpha"><?php echo $address;?></span></li>
								
								<li class="detail"><a href="<?php echo $linkurl; ?>" target="_blank"><span class="color136">查看詳情…</span></a></li>
							
							</ul></span> <span style="float:right; margin-top:3px;"><img src="<?php echo $thumb; ?>" width="105" height="135" class="mapnewhousepic" /></span> </div>
  <div style="clear:both;"></div>
  </div>
<?php
}
?>