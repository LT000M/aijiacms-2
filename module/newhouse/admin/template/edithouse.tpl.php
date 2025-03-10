<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>管理中心</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="admin/layui/lib/layui-v2.5.4/css/layui.css">
    <link rel="stylesheet" href="admin/static/manage/css/blue.css">
    
    <script src="admin/layui/lib/layui-v2.5.4/layui.js"></script>
    <style>
        .subnav{padding:5px 15px;}
        .layui-form-item label em{display:none;}
    </style>
</head>

<body class="body">
<div class="subnav">
    </div>
<div class="layui-fluid">

<form class="layui-form" id="info_form" action="<?php echo $MODULE[1]['linkurl'];?>api/shapan/edithouse.php"   method="post" enctype="multipart/form-data">
    <div class="layui-tab-item layui-show">
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="layui-form-alert">*</span>楼栋名称</label>
            <div class="layui-input-inline">
                <input type="text" name="title" lay-verify="title" id="title" placeholder="楼栋名称" value="<?php echo (isset($house_sand['title']) && ($house_sand['title'] !== '')?$house_sand['title']:''); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">单元数</label>
            <div class="layui-input-inline">
                <input type="text" name="unit" id="unit" placeholder="单元数" value="<?php echo (isset($house_sand['elevator']) && ($house_sand['elevator'] !== '')?$house_sand['elevator']:''); ?>" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">电梯数</label>
            <div class="layui-input-inline">
                <input type="text" name="elevator" id="elevator" placeholder="电梯数" value="<?php echo (isset($house_sand['elevator']) && ($house_sand['elevator'] !== '')?$house_sand['elevator']:''); ?>" autocomplete="off" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总楼层</label>
            <div class="layui-input-inline">
                <input type="text" name="floor_num" class="layui-input" placeholder="12" value="<?php echo $house_sand['floor_num'];?>" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">总户数</label>
            <div class="layui-input-inline">
                <input type="text" name="room_num" class="layui-input" placeholder="22" value="<?php echo $house_sand['room_num'];?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开盘时间</label>
            <div class="layui-input-inline">
                <input type="text" name="open_time" class="layui-input" placeholder="2017-12-22" value="<?php echo timetodate($house_sand['open_time'],3);?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">交房时间</label>
            <div class="layui-input-inline">
                <input type="text" name="complate_time" class="layui-input" placeholder="2017-12-22" value="<?php echo timetodate($house_sand['complate_time'],3);?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">销售状态</label>
            <div class="layui-input-block">
                <input type="radio" name="sale_status" id="sale_status30" value="30" <?php if($house_sand['sale_status'] == 30) echo 'checked';?> title=在售><input type="radio" name="sale_status" id="sale_status31" value="31" <?php if($house_sand['sale_status'] == 31) echo 'checked';?>  title=预售><input type="radio" name="sale_status" id="sale_status32" value="32"  <?php if($house_sand['sale_status'] == 32) echo 'checked';?> title=售完>            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">包含户型</label>
            <div class="layui-input-block">
                              <?php foreach($houselist as $k=>$v) { ?>
                                 <input type="checkbox" <?php if(in_array($v['itemid'], $house_sand['huxing_id'])): ?>checked="checked"<?php endif; ?> lay-skin="primary" name="huxing_id[]" value="<?php echo $v['itemid'];?>" title="<?php echo $v['shi'];?>室<?php echo $v['ting'];?>厅<?php echo $v['wei'];?>卫">
                                 <?php } ?>
                               
                            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $id;?>">
   

</form>
<script src="admin/static/js/jquery.min.js"></script>
<script src="admin/static/js/plugins/formvalidator.js"></script>
<script src="admin/static/js/layer/layer.js"></script>
<script src="admin/static/js/plugins/jquery.ajax.form.js"></script>
<script>
    function submitForm(){
        var title = $("#title").val();
        if(!title)
        {
            layer.msg('请填写楼栋名称');
            $("#title").focus();
            return false;
        }else{
            $("#info_form").ajaxForm({success:complate,dataType:'json'}).submit();
        }
    }
    function complate(result){
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        if(result.code == 1){
            parent.layer.close(index);
            parent.layer.msg(result.msg,{icon:1});
            window.parent.location.reload();
        } else {
            layer.msg(result.msg,{icon:2});
        }
    }
</script>

</div>

<script src="admin/static/manage/js/dialog.js"></script>
<script>
    layui.config({
        base: 'admin/static/manage/js/'
    });
</script>
</body>
</html>

