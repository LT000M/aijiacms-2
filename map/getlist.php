<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文檔</title>
</head>
<body>
<?php
require('../common.inc.php');
$id=$_REQUEST['cid'];
//分頁設置
$page=$_REQUEST['page']?$_REQUEST['page']:1;
$condition = "status=3 and houseid=$id";
//價目格範圍

	if($j==0 and $j!='' ){
			$condition.=' AND price<30';
		}
	if($j ==1){
			$condition.=" AND price>=30  AND price<50";
			
		}
	if($j == 2){
			$condition.=' AND 50<=price AND price<80';
			
		}
	if($j== 3){
			$condition.=' AND 80<=price AND price<100';
		}
	if($j == 4){
			$condition.=' AND 100<=price AND price<120';
		}
	if($j == 5){
			$condition.=' AND 120<=price AND price<150';
		}
		if($j == 6){
			$condition.=' AND 200<=price ';
		}
	
		//間隔範圍
	if($h== 0 and $h!='' ){
			$condition.=' AND room=1';
		}
	if($h == 1){
			$condition.=" AND room=2";}
	if($h == 2){
			$condition.=' AND room=3';
			
		}
	if($h== 3){
			$condition.=' AND room=4';
		}
		if($h== 4){
			$condition.=' AND room=5';
		}
	if($h == 5){
			$condition.=' AND 5<=room ';
		}
		//list_order 排序轉換
		if($b == ''){
			$order = " order by itemid desc";
		}
		if($b == price_up){
			$order = " order by price asc";
		}
		if($b == price_down){
			$order = " order by price desc";
		}
		if($b == area_up){
			$order = " order by houseearm asc";
		}
		if($b == area_down){
			$order = " order by houseearm desc";
		}

  $pagesize =5;
	$hsall=$db->pre.'sale_5';
	$r = $db->get_one("SELECT COUNT(*) AS num FROM $hsall   WHERE  $condition");
	$items = $r['num'];
	$cnum = $r['num'];
	$pages = pages($r['num'], $page, $pagesize);
	$page=isset($page)?intval($page):1;       
     $pagenum=ceil($items/$pagesize); 
      If($page>$pagenum || $page == 0){
       Echo "暫無數據";
       Exit;
}
$offset=($page-1)*$pagesize;
$pagenum=ceil($items/$pagesize);                                   
$page=min($pagenum,$page);//獲得首頁
$prepg=$page-1;//上一頁
$nextpg=($page==$pagenum ? 0 : $page+1);//下一頁
$offset=($page-1)*$pagesize;                                     


$pagenav=" <div class='list_page'><em>";
if($prepg) $pagenav.=" <a href='javascript:;'onClick='mapPatch.goPage(".$prepg.")'>上頁</a> </em>"; else $pagenav.="上頁</em>";
if($nextpg) $pagenav.="<em> <a href='javascript:;'onClick='mapPatch.goPage(".$nextpg.")'>下頁</a></em> "; else $pagenav.=" <em>下頁</em>";
$pagenav.="<em>第<b>".$page."</b>頁</em><em>共".$pagenum."頁</em></div>";
function charsetIconv($vars,$from='gbk',$to='utf-8') {
	if (is_array($vars)) {
		$result = array();
		foreach ($vars as $key => $value) {
			$result[$key] = charsetIconv($value);
		}
	} else {
		$result = iconv($from,$to, $vars);
	}
	return $result;
}
$result = $db->query("SELECT * FROM $hsall where $condition $order LIMIT $offset,$pagesize ");
	
	while($r = $db->fetch_array($result)) {
		$arr=$r['map'];
		$r['linkurl'] = $MODULE[5][linkurl].$r['linkurl'];
		$edittime=timetodate($r[edittime], 3);
		$thumb=imgurl($r[thumb]);
		$r['title']=dsubstr($r[title], 38, '');
		if($r['price'])$r['danjia']=floor($r['price']*10000/$r['houseearm']).'元/㎡';
		if($r['price'])
		{$price=$r['price'].'萬';}
		 else 
		 {$price='面議';}
	?>
	
   <div class="list_item" title="<?php echo $r['title'];?>"><ul><li class="lit_1"><a href="<?php echo $r['linkurl'];?>" target="_blank"><img src="<?php echo $thumb;?>" height="48" width="64"></a></li><li class="lit_2"><a href="<?php echo $r['linkurl'];?>" target="_blank"><?php echo $r['title'];?></a><br><?php echo $r['room'];?>室<?php echo $r['hall'];?>廳 , <?php echo $r['houseearm'];?>㎡ , <?php echo $r['floor1'];?>層共<?php echo $r['floor3'];?>層<br><span><a href="<?php echo userurl($r[username], '');?>" target="_blank"><?php echo $r['truename'];?></a> <?php echo $edittime;?> 發佈</span></li><li class="lit_3"><?php echo $price;?><br><i><?php echo $r['danjia'];?></i></li></ul></div>
	 
<?php
}                                                              //顯示數據
?>  

 <?php echo $pagenav?>
 </body>
</html>