<?php
defined('AJ_ADMIN') or exit('Access Denied');
?>
<!doctype html>
<html lang="<?php echo AJ_LANG;?>">
<head>
<meta charset="<?php echo AJ_CHARSET;?>"/>
<title>管理中心 - <?php echo $AJ['sitename']; ?> - Powered By AIJIACMS  V<?php echo AJ_VERSION; ?> R<?php echo AJ_RELEASE;?></title>
<meta name="robots" content="noindex,nofollow"/>
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width"/>
<meta name="generator" content="AIJIACMS  - www.aijiacms.com"/>
<meta http-equiv="x-ua-compatible" content="IE=8"/>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
<link rel="bookmark" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
<link rel="stylesheet" href="admin/image/style.css?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>" type="text/css"/>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>lang/<?php echo AJ_LANG;?>/lang.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/config.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<!--[if lte IE 9]><!-->
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery-1.5.2.min.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<!--<![endif]-->
<!--[if (gte IE 10)|!(IE)]><!-->
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery-2.1.1.min.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<!--<![endif]-->
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/common.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/panel.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/admin.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
</head>
<body>
<div id="msgbox" onmouseover="closemsg();" style="display:none;"></div>
<?php dmsg();?>