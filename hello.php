<?php
require 'common.inc.php';




echo AJ_ROOT;//输出站点的物理路径
echo '<br/>';

echo AJ_PATH;//输出站点的首页地址
echo '<br/>';

echo $db;
echo '<br/>';

//$r = $db->get_one("SELECT * FROM {$AJ_PRE}category");//从分类表里查询一条数据
//print_r($r);//打印读取的数据

$A = cache_read('area.php');//读取系统的地区缓存
print_r($A);//打印读取的数据
//



?>
