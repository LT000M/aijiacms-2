<?php
defined('IN_AIJIACMS') or exit('Access Denied');
if(strlen($answer) < 1) exit('1');
$answer = stripslashes($answer);
$session = new dsession();
if(!isset($_SESSION['answerstr'])) exit('2');
if(decrypt($_SESSION['answerstr'], AJ_KEY.'ANS') != $answer) exit('3');
exit('0');
?>