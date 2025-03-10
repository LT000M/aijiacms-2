<?php
define('AJ_ADMIN', true);
require_once('initapi.php');

header("Access-Control-Allow-Origin:*");

$initapp = new Response;
$userid = $_GET['userid'];
$admin= $_GET['admin'];

$initapp -> initapi($userid,$admin);