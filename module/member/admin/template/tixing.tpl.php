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
		.layui-btn-tijiao {
			background-color: {$lscx} !important;
		}
		{$lscxdate}
	</style>
</block>
<block name="content">
	<div style="position:fixed;top:0;width: 100%; border-top-style: solid;border-top-width: 2px;border-top-color: {$lscx};z-index: 999;"></div>
	<form class="layui-form" action="<?php echo $MODULE[1]['linkurl'];?>api/keyuan/tixing.php" method="post" style="margin-top: 20px;">
		<input type="hidden" name="kybh" id="" value="<?php echo $_GET['kybh'];?>">
		<input type="hidden" name="kyid" id="" value="<?php echo $_GET['kyid'];?>">
        <input type="hidden" name="userid" id="" value="<?php echo $_userid;?>">
		<div class="layui-form-item" style="margin-top: 20px;">
			<div class="layui-inline">
				<label class="layui-form-label" style="color: #f00;width: 120px;">
					提醒人：
				</label>
				<div class="layui-input-inline" style="width:150px;">
					<div class="layui-form-select choice-user-div">
						<div class="layui-select-title">
							<input type="text" name="username" placeholder="搜索选择" class="layui-input choice-user-input" lay-verify="required" autocomplete="off">
							<input type="hidden" name="txuid" class="choice-userid-input" lay-verify="required">
                            	
							<i class="layui-edge"></i>
						</div>
						<dl class="layui-anim layui-anim-upbit choice-user-dl" style="">
							<dd lay-value="" class="layui-select-tips">搜索选择</dd>
							<p class="layui-select-none">无匹配项</p>
						</dl>
					</div>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label" style="color:#f00;width: 120px;">
					提醒日期：
				</label>
				<div class="layui-input-inline">
					<input type="text" name="txshijian" id="test1" placeholder="yyyy-mm-dd" lay-verify="required" autocomplete="off" class="layui-input">
				</div>
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label" style="color: #f00;width: 120px;">
				提醒内容：
			</label>
			<div class="layui-input-inline" style="width: 555px;">
				<textarea placeholder="请输入内容" name="txneirong" class="layui-textarea" lay-verify="required"></textarea>
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
			laydate.render({
				elem: '#test1'
				,type: 'datetime'
				,min: '{:date("Y-m-d H:i:s",time())}'
			});
			$('.choice-user-input').keyup(function(){
				var txt = $(this).val();
				//var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
				if (txt != "") {
					$(".choice-user-div").addClass('layui-form-selected');
					$.ajax({
						url:'<?php echo $MODULE[1][linkurl];?>api/keyuan/getmember.php',
						type:"get",
						data:"txt="+txt,
						dataType:"json",
						success:function(data){
							var lists = data.district;
							$(".choice-user-dl dd").remove();
							$(".choice-user-dl p").remove();
							if (lists.length == 0) {
								$(".choice-user-dl").append('<p class="layui-select-none">无匹配项</p>');
							}
							for(var i in lists){
								var dd = $("<dd></dd>");
								$(dd).attr('dataid',lists[i]['txuid']);
								
								$(dd).html(lists[i]['company']);
								$(".choice-user-dl").append(dd);
							}
						}
					});
				}else{
					$(".choice-user-div").removeClass('layui-form-selected');
				}
			});
			$(".choice-user-dl").on("click","dd",function(event){
				$('.choice-user-input').val($(this).html());
				$('.choice-userid-input').val($(this).attr('dataid'));
				$(".choice-user-div").removeClass('layui-form-selected');
				event.stopPropagation();
			});
			$('body').click(function(event){
				$(".choice-user-div").removeClass('layui-form-selected');
			});
			//监听提交
			form.on('submit(demo1)', function(data){
				$.ajax({
					url:'<?php echo $MODULE[1][linkurl];?>api/keyuan/save_tingxing.php',
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