<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
if($AJ_BOT) return;
if($page == 1 && $MOD['hits']) {
	if($AJ['cache_hits']) {
		 cache_hits($moduleid, $itemid);
	} else {
		$update .= ',hits=hits+1';
	}
}
if($update) $db->query("UPDATE LOW_PRIORITY {$table} SET ".substr($update, 1)." WHERE itemid=$itemid", 'UNBUFFERED');	
?>