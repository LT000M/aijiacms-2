<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php include template('header');?>
<link href="<?php echo AJ_SKIN;?>index.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo AJ_SKIN;?>js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="<?php echo AJ_SKIN;?>js/js08-28.js"></script>
        
    <!-- img slide -->
<div id="slider-wrap" class="slider-wrap" data-tag="jdt">
    <div class="jqDuang ma" data-duang="1" data-nextbtn=".next-btn" data-prevbtn=".prev-btn" data-cell=".small-btn" data-obj=".slider">
        <div class="slider-content">
        
        <?php echo ad(6);?>
                    
                    </div>
        <div class="small-btn"></div>
      
    </div>
    <!-- 表单 -->
    <div class="search-form" id="search-form">
        <form class="head-tt" id="i_search" method="post" target="_blank" autocomplete="off" >
       
            <div class="head-td f16">
            <ul>
                <li class="search-tr"><a href="javascript:void(0);" class="hover">新房</a><a href="javascript:void(0);" >二手房</a><a href="javascript:void(0);" >租房</a><a href="javascript:void(0);" >资讯</a>
              </li>
                    <li class="search-tt">
                    <input type="text" value="请输入楼盘名称(中文/拼音/简拼)、地址" class="search-inp f16 keyword"  onBlur="if(!value){value=defaultValue;}"/>
                        <input type="submit" value="" class="search-but" />
                         
                    </li>
                  
              </ul>
            </div>
            <div class="head-map">
            <a href="<?php echo $MODULE['1']['linkurl'];?>map/house.html" target="_blank">地图找房</a>
            </div>
        </form>
    </div>
    <!-- /表单 -->
</div>
<!-- /img slide -->
<script type="text/javascript">
        var obj = {
             house:{
                url:"<?php echo $MODULE['6']['linkurl'];?>search-k",
                initUrl:"<?php echo $MODULE['6']['linkurl'];?>list.html",
                hz:".html",
                msg:"请输入楼盘名称(中文/拼音/简拼)、地址",
                autoUrl:""
                  },
sale:{
url:"<?php echo $MODULE['5']['linkurl'];?>search-k",
initUrl:"<?php echo $MODULE['5']['linkurl'];?>list.html",
hz:".html",
msg:"请输入小区名称/地址/标题",
autoUrl:""
        },
    rent:{
url:"<?php echo $MODULE['7']['linkurl'];?>search-k",
initUrl:"<?php echo $MODULE['7']['linkurl'];?>list.html",
hz:".html",
msg:"请输入小区名称/地址/标题",
autoUrl:""
      },
            news:{
                url:"<?php echo $MODULE['8']['linkurl'];?>search-k",
                initUrl:"<?php echo $MODULE['8']['linkurl'];?>list.html",
                hz:".html",
                msg:"请输入搜索内容",
                autoUrl:""
            }
        };
