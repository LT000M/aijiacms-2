<?php
require('path.inc.php');
header('content-Type: text/html; charset=utf-8');
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
//输出地图点的位置
if($p11==0){
$where='where 1=1';
if($p3){
	$where .= ' and b.lat>'.$p3.' and b.lat<'.$p4.' and b.lng>'.$p5.' and b.lng<'.$p6;
}
if($p7){
	$tmp = explode('-',$p7);
	if($tmp[0]){
		$where .= ' and a.house_price >= '.intval($tmp[0]);
	}
	if($tmp[1]){
		$where .= ' and a.house_price <= '.intval($tmp[1]);
	}	
} 
if($p8){
	$tmp = explode('-',$p8);
	if($tmp[0]){
		$where .= ' and a.house_totalarea >= '.intval($tmp[0]);
	}
	if($tmp[1]){
		$where .= ' and a.house_totalarea <= '.intval($tmp[1]);
	}
}
if($p9){
	$where .= ' and a.house_room = '.$p9;
}
if($p10){
	$where .= ' and a.house_type = '.$p10;
}
$sql='select count(a.borough_id) as num,b.id as id,b.borough_name as name,b.lat as lat,b.lng as lng from fke_housesell as a left join fke_borough as b on a.borough_id = b.id '.$where.' group by a.borough_id';

mysql_query("set names gbk");
$result = mysql_query($sql);

$total = mysql_num_rows($result);
echo "this.markersNum = ".$total.";";
while($row = mysql_fetch_array($result))
  {
 if($row["id"] == null){
 }
 else{
 $str=iconv("gb2312","UTF-8",$row['name']); 
?>
this.metaMarkers.set("<?php echo $row['id'] ?>", {id:"<?php echo $row['id'] ?>", num:"<?php echo $row['num'] ?>", name:"<?php echo $str ?>", lat:"<?php echo $row['lat'] ?>", lng:"<?php echo $row['lng'] ?>"});
<?php
}
}
}
 //输出弹窗
else
{
$where='where id is not null';
if($p7){
	$tmp = explode('-',$p7);
	if($tmp[0]){
		$where .= ' and house_price >= '.intval($tmp[0]);
	}
	if($tmp[1]){
		$where .= ' and house_price <= '.intval($tmp[1]);
	}	
} 
if($p8){
	$tmp = explode('-',$p8);
	if($tmp[0]){
		$where .= ' and house_totalarea >= '.intval($tmp[0]);
	}
	if($tmp[1]){
		$where .= ' and house_totalarea <= '.intval($tmp[1]);
	}
}
if($p9){
	$where .= ' and house_room = '.$p9;
}
if($p10){
	$where .= ' and house_type = '.$p10;
}
if($p11){
mysql_query("set names gbk");
$where .= ' and borough_id = '.$p11;
$result = mysql_query("SELECT borough_name FROM fke_borough WHERE id=".$p11);
$row = mysql_fetch_array($result);
$borough_name=iconv("gb2312","UTF-8",$row['borough_name']); 
}
if($p12){
$page=$p12;
}
$order='order by id desc';
if($p13){
$order='order by '.$p13;
}
$page=isset($page)?intval($page):1;        //这句就是获取page=18中的page的值，如果不存在page，那么页数就是1。
$num=6;

$sql='select id from fke_housesell '.$where;
$result = mysql_query($sql);
$total = mysql_num_rows($result);
$pagenum=ceil($total/$num); 
If($page>$pagenum || $page == 0){
       Echo "Error : Can Not Found The page .";
       Exit;
}
$offset=($page-1)*$num;
$pagenum=ceil($total/$num);                                    //获得总页数,也是最后一页
$page=min($pagenum,$page);//获得首页
$prepg=$page-1;//上一页
$nextpg=($page==$pagenum ? 0 : $page+1);//下一页
$offset=($page-1)*$num;                                     //获取limit的第一个参数的值，如果第一页则为(1-1)*10=0,第二页为(2-1)*10=10。

//开始分页导航条代码：

//如果只有一页则跳出函数：
$pagenav=" <div class='mapFinddingExtInofWind_Pagebar'><span class='pagePre'>";
if($prepg) $pagenav.=" <a href='javascript:;'".$page." id=page_prev>上一页</a> </span>"; else $pagenav.="上一页</span>";
$pagenav.="<span class='pageInfo'>第".$page."/".$pagenum."页</span>";
if($nextpg) $pagenav.="<span class='pageNext'> <a href='javascript:;'".$page." id=page_next>下一页</a></span> "; else $pagenav.=" <span class='pageNext'>下一页</span></div>";
?>
<div class="mapFinddingExtInofWind">
  <div class="mapFinddingExtInofWind_TopLine"> <span class="mapFinddingExtInofWind_CommName"><a href="/community/g-<?php echo $p11;?>.html" target="_blank" ><?php echo $borough_name;?></a></span> <span class="mapFinddingExtInofWind_PosError">(<a href="/community/edit.php?id=<?php echo $p11;?>" target="_blank" >位置有错误?</a>)</span> </div>
  <div class="mapFinddingExtInofWind_TopLine"> <span class="mapFinddingExtInofWind_Price">&nbsp;</span> </div>
  <div class="mapFinddingExtInofWind_TopLine"> <span style="float:left;"> <?php echo $total;?>套房子符合要求</span> <span style="float:right;">
    <select id="select_order" style="font-size:12px">
      <option value="" selected="selected">选择排序方式</option>
      <option value="house_price asc" >总价由低到高</option>
      <option value="house_price desc" >总价由高到低</option>
      <option value="house_totalarea asc" >建面由小到大</option>
      <option value="house_totalarea desc" >建面由大到小</option>
    </select>
    </span> </div>
  <div  class="clearBoth"> </div>
  <!-- 小区房源数据列表 -->
  <div class="mapFinddingExtInofWind_dataBody">
<?php
$info=mysql_query("select id,house_title as title,house_thumb as imgs,house_price as price,house_totalarea as area,house_room as room from fke_housesell ".$where." ".$order." limit $offset,$num"); 
while($it = mysql_fetch_array($info)){
?>
<a href='/sale/d-<?php echo $it['id']?>.html' target='_blank' class='mapFinddingExtInofWind_dataBox' style='margin-left:3px;'  ><img src='/upfile/<?php echo $it['imgs'];?>'  border='0' class='photo' onerror="this.src='nopic.gif'"><div class='info'> <span class='room'><?php echo $it['room']?>室</span>，<span class='area'><?php echo $it['area']?>平米</span></div><div class='price'><?php echo $it['price']?>万</div></a>

<?php
}                                                              //显示数据
?>   
  <div class="clearBoth"></div>
  </div>
  <div class="clearBoth"></div>
  <!-- PagesBar Start -->
  <?php echo $pagenav?>
  <!-- PagesBar End -->
  </div>
<?php
}
?>