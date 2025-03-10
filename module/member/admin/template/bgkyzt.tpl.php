<!DOCTYPE HTML>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
		<meta http-equiv="Cache-Control" content="no-siteapp"/>
		<link rel="icon" href="/Upload/Admin/Images/favicon.png" type="image/png"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/static/h-ui/css/H-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/static/h-ui.admin/css/H-ui.admin.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/Hui-iconfont/1.0.8/iconfont.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/static/h-ui.admin/css/style.css"/>
		<block name="css"></block>
	</head>
	<body>
		<block name="content"></block>
		<script type="text/javascript" src="<?php echo $MODULE[1][linkurl];?>keyuan/lib/jquery/1.9.1/jquery.min.js"></script> 
		<script type="text/javascript" src="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layer/2.4/layer.js"></script>
		<script type="text/javascript" src="<?php echo $MODULE[1][linkurl];?>keyuan/static/h-ui/js/H-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo $MODULE[1][linkurl];?>keyuan/static/h-ui.admin/js/H-ui.admin.js"></script>
		<script>
			$(document).ready(function(){
				$(document).bind("contextmenu",function(e){
					return false;
				});
			});
		</script>
		<block name="js"></block>
	</body>
</html>

<block name="css">
	<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layui/css/layui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/Hui-iconfont/1.0.8/iconfont.css"/>
	
</block>
<block name="content">
	<div style="position:fixed;top:0;width: 100%; border-top-style: solid;border-top-width: 2px;border-top-color: {$lscx};z-index: 999;"></div>
	<form class="layui-form" action="" method="post">
		<input type="hidden" name="kyid" id="" value="<?php echo $_GET['kyid'];?>">
		<div style="line-height:30px;">&nbsp;</div>
		<div class="layui-form-item">
			<div class="layui-inline">
				<label class="layui-form-label" style="color:#f00;">
					状态
				</label>
			<div class="layui-input-inline">
					<select name="zhuangtai" lay-verify="required">
                     <option value="1"  <?php echo $zhuangtai == '1' ? ' selected="selected"' : '';?>>私客</option>
                     <option value="2" <?php echo $zhuangtai ==' 2' ? ' selected="selected"' : '';?>>公客</option>
                     <option value="3"  <?php echo $zhuangtai =='3' ? 'selected="selected"': ''; ?>>成交</option> 
                     <option value="4" <?php echo $zhuangtai ==' 4' ? ' selected="selected"' : '';?>>他人成交</option>
                     <option value="5"  <?php echo $zhuangtai =='5' ? 'selected="selected"': ''; ?>>暂缓委托</option>   
                     
						
                        </select>
				</div>
			</div>
		</div>
		<div style="line-height:50PX;">&nbsp;</div>
		<div class="layui-form-item" style="width:100%;height:50px;margin:0 auto;background:#fff;position:fixed;bottom:0;text-align:center;border-top-style: solid;border-top-width: 1px;border-top-color: {$lscx};padding-top: 5px;">
			<div class="layui-form-item" style="margin-left: -15px;">
				<button class="layui-btn layui-btn-radius layui-btn-tijiao" lay-submit="" lay-filter="demo1">
					<i class="Hui-iconfont">&#xe603;</i> 立即提交
				</button>
				<button type="reset" class="layui-btn layui-btn-radius layui-btn-primary lscxan">
					<i class="Hui-iconfont">&#xe72a;</i> 重置
				</button>
				<button type="button" class="layui-btn layui-btn-radius layui-btn-primary lscxan" onclick="parent.layer.close(parent.layer.getFrameIndex(window.name));">
					<i class="Hui-iconfont">&#xe706;</i> 关闭
				</button>
			</div>
		</div>
	</form>
</block>
<block name="js">
	<script src="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layui1/layui.js" charset="utf-8"></script>
	<script>
		layui.use(['form', 'layedit', 'laydate'], function(){
			var form = layui.form
			,layer = layui.layer
			,layedit = layui.layedit
			,laydate = layui.laydate;
			//监听提交
			form.on('submit(demo1)', function(data){
				$.ajax({
					url:'<?php echo $MODULE[1][linkurl];?>api/keyuan/bgkyzt.php',
					type:"post",
					data:data.field,
					dataType:"json",
					success:function(data){
						if (data.status==1) {
							var index = parent.layer.getFrameIndex(window.name);//获取窗口索引
							parent.layer.msg(data.info);//父级页面提示成功信息
							parent.location.reload();//刷新父级页面
							parent.layer.close(index);//关闭弹出的子页面窗口
						}else{
							layer.msg(data.info,{anim: 6});//错误提示
						}
					},
				});
				return false;
			});
		});
	</script>
</block>