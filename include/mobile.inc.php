<?php
/*
	
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
require AJ_ROOT.'/include/mobile.func.php';

    //20220803百度移动端推送
    $mobpingurl= '  '.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; //注意先清除空格，网站如果是http 就把 https 改成 http 
  if($AJ['baidu_tui'])  baiduping($mobpingurl);
    //百度移动推送结束

include load('mobile.lang');
$EXT['mobile_enable'] or message($L['msg_mobile_close']);
if($AJ_BOT) $EXT['mobile_ajax'] = 0;
$dmobile = get_cookie('mobile');
if($dmobile == '' || $dmobile == 'pc') set_cookie('mobile', 'touch', $AJ_TIME + 30*86400);
$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
$back_link = $head_link = $head_name = $pages = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$site_name = $EXT['mobile_sitename'] ? $EXT['mobile_sitename'] : $AJ['sitename'].$L['mobile_version'];
$AJ['sitename'] = $site_name;
$AJ_PC = 0;
$MURL = $MODULE[2]['linkurl'];
if($AJ_MOB['browser'] == 'screen' && $_username) $MURL = AJ_PATH.'api/mobile.php?action=sync&auth='.encrypt($_username.'|'.$AJ_IP.'|'.$AJ_TIME, AJ_KEY.'SCREEN').'&goto=';
$_cart = ($AJ['max_cart'] && $_userid) ? intval(get_cookie('cart')) : 0;
$share_icon = ($AJ_MOB['browser'] == 'weixin' || $AJ_MOB['browser'] == 'qq') ? AJ_PATH.'apple-touch-icon-precomposed.png' : '';
$MOB_MODULE = array();
foreach($MODULE as $v) {
	if($v['moduleid'] > 3 && $v['ismenu'] && !$v['islink']) $MOB_MODULE[] = $v;
}
$js_pageid = random(4, 'a-Z').substr(AJ_TIME, -6);
$js_load = '';
$js_pull = 1;
$js_item = $js_album = 0;
$foot = 'channel';

?>