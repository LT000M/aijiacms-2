<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($job == 'sale') {
	$moduleid = 5;
} else if($job == 'buy') {
	$moduleid = 16;
} else {
	exit;
}
tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&pagesize=".$AJ['page_trade']."&page=$page&datetype=2&order=addtime desc&time=addtime&template=list-trade");
?>