</script>
<script type="text/javascript" src="<?php echo AJ_SKIN;?>js/search.js?v=22"></script><!---main main-->
<!--新加菜单导航-->
<link rel="stylesheet" href="<?php echo AJ_SKIN;?>/index_up.css">
<div class="wrap clearfix">
<div class="w270 nav-dt keep">
<div class="bigdiv">
<div class="divborder">
<div class="leixingtu">
<img src="<?php echo AJ_SKIN;?>images/index/quyu.png" alt="" class="bigdivimg"><div class="leibieword">区域</div></div>
<div class="smalldiv">
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a56v.html" target="_blank">和平</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a59v.html" target="_blank">南开</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a60v.html" target="_blank">河北</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a58v.html" target="_blank">河西</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a57v.html" target="_blank">河东</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a61v.html" target="_blank">红桥</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_a71v.html" target="_blank">滨海</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">更多</a></div>
</div>
</div>
<div class="divborder">
<div class="leixingtu">
<img src="<?php echo AJ_SKIN;?>images/index/jiage1.png" alt="" class="bigdivimg"><div class="leibieword">价格</div></div>
<div class="smalldiv">
<div class="six"><adc href="<?php echo $MODULE['6']['linkurl'];?>list_b20000v_c25000v.html" target="_blank">2.5万以下</adc></div>
<div class="six"><adc href="<?php echo $MODULE['6']['linkurl'];?>list_b25000v_c30000v.html" target="_blank">2.5-3万</adc></div>
<div class="six"></div>
<div class="six"><adc href="<?php echo $MODULE['6']['linkurl'];?>list_b30000v_c35000v.html" target="_blank">3-3.5万</adc></div>
<div class="six"><adc href="<?php echo $MODULE['6']['linkurl'];?>list_b35000v_c40000v.html" target="_blank">3.5万以上</adc></div>
<div class="six"><adc href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">更多</adc></div>
</div>
</div>
<div class="divborder">
<div class="leixingtu">
<img src="<?php echo AJ_SKIN;?>images/index/leixing.png" alt="" class="bigdivimg"><div class="leibieword">类别</div></div>
<div class="smalldiv">
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_t1v.html" target="_blank">洋房</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_t2v.html" target="_blank">小高层</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_t3v.html" target="_blank">高层</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_t4v.html" target="_blank">叠拼</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_t5v.html" target="_blank">别墅</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">更多</a></div>
</div>
</div>
<div class="divborder">
<div class="leixingtu">
<img src="<?php echo AJ_SKIN;?>images/index/tese1.png" alt="" class="bigdivimg"><div class="leibieword">房型</div></div>
<div class="smalldiv">
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_l2v.html" target="_blank">一居室</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_l3v.html" target="_blank">二居室</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_l4v.html" target="_blank">三居室</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_l5v.html" target="_blank">四居室</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>list_l6v.html" target="_blank">五居室</a></div>
<div class="six"><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">更多</a></div>
</div>
</div>
<div class="divborder">
<div class="leixingtu">
<img src="<?php echo AJ_SKIN;?>images/index/zhuangtai.png" alt="" class="bigdivimg"><div class="leibieword">状态</div></div>
<div class="smalldiv">
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_x90v.html" target="_blank">现房</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_x91v.html" target="_blank">期房</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_x92v.html" target="_blank">准现房</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_f1v.html" target="_blank">毛坯</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_f2v.html" target="_blank">简装</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_f3v.html" target="_blank">精装</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>list_o1v.html" target="_blank">快开盘</a></div>
<div class="eight"><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">更多</a></div>
</div>
</div>
</div>
</div>
<!--新加菜单结束>
<!--菜单导航-->
<div id="navmover">
  <div class="newtoolnr family wrap"> 
 <!--卖房-->
      <div class="trd wd1">
        <dl>
         <dt><a target="_blank" href="<?php echo $MODULE['6']['linkurl'];?>">买房</a></dt>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['6']['linkurl'];?>list.html">新房</a><a target="_blank" href="<?php echo $MODULE['15']['linkurl'];?>">团购</a></dd>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['6']['linkurl'];?>list_t3v.html">商铺</a><a target="_blank" href="<?php echo $MODULE['6']['linkurl'];?>list_t2v.html">公寓</a></dd>
       </dl>
      </div>
  <!--资讯-->
 <div class="trd wd1">
      <dl>
        <dt><a target="_blank" href="<?php echo $MODULE['8']['linkurl'];?>">资讯</a></dt>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['8']['linkurl'];?>list-28.html">本地</a><a target="_blank" href="<?php echo $MODULE['8']['linkurl'];?>list-29.html">国内</a></dd>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['8']['linkurl'];?>list-32.html">导购</a><a target="_blank" href="<?php echo $MODULE['8']['linkurl'];?>list-33.html">优惠</a></dd>
      </dl>
   </div>
 <!--赚佣金-->
    <div class="trd wd1">
         <dl>
         <dt><a target="_blank" href="<?php echo $MODULE['15']['linkurl'];?>">优惠</a></dt>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['15']['linkurl'];?>">新房团购</a></dd>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['1']['linkurl'];?>fenxiao">赚佣金</a></dd>
         </dl>
    </div>
      <!--卖房-->
      <div class="trd wd1">
       <dl>
        <dt><a target="_blank" href="<?php echo $MODULE['5']['linkurl'];?>">卖房</a></dt>
         <dd class="w110"><a target="_blank" href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=5&action=add">我要卖房</a></dd>
          <dd class="w110"><a target="_blank" href="<?php echo $MODULE['18']['linkurl'];?>">小区</a></dd>
        </dl>
    </div>
   <!--租房-->
    <div class="trd wd5">
     <dl><dt><a target="_blank" href="<?php echo $MODULE['7']['linkurl'];?>">租房</a></dt>
      <dd class="w110"><a target="_blank" href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=7&action=add">我要出租</a></dd>
     <dd class="w110"><a target="_blank" href="<?php echo $MODULE['7']['linkurl'];?>">找租房</a></dd>
    </dl>
    </div>
      <!--//End 租房--> 
  </div>
</div>
<!--//End菜单导航-->
<script src="<?php echo AJ_SKIN;?>js/amendTab.js"></script>
    <div class="house-ad adb"><!-- 广告位： 首页A区横幅AD1 --><?php echo ad(11);?></div>
    <div class="house-ad adb"><!-- 广告位： 首页A区横幅AD2 --><?php echo ad(12);?></div>
    <div class="house-ad adb"><!-- 广告位： 首页A区横幅AD3 --><?php echo ad(13);?></div>
<!--正文最外部容器-->
<div class="wrap"> 
  <!--顶部热点推荐选项卡板块-->
 <div class="toprecom">
    <ul  id="amendTab0" class="toprecom_tab">
     <li class="amendTabDef">热销楼盘</li>
      <li>最新楼盘</li>
      <li style="border-right:0px;">最新开盘</li>
    </ul>
 <!--独家优惠-->
 <div id="album01" class="toprecom_content album01" style="display:block"> 
 <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb!=''&areaid=$cityid&length=20&order=hits desc&pagesize=4&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
    <div class="toprecom_box <?php if(empty($k)) { ?>fst<?php } ?>">
        <div class="inner"> <a target="_blank" href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"> <img src="<?php echo imgurl($t['thumb']);?>" width="260" height="160"  alt="<?php echo $t['alt'];?>"/> <span><?php echo $t['title'];?></span> </a>
    <div class="toprecom_info">
    <div class="l address"> <em><a href="" target="_blank"><?php echo area_poss($t['areaid'], ' ');?></a></em> <p title=""><?php echo search_cats($t['catid'], '6');?></p> </div>
      <div class="l youhui"> <em><?php echo $t['tedian'];?></em> <p>均价<?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></p> </div>
    </div> </div> </div><?php } } ?>
    </div>
    <!--9月特卖-->
    <div id="album02"  class="toprecom_content album03" style="display:none"> 
 <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb!=''&areaid=$cityid&length=20&order=addtime desc&pagesize=4&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
    <div class="toprecom_box <?php if(empty($k)) { ?>fst<?php } ?>">
        <div class="inner"> <a target="_blank" href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"> <img src="<?php echo imgurl($t['thumb']);?>" width="282" height="188"  alt="<?php echo $t['alt'];?>"/> <span><?php echo $t['title'];?></span> </a>
          <div class="toprecom_info"> <em><?php echo search_cats($t['catid'], '6');?></em>
       <p class="needslicestr"><?php echo $t['tedian'];?></p>
          </div>
        </div>
      </div>
