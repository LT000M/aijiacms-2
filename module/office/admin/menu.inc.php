<?php
defined('AJ_ADMIN') or exit('Access Denied');
$menu = array(
	//	array("添加".$name, "?moduleid=$moduleid&action=add"),
	array($name."列表", "?moduleid=$moduleid"),
	//array("审核".$name, "?moduleid=$moduleid&action=check"),
	//array("物业类型", "?file=category&mid=$moduleid"),
	//array("更新数据", "?moduleid=$moduleid&file=html"),
	array("模块设置", "?moduleid=$moduleid&file=setting"),
);
?>