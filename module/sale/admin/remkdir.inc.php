<?php
defined('AJ_ADMIN') or exit('Access Denied');
file_copy(AJ_ROOT.'/api/ajax.php', AJ_ROOT.'/'.$dir.'/ajax.php');
install_file($moduleid, 'index', $dir, 1);
install_file($moduleid, 'list', $dir, 1);
install_file($moduleid, 'show', $dir, 1);
install_file($moduleid, 'search', $dir, 1);
install_file($moduleid, 'compare', $dir, 0);
install_file($moduleid, 'inquiry', $dir, 1);
?>