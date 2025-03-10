<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');

?>
<link rel="stylesheet" href="admin/layui/lib/layui-v2.5.4/css/layui.css">
 <div class="subnav">
    </div>
<div class="layui-fluid">

 <style>
        .subnav{padding:5px 15px;}
        .layui-form-item label em{display:none;}
    </style>
<div class="dialog-form">
   <form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
        <div class="layui-form-item">
            <label class="layui-form-label">跟进内容</label>
            <div class="layui-input-inline">
                <textarea name="content" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">跟进人</label>
            <div class="layui-input-inline">
                <input type="text" name="username" autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="subid" value="<?php echo $subid;?>" />
        <div class="sbt"><input type="submit" name="submit" value="确 定" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/></div>
    </form>
</div>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>