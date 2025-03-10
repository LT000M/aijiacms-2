<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$MCFG['module'] = 'shop';
$MCFG['name'] = '商铺';
$MCFG['author'] = 'aijiacms.com';
$MCFG['homepage'] = 'www.aijiacms.com';
$MCFG['copy'] = true;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 0;

$RT = array();
$RT['file']['index'] = '商铺管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加商铺';
$RT['action']['index']['edit'] = '修改商铺';
$RT['action']['index']['delete'] = '删除商铺';
$RT['action']['index']['check'] = '审核商铺';
$RT['action']['index']['expire'] = '过期商铺';
$RT['action']['index']['reject'] = '未通过商铺';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动商铺';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>