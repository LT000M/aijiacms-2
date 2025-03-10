<?php
    header('content-type:application/json;charset=utf-8');

include '../../common.inc.php';
$biao=$AJ_PRE.'newhouse_6';
	$sale=$AJ_PRE.'rent_7';	
$zoom = $_GET['zoom'];
$areaid = $_GET['city'];
$price = $_GET['price'];
$projecttype = $_GET['type'];
$buildfeature = $_GET['special'];
$status = $_GET['status'];
$bssw_lat = $_GET['bssw_lat'];
$bssw_lng = $_GET['bssw_lng'];
$bsne_lat = $_GET['bsne_lat'];
$bsne_lng = $_GET['bsne_lng'];
$roomtype = intval($_GET['room']);
$condition = "status=3 and map <>''";

if (isset($status) &&!empty($status))
{
$condition.=" and `typeid` in ($status)";
}
if (isset($price) &&!empty($price))
{
$mix=mixprice($price,'range','rent_7');
		$max=maxprice($price,'range','rent_7');
		if($mix){$mix=$mix;}
		else
		{$mix=0;}
		if($max){$condition.=" and $mix<=price AND price<$max ";}
		else
		{$condition.=" and $mix <= price ";}
}
if (isset($roomtype) &&!empty($roomtype))
{
$condition.=" and `room` = '$roomtype'";
}
if (isset($buildfeature) &&!empty($buildfeature))
{
$condition .= " AND FIND_IN_SET('$buildfeature',`lpts`)" ;
}
if (isset($projecttype) &&!empty($projecttype))
{
$condition .= " AND FIND_IN_SET('$projecttype',`catid`)" ;

}


	if (isset($areaid) &&!empty($areaid))
{$condition .= $ARE['child'] ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";
}
if (isset($circleid) &&!empty($circleid))$condition .= " AND areaid=$circleid";
$result = $db->query("SELECT * FROM $biao WHERE $condition ORDER BY itemid DESC");
while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}
if($tags)
{
$num=0;
$json = array();
foreach($tags AS $k=>$v) {


$map = explode(',',$v['map']);

foreach($map as $key =>$value){
		  $lngX =$map['0'];
		   $latY=$map['1']; 
		   }
		   
	
if($bssw_lat<$latY && $latY<$bsne_lat && $bssw_lng<$lngX && $lngX<$bsne_lng)

{
$num++;
if(($v['priceunit']=="0")||empty($v['priceunit']))
{
$priceunit = '元/平方米';
}
else
{
$priceunit = '元/套';
}
if(empty($v['price'])||($v['price']==' ')||($v['price']==''))
{
$v['price'] = '';
$priceunit = '';
}
$total=get_sale($v['itemid']);
$housenums = $db->count($sale, 'status=3 and houseid ='.$v['itemid']. ' and ' .$condition.'');

if($housenums)
{
$linkurl=$MODULE[1][linkurl].'mobile/community/'.$v['linkurl'].'/rent.html';
$r = array('id'=>$v['itemid'],'title'=>$v['title'],'img'=>$v['thumb'],'sale_status'=>$v['typeid'],'city'=>$v['areaid'],'address'=>$v['address'],'price'=>$total,'lat'=>$latY,'lng'=>$lngX,'unit'=>"",'url'=>$linkurl,'w_url'=>$linkurl);


$json[] = JSON($r);
}
else
{
continue;
}
}
}
$lists = array();
$result = $db->query("SELECT * FROM ".AJ_PRE."area WHERE parentid=0 ORDER BY areaid,listorder");
while($r = $db->fetch_array($result)) {
	$cat[] = $r;
	$map = explode(',',$r['map']);

foreach($map as $key =>$value){
		  $lngX =$map['1'];
		   $latY=$map['0']; 
		   }
	$ARE = get_area($r['areaid']);
	$areaid=$r['areaid'];
	$conditions = "status=3  and map <>''";
	$conditions .= $ARE['child'] ? " and areaid IN (".$ARE['arrchildid'].")" : " and areaid=$areaid";	

	$items = $db->count($sale, $conditions, $CFG['db_expires']);
	   
$cityname.='{"price":"","city_name":"'.$r['areaname'].'","total":"'.$items.'套房源","lat":"'.$lngX.'","lng":"'.$latY.'"},';	

}
   $cityname = rtrim($cityname, ','); 
$city='"countData":['.$cityname.'],"zoom":"10"';
$json_str =header('content-type:application/json;charset=utf-8');
	$json_str =header('Access-Control-Allow-Origin: *');
if($num>0)
{
header('content-type:application/json;charset=utf-8');

$json_str ="{\"code\":1,\"data\":[";
$json_str .= implode(',',$json);

if($zoom>13)
{
	$json_str .= '],"zoom":"15"}';
}
else
{
$json_str .= '],'.$city.'}';}
}



else
{
$json_str ="{\"code\":null}";
}


echo $json_str;
}
else
{
$json_str ="{\"code\":null}";
$json_str=http_response_code($json_str);
echo $json_str;
}
function arrayRecursive(&$array,$function,$apply_to_keys_also = false)
{
foreach ($array as $key =>$value) {
if (is_array($value)) {
arrayRecursive($array[$key],$function,$apply_to_keys_also);
}else {
$array[$key] = $function($value);
}
if ($apply_to_keys_also &&is_string($key)) {
$new_key = $function($key);
if ($new_key != $key) {
$array[$new_key] = $array[$key];
unset($array[$key]);
}
}
}
}

function JSON($array) {
arrayRecursive($array,'urlencode',true);
$json = json_encode($array);
return urldecode($json);
}
function unicode_encode($name)
{
$name = urldecode($name);
$name = iconv('UTF-8','UCS-2BE',$name);
$len = strlen($name);
$str = '';
for ($i = 0;$i <$len -1;$i = $i +2)
{
$c = $name[$i];
$c2 = $name[$i +1];
if (ord($c) >0)
{
$str .= '\u'.base_convert(ord($c),10,16).str_pad(base_convert(ord($c2),10,16),2,0,STR_PAD_LEFT);
}
else
{
$str .= $c2;
}
}
return $str;
}

?>