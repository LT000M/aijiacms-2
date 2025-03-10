<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$AJ_MOB['os'] == 'ios' or exit;
if(get_cookie('mobile') != 'screen') set_cookie('mobile', 'screen', $AJ_TIME + 86400*30);
?>