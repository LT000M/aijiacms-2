<?php
defined('AJ_ADMIN') or exit('Access Denied');
?>
<!doctype html>
<html lang="<?php echo AJ_LANG;?>">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo AJ_CHARSET; ?>"/>
<title>top</title>
<meta name="generator" content=""/>
<link rel="stylesheet" href="admin/image/style.css" type="text/css"/>
<link href="admin/image/top.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="admin_top">
<div class="fl admin_top_fl">
 <a href="#" class="topbar-logo fl">
   <span><img src="admin/image/ico-logo.png" width="30" height="30"></span>
  </a>
 <a href="?action=start" class="topbar-home-link fl"><span class="ltxt">管理控制台</span><span class="ltxt-2"> Management console</span></a></div>
<div class="admin_top_fr" onselectstart="return false">
<span><?php echo $_username;?>（<?php echo $_admin == 1 ? (is_founder($_userid) ? '网站创始人' : '超级管理员') : ($_aid ? '<span class="f_blue">'.$AREA[$_aid]['areaname'].'站</span>管理员' : '普通管理员'); ?>），您好！</span>
<span><a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>" target="_blank"><img src="admin/image/ico-tongz.png" width="20" height="20" title="消息通知"><b><?php echo $_message;?></b></a></span>
<span><a href="<?php echo AJ_PATH ?>" target="_blank"><img src="admin/image/tool-home.png" width="16" height="16" title="前台" alt=""/></a></span>
<span><a href="<?php echo $MODULE[2]['linkurl'] ?>" target="_blank"><img src="admin/image/tool-hui.png" width="16" height="16" title="会员中心" alt=""/></a></span>
<span><a href="?file=logout" target="_top" onclick="if(!confirm('确实要注销登录吗?')) return false;"><img src="admin/image/tool-tuo.png" width="16" height="16" title="注销" alt="注销"/></a></span>
</div>
</div>
</body>
</html>
