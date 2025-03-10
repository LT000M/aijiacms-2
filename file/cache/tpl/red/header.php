<?php defined('IN_AIJIACMS') or exit('Access Denied');?><!DOCtype html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?php if($seo_title) { ?><?php echo $seo_title;?><?php } else { ?><?php if($head_title) { ?><?php echo $head_title;?><?php echo $AJ['seo_delimiter'];?><?php } ?><?php if($city_sitename) { ?><?php echo $city_sitename;?><?php } else { ?><?php echo $AJ['sitename'];?><?php } ?><?php } ?></title>
<?php if($head_keywords) { ?>
<meta name="keywords" content="<?php echo $head_keywords;?>"/>
<?php } ?>
<?php if($head_description) { ?>
<meta name="description" content="<?php echo $head_description;?>"/>
<?php } ?>
<?php if($head_mobile) { ?>
<meta http-equiv="mobile-agent" content="format=html5;url=<?php echo $head_mobile;?>">
<?php } ?>
<?php if($EXT['archiver_enable']) { ?>
<link rel="archives" title="<?php echo $city_name;?><?php echo $AJ['sitename'];?>" href="<?php echo $EXT['archiver_url'];?>"/>
<?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo AJ_STATIC;?>favicon.ico"/>
<?php if($head_canonical) { ?>
<link rel="canonical" href="<?php echo $head_canonical;?>"/>
<?php } ?>
<link href="<?php echo AJ_SKIN;?>style2016.css" rel="stylesheet" type="text/css" />
<link href="<?php echo AJ_SKIN;?>global.css" rel="stylesheet" type="text/css" />
<?php if($moduleid!=15) { ?><link href="<?php echo AJ_SKIN;?>reset<?php if($moduleid==1) { ?>index<?php } ?>.css" rel="stylesheet" type="text/css" /><?php } ?>
<?php if($moduleid>8) { ?><link rel="stylesheet" type="text/css" href="<?php echo AJ_SKIN;?><?php echo $module;?>.css"/><?php } ?>
<?php if($moduleid==3) { ?><link rel="stylesheet" type="text/css" href="<?php echo AJ_SKIN;?>style.css"/><?php } ?>
<?php if($moduleid!=8 && $moduleid!=6  && $moduleid!=1) { ?><link href="<?php echo AJ_SKIN;?>esf.css" rel="stylesheet" type="text/css" /><?php } ?>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>lang/<?php echo AJ_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/page.js"></script>    
<script src="<?php echo AJ_SKIN;?>js/sea.js" type="text/javascript"></script>
<script src="<?php echo AJ_SKIN;?>js/int.js" type="text/javascript"></script>
<script type="text/javascript">
<?php if($head_mobile && $EXT['mobile_goto']) { ?>
GoMobile('<?php echo $head_mobile;?>');
<?php } ?>
<?php $searchid = ($moduleid > 3 && $MODULE[$moduleid]['ismenu'] && !$MODULE[$moduleid]['islink']) ?$moduleid : 6;?>
 var apptype = "<?php echo $MODULE[$searchid]['moduledir'];?>";
</script>
 <script type="text/javascript">
function gocity(s) {
Go('<?php echo $MODULE['1']['linkurl'];?>api/city.php?action=go&'+s);
}
</script>            
    </head>
    <body>
    <div id="header-bar">
        <div class="wrapper">
            <a href="/" style="display:block; width:180px; height:50px; float:left;  background:#fff; color:#FFF;   background:url(<?php if($MODULE[$moduleid]['logo']) { ?><?php echo AJ_SKIN;?>image/logo_<?php echo $moduleid;?>.gif<?php } else if($AJ['logo']) { ?><?php echo $AJ['logo'];?><?php } else { ?><?php echo AJ_SKIN;?>image/logo.png<?php } ?>) no-repeat; margin-top:0px"></a>
            <div class="change-city">
                <dt><?php if($AJ['city']) { ?><?php echo $city_name;?><i class="iconfont">&#xe60c;</i><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?></dt>
               <?php if($AJ['city']) { ?> <dl>
                    <em></em>
                                     <?php $citys = get_city(0)?>
<?php if(is_array($citys)) { foreach($citys as $k => $v) { ?><dd ><a href="<?php if($v['domain']) { ?><?php echo $v['domain'];?><?php } else { ?>javascript:gocity('areaid=<?php echo $v['areaid'];?>');<?php } ?>"><?php echo $v['name'];?></a></dd><?php } } ?> <dd ><a href="<?php echo $MODULE['1']['linkurl'];?>api/city.php">切换分站</a></dd>  </dl><?php } ?>
        
            </div>
            <div class="top-nav">
                <ul>
    <li><a href="<?php echo $MODULE['1']['linkurl'];?>" <?php if($moduleid==1) { ?>class="current"<?php } ?> >首页</a></li>
    
    <?php if(is_array($MODULE)) { foreach($MODULE as $m) { ?><?php if($m['ismenu']) { ?><li><a href="<?php echo $m['linkurl'];?>"<?php if($m['isblank']) { ?> target="_blank"<?php } ?> <?php if($m['moduleid']==$moduleid) { ?> class="current"<?php } ?>><?php echo $m['name'];?></a>
    
   <?php if($m['moduleid']==6) { ?>
        <dl>
            <dd><a href="<?php echo $MODULE['6']['linkurl'];?>" class="first"><em>楼盘</em></a></dd> 
            <dd><a href="<?php echo $MODULE['1']['linkurl'];?>map/house.html">地图找房</a></dd>
        </dl>
      
        <?php } else if($m['moduleid']==8) { ?>
        <dl>  <?php $maincata = get_maincat(0,8)?>
        <?php if(is_array($maincata)) { foreach($maincata as $k => $v) { ?>
                        <dd> <a href="<?php echo $MODULE['8']['linkurl'];?><?php echo $v['linkurl'];?>"  ><em><?php echo $v['catname'];?></em></a></dd><?php } } ?>
         </dl>
      
      
        <?php } else if($m['moduleid']==5) { ?>
        <dl>
            <dd><a href="<?php echo $MODULE['5']['linkurl'];?>" class="first"><em>二手房</em></a></dd>
            <dd><a href="<?php echo $MODULE['18']['linkurl'];?>">小区</a></dd>
            <dd><a href="<?php echo $MODULE['4']['linkurl'];?>list_u1v.html">经纪人</a></dd>
            <dd><a href="<?php echo $MODULE['16']['linkurl'];?>list_u1v.html" rel="nofollow">求购</a></dd>
        </dl>
        <?php } ?>
    
    
    </li><?php } ?><?php } } ?>
    
  
</ul>
            </div>
            <div class="login-link" id="aijiacms_member"></div>
        </div>
    </div>
 <?php if($moduleid!=1 && $moduleid!=8 && $moduleid!=2) { ?>
    <div id="house-top">
    <div class="wrapper">
    
   
    
    
    
         <form action="" id="serach_form" method="post" action="<?php echo $MODULE[$moduleid]['linkurl'];?>search.php">
        <div class="house-search">
       <input  class="input"  data-url="<?php echo $MODULE['1']['linkurl'];?>api/house.php?action=house" type="text" id="hname" name="kw" value="" placeholder="请输入名称（支持拼音或简拼）" autocomplete="off">
        <button type="submit"><i class="iconfont">&#xe604;</i></button>
        </div>
        </form>
        <div class="house-search-keywords">
            <span>热门搜索：</span>
<?php echo tag("moduleid=$searchid&table=keyword&condition=moduleid=$moduleid and status=3&pagesize=10&order=total_search desc&template=list-search_kw");?>
        </div>
        <!--
        <div class="house-search-type">
            <a href="<?php echo $MODULE['1']['linkurl'];?>map" class="map-icon">地图</a>
            <a class="current list-icon"  href="<?php echo $MOD['linkurl'];?>list.html">列表</a>
        </div>-->
        <div class="clearit"></div>
    </div>
   <?php } ?>
   
   <script>
seajs.use(["autoc"],function(alertM){
/* 对比 */
var $hname=$("#hname").autoC("<?php echo $MODULE['1']['linkurl'];?>api/house.php?action=house"),
$form=$("#serach_form").on("submit",function(){
var kw = $hname.val();
if(kw == ""||kw==$hname.attr('placeholder')){
$hname.focus();
return false;
}
kw = encodeURIComponent(kw);
window.location.href = "<?php echo $MOD['linkurl'];?>search-k" + kw + ".html";
return false;
}).on("click","a.obtn",function(){
$form.trigger("submit")
});
})
</script>