<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php include template('header');?>
<link href="<?php echo AJ_SKIN;?>xfreset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo AJ_SKIN;?>xinfang.css" rel="stylesheet" type="text/css" />
<style>/*楼盘列表右侧*/
#right{width:250px;float:left;_display:inline;margin-top:16px;position: relative;}
.list_map{ width:250px; height:400px; position:relative;}
.list_map .list_map_ico{ background:url(<?php echo AJ_SKIN;?>images/xinfang/list_map_ico.png) no-repeat left top;width:15px; height:21px}
.list_map .list_map_ico.cur{ background:url(<?php echo AJ_SKIN;?>images/xinfang/list_map_ico0.png) no-repeat left top}
.list_map_tcbox{ position:absolute; left:-83px; top:-45px; white-space:nowrap; text-align:center; background:url(../build/map_arrow.png) no-repeat center 35px;padding-bottom:9px}
.list_map_tcbox p{ background:#f57f00; height:35px; line-height:35px; padding:0 10px;color:#fff; margin:0;}
.mapinfo_box{display:none;position:absolute;z-index:9999999;}
.mapinfo{line-height:35px;height:44px;color:#fff;display:inline-block;height:35px;}
.maptext{padding: 0px 12px; height: 35px; overflow: inherit;background-color: rgb(250, 29, 48);opacity:0.7;border-radius: 5px}
.right_banner_view{
    position: relative;
    /* height: 425px; */
    overflow: hidden;
    
}
.right_banner_view .banner_img{
    margin-bottom: 10px;
    display: inline-block;
    position: relative;
}
.list_rt{ height:66px; overflow:hidden;margin-top: 10px}
.list_rt01{ border:#ececec solid 1px; padding:15px 0 10px 30px; font-size:14px;margin-bottom: 10px}
.list_rt01 td{ padding-bottom:9px;}
.list_rt01 .lrt_srk{ width:185px; height:30px; line-height:30px; border:#dbdbdb solid 1px; color:#b4b4b4; padding-left:7px;}
.list_rt01 .an_red{ width:88%; line-height:40px; color:#FFF; text-align:center; height:40px; background:#ff5b6a; cursor:pointer; border:none; font-size:20px; font-weight:bold;border-radius:5px;}
.list_rt01 .an_blue{ width:124px; line-height:40px; text-align:center; height:40px; background:#10d1aa; cursor:pointer; border:none; font-size:20px; margin-left:8px;}
</style>
<script type="text/javascript">
    var BASE_URL = "";
    var BASE_MAP = "<?php echo $map_mid;?>";
    var STATIC_URL = "<?php echo AJ_SKIN;?>images/xinfang/";
</script>
<div class="main">
         
    <div class="bread">您当前的位置：<a href="<?php echo $MODULE['1']['linkurl'];?>" title="<?php echo $AJ['sitename'];?>"><?php echo $AJ['sitename'];?></a>&gt;<a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a>&gt;<span>楼盘搜索</span></div>
   
<div class="con">
<div class="hslist" id="hslist">
<h2>
<a href="<?php echo $MOD['linkurl'];?>list.html" class="qy on">区域地标</a>
<a href="<?php echo $MODULE['1']['linkurl'];?>map/house.html" class="map" target="_blank">地图找房</a>
</h2>
                            <div class="cf hsl_t">
                    <span>区域：</span>
                    <p id="hs_area" class="hs_hidep on">
                        <a href="javascript:" class="hs_hide" style="display: inline-none;"><u class="hs_mo">更多</u><u class="hs_le">收起</u></a>
<em><a <?php if(returnsx("a")==-1) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('a','');?>">全部</a></em>
<?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?><em><a <?php if(check_in('_a'.$v['areaid'].'v',$getstr)) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('a',$v['areaid'],'d');?>"><?php echo $v['areaname'];?></a></em><?php } } ?>
<?php if($areaid) { ?>
<span class="i">
<em><a <?php if(returnsx("d")==-1) { ?>class="on"<?php } ?> href="$MOD[linkurl]}<?php echo rentser('d',$v['areaid']);?>">全部</a></em>
<?php $mainareas = get_mainarea($areaid)?>
<?php if(is_array($mainareas)) { foreach($mainareas as $k => $v) { ?>
<em><a <?php if(check_in('_d'.$v['areaid'].'d',$getstr)) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('d',$v['areaid']);?>"><?php echo $v['areaname'];?></a></em><?php } } ?></span><?php } ?>
                       
                                                </p>
                </div>
            
<div class="cf">
<span>价格：</span>
<p>
<em><a <?php if(check_in("_bv",$getstr) || check_in("_cv",$getstr) || !check_in("_b",$getstr) || !check_in("_c",$getstr)) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('b','','c','',$nq);?>">全部</a></em>
                 <?php echo getsearchstr('b','c','em','元',$AJ['houseprice'],$getstr,'on');?>
             
  
  
</p>
</div>
<div class="cf">
<span>类型：</span>
<p>
<em><a <?php if(returnsx("t")==-1) { ?>class="on"<?php } ?> href="<?php echo rentser('t','','','',$nq);?>">全部</a></em>
 <?php $maincat = get_maincat(0,6)?>
<?php if(is_array($maincat)) { foreach($maincat as $k => $v) { ?> <em><a  <?php if(check_in('_t'.$v['catid'].'v',$getstr)) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('t',$v['catid']);?>"><?php echo $v['catname'];?></a></em><?php } } ?>
</p>
</div>
<div class="cf">
<span>特色：</span>
<p>
                 <em><a  <?php if(returnsx("l")==-1) { ?>class="on"<?php } ?> href="<?php echo rentser('l','','','',$nq);?>" >全部</a></em>
<?php $lpts_arr = getbox_name('lpts','newhouse_6')?>
    <?php if(is_array($lpts_arr)) { foreach($lpts_arr as $key => $v) { ?>
 <em><a <?php if(check_in('_l'.$key.'v',$getstr)) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('l',$key);?>"><?php echo $v;?></a></em><?php } } ?>
                        </p>
</div>
<div class="cf letter">
<span>字母：</span>
<p>
                   <a <?php if(returnsx("e")==-1) { ?>class="on"<?php } ?> href="<?php echo rentser('e','','','',$nq);?>" >全部</a>
  <?php $l = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');?>
               <?php if(is_array($l)) { foreach($l as $k => $v) { ?>
<a <?php if(check_in('_e'.$v.'v',$getstr)) { ?>class="on"<?php } ?> href="<?php echo $MOD['linkurl'];?><?php echo rentser('e',$v);?>"><?php echo $v;?></a><?php } } ?>
                        </p>
</div>
<div class="cf hsl_b">
<span>名称：</span>
<form action="" id="serach_form" method="post">
<input data-url="<?php echo $MOD['linkurl'];?>house.php?action=house" type="text" id="hname" name="kw" value="" placeholder="请输入楼盘名称（支持拼音或简拼）" autocomplete="off">
<a class="obtn" href="javascript:"><i class="search"></i><button type="submit"></button></a>
</form>
</div>
<div class="hs_more cf" id="hs_more">
<span>更多找房条件：</span>
<div class="hs_mlist"><?php if(returnsx("j")==-1) { ?>建筑类型<?php } else { ?><?php echo getbox_diaoval('buildtype','checkbox',returnsx("j"),'newhouse_6');?><?php } ?><ul>
<li><a href="<?php echo rentser('j','','','',$nq);?>">全部</a></li>
<?php $buildtype_arr = getbox_name('buildtype','newhouse_6')?>
    <?php if(is_array($buildtype_arr)) { foreach($buildtype_arr as $key => $v) { ?>
 <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('j',$key);?>"><?php echo $v;?></a></li><?php } } ?>
                    
</ul>
</div>
<div class="hs_mlist"><?php if(returnsx("f")==-1) { ?>装修情况<?php } else { ?><?php echo getbox_diaoval('fitment','checkbox',returnsx("f"),'newhouse_6');?><?php } ?><ul>
<li><a href="<?php echo rentser('f','','','',$nq);?>">全部</a></li>
<?php $fix_arr = getbox_name('fitment','newhouse_6')?>
    <?php if(is_array($fix_arr)) { foreach($fix_arr as $key => $v) { ?>
 <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('f',$key);?>"><?php echo $v;?></a></li><?php } } ?>
</ul>
</div>
<div class="hs_mlist">开盘时间<ul style="display: none;">
<li><a href="<?php echo rentser('o','','','',$nq);?>">全部</a></li>
<?php $kaipan = array('本月开盘', '下月开盘', '3月内开盘', '6月内开盘', '前3月已开','前6月已开');?>
    <?php if(is_array($kaipan)) { foreach($kaipan as $k => $v) { ?>
 <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('o',($k+1));?>"><?php echo $v;?></a></li><?php } } ?>
</ul>
</div>
</div>
            </div>
<div class="fl xf_sh_list">
<div class="xf_sh_list_t">
<ul class="xszt cf">
<li><a <?php if(returnsx("h")==-1) { ?>class="on"<?php } ?> href="<?php echo rentser('h','','','',$nq);?>">全部</a></li>
  <?php if(is_array($TYPE)) { foreach($TYPE as $k => $v) { ?> 
<li><a  <?php if(check_in('_h'.($k+1).'v',$getstr)) { ?>class="on"<?php } ?>  href="<?php echo $MOD['linkurl'];?><?php echo rentser('h',($k+1));?>"><?php echo $v;?></a></li><?php } } ?>
                  
</ul>
<div class="px">
<p><?php if(returnsx("n")==-1) { ?>默认排序<?php } else if(returnsx("n")==1) { ?>售价从高到低<?php } else if(returnsx("n")==2) { ?>售价从低到高<?php } else if(returnsx("n")==3) { ?>开盘时间由近到远<?php } else if(returnsx("n")==4) { ?>开盘时间由远到近<?php } ?><span class="pointer"><i class="sj_icon"></i><u class="sj_icon"></u></span></p>
<ul><li><a href="<?php echo rentser('n','','','',$nq);?>">默认排序</a></li>
    <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('n',1);?>">售价从高到低</a></li>
                                <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('n',2);?>">售价从低到高</a></li>
                                <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('n',3);?>">开盘时间由近到远</a></li>
                                <li><a  href="<?php echo $MOD['linkurl'];?><?php echo rentser('n',4);?>">开盘时间由远到近</a></li>
                            </ul>
</div>
<div class="ssjj">共为您找到 <span><?php echo $items;?></span> 个楼盘</div>
<div class="page">
<a href=" <?php if($page==1) { ?> javascript:void(0);<?php } else { ?><?php echo $MOD['linkurl'];?><?php echo rentser('p',($page-1));?><?php } ?>" class="fl"></a>
<a href="<?php echo $MOD['linkurl'];?><?php if($page==$total) { ?><?php echo rentser('p',$total);?><?php } else { ?><?php echo rentser('p',($page+1));?><?php } ?>" class="fr"></a>
<span><em><?php echo $page;?></em>/<?php echo $total;?></span>
</div>
</div>
          
        <?php if($page == 1) { ?><?php echo ad($moduleid,0,'',6);?><?php } ?><?php echo tag("moduleid=$moduleid&condition=status=3 and isnew=1$dtype&areaid=$cityid&pagesize=".$MOD['pagesize']."&page=$page&showpage=1&datetype=5&order=".$MOD['order']."&fields=".$MOD['fields']."&lazy=$lazy&template=list-newhouse");?>
</div>
        <div class="fr lp_right">
    
       
           <div id="right" class="list-advs">
                        
           
        <div class="mapinfo_box" id="mapinfo">
            <div class="mapinfo">
                <p  id="maptext" class="maptext"></p>
            </div>
        </div>
        <div class="list_map" id="list_map" >
               
        </div>
              
    
        </div>
<div class="category adb">
    <?php echo ad($moduleid,$catid,$kw,7);?>
     </div>
        
    
    
       
          
    </div>
<div style="clear:both;"></div>            <div class="guanzhu">
                <h2>网友正在关注的楼盘</h2>
                <ul class="cf">
                                       
   <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb<>''&areaid=$cityid&length=42&pagesize=6&order=hits desc&template=null");?>
 <?php if(is_array($tags)) { foreach($tags as $i => $t) { ?> 
                        <li <?php if($i==5) { ?> class="no_fl"<?php } ?>>
                            <div class="thumb">
                                <div class="img"><a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo imgurl($t['thumb']);?>" alt="<?php echo $t['alt'];?>" width="150" height="110"></a></div>
                                <div class="text">
                                    <h3><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a></h3>
                                    <p><?php if($t['price']) { ?><?php echo $t['price'];?>元/平米<?php } else { ?>待定<?php } ?>
</p>
                                </div>
                            </div>
                        </li><?php } } ?>
                                    </ul>
            </div>
            </div>
 
    <div class="shengming"> <?php echo $AJ['sitename'];?>所提供的<?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>楼盘及<?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>房价信息仅供参考！<?php echo $AJ['sitename'];?> <?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>，专业的<?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>房产网，提供最全面的 <?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>新楼盘,  <?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>楼盘信息以及 <?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>房价查询，您可以查到<?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>新楼盘的打折优惠以及团购活动，为您找到最适合的<?php if($AJ['city']) { ?><?php echo $city_name;?><?php } else { ?><?php echo $AJ['city_sitename'];?><?php } ?>新房房产信息。</div>
 </div>
<script>
seajs.use(["alert","loginafter","pk","autoc","cookie"],function(alertM,loginafter,pk){
/* 对比 */
pk({
elm:".xf_sh_list_b .detail .db",
hlength:3,
url:"<?php echo $MOD['linkurl'];?>pk/",
type:"楼盘"
})
/* 地区 */
var $hs_area=$("#hs_area").on("click",".hs_hide",function(){
if($.cookie("hs_hide")){
$hs_area.removeClass("on")
$.cookie("hs_hide","")
}else{
$hs_area.addClass("on")
$.cookie("hs_hide",1)
}
})
if($hs_area.height()>32){
$hs_area.addClass("hs_hidep").find(".hs_hide").css("display","inline-block")
}
if($.cookie("hs_hide")){
$hs_area.addClass("on")
}
$(".xf_sh_list_b .list").on("mouseenter","li",function(){
$(this).addClass('on')
}).on("mouseleave","li",function(){
$(this).removeClass('on')
})
var $hname=$("#hname").autoC("<?php echo $MOD['linkurl'];?>house.php?action=house"),
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
/*********更多找房条件*************/
$("#hs_more div").on({
mouseenter:function(){
$(this).find("ul").show()
},
mouseleave:function(){
$(this).find("ul").hide()
}
})
/* 排序 */
$(".xf_sh_list_t .px").on({
mouseenter:function(){
$(this).addClass('on')
},
mouseleave:function(){
$(this).removeClass('on')
}
})
});
</script>
<script type="text/javascript" src="https://api.map.baidu.com/api?v=3.0&ak=<?php echo $AJ['map_key'];?>&s=1"></script>
<script type="text/javascript" src="<?php echo AJ_SKIN;?>js/list-map.js"></script>
<script type="text/javascript" src="<?php echo AJ_SKIN;?>js/scrollfix.js"></script>
<script>
    $(".list-advs").scrollFix();
</script>
<script type="text/javascript">
     var house_list_num = $('.item-mod').length;
    var house_list = $('.item-mod');
    var last_scroll_top=0;// 上次滚动条到顶部的距离
    var interval=null;// 定时器
   
   
    var markerArr = [
                 <?php if(is_array($tagss)) { foreach($tagss as $k => $t) { ?> 
  {title:"<?php echo $t['title'];?>        <?php echo $t['price'];?>",id:"myid<?php echo $t['itemid'];?>",point:'<?php echo $t['map'];?>', url: '<?php echo $t['linkurl'];?>'},
  <?php } } ?>
            ]
    if(markerArr!=""){
        var map = createmap("list_map");
        markermap(markerArr, map);
    }else{
        var map = new BMap.Map("list_map");    // 创建Map实例
        map.centerAndZoom(new BMap.Point(<?php echo $map_mid;?>), 11);  // 初始化地图,设置中心点坐标和地图级别
        map.setCurrentCity("");          // 设置地图显示的城市 此项是必须设置的
        map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
    }
    
    $(window).scroll(function(){
        if(house_list_num>0){
            if(interval==null){
                interval=setInterval("validate_scroll()",100);//这里就是判定时间，并执行相关操作
            }
        }
    })
    //验证是否滚动停止，滚动停止后执行验证楼盘列表在可见区域的操作
    function validate_scroll(){
        markerArr = [];
        // 判断是否停止拖动，如停止执行验证和操作。此刻到顶部的距离是否之前前的距离相等
        if($(document).scrollTop()==last_scroll_top){
            var window_height = $(window).outerHeight();
            var scroll_height = $(document).scrollTop();
            var view_height = scroll_height+window_height;
            for(i=0;i<house_list_num;i++){
                var list = house_list.eq(i).attr("id");
                console.log(list);
                
                //判断是否有id为空，为空则停止，防止循环不断执行
                if(list == undefined){
                    break;
                }
                var list_top = $('#'+list).offset().top;
                var item_height = $('#'+list).outerHeight();
                var list_bottom = list_top + $('#'+list).outerHeight();
                console.log();
                
                //该楼盘列表的上下是否都有一部分或全部在可见区域内
                //scroll_height >(list_top+item_height)
                if((list_top>scroll_height&&list_top<view_height&&scroll_height>150)||(list_bottom>scroll_height&&list_bottom<view_height)){
 
                    //console.log('#'+list+'top:'+list_top +'||'+'scrolltop:'+ scroll_height +'||'+ 'bottom:'+list_bottom +'||'+ view_height);
                    markerArr.push({title:$('#'+list).attr('housename')+'    '+$('#'+list).attr('houseprice')+'元/㎡',id:"myid"+$('#'+list).attr('houseid'),url:$('#' + list).attr('url'),point:$('#'+list).attr('housemap')})
                }
            }
            setTimeout(function(){  markermap(markerArr,map);},100);
            window.clearInterval(interval);
            interval=null;
        }
        last_scroll_top=$(document).scrollTop();
    }
    
</script>
<?php include template('footer');?>