<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php include template('header');?>
<style>
* {word-break:break-all;font-family:"Microsoft Yahei",Tahoma,Verdana,Arial;-webkit-text-size-adjust:none;}
/* links */
a.w:link,a.w:visited,a.w:active {color:#FFFFFF;text-decoration:none;}
a.w:hover {color:#F4F3F2;}
a.b:link,a.b:visited,a.b:active {color:#007AFF;text-decoration:none;}
a.b:hover {color:#FF3300;}
a.g:link,a.g:visited,a.g:active {color:#666666;text-decoration:none;}
a.g:hover {color:#FF6600;}
/* common */
.m {margin:auto;width:1200px;background:#FFFFFF;clear:both;}
.m0 {width:100%;background:#F2F2F2;}
.m0 .m {background:#F2F2F2;}
.m1 {background:url('image/bg-line.png') repeat-y 960px 0;}
.m1l {width:940px;float:left;}
.m1r {width:239px;float:right;}
.m2 {background:url('image/bg-line.png') repeat-y 960px 0;}
.m2l {width:940px;float:left;}
.m2r {width:219px;float:right;}
.m3 {background:url('image/bg-line.png') repeat-y 880px 0;}
.m3l {width:860px;float:left;}
.m3r {width:299px;float:right;}
.tf {width:100%;}
.tf td {border-top:#F0F0F0 1px solid;}
.tf tr:hover {background:#F4F4F4;}
.tf .tl {width:100px;text-align:right;}
.btns {padding:20px 20px 20px 150px;}
.thumb {padding:6px 0;}
.thumb img {border:#DDDDDD 1px solid;padding:2px;}
.thumb li {height:22px;line-height:22px;overflow:hidden;}
.thumbml ul {margin:10px 0 15px 0;}
.imb img {border:#DDDDDD 1px solid;padding:3px;}
/* album */
#mid_pos {position:absolute;}
#mid_div {width:320px;height:240px;cursor:crosshair;padding:6px;border:#CCCCCC 1px solid;background:#F3F3F3;}
#zoomer {border:#333333 1px solid;width:120px;height:90px;background:#FFFFFF url('image/zoom_bg.gif');position:absolute;opacity:0.5;filter:alpha(opacity=50);}
#big_div {width:400px;height:300px;border:#CCCCCC 1px solid;background:#FFFFFF;position:absolute;overflow:hidden;}
#big_pic {position:absolute;}
.ab_im {padding:2px;margin:10px 0 10px 32px;border:#C0C0C0 1px solid;}
.ab_on {padding:2px;margin:10px 0 10px 32px;border:#FF6600 1px solid;background:#FF6600;}
/* ads */
.adword table {background:url('image/adword_bg.gif') repeat-x 0 bottom;}
.adword_tip {color:#FF1100;border-bottom:#DDDDDD 1px solid;padding:8px 10px 8px 28px;background:url('image/arrow_up.gif') no-repeat 10px 8px;}
.sponsor {margin-bottom:10px;}
/* basic */
.f_l {float:left;}
.f_r {float:right;}
.t_l {text-align:left;}
.t_r {text-align:right;}
.t_c {text-align:center;}
.f_b {font-weight:bold;}
.f_n {font-weight:normal;}
.f_white {color:white;}
.f_gray {color:#666666;}
.f_orange {color:#FF6600;}
.f_red {color:red;}
.f_green {color:green;}
.f_blue {color:blue;}
.f_dblue {color:#007AFF;}
.f_price {font-weight:bold;font-family:Arial;color:#FF0000;}
.px12 {font-size:12px;}
.px14 {font-size:14px;}
.px16 {font-size:16px;}
.px18 {font-size:18px;}
.bd-t {border-top:#DDDDDD 1px solid;}
.bd-b {border-bottom:#DDDDDD 1px solid;}
.b10 {height:10px;}
.b16 {height:16px;}
.b20 {height:20px;}
.b24 {height:24px;}
.b32 {height:32px;}
.pd3 {padding:3px;}
.pd5 {padding:5px;}
.pd10 {padding:10px;}
.pd15 {padding:15px;}
.pd20 {padding:20px;}
.lh18 {line-height:180%;}
.ls1 {letter-spacing:1px;}
.c_p {cursor:pointer;}
.c_b {clear:both;}
.o_h {overflow:hidden;}
.dsn {display:none;}
.absm {vertical-align:middle;}
.btn_s {background:#2388FA;color:#FFFFFF;border:none;padding:2px;letter-spacing:1px;}
.btn_r {background:#D7D7D7;color:#666666;border:none;padding:2px;letter-spacing:1px;}
.bd {border:#CAD9EA 1px solid;}
.highlight {color:red;}
.jt {color:#003278;cursor:pointer;}
.np {padding:20px 30px 20px 50px;line-height:25px;}
.lazy {background:#FAFAFA url('image/loading.gif') no-repeat center center;}
.slide {background:#FAFAFA;overflow:hidden;}
.btn,.btn-green,.btn-blue,.btn-red {color:#FFFFFF;font-size:14px;width:100px;line-height:32px;border:none;border-radius:4px;text-align:center;cursor:pointer;padding:0;-webkit-appearance:none;}
.btn{background:#FFFFFF;border:#DDDDDD 1px solid;color:#333333;}
.btn:hover{background:#D9D9D9;border:#CDCDCD 1px solid;}
.btn-green{background:#1AAD19;border:#18A117 1px solid;color:#FFFFFF;}
.btn-green:hover{background:#179B16;border:#159014 1px solid;}
.btn-blue{background:#007AFF;border:#1E74D0 1px solid;color:#FFFFFF;}
.btn-blue:hover{background:#0569D5;}
.btn-red{background:#F8F8F8;border:#C6C6C6 1px solid;}
.btn-red:hover{background:#CE3C39;border:#BF3835 1px solid;color:#FFFFFF;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo AJ_SKIN;?>member.css"/>
<div class="b10"></div>
<div class="m" style="padding:32px 0;">
<div class="login-show">&nbsp;</div>
<div class="login-main">
<div id="msgs"></div>
<div class="login-head">
<ul>
<li<?php if($action=='login') { ?> class="on"<?php } ?>><a href="?action=login&forward=<?php echo $_forward;?>">会员登录</a></li>
<?php if($could_sms) { ?><li<?php if($action=='sms') { ?> class="on"<?php } ?>><a href="?action=sms&forward=<?php echo $_forward;?>">短信登录</a></li><?php } ?>
<?php if($could_scan) { ?><li<?php if($action=='scan') { ?> class="on"<?php } ?>><a href="?action=scan&forward=<?php echo $_forward;?>">扫码登录</a></li><?php } ?>
</ul>
</div>
<div class="login-body">
<?php if($action == 'scan') { ?>
<div id="weixin_qrcode"></div>
<script src="//res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js?v=<?php if(AJ_DEBUG) { ?><?php echo AJ_TIME;?><?php } else { ?><?php echo AJ_REFRESH;?><?php } ?>"></script>
<script type="text/javascript">
var obj = new WxLogin({
id:"weixin_qrcode", 
appid: "<?php echo WX_ID;?>", 
scope: "snsapi_login", 
redirect_uri: "<?php echo urlencode(WX_CALLBACK);?>",
state: "",
style: "",
href: "<?php echo AJ_PATH;?>api/oauth/wechat/style.css?v=<?php if(AJ_DEBUG) { ?><?php echo AJ_TIME;?><?php } else { ?><?php echo AJ_REFRESH;?><?php } ?>"
});
</script>
<?php } else if($action == 'sms') { ?>
<form method="post" action="?" onsubmit="return Scheck();">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php if($verfiy) { ?><div style="font-size:12px;color:#FF6600;">&nbsp;本次登录需要使用手机短信验证身份</div><?php } ?>
<div><input name="mobile" type="text" id="mobile"<?php if($verfiy) { ?> value="<?php echo $mobile;?>" readonly<?php } ?> placeholder="已认证手机号" class="input-mob"/></div>
<div><?php include template('captcha', 'chip');?></div>
<div>&nbsp;&nbsp;<a href="javascript:;" class="b" onclick="Dsend();" id="send">发送短信</a></div>
<div><input name="code" type="text" id="code" placeholder="短信验证码" class="input-code"/></div>
<div><input type="submit" name="submit" value="登 录" class="btn-blue login-btn"/></div>
<?php if($MOD['login_sms'] > 1 && $verfiy == 0) { ?>
<div><input type="checkbox" checked="checked" name="read" id="read" value="1" disabled/> <a href="<?php echo $AJ['file_register'];?>?action=read" target="_blank">我已阅读并同意服务条款</a></div>
<?php } ?>
</form>
<?php } else { ?>
<form method="post" action="?" onsubmit="return Dcheck();">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="auth" value="<?php echo $auth;?>"/>
<div><input name="username" type="text" id="username" value="<?php echo $username;?>" placeholder="用户名/已认证手机/邮箱" class="input-user"/></div>
<div><input name="password" type="password" id="password" value="" placeholder="密码"  class="input-pass"/></div>
<?php if($MOD['captcha_login']) { ?><div><?php include template('captcha', 'chip');?></div><?php } ?>
<div><input type="submit" name="submit" value="登 录" class="btn-blue login-btn"/></div>
<div class="t_c f_gray"><a href="<?php echo $AJ['file_register'];?>" class="b">会员注册</a> &nbsp;|&nbsp; <a href="send.php" class="b">忘记密码</a>
</div>
<?php if($oa) { ?><div title="使用社交帐号登录" class="login-oauth">
<?php if(is_array($OAUTH)) { foreach($OAUTH as $k => $v) { ?>
<?php if($v['enable']) { ?><a href="<?php echo AJ_PATH;?>api/oauth/<?php echo $k;?>/connect.php" title="<?php echo $v['name'];?>"><img src="<?php echo AJ_PATH;?>api/oauth/<?php echo $k;?>/icon.png" alt="<?php echo $v['name'];?>"/></a><?php } ?>
<?php } } ?>
</div><?php } ?>
</form>
<?php } ?>
</div>
</div>
<div class="login-show">&nbsp;</div>
<div class="c_b"></div>
</div>
<script type="text/javascript">
function Dmsgs(msg) {
$('#msgs').html(msg);
$('#msgs').fadeIn(100, function() {
setTimeout(function() {$('#msgs').fadeOut(300);}, 3000);
});
}
function Dcheck() {
if(Dd('username').value.length < 2) {
Dmsgs('请输入登录名称');
Dd('username').focus();
return false;
}
if(Dd('password').value.length < 6) {
Dmsgs('请输入密码');
Dd('password').focus();
return false;
}
<?php if($MOD['captcha_login']) { ?>
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
if(Dd('code').value.length < 6) {
Dmsgs('请输入短信验证码');
Dd('code').focus();
return false;
}
return true;
}
function Dstop() {
var i = 180;
var interval=window.setInterval(
function() {
if(i == 0) {
$('#send').html('重新发送');
clearInterval(interval);
} else {
$('#send').html('<span class="f_green">发送成功</span> &nbsp; <span class="f_gray">重新发送('+i+'秒)</span>');
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
if($('#ccaptcha').html().indexOf('ok.png') == -1) {
Dmsgs('验证码填写错误');
Dd('captcha').focus();
return false;
}
$.post('?', 'action=send&mobile='+Dd('mobile').value+'&captcha='+Dd('captcha').value, function(data) {
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
Dmsgs('发送失败'+data);
}
reloadcaptcha();
});
}
</script>
<?php include template('footer');?>