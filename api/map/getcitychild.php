<?php
    header('content-type:application/json;charset=utf-8');
include '../../common.inc.php';
$areaid = intval($_GET['pid']);
 $area=$db->pre.'area';
 $city = $db->get_one("SELECT * FROM $area WHERE areaid=$areaid");
  $areaname = $city['areaname'];
$map = explode(',',$city['map']);
foreach($map as $key =>$value){
		  $lng =$map['1'];
		   $lat=$map['0']; 
		   }
 $condition="parentid=$areaid";
$result = $db->query("SELECT * FROM $area WHERE parentid=$areaid ORDER BY areaid DESC");

while($r = $db->fetch_array($result)) {
	$tags[] = $r;
		}

$items = $db->count($area, $condition, $CFG['db_expires']);

if($items)
{
	
	foreach($tags AS $k=>$v) {
$map = explode(',',$v['map']);
foreach($map as $key =>$value){
		  $lngX =$map['1'];
		   $latY=$map['0']; 
		   }
		
		$areaids=$v['areaid'];
		$name=$v['areaname'];
$r = array('id'=>$v['areaid'],'pid'=>$v['parentid'],'name'=>$v['areaname'],'lat'=>$lngX,'lng'=>$latY);
$r=array($areaids=>$r);

$json[] = JSON($r);
}

}
if($tags)
{
	 header('content-type:application/json;charset=utf-8');


$json_str ="{\"code\":1,\"data\":";


$json_str .= implode(',',$json);

$json_str .=",\"points\":{\"lng\":\"$lat\",\"lat\":\"$lng\",\"name\":\"$areaname\"}}";
$json_str=$str=str_replace("}},{","},",$json_str); 



}
else
{
 header('content-type:application/json;charset=utf-8');


$json_str ="{\"code\":0";


$json_str .= implode(',',$json);

$json_str .=",\"points\":{\"lng\":\"$lat\",\"lat\":\"$lng\",\"name\":\"$areaname\"}}";
$json_str=$str=str_replace("}},{","},",$json_str); 
}
echo $json_str;	
		

		
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