<?php } } ?>
    </div>
    <!--抢9月-->
    <div id="album03" class="toprecom_content album02" style="display:none"> 
<?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb!=''&areaid=$cityid&length=20&order=selltime desc&pagesize=4&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
    <div class="toprecom_box <?php if(empty($k)) { ?>fst<?php } ?>">
        <div class="inner"> <a target="_blank" href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"> <img src="<?php echo imgurl($t['thumb']);?>" width="282" height="188"  alt="<?php echo $t['alt'];?>"/> <span><?php echo $t['title'];?></span> </a>
          <div class="toprecom_info"> <em>价格：<?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></em>
       <p class="needslicestr">特点：<?php echo $t['tedian'];?></p>
          </div>
        </div>
      </div>
<?php } } ?>
    </div>
  </div>
  <script>amendTab("amendTab0","album0","li","amendTabDef",0);</script> 
  <!--//End顶部热点推荐选项卡板块-->
   <div class="house-ad adb"><!-- 广告位： 首页B区横幅AD1 --><?php echo ad(14);?></div>
     <div class="house-ad adb"><!-- 广告位： 首页B区横幅AD1 --><?php echo ad(15);?></div>
  <div class="house-ad adb"><!-- 广告位： 首页B区横幅AD1 --><?php echo ad(16);?></div>
  <div class="blank10"></div>
        
        <div id="news" class="clearfix">
        <div class="col-title clearfix">
                <h2 class="l"><span>热门资讯</span></h2>
                <div class="col-info r">
                 <?php $maincat = get_maincat(0,8)?>
        <?php if(is_array($maincat)) { foreach($maincat as $k => $v) { ?>
        <?php if($k<8) { ?>
                        <a href="<?php echo $MODULE['8']['linkurl'];?><?php echo $v['linkurl'];?>" <?php if($catid==$v['catid']) { ?>class="current"<?php } ?> ><?php echo $v['catname'];?></a>&nbsp;&nbsp;<?php } ?><?php } } ?>
                     </div>
            </div>
            <div class="clearfix mt20">
                <div class="news-left w270 l mr20">
                    <ul>
                                   <?php $tags=tag("moduleid=8&condition=status=3 and level=3 and thumb!=''&areaid=$cityid&length=30&order=addtime desc&pagesize=3&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>         <li><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"><img alt="<?php echo $t['alt'];?>" src="<?php echo imgurl($t['thumb']);?>"width="270" height="145"><span><?php echo $t['title'];?></span></a></li>
                                               <?php } } ?>
                                            </ul>
                </div>
                <div class="news-center w640 l">
                    <div class="news-list clearfix">
                                                                     <?php $tags=tag("moduleid=8&condition=status=3 and level=5&areaid=$cityid&order=addtime desc&pagesize=1&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?> <h3><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"><?php echo $t['title'];?></a> </h3><?php } } ?>
                        <ul>
                                                                   <?php $tags=tag("moduleid=8&condition=status=3 and level=4&areaid=$cityid&order=addtime desc&pagesize=10&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?> <li><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"><?php echo $t['title'];?></a> </li><?php } } ?>     </ul>
                        </ul>
                    </div>
                    <div class="news-list mt20 clearfix">
                                                      <?php $tags=tag("moduleid=8&condition=status=3 and level=6&length=48&areaid=$cityid&order=addtime desc&pagesize=1&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?> <h3><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"><?php echo $t['title'];?></a> </h3><?php } } ?>
                        <ul>
                                                                   <?php $tags=tag("moduleid=8&condition=status=3 and level=1&areaid=$cityid&order=addtime desc&pagesize=10&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?> <li><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"><?php echo $t['title'];?></a> </li><?php } } ?> 
                                                                                </ul>
                    </div>
                </div>
                <div class="news-right w270 r">
                     <!--385--><div class="house-ad ad"><?php echo ad(24);?></div>
                    <div class="news-kb clearfix mt10">
                        <h3>公告信息</h3>
                        <ul>
                <?php $tags=tag("table=announce&condition=(totime=0 or totime>$today_endtime-86400)&areaid=$cityid&pagesize=7&datetype=2&order=listorder desc,addtime desc&target=_blank")?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?> <li><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>"><?php echo $t['title'];?></a> </li><?php } } ?> 
                                                    </ul>
                    </div>
                </div>
            </div>
        </div>
<div class="clear"></div>
 <div class="house-ad adb"><!-- 广告位： 首页C区横幅AD1 --><?php echo ad(17);?></div>
  <div class="house-ad adb"><!-- 广告位： 首页C区横幅AD1 --><?php echo ad(18);?></div>
  <div class="house-ad adb"><!-- 广告位： 首页C区横幅AD1 --><?php echo ad(19);?></div>
