<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$MCFG['module'] = 'office';
$MCFG['name'] = '写字楼';
$MCFG['author'] = 'aijiacms.com';
$MCFG['homepage'] = 'www.aijiacms.com';
$MCFG['copy'] = true;
$MCFG['uninstall'] = true;
$MCFG['moduleid'] = 0;

$RT = array();
$RT['file']['index'] = '写字楼管理';
$RT['file']['html'] = '更新网页';

$RT['action']['index']['add'] = '添加写字楼';
$RT['action']['index']['edit'] = '修改写字楼';
$RT['action']['index']['delete'] = '删除写字楼';
$RT['action']['index']['check'] = '审核写字楼';
$RT['action']['index']['expire'] = '过期写字楼';
$RT['action']['index']['reject'] = '未通过写字楼';
$RT['action']['index']['recycle'] = '回收站';
$RT['action']['index']['move'] = '移动写字楼';
$RT['action']['index']['level'] = '信息级别';

$CT = 1;
?>