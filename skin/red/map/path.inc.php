<?php
/**
 * 二手房源
 *
 * @author 阿一 yandy@yanwee.com
 * @package package
 * @version $Id$
 */

require('../../common.inc.php');
$page->dir  = 'm/map';//目录名
$page->addCss('common.css');
$page->addCss('sale.css');
$page->addCss('header.css');
$page->addCss('Home_Home2.css');

$realname = $_COOKIE['AUTH_MEMBER_REALNAME'] ? $_COOKIE['AUTH_MEMBER_REALNAME'] :$_COOKIE['AUTH_MEMBER_NAME'];

if($_COOKIE['AUTH_MEMBER_STRING']){
	$member = new Member($query);
	$user_type = $member->getAuthInfo('user_type');
	$page->tpl->assign('user_type',$user_type);
}

$newMsgCount = 0;
if($_COOKIE['AUTH_MEMBER_NAME']){
	$innernote = new Innernote($query);
	$newMsgCount = $innernote->getCount(' to_del=0 and is_new = 1 and msg_to = \''.$_COOKIE['AUTH_MEMBER_NAME'].'\'');
}
$page->tpl->assign('msgCount',$newMsgCount);

?>