<?php
defined('AJ_ADMIN') or exit('Access Denied');
?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="keywords" content="<?php echo $AJ['sitename']; ?>">
<meta name="description" content="<?php echo $AJ['sitename']; ?>">
<meta name="author" content="yinq">
 <title>管理中心 - <?php echo $AJ['sitename']; ?> - <?php echo strtoupper(AJ_LANG);?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/animate.min.css">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/js/bootstrap-multitabs/multitabs.min.css">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/style.min.css">
</head>

<body class="lyear-index">
<?php
include AJ_ROOT.'/admin/menu.inc.php';

?>
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">

      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="?mian"><img src="admin/bootstrap/images/logo-sidebar.png" title="LightYear" alt="LightYear" /></a>
      </div>
      <div class="lyear-layout-sidebar-info lyear-scroll">

        <nav class="sidebar-main">

          <ul class="nav-drawer">
            <li class="nav-item active">
              <a class="multitabs" href="?action=main" id="default-page">
                <i class="mdi mdi-home-city-outline"></i>
                <span>后台首页</span>
              </a>
            </li>
			
			
			
			
			
			
           <?php if($_admin == 2) {
?>
			
			<?php
		foreach($mymenu as $menu) {
	?>
	 <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-palette"></i> <span> <?php echo set_style($menu['title'], $menu['style']);?></span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="<?php echo substr($menu['url'], 0, 1) == '?' ? $menu['url'] : AJ_PATH.'api/redirect.php?url='.$menu['url'].'" target="_blank';?>"><?php echo set_style($menu['title'], $menu['style']);?></a> </li>
            
              </ul>
            </li>
	
	<?php
		}
	?>
	<?php } else { ?>
          
			
			<?php
		$k = 0;
		foreach($MODULE as $v) {
			if($v['moduleid'] > 4) {
				$menuinc = AJ_ROOT.'/module/'.$v['module'].'/admin/menu.inc.php';
				if(is_file($menuinc)) {
					extract($v);
					include $menuinc;
					echo ' <li class="nav-item nav-item-has-subnav">';
					echo ' <a href="javascript:void(0)"><i class="mdi mdi-'.$icon.'"></i> <span>'.$name.'管理</span></a><ul class="nav nav-subnav">';
					foreach($menu as $m) {
						echo ' <li> <a class="multitabs" href="'.$m[1].'">'.$m[0].'</a> </li>';
					}
					echo '</ul></li>';
					$k++;
				}
			}
		}
	?>
			
			 <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-account-supervisor"></i> <span>会员管理</span></a>
              <ul class="nav nav-subnav">
			  
			  
				<?php
		$menuinc = AJ_ROOT.'/module/'.$MODULE[2]['module'].'/admin/menu.inc.php';
		if(is_file($menuinc)) {
			extract($MODULE[2]);
			include $menuinc;
		
			
			foreach($menu as $m) {
				echo '<li><a class="multitabs" href="'.$m[1].'"><i class="bi bi-dot"></i>'.$m[0].'</a></li>';
			}
			
		}
	?>
			  
              
            
              </ul>
            </li>
			
			 <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-account-tie"></i> <span>CRM客户管理</span></a>
              <ul class="nav nav-subnav">
              	<?php
		foreach($kefumenu as $m) {
			echo '<li ><a  class="multitabs" href="'.$m[1].'"><i class="bi bi-dot"></i>'.$m[0].'</a></li>';
		}
	?>
            
              </ul>
            </li>
			
				 
           
			 <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-finance"></i> <span>财务管理</span></a>
			  
			   <ul class="nav nav-subnav">
              
				<?php
		$menuinc = AJ_ROOT.'/module/'.$MODULE[2]['module'].'/admin/menu.inc.php';
		if(is_file($menuinc)) {
			extract($MODULE[2]);
			include $menuinc;
		
			
			foreach($menu_finance as $m) {
				echo '<li ><a class="multitabs" href="'.$m[1].'"><i class="bi bi-dot"></i>'.$m[0].'</a></li>';
			}
			
		}
	?>
            
              </ul>
            </li>
			  
		     <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-cog"></i> <span>系统维护</span></a>
              <ul class="nav nav-subnav">
               	<?php
		foreach($menu_system as $m) {
			echo '<li ><a class="multitabs" href="'.$m[1].'"><i class="bi bi-dot"></i>'.$m[0].'</a></li>';
		}
	?>
            
              </ul>
            </li>
			 <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-tools"></i> <span>系统工具</span></a>
              <ul class="nav nav-subnav">
               	<?php
		foreach($smenu as $m) {
			echo '<li ><a class="multitabs" href="'.$m[1].'"><i class="bi bi-dot"></i>'.$m[0].'</a></li>';
		}
	?>
            
              </ul>
            </li>
          
		  	 <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-palette"></i> <span>其他管理</span></a>
              <ul class="nav nav-subnav">
             		<?php
		$menuinc = AJ_ROOT.'/module/'.$MODULE[3]['module'].'/admin/menu.inc.php';
		if(is_file($menuinc)) {
			extract($MODULE[3]);
			include $menuinc;
		
			foreach($menu as $m) {
				echo '<li ><a class="multitabs" href="'.$m[1].'"><i class="bi bi-dot"></i>'.$m[0].'</a></li>';
			}
			
		}
	?>
            
              </ul>
            </li>
			 
			
			<?php } ?>
          </ul>
        </nav>

        <div class="sidebar-footer">
          <p class="copyright">
            <span>Copyright &copy; 2023. </span>
            <a target="_blank" href="<?php echo AJ_PATH;?>"><?php echo $AJ['sitename']; ?></a>
            <span> All rights reserved.</span>
          </p>
        </div>
      </div>

    </aside>
    <!--End 左侧导航-->

    <!--头部信息-->
    <header class="lyear-layout-header">

      <nav class="navbar">

        <div class="navbar-left">
          <div class="lyear-aside-toggler">
            <span class="lyear-toggler-bar"></span>
            <span class="lyear-toggler-bar"></span>
            <span class="lyear-toggler-bar"></span>
          </div>
        </div>

        <ul class="navbar-right d-flex align-items-center">
          <!--顶部消息部分-->
          <li class="dropdown dropdown-notice">
            <span data-bs-toggle="dropdown" class="position-relative icon-item">
              <i class="mdi mdi-bell-outline fs-5"></i>
              <span class="position-absolute translate-middle badge bg-danger"><?php echo $_message;?></span>
            </span>
            <div class="dropdown-menu dropdown-menu-end">
              <div class="lyear-notifications">

                <div class="lyear-notifications-title d-flex justify-content-between" data-stopPropagation="true">
                  <span>你有<?php echo $_message;?> 条未读消息</span>
                  <a href="<?php echo $MODULE[2]['linkurl'].'message.php';?>">查看全部</a>
                </div>
             

              </div>
            </div>
          </li>
          <!--End 顶部消息部分-->
          <!--切换主题配色-->
		  <li class="dropdown dropdown-skin">
		    <span data-bs-toggle="dropdown" class="icon-item">
              <i class="mdi mdi-palette fs-5"></i>
            </span>
			<ul class="dropdown-menu dropdown-menu-end" data-stopPropagation="true">
              <li class="lyear-skin-title"><p>主题</p></li>
              <li class="lyear-skin-li clearfix">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_1" value="default" checked="checked">
                  <label class="form-check-label" for="site_theme_1"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_2" value="translucent-green">
                  <label class="form-check-label" for="site_theme_2"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_3" value="translucent-blue">
                  <label class="form-check-label" for="site_theme_3"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_4" value="translucent-yellow">
                  <label class="form-check-label" for="site_theme_4"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_5" value="translucent-red">
                  <label class="form-check-label" for="site_theme_5"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_6" value="translucent-pink">
                  <label class="form-check-label" for="site_theme_6"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_7" value="translucent-cyan">
                  <label class="form-check-label" for="site_theme_7"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="site_theme" id="site_theme_8" value="dark">
                  <label class="form-check-label" for="site_theme_8"></label>
                </div>
              </li>
			  <li class="lyear-skin-title"><p>LOGO</p></li>
			  <li class="lyear-skin-li clearfix">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_1" value="default" checked="checked">
                  <label class="form-check-label" for="logo_bg_1"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_2" value="color_2">
                  <label class="form-check-label" for="logo_bg_2"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_3" value="color_3">
                  <label class="form-check-label" for="logo_bg_3"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_4" value="color_4">
                  <label class="form-check-label" for="logo_bg_4"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_5" value="color_5">
                  <label class="form-check-label" for="logo_bg_5"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_6" value="color_6">
                  <label class="form-check-label" for="logo_bg_6"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_7" value="color_7">
                  <label class="form-check-label" for="logo_bg_7"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="logo_bg" id="logo_bg_8" value="color_8">
                  <label class="form-check-label" for="logo_bg_8"></label>
                </div>
			  </li>
			  <li class="lyear-skin-title"><p>头部</p></li>
			  <li class="lyear-skin-li clearfix">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_1" value="default" checked="checked">
                  <label class="form-check-label" for="header_bg_1"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_2" value="color_2">
                  <label class="form-check-label" for="header_bg_2"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_3" value="color_3">
                  <label class="form-check-label" for="header_bg_3"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_4" value="color_4">
                  <label class="form-check-label" for="header_bg_4"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_5" value="color_5">
                  <label class="form-check-label" for="header_bg_5"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_6" value="color_6">
                  <label class="form-check-label" for="header_bg_6"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_7" value="color_7">
                  <label class="form-check-label" for="header_bg_7"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="header_bg" id="header_bg_8" value="color_8">
                  <label class="form-check-label" for="header_bg_8"></label>
                </div>
			  </li>
			  <li class="lyear-skin-title"><p>侧边栏</p></li>
			  <li class="lyear-skin-li clearfix">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_1" value="default" checked="checked">
                  <label class="form-check-label" for="sidebar_bg_1"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_2" value="color_2">
                  <label class="form-check-label" for="sidebar_bg_2"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_3" value="color_3">
                  <label class="form-check-label" for="sidebar_bg_3"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_4" value="color_4">
                  <label class="form-check-label" for="sidebar_bg_4"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_5" value="color_5">
                  <label class="form-check-label" for="sidebar_bg_5"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_6" value="color_6">
                  <label class="form-check-label" for="sidebar_bg_6"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_7" value="color_7">
                  <label class="form-check-label" for="sidebar_bg_7"></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="sidebar_bg" id="sidebar_bg_8" value="color_8">
                  <label class="form-check-label" for="sidebar_bg_8"></label>
                </div>
			  </li>
		    </ul>
		  </li>
          <!--End 切换主题配色-->
          <!--个人头像内容-->
          <li class="dropdown">
            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="dropdown-toggle">
              <img class="avatar-md rounded-circle" src="<?php echo useravatar($_username, 'large');?>" alt="<?php echo $_username;?>" />
              <span style="margin-left: 10px;"><?php echo $_username;?><?php echo $_admin == 1 ? (is_founder($_userid) ? '网站创始人' : '超级管理员') : ($_aid ? '<span class="f_blue">'.$AREA[$_aid]['areaname'].'站</span>管理员' : '普通管理员'); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="multitabs dropdown-item" data-url="?moduleid=2"
                  href="javascript:void(0)">
                  <i class="mdi mdi-account"></i>
                  <span>个人信息</span>
                </a>
              </li>
              <li>
                <a class="multitabs dropdown-item" data-url="?action=password"
                  href="javascript:void(0)">
                  <i class="mdi mdi-lock-outline"></i>
                  <span>修改密码</span>
                </a>
              </li>
             
              <li class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="?file=logout">
                  <i class="mdi mdi-logout-variant"></i>
                  <span>退出登录</span>
                </a>
              </li>
            </ul>
          </li>
          <!--End 个人头像内容-->
        </ul>

      </nav>

    </header>
    <!--End 头部信息-->

    <!--页面主要内容-->
    <main class="lyear-layout-content">

      <div id="iframe-content"></div>

    </main>
    <!--End 页面主要内容-->
  </div>
</div>

<script type="text/javascript" src="admin/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/bootstrap-multitabs/multitabs.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/index.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {});
</script>
</body>
</html>
