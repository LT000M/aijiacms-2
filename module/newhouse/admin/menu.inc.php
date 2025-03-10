<?php
defined('AJ_ADMIN') or exit('Access Denied');
$menu = array(
	array("新房列表", "?moduleid=$moduleid"),
	//array("预约记录", "?moduleid=2&file=subscribe&action=house"),
	array("红包管理", "?moduleid=$moduleid&file=hongbao"),
	array("分销客户管理", "?moduleid=2&file=house_kehu"),
	array("分销佣金管理", "?moduleid=2&file=amount"),
	array("问房管理", "?moduleid=3&file=wenfang"),
	array("点评管理", "?moduleid=3&file=comment"),
	//array("物业类型", "?file=category&mid=$moduleid"),
	//array("更新数据", "?moduleid=$moduleid&file=html"),
	//array("模块设置", "?moduleid=$moduleid&file=setting"),
	
);
?>