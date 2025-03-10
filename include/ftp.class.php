<?php
/*
	
*/
defined('IN_AIJIACMS') or exit('Access Denied');
switch($AJ['gl_ftptype']) {
    case '1':
	require AJ_ROOT.'/include/aliossftp.class.php';
	break;
    case '2':
	require AJ_ROOT.'/include/qnftp.class.php';
	break;
	default:
	require AJ_ROOT.'/include/dtftp.class.php';
	break;
}
?>