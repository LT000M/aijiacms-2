<?php
require '../common.inc.php';
#header("Content-type:text/javascript");
$AJ['pushtime'] > 0 or exit;
include template('push', 'chip');
?>