<?php
defined('AJ_ADMIN') or exit('Access Denied');
$smenu = array(
    array('流量统计', '?file=stats'),
	array('信息统计', '?file=count'),
	array('数据维护', '?file=database'),
	array('文件维护', '?file=patch'),
	array('标签模板', '?file=template'),
	array('计划任务', '?file=cron'),
	array('上传记录', '?file=upload'),
	array('搜索记录', '?file=keyword'),
	array('后台日志', '?file=log'),
	array('404日志', '?file=404'),
	array('问题验证', '?file=question'),
	array('词语过滤', '?file=banword'),
	array('禁止IP', '?file=banip'),
//	array('重名检测', '?file=repeat'),
	//array('单页采编', '?file=fetch'),
	//array('编辑助手', '?file=word'),
	array('系统体检', '?file=doctor'),
);
if(!$_founder) unset($menu[0],$menu[1],$menu[3]);
$menu_fenxiao = array(
	array('分销楼盘', '?moduleid=6&action=fenxiao'),
	array('客户列表', '?moduleid=2&file=house_kehu'),
	array('佣金管理', '?moduleid=2&file=amount'),
);
$kefumenu = array(

	array("客源管理", "?moduleid=2&file=keyuan"),
	array("预约记录", "?moduleid=2&file=subscribe"),
);
$menu_system = array(
	array('网站设置', '?file=setting'),
	array('模块管理', '?file=module'),
	array('更新数据', '?file=html'),
	array('分类管理', '?file=cate'),
	array('地区管理', '?file=area'),
	array('地铁管理', '?file=area_ditie'),
	array('城市分站', '?file=city'),
	array('管理员设置', '?file=admin'),
);
?>