<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');

?>
<link rel="stylesheet" href="admin/layui/lib/layui-v2.5.4/css/layui.css">
   
<div class="subnav">
    </div>
<div class="layui-fluid">

<!--跟进列表-->
<div class="layui-tab-content">
    <ul class="layui-timeline">
    <?php if($lists) { ?>
    <?php foreach($lists as $k=>$v) {?>
                <li class="layui-timeline-item">
            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
            <div class="layui-timeline-content layui-text">
                <h3 class="layui-timeline-title"><?php echo $v['content'];?> <span style="font-size: 14px;color: red"><?php echo $v['username'];?></span> &nbsp;<?php echo timetodate($v['addtime'], 3);?></h3>
                <p>
                    <?php echo $v['title'];?>                </p>
            </div>
        </li>
        <?php } ?>
<?php } else { ?>
  <li class="layui-timeline-item">暂无记录  </li>
<?php } ?>
        
        
        
        
        
    </ul>
</div>

</div>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>