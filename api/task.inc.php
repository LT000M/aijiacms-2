<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ['stats']) include AJ_ROOT.'/api/stats.inc.php';
if($AJ_BOT) {
	//
} else {
	include template('line', 'chip');
}
?>