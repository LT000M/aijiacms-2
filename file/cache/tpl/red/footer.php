<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php if($moduleid==2) { ?></div><?php } ?>
<div class="content content-two web-consult">
<div id="footer">
    <div class="wrapper">
        <div class="footer-menu">
            <dl class="item-a">
                <dt>购房工具</dt>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>tool/benjin.php">房贷计算器</a></dd>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>map">地图找房</a></dd>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>tool/tqhd.php">提前还款计算器</a></dd>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>tool">购房能力</a></dd>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>tool/sf.php">税费计算器</a></dd>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>tool/gjj.php">公积金贷款计算器</a></dd>
            </dl>
            <dl class="item-b">
                <dt>购房优惠</dt>
                <dd><a href="<?php echo $MODULE['8']['linkurl'];?>list-32.html">楼盘导购</a></dd>
                <dd><a href="<?php echo $MODULE['15']['linkurl'];?>">新房团购</a></dd>
                <dd><a href="<?php echo $MODULE['1']['linkurl'];?>fenxiao">赚佣金</a></dd>
            </dl>
            <dl class="item-c">
                <dt>楼盘项目</dt>
                <dd><a href="<?php echo $MODULE['6']['linkurl'];?>">楼盘</a></dd>
                <dd><a href="<?php echo $MODULE['7']['linkurl'];?>list-t15v.html">商铺出租</a></dd>
                <dd><a href="<?php echo $MODULE['5']['linkurl'];?>list-t10v.html">商业</a></dd>
                <dd><a href="<?php echo $MODULE['5']['linkurl'];?>list-t11v.html">写字楼</a></dd>
                <dd><a href="<?php echo $MODULE['5']['linkurl'];?>">二手房</a></dd>
                <dd><a href="<?php echo $MODULE['7']['linkurl'];?>">租房</a></dd>
            </dl>
            <dl class="item-d">
                <div class="code-con">
                    <img src="<?php echo $MODULE['1']['linkurl'];?>api/qrcode.png.php?auth=<?php echo urlencode($EXT['mobile_url']);?>" />
                    <span>手机扫描二微码</span>
                </div>
                <div class="contact-con">
                    <img src="<?php echo $MODULE['1']['linkurl'];?>api/weixin/qrcode.php" />
                    <span>手机扫描关注微信</span>
                </div>
            </dl>
        </div>
        <div class="clearit"></div>
        <?php if($moduleid==1) { ?>
       <div class="footer-friendlink">
            <div class="footer-friendlink-cate">
                <a href="javascript:;" class="tabs current" data-group="flink" data-rel="f1">友情链接<em></em></a>
                
            </div>
            <?php if($AJ['page_logo']) { ?>
            <div class="footer-friendlink-con">
                <div id="f1" class="flink" style="display: block;">
                <?php $tags=tag("table=link&condition=status=3 and level>0 and thumb<>'' and username=''&areaid=$cityid&pagesize=".$AJ['page_logo']."&order=listorder desc,itemid desc&lazy=$lazy&template=null");?>
  <?php if(is_array($tags)) { foreach($tags as $t) { ?> <a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['alt'];?>"><img src="<?php echo $t['thumb'];?>"/></a> <?php } } ?>
                                    </div>                
                
            </div>
        </div>    
        <?php } ?>
        <?php if($AJ['page_text']) { ?>
         <div class="">
           
            <div class="footer-friendlink-con">
 
                <div id="f1" class="flink" style="display: block;">
                <?php $tags=tag("table=link&condition=status=3 and thumb='' and username=''&areaid=$cityid&pagesize=".$AJ['page_text']."&order=listorder desc,itemid desc&template=null");?>
  <?php if(is_array($tags)) { foreach($tags as $t) { ?> <a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['alt'];?>"><?php echo $t['title'];?></a><span>|</span> <?php } } ?>
                                    </div>                
                
            </div>
        </div>    
         <?php } ?>
        
 <?php } ?>
        <div class="copyright">
         <a href="<?php echo $MODULE['1']['linkurl'];?>">网站首页</a>  <?php echo tag("table=webpage&condition=item=1&areaid=$cityid&order=listorder desc,itemid desc&template=list-webpage");?>|  <a href="<?php echo $MODULE['1']['linkurl'];?>sitemap/">网站地图</a>
<?php if($EXT['guestbook_enable']) { ?> |  <a href="<?php echo $EXT['guestbook_url'];?>">网站留言</a><?php } ?>
<?php if($EXT['ad_enable']) { ?> |  <a href="<?php echo $EXT['ad_url'];?>">广告服务</a><?php } ?> | <a href="<?php echo $EXT['mobile_url'];?>" target="_blank">手机版</a><br />
           <?php echo $AJ['copyright'];?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://beian.miit.gov.cn" target="_blank" rel="nofollow"><?php echo $AJ['icpno'];?></a><br />
           客服热线  <?php echo $AJ['telephone'];?>（工作时间：周一至周五8:00至18:00）
       
        </div>
    </div>
</div>
<div id="float-links">
    <a href="<?php echo $MODULE['6']['linkurl'];?>"><i class="i1"></i><span>楼盘搜索</span></a>
    <a href="<?php echo $MODULE['8']['linkurl'];?>list-32.html"><i class="i2"></i><span>楼盘导购</span></a>
    <a href="<?php echo $MODULE['5']['linkurl'];?>"><i class="i3"></i><span>二手房</span></a>
    <a href="<?php echo $MODULE['7']['linkurl'];?>"><i class="i4"></i><span>租房</span></a>
    <a href="javascript:;" class="back-top"><i class="i5"></i><span>返回顶部</span></a>
</div>
</div>
<script type="text/javascript">
<?php if($aijiacms_task) { ?>
show_task('<?php echo $aijiacms_task;?>', <?php echo $AJ['stats'];?>);
<?php } else { ?>
<?php include AJ_ROOT.'/api/task.inc.php';?>
<?php } ?>
</script>
</body>
</html>