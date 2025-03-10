<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/include/module.func.php';
require AJ_ROOT.'/module/'.$module.'/global.func.php';
$table = $AJ_PRE.$module.'_'.$moduleid;
$table_data = $AJ_PRE.$module.'_data_'.$moduleid;
$table_search = $AJ_PRE.$module.'_search_'.$moduleid;
$TYPE = explode('|', trim($MOD['type']));
//define('SELL_ORDER', $MOD['checkorder'] == 2 ? 0 : 1);
?>