<!--box 新房-->
    <div  id="xptj" class="jqDuang clearfix box-block01" data-cell=".col-nav" data-obj=".newhouse-block" data-autoplay="0" data-speed="0">
        <!--newhouse-->
        <div class="newhouse f-left">
         <div>
            <div class="col-title clearfix">
                <h2 class="l"><span>新盘推荐</span></h2>
                <div class="col-nav l">
                    <a class="act" href="<?php echo $MODULE['6']['linkurl'];?>" ><span>人气楼盘</span><i class="ico08">&#xf0dc;</i></a><a class="" href="<?php echo $MODULE['6']['linkurl'];?>" ><span>品牌精品</span><i class="ico08">&#xf0dc;</i></a><a class="" href="<?php echo $MODULE['1']['linkurl'];?>" ><span>最新开盘</span><i class="ico08">&#xf0dc;</i></a> <a class="" href="<?php echo $MODULE['6']['linkurl'];?>" ><span>商业地产</span><i class="ico08">&#xf0dc;</i></a>              </div>
               
            </div>
              
            </div>
          
            
            <div class="newhouse-block ">
            <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb!=''&areaid=$cityid&length=20&order=hits desc&pagesize=8&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                <div class="pic-list f-left">
                    <a href="<?php echo $t['linkurl'];?>" class="pic" target="_blank"><img class="scrollLoading" alt="<?php echo $t['alt'];?>" src="<?php echo imgurl($t['thumb']);?>"   height="165" width="220"/><span><?php echo $t['title'];?></span></a>
                    <div class="fl f-left">
                                                                                            <em class="red"><?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></em>
                                                                                </div>
                    <div class="fr f-right" title="<?php echo $t['tedian'];?>"><?php echo $t['tedian'];?></div>                    <div class="clear"></div>
                      <?php if($t['lpts']) { ?> <div class="tags">
                                                                           <?php $ts=explode(",",$t['lpts']);?>
                    <?php if(is_array($ts)) { foreach($ts as $ks => $vs) { ?>
                    <?php if($ks<2) { ?>
                     <span><?php echo getbox_diaoval('lpts','checkbox',$vs,'newhouse_6');?></span><?php } ?>
                    <?php } } ?>  </div><?php } ?>
                </div>
                          <?php } } ?>
                                <div class="clear"></div>
            </div>
            <div class="newhouse-block" style="display:none;">
                              <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb!='' and level>0&areaid=$cityid&length=20&order=addtime desc&pagesize=8&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                <div class="pic-list f-left">
                    <a href="<?php echo $t['linkurl'];?>" class="pic" target="_blank"><img class="scrollLoading" alt="<?php echo $t['alt'];?>" src="<?php echo imgurl($t['thumb']);?>"   height="165" width="220"/><span><?php echo $t['title'];?></span></a>
                    <div class="fl f-left">
                                                                                            <em class="red"><?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></em>
                                                                                </div>
                    <div class="fr f-right" title="<?php echo $t['tedian'];?>"><?php echo $t['tedian'];?></div>                    <div class="clear"></div>
                      <?php if($t['lpts']) { ?> <div class="tags">
                                                                           <?php $ts=explode(",",$t['lpts']);?>
                    <?php if(is_array($ts)) { foreach($ts as $ks => $vs) { ?>
                    <?php if($ks<2) { ?>
                     <span><?php echo getbox_diaoval('lpts','checkbox',$vs,'newhouse_6');?></span><?php } ?>
                    <?php } } ?>  </div><?php } ?>
                </div>
                          <?php } } ?>
                                <div class="clear"></div>
            </div> 
            <div class="newhouse-block" style="display:none;">
                               <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1 and thumb!=''&areaid=$cityid&length=20&order=selltime desc&pagesize=8&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                <div class="pic-list f-left">
                    <a href="<?php echo $t['linkurl'];?>" class="pic" target="_blank"><img class="scrollLoading" alt="<?php echo $t['alt'];?>" src="<?php echo imgurl($t['thumb']);?>"   height="165" width="220"/><span><?php echo $t['title'];?></span></a>
                    <div class="fl f-left">
                                                                                            <em class="red"><?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></em>
                                                                                </div>
                    <div class="fr f-right" title="<?php echo $t['tedian'];?>"><?php echo $t['tedian'];?></div>                    <div class="clear"></div>
                      <?php if($t['lpts']) { ?> <div class="tags">
                                                                           <?php $ts=explode(",",$t['lpts']);?>
                    <?php if(is_array($ts)) { foreach($ts as $ks => $vs) { ?>
                    <?php if($ks<2) { ?>
                     <span><?php echo getbox_diaoval('lpts','checkbox',$vs,'newhouse_6');?></span><?php } ?>
                    <?php } } ?>  </div><?php } ?>
                </div>
                          <?php } } ?>
                                <div class="clear"></div>
            </div>
              <div class="newhouse-block" style="display:none;">
                              <?php $tags=tag("moduleid=6&condition=status=3 and catid=3 and isnew=1&areaid=$cityid&length=20&order=addtime desc&pagesize=8&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                <div class="pic-list f-left">
                    <a href="<?php echo $t['linkurl'];?>" class="pic" target="_blank"><img class="scrollLoading" alt="<?php echo $t['alt'];?>" src="<?php echo imgurl($t['thumb']);?>"   height="165" width="220"/><span><?php echo $t['title'];?></span></a>
                    <div class="fl f-left">
                                                                                            <em class="red"><?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></em>
                                                                                </div>
                    <div class="fr f-right" title="<?php echo $t['tedian'];?>"><?php echo $t['tedian'];?></div>                    <div class="clear"></div>
                      <?php if($t['lpts']) { ?> <div class="tags">
                                                                           <?php $ts=explode(",",$t['lpts']);?>
                    <?php if(is_array($ts)) { foreach($ts as $ks => $vs) { ?>
                    <?php if($ks<2) { ?>
                     <span><?php echo getbox_diaoval('lpts','checkbox',$vs,'newhouse_6');?></span><?php } ?>
                    <?php } } ?>  </div><?php } ?>
                </div>
                          <?php } } ?>
                                <div class="clear"></div>
            </div> 
        </div>
        <!--newhouse end-->
        
        <!--right-->
       <div class="newhouse-right f-right">
            <!--开盘日历-->
            <div class="calendar">
                <div class="calendar-title">开盘日历</div>
                <div class="opened_date" >
                    <div class="jscroll-c calendar-block" id="inner-content-div">
                        <ul>   <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1&areaid=$cityid&length=20&order=selltime desc&pagesize=8&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                                            <li class="clearfix">
                                    <i class="timebox"></i>
                                    <div class="infbox">
                                        <span class="no1"><?php echo $t['selltime'];?></span>
                                                                                    <p><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a><em><?php if($t['price']) { ?><?php echo $t['price'];?>元/㎡<?php } else { ?>一房一价<?php } ?></em></p>
                                                                                <div class="clear"></div>
                                    </div>
                                </li>  <?php } } ?>
                                                    </ul>
                    </div>
                </div>
            </div>
            <!--开盘日历 end-->
            
            <!--box-->
            <div class="box01">
                <table cellpadding="0" cellspacing="0" border="1" bordercolor="#cacaca" width="100%">
                    <tr>
                        <td width="50%"><a href="<?php echo $MODULE['1']['linkurl'];?>tool" target="_blank"><i class="tab-icon01"></i><span>购房计算器</span></span></a></td>
                        <td width="50%"><a href="<?php echo $MODULE['8']['linkurl'];?>" target="_blank"><i class="tab-icon02"></i><span>购房知识</span></a></td>
                    </tr>
                    <tr>
                        <td><a href="<?php echo $MODULE['1']['linkurl'];?>fenxiao" target="_blank"><i class="tab-icon03"></i><span>赚佣金</span></a></td>
                        <td><a href="<?php echo $MODULE['15']['linkurl'];?>" target="_blank"><i class="tab-icon04"></i><span>看房团</span></a></td>
                    </tr>
                    <tr>
                        <td><a href="<?php echo $MODULE['8']['linkurl'];?>list-34.html" target="_blank"><i class="tab-icon05"></i><span>看房日记</span></a></td>
                        <td><a href="<?php echo $MODULE['1']['linkurl'];?>map" target="_blank"><i class="tab-icon06"></i><span>地图找房</span></a></td>
                    </tr>
                </table>
            </div>
            <!--box end-->
            
        </div>
        <!--right end-->
        <div class="clear"></div>
    </div>
    <!--box end-->
    <div class="blank10"></div>
    <?php if($AJ['page_video'] && isset($MODULE['14'])) { ?>
<div id="xspd" class="jqDuang clearfix" data-cell=".col-nav" data-obj=".plist" data-autoplay="0" data-speed="0">
            <div class="col-title clearfix">
                <h2 class="l"><span>楼盘视频</span></h2>
              
            </div>
            <div class="clearfix">
                                <ul class="plist plist-mod clearfix  ">
                                   <?php $tags=tag("moduleid=14&condition=status=3 and thumb!=''&areaid=$cityid&order=addtime desc&pagesize=5&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?> 
                                        <li>
                        <a class="img" href="<?php echo $t['linkurl'];?>" target="_blank"><img  width="220" height="160" alt="<?php echo $t['alt'];?>" src="<?php echo imgurl($t['thumb']);?>"/></a>
                        <h4 class="fcw"><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a></h4>
                    </li><?php } } ?>
                                    </ul>
                               
                
            </div>
        </div>
        <?php } ?>
        <div class="blank10"></div>
          
         <div class="house-ad adb"><!-- 广告位： 首页D区横幅AD1 --><?php echo ad(20);?></div>
 <div class="house-ad adb"><!-- 广告位： 首页D区横幅AD1 --><?php echo ad(21);?></div>
        
        <div class="blank10"></div>
        
        <div id="escz" class="jqDuang clearfix" data-cell=".col-nav" data-obj=".escz_list|#escz .condition" data-autoplay="0" data-speed="0">
            <div class="col-title clearfix">
                <h2 class="l"><span>二手房 <i class="ico08 fz12" style="vertical-align:top;_vertical-align:middle">&#xf052;</i> 出租</span></h2>
                <div class="col-nav col-nav-lg l">
                    <a class="act" href="<?php echo $MODULE['5']['linkurl'];?>"><span>二手房</span><i class="ico08">&#xf0dc;</i></a>
                    <a href="<?php echo $MODULE['7']['linkurl'];?>"><span>出租房</span><i class="ico08">&#xf0dc;</i></a>
                    <a href="<?php echo $MODULE['18']['linkurl'];?>"><span>热门小区</span><i class="ico08">&#xf0dc;</i></a>
                    <a href="<?php echo $MODULE['4']['linkurl'];?>"><span>经纪人</span><i class="ico08">&#xf0dc;</i></a>
                    <a href="<?php echo $MODULE['16']['linkurl'];?>list-u2.html"><span>求租</span><i class="ico08">&#xf0dc;</i></a>
                    <a href="<?php echo $MODULE['16']['linkurl'];?>list-u1.html"><span>求购</span><i class="ico08">&#xf0dc;</i></a>
                </div>
            </div>
            <div class="w270 l mr20 pt20">
                <dl class="condition">
                    <dd>
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>区域</h4>
                            <div class="con-cate-list">
                                <?php $mainarea = get_mainarea($cityid)?>
    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?><a  href="<?php echo $MODULE['5']['linkurl'];?><?php echo rentser('d',$v['areaid']);?>"><?php echo $v['areaname'];?></a><?php } } ?>                           </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有区域</h4>
                            <div class="con-cate-list">
                                <?php $mainarea = get_mainarea($cityid)?>
    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?><a  href="<?php echo $MODULE['5']['linkurl'];?><?php echo rentser('d',$v['areaid']);?>"><?php echo $v['areaname'];?></a><?php } } ?>                          </div>
                        </div>
                    </dd>
                    <dd>
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>价格</h4>
                            <div class="con-cate-list">
                          <?php echo getxqsearchstr('b','c','c','万',$AJ['saleprice'],$getstr,'c','sale',$linkurl);?>     </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有价格</h4>
                            <div class="con-cate-list">
                         <?php echo getxqsearchstr('b','c','c','万',$AJ['saleprice'],$getstr,'c','sale',$linkurl);?>  </div>
                        </div>
                    </dd>
                    <dd>
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>建面</h4>
                            <div class="con-cate-list">
                           <?php echo getxqsearchstr('g','h','c','平米',$AJ['salearea'],$getstr,'c','sale',$linkurl);?>    </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有建面</h4>
                            <div class="con-cate-list">
                            <?php echo getxqsearchstr('g','h','c','平米',$AJ['salearea'],$getstr,'c','sale',$linkurl);?>       </div>
                        </div>
                    </dd>
                    <dd class="last">
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>户型</h4>
                            <div class="con-cate-list">
                             <?php $huxing = array('一室', '二室', '三室', '四室', '五室以上');?>
<?php if(is_array($huxing)) { foreach($huxing as $k => $v) { ?>
  <a  target="_blank" href="<?php echo $MODULE['5']['linkurl'];?>list-i<?php echo $k+1;?>.html"><?php echo $v;?></a>
<?php } } ?>                       </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有户型</h4>
                            <div class="con-cate-list">
                              <?php $huxing = array('一室', '二室', '三室', '四室', '五室以上');?>
<?php if(is_array($huxing)) { foreach($huxing as $k => $v) { ?>
  <a  target="_blank" href="<?php echo $MODULE['5']['linkurl'];?><?php echo rentser('r',($k+1));?>"><?php echo $v;?></a>
<?php } } ?>                         </div>
                        </div>
                    </dd>
                </dl>
                <dl class="condition dn" style="display:none;">
                    <dd>
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>区域</h4>
                            <div class="con-cate-list">
                                <?php $mainarea = get_mainarea($cityid)?>
    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?><a  href="<?php echo $MODULE['7']['linkurl'];?><?php echo rentser('a',$v['areaid'],'d');?>"><?php echo $v['areaname'];?></a><?php } } ?>                     </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有区域</h4>
                            <div class="con-cate-list">
                               <?php $mainarea = get_mainarea($cityid)?>
    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?><a  href="<?php echo $MODULE['7']['linkurl'];?><?php echo rentser('a',$v['areaid'],'d');?>"><?php echo $v['areaname'];?></a><?php } } ?>                </div>
                        </div>
                    </dd>
                    <dd>
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>租金</h4>
                            <div class="con-cate-list">
                                    <?php echo getxqsearchstr('b','c','c','元',$AJ['rentprice'],$getstr,'c','rent',$linkurl);?>      </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有租金</h4>
                            <div class="con-cate-list">
                                   <?php echo getxqsearchstr('b','c','c','元',$AJ['rentprice'],$getstr,'c','rent',$linkurl);?>      </div>
                        </div>
                    </dd>
                    <dd>
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>户型</h4>
                            <div class="con-cate-list">
                              <?php $huxing = array('一室', '二室', '三室', '四室', '五室以上');?>
<?php if(is_array($huxing)) { foreach($huxing as $k => $v) { ?>
  <a  target="_blank" href="<?php echo $MODULE['7']['linkurl'];?><?php echo rentser('r',($k+1));?>"><?php echo $v;?></a>
<?php } } ?>                         </div>
                        </div>
                        <div class="con-cate-more">
                            <h4>所有户型</h4>
                            <div class="con-cate-list">
                              <?php $huxing = array('一室', '二室', '三室', '四室', '五室以上');?>
<?php if(is_array($huxing)) { foreach($huxing as $k => $v) { ?>
  <a  target="_blank" href="<?php echo $MODULE['7']['linkurl'];?><?php echo rentser('r',($k+1));?>"><?php echo $v;?></a>
<?php } } ?>                       </div>
                        </div>
                    </dd>
                    <dd class="last">
                        <div class="con-cate">
                            <h4><i class="ico08 r fcg">&#xe68f;</i>建面</h4>
                            <div class="con-cate-list">
                                <?php echo getxqsearchstr('g','h','c','平米',$AJ['rentarea'],$getstr,'c','rent',$linkurl);?>   </div>
                        </div>
                        <div class="con-cate-more">
                          
                            <h4>所有建面</h4>
                            <div class="con-cate-list">
                                <?php echo getxqsearchstr('g','h','c','平米',$AJ['rentarea'],$getstr,'c','rent',$linkurl);?> </div>
                        </div>
                    </dd>
                </dl>
                
                <div class="col-tools1 clearfix">
                    <a href="<?php echo $MODULE['2']['linkurl'];?>" rel="nofollow"><i class="ico08 mr5">&#xe635;</i>发布二手</a>
                    <a href="<?php echo $MODULE['2']['linkurl'];?>" rel="nofollow"><i class="ico08 mr5">&#xe632;</i>发布出租</a>
                    <a href="<?php echo $MODULE['2']['linkurl'];?>" rel="nofollow"><i class="ico08 mr5">&#xe62f;</i>发布求购</a>
                    <a href="<?php echo $MODULE['2']['linkurl'];?>" rel="nofollow"><i class="ico08 mr5">&#xe626;</i>发布求租</a>
                    <a href="<?php echo $MODULE['1']['linkurl'];?>map" rel="nofollow"><i class="ico08 mr5">&#xf15b;</i>地图找房</a>
                    <a href="<?php echo $MODULE['5']['linkurl'];?>" rel="nofollow"><i class="ico08 mr5">&#xf0f6;</i>区域找房</a>
                    <div class="blank0"></div>
                </div>
            </div>
            <div class="w640 l">
            <div class="escz_list clearfix">
                    <ul class="plist1 plist-mod clearfix">
                            <?php $tags=tag("moduleid=5&condition=status=3 and thumb<>''&areaid=$cityid&length=22&pagesize=3&order=addtime desc&target=_blank&template=null");?>
 <?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                                <li>
                            <a class="img" href="<?php echo $t['linkurl'];?>"><img alt="<?php echo $t['alt'];?>" width="193" height="140" src="<?php echo imgurl($t['thumb']);?>"/></a>
                            <h4><a href="<?php echo $t['linkurl'];?>"><?php echo $t['title'];?></a></h4>
                            <h5><span class="r"><?php echo area_pos($t['areaid'], '');?></span><span class="fz24 fcr"><?php if($t['price']) { ?><?php echo $t['price'];?>万<?php } else { ?>面议<?php } ?></span>                            </h5>
                        </li><?php } } ?>
                                            </ul>
                    <ul class="escz_ul mt20 clearfix">
                      <?php $tags=tag("moduleid=5&condition=status=3&areaid=$cityid&length=22&pagesize=6&order=addtime desc&target=_blank&template=null");?>
 <?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                        <li>
                                              
                            <i class="<?php if($k<3) { ?>hot<?php } ?>"><?php echo $k+1;?></i>
                            <a  href="<?php echo $t['linkurl'];?>" title="<?php echo $t['title'];?>" class="escz-name"><?php echo $t['title'];?> </a>
                            <span class="escz-area"><?php echo area_pos($t['areaid'], '');?></span>                            <span class="escz-room"><?php if($t['room']) { ?><?php echo $t['room'];?>室<?php } else { ?>待定<?php } ?><?php if($t['hall']) { ?><?php echo $t['hall'];?>厅<?php } ?></span>
                            <span class="escz-totalarea"><?php echo $t['houseearm'];?><em class="fz12">m&sup2;</em></span>
                            <span class="escz-price"><em><?php if($t['price']) { ?><?php echo $t['price'];?></em>万<?php } else { ?>面议</em><?php } ?></span>
                        </li><?php } } ?>
                                            </ul>
                </div><!-- /plist -->
                <div class="escz_list clearfix dn" style="display:none;">
                    <ul class="plist1 plist-mod clearfix">
                     <?php $tags=tag("moduleid=7&condition=status=3 and thumb<>''&areaid=$cityid&length=22&pagesize=3&order=addtime desc&target=_blank&template=null");?>
 <?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                                <li>
                            <a class="img" href="<?php echo $t['linkurl'];?>"><img alt="<?php echo $t['alt'];?>" width="193" height="140" src="<?php echo imgurl($t['thumb']);?>"/></a>
                            <h4><a href="<?php echo $t['linkurl'];?>"><?php echo $t['title'];?></a></h4>
                            <h5><span class="r"><?php echo area_pos($t['areaid'], '');?></span><span class="fz24 fcr"><?php if($t['price']) { ?><?php echo $t['price'];?>元/月<?php } else { ?>面议<?php } ?></span>                            </h5>
                        </li><?php } } ?>
                                            </ul>
                    <ul class="escz_ul mt20 clearfix">
                    <?php $tags=tag("moduleid=7&condition=status=3&areaid=$cityid&length=22&pagesize=6&order=addtime desc&target=_blank&template=null");?>
 <?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                        <li>
                                              
                            <i class="<?php if($k<3) { ?>hot<?php } ?>"><?php echo $k+1;?></i>
                            <a  href="<?php echo $t['linkurl'];?>" title="<?php echo $t['title'];?>" class="escz-name"><?php echo $t['title'];?> </a>
                            <span class="escz-area"><?php echo area_pos($t['areaid'], '');?></span>                            <span class="escz-room"><?php if($t['room']) { ?><?php echo $t['room'];?>室<?php } else { ?>待定<?php } ?><?php if($t['hall']) { ?><?php echo $t['hall'];?>厅<?php } ?></span>
                            <span class="escz-totalarea"><?php echo $t['houseearm'];?><em class="fz12">m&sup2;</em></span>
                            <span class="escz-price"><em><?php if($t['price']) { ?><?php echo $t['price'];?></em>元/月<?php } else { ?>面议</em><?php } ?></span>
                        </li><?php } } ?>
                                            </ul>
                </div>
                <div class="escz_list clearfix dn" style="display:none;">
                    <ul class="plist1 plist-mod">
                     <?php $tags=tag("moduleid=18&condition=status=3 and isnew=0&areaid=$cityid&length=22&pagesize=6&order=hits desc&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
                                                <li>
                            <a class="img" href="<?php echo $t['linkurl'];?>"><img src="<?php echo imgurl($t['thumb']);?>" width="193" height="140"  alt="<?php echo $t['alt'];?>"></a>
                            <h4><a href="<?php echo $t['linkurl'];?>"><?php echo $t['title'];?></a></h4>
                            <h5><span class="r"><?php echo area_pos($t['areaid'], '');?></span><span class="fz24 fcr"><?php echo get_avg_price($t['itemid']);?></span>元/m&sup2;</h5>
                            <h5 class="tip"><i class="l">售:<span class="fcr fz16"><?php echo get_sale($t['itemid']);?></span>套</i><i class="r">租:<span class="fcr fz16"><?php echo get_rent($t['itemid']);?></span>套</i></h5>
                        </li>
                                             <?php } } ?>
                                            </ul>
                </div>
            </div>
            <div class="w270 r pt20">
            <a href="<?php echo $MODULE['2']['linkurl'];?>"><img src="<?php echo AJ_SKIN;?>images/index/esfb.png" width="270" height="76" alt="二手房个人发布" /></a>
                <div class="blank10"></div>
                <a href="<?php echo $MODULE['2']['linkurl'];?>"><img src="<?php echo AJ_SKIN;?>images/index/jjrfb.png" width="270" height="76" alt="经纪人房源发布" /></a>
                <div class="blank5"></div>
                <div class="plist4">
                    <ul class="clearfix">
                     <?php $tags=tag("table=member&condition=groupid=6&areaid=$cityid&order=userid desc&pagesize=3&template=null");?>
 <?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
                                                <li>
                            <a href="<?php echo userurl($t['username'], '');?>" ><img src="<?php echo useravatar($t['username'], 'large');?>" title="<?php echo $t['username'];?>" alt="<?php echo $t['username'];?>"  height="56" width="56" /></a>
                             <p>
                                <a href="<?php echo userurl($t['username'], '');?>" class="fcr"><?php echo userinfos($t['username']);?></a><br />
                                                                手机:<?php echo $t['mobile'];?> <br/>
                                公司:<?php echo $t['company'];?>
                                                             </p>
                         </li><?php } } ?>
                                            </ul>
                    <a class="more" href="<?php echo $MODULE['4']['linkurl'];?>">更多经纪人</a>
                </div><!-- /plist -->
            </div>
        </div>
        
        <div class="blank10"></div>
      
        <script type="text/javascript" src="<?php echo AJ_SKIN;?>js/common.js?20150907"></script> 
     <script type="text/javascript" src="<?php echo AJ_SKIN;?>js/jqfixed.js?20150907"></script> 
      <script type="text/javascript" src="<?php echo AJ_SKIN;?>js/jqduang.js?2015-8-26"></script>
      
        <div class="house-ad adb"><!-- 广告位： 首页E区横幅AD1 --><?php echo ad(22);?></div>
        <!--房产排行榜html begin-->
        <div class="house-phb">
        <div class="col-title clearfix">
                <h2 class="l"><span>房产排行榜</span></h2>
              
            </div>
           
            <div class="w1200">
                <dl class="statis-log"  data-statis="FCAS-43-46">
                    <dt>热门楼盘</dt>
                               <?php $tags=tag("moduleid=6&condition=status=3 and isnew=1&areaid=$cityid&length=20&pagesize=10&order=hits desc&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                            <dd>
                            <em class="phb-num   <?php if($k<3) { ?>first<?php } ?> "><?php echo $k+1;?></em>
                            <span class="phb-title"><a target="_blank" href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" ><?php echo $t['title'];?></a></span>
                                                         <span class="phb-area"><strong><?php if($t['price']) { ?><?php echo $t['price'];?></strong>元/㎡<?php } else { ?>一房一价</strong><?php } ?></span>
                            <span class="phb-person"><?php echo area_poss($t['areaid'], '');?></span>
                        </dd><?php } } ?>
                          
                                                                </dl>
                <dl class="rmzx statis-log"  data-statis="FCAS-43-47">
                    <dt>热门资讯</dt>
                                      <?php $tags=tag("moduleid=8&condition=status=3&areaid=$cityid&length=40&pagesize=10&order=hits desc&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                            <dd>
                            <em class="phb-num   <?php if($k<3) { ?>first<?php } ?> "><?php echo $k+1;?></em>
                        <span class="phb-zx-title"><a target="_blank" href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" ><?php echo $t['title'];?></a></span>
                       
                    </dd>
                              <?php } } ?>
                                    </dl>
                <dl class="last statis-log" data-statis="FCAS-43-48">
                    <dt>热门二手房</dt>
                    <?php $tags=tag("moduleid=5&condition=status=3&areaid=$cityid&length=20&pagesize=10&order=hits desc&target=_blank&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $k => $t) { ?>
                                            <dd>
                            <em class="phb-num   <?php if($k<3) { ?>first<?php } ?> "><?php echo $k+1;?></em>
                            <span class="phb-title"><a target="_blank" href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" ><?php echo $t['title'];?></a></span>
                                                         <span class="phb-area"><strong><?php if($t['price']) { ?><?php echo $t['price'];?></strong>万<?php } else { ?>面议</strong><?php } ?></span>
                            <span class="phb-person"><?php echo area_poss($t['areaid'], '');?></span>
                        </dd><?php } } ?>
                                                                    </dl>
            </div>
        </div>
        <!--房产排行榜html end-->
   </div>
  </div>
</div>
    <?php include template('footer');?>