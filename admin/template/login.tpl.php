<?php 
defined('AJ_ADMIN') or exit('Access Denied');
?>
<!doctype html>
<html lang="<?php echo AJ_LANG;?>">
<head>
<meta charset="<?php echo AJ_CHARSET;?>"/>
<title>管理员登录</title>
<meta name="robots" content="noindex,nofollow"/>
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width"/>
<meta name="generator" content="AIJIACMS  - www.aijiacms.com"/>
<link rel="stylesheet" href="admin/image/login.css?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>" type="text/css" />
<script type="text/javascript" src="<?php echo AJ_STATIC;?>lang/<?php echo AJ_LANG;?>/lang.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/config.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<!--[if lte IE 9]><!-->
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery-1.5.2.min.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<!--<![endif]-->
<!--[if (gte IE 10)|!(IE)]><!-->
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/jquery-2.1.1.min.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<!--<![endif]-->
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/common.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/keyboard.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/md5.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
</head>
<body>
<noscript><br/><br/><br/><center><h1>您的浏览器不支持JavaScript,请更换支持JavaScript的浏览器</h1></center></noscript>
<noframes><br/><br/><br/><center><h1>您的浏览器不支持框架,请更换支持框架的浏览器</h1></center></noframes>
<form method="post" action="?"  onsubmit="return <?php echo $job == 'sms' ? 'S' : 'D' ?>check();">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="job" value="<?php echo $job;?>"/>
<input name="forward" type="hidden" value="<?php echo $forward;?>"/>
<div class="login">
	<div id="msgs"></div>
	<?php if($job == 'sms') { ?>
	<div class="head"><?php if($could_name) { ?><div><a href="?action=<?php echo $action;?>&forward=<?php echo $_forward;?>"><span>账号登录</span></a></div><?php } ?>管理登录</div>
	<div class="main">	
		<?php if($verfiy) { ?><div style="font-size:12px;color:#FF6600;">&nbsp;本次登录需要使用手机短信验证身份</div><?php } ?>
		<div><input name="mobile" type="text" id="mobile"<?php if($verfiy) { ?> value="<?php echo $mobile;?>" readonly<?php } ?> placeholder="已认证手机号"/></div>
		<div style="padding:0 60px;"><a href="javascript:;" onclick="Dsend();" id="send">发送短信</a></div>
		<div><input name="code" type="text" id="code" placeholder="短信验证码"/></div>
		<div><input type="submit" name="submit" value="登 录" tabindex="4" id="sbm"/><input type="button" id="btn" value="退 出" onclick="top.Go('<?php echo AJ_PATH;?>');"/></div>
	</div>	
	<?php } else {?>
	<div class="head"><?php if($could_sms) { ?><div><a href="?action=<?php echo $action;?>&job=sms&forward=<?php echo $_forward;?>"><span>短信登录</span></a></div><?php } ?>管理登录</div>
	<div class="main">
		<div><input name="username" type="text" id="username" placeholder="用户名/已认证手机/邮箱" value="<?php echo $username;?>"/></div>
		<div><input name="password" type="password" id="password" placeholder="密码" value="" ondblclick="kb_s('password', 'kb');" title="双击弹出密码键盘"/></div>
		<?php if($AJ['captcha_admin']) { ?>
		<div><?php include template('captcha', 'chip');?></div>
		<?php } ?>
		<div><input type="submit" name="submit" value="登 录" tabindex="4" id="sbm"/><input type="button" id="btn" value="退 出" onclick="top.Go('<?php echo AJ_PATH;?>');"/></div>
	</div>
	<?php } ?>
</div>
</form>
<div id="tips"></div>
<div id="kb" style="display:none;"></div>
<script type="text/javascript">
$.fn.shake = function(times,offset,delay) {//次数,偏移,间隔
this.stop().each(function() {
    var Obj = $(this);
    var marginLeft = parseInt(Obj.css('margin-left'));
    var delay = delay > 20 ? delay : 20; 
    Obj.animate({'margin-left':marginLeft+offset},delay,function(){
        Obj.animate({'margin-left':marginLeft},delay,function(){
            times = times - 1;
            if(times > 0) Obj.shake(times,offset,delay);
            })
        });

    });
    return this;
}
function Dmsgs(msg) {
	$('#tips').hide();
	$('#sbm').attr('disabled', true);
	$('#msgs').html(msg);
	$('#msgs').fadeIn(100, function() {
		setTimeout(function() {$('#msgs').shake(4,6,1000);}, 100);
		setTimeout(function() {$('#msgs').fadeOut(300);$('#sbm').attr('disabled', false);}, 3000);
	});
}
function Dcheck() {
	if(Dd('username').value.length < 2) {
		Dmsgs('请填写会员名');
		Dd('username').focus();
		return false;
	}
	if(Dd('password').value.length < 6) {
		Dmsgs('请填写密码');
		Dd('password').focus();
		return false;
	}
	<?php if($AJ['captcha_admin']) { ?>
	if($('#ccaptcha').html().indexOf('ok.png') == -1) {
		Dmsgs('请填写验证码');
		Dd('captcha').focus();
		return false;
	}
	<?php } ?>
	return true;
}
function Scheck() {
	if(Dd('mobile').value.length < 11) {
		Dmsgs('请输入手机号码');
		Dd('mobile').focus();
		return false;
	}
	return true;
}
function Dstop() {
	var i = 60;
	var interval=window.setInterval(
		function() {
			if(i == 0) {
				$('#send').html('重新发送');
				clearInterval(interval);
			} else {
				$('#send').html('<span style="color:#1AAD16;font-size:12px;">发送成功</span> &nbsp; <span style="color:#999999;font-size:12px;">重新发送('+i+'秒)</span>');
				i--;
			}
		},
	1000);
}
function Dsend() {
	if($('#send').html().indexOf('秒') != -1) {
		Dmsgs('请耐心等待');
		return false;
	}
	if(Dd('mobile').value.length < 11) {
		Dmsgs('请输入手机号码');
		Dd('mobile').focus();
		return false;
	}
	$.post('?', 'action=<?php echo $action;?>&job=send&mobile='+Dd('mobile').value, function(data) {
		if(data == 'ok') {
			Dstop();return;
		} else if(data == 'format') {
			Dmsgs('手机格式错误');
		} else if(data == 'captcha') {
			Dmsgs('验证码错误');
		} else if(data == 'exist') {
			Dmsgs('号码不存在或未验证');
		} else if(data == 'max') {
			Dmsgs('发送次数过多');
		} else if(data == 'fast') {
			Dmsgs('发送频率过快');
		} else {
			Dmsgs('发送失败');
		}
	});
}
$(function(){
	<?php if($job == 'sms') { ?>
		if(Dd('mobile').value == '') {
			Dd('mobile').focus();
		}
	<?php } else { ?>
	if(Dd('username').value == '') {
		Dd('username').focus();
	} else {
		Dd('password').focus();
	}
	init_md5();
<?php if($AJ['captcha_admin']) { ?>
	$('#captcha').css({'margin':'0 10px 0 0'});
<?php } ?>
	<?php } ?>
	if(window.screen.width < 1200) {
		setTimeout(function() {
			$('#tips').hide();
			$('#tips').html(window.screen.width+'px屏幕无法获得最佳体验，建议1200px以上');
			$('#tips').slideDown(600);
		}, 5000);
	}
<?php if(strpos(get_env('self'), '/admin.php') !== false) { ?>
	$('#tips').html('提示：为了系统安全，请修改后台地址');
	$('#tips').slideDown(600);
<?php } ?>
});
</script>
</body>
</html>