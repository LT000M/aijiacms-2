<?php
require '../../common.inc.php';
require AJ_ROOT.'/include/mobile.inc.php';
require AJ_ROOT.'/include/post.func.php';
set_cookie('mobile', 'pc', $AJ_TIME + 30*86400);
$uri = isset($uri) && is_url($uri) ? $uri : AJ_PATH;
$head_title = $L['device_title'].$AJ['seo_delimiter'].$head_title;
$foot = '';
include template('device', 'mobile');
?>