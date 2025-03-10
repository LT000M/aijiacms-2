<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
require_once AJ_ROOT.'/include/mobile.func.php';
include load('mobile.lang');
$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
$back_link = $head_name = $pages = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$site_name = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $AJ['sitename'].$L['mobile_version'];
$AJ['sitename'] = $site_name;
$AJ_PC = $GLOBALS['AJ_PC'] = 0;
$MURL = $MODULE[2]['linkurl'];
if($AJ_MOB['browser'] == 'screen' && $_username) $MURL = AJ_PATH.'api/mobile.php?action=sync&auth='.encrypt($_username.'|'.$AJ_IP.'|'.$AJ_TIME, AJ_KEY.'SCREEN').'&goto=';
$_cart = 0;
$share_icon = ($AJ_MOB['browser'] == 'weixin' || $AJ_MOB['browser'] == 'qq') ? AJ_PATH.'apple-touch-icon-precomposed.png' : '';
$MOB_MODULE = array();
foreach($MODULE as $v) {
	if($v['moduleid'] > 3 && $v['ismenu'] && !$v['islink']) $MOB_MODULE[] = $v;
}
$js_pageid = random(4, 'a-Z').substr(AJ_TIME, -4);
$js_load = '';
$js_pull = 1;
$js_item = $js_album = 0;
$foot = 'channel';
?>