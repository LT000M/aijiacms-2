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
	<link rel="stylesheet" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layui1/css/layui.css"  media="all">
	<link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/Hui-iconfont/1.0.8/iconfont.css"/>
	<style type="text/css">
		.lscxan:hover{
			{$lscxanbk}
		}
		{$lscxb}
		{$lscxdate}
	</style>
</block>
<block name="content">
	<div style="position:fixed;top:0;width: 100%; border-top-style: solid;border-top-width: 2px;border-top-color: {$lscx};z-index: 999;"></div>
	<form class="layui-form" action="" method="post" style="margin-top: 20px;">
    <input type="hidden" name="kybh" id="" value="<?php echo $_GET['kybh'];?>">
		<input type="hidden" name="kyid" id="" value="<?php echo $_GET['kyid'];?>">
        <input type="hidden" name="gjid" id="" value="<?php echo $_userid;?>">
     
		
			<div class="layui-form-item" style="margin-top: 20px;">
				<div class="layui-inline">
					<label class="layui-form-label" style="color: #f00;width: 120px;">
						跟进方式：
					</label>
					<div class="layui-input-inline" style="width: 180px;">
						<select name="genjinfs" lay-filter="aihao" lay-verify="required">
						
							<option value="短信">短信</option><option value="接待">接待</option><option value="调查">调查</option><option value="电话">电话</option><option value="拜访">拜访</option><option value="其他">其他</option><option value="一手带看">一手带看</option><option value="无法接通">无法接通</option><option value="客服部回访">客服部回访</option>						</select>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label" style="color:#f00;width: 120px;">
						跟进日期：
					</label>
					<div class="layui-input-inline">
						<input type="text" name="gjshijian" id="test1" placeholder="yyyy-mm-dd" lay-verify="required" autocomplete="off" class="layui-input">
					</div>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label" style="color: #f00;width: 120px;">
					跟进内容：
				</label>
				<div class="layui-input-inline" style="width: 666px;">
					<textarea placeholder="请输入内容" name="gjneirong" class="layui-textarea" lay-verify="required"></textarea>
				</div>
			</div>
			<div style="line-height:50PX;">&nbsp;</div>
			<div class="layui-form-item" style="width:100%;height:45px;margin:0 auto;background:#fff;position:fixed;bottom:0;text-align:center;border-top-style: solid;border-top-width: 1px;border-top-color: {$lscx};padding-top: 5px;" id="submit">
				<div class="layui-input-block" style="margin-left: 15px;">
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
		</if>
	</form>
</block>
<block name="js">
	<script src="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layui1/layui.js" charset="utf-8"></script>
	<script>
		layui.use(['form', 'upload', 'layedit', 'laydate'], function(){
			var form = layui.form
			,upload = layui.upload
			,layer = layui.layer
			,layedit = layui.layedit
			,laydate = layui.laydate;
			laydate.render({
				elem: '#test1'
				,type: 'datetime'
				,max: '{:date("Y-m-d H:i:s",time())}'
			});
			
			//监听提交
			form.on('submit(demo1)', function(data){
				$.ajax({
					url:'<?php echo $MODULE[1][linkurl];?>api/keyuan/genjin.php',
					type:"post",
					data:data.field,
					dataType:"json",
					success: function(data){
						if (data.status==1) {
							var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
							parent.layer.msg(data.info);//父级页面提示成功信息
							parent.layer.close(index);//关闭弹出的子页面窗口
						}else{
							layer.msg(data.info,function(){});//错误提示
						}
					},
					error:function(data) {
						console.log(data.msg);
					},
				});
				return false;
			});
		});
	</script>
</block>