<?php defined('IN_AIJIACMS') or exit('Access Denied');?><input name="captcha" id="captcha" type="text" size="6" placeholder="验证码" class="input-captcha"/>&nbsp;<img src="<?php echo AJ_PATH;?>api/captcha.png.php?action=image" title="验证码,看不清楚?请点击刷新&#10;字母不区分大小写" alt="" align="absmiddle" id="captchapng" onclick="reloadcaptcha();" style="cursor:pointer;"/><span id="ccaptcha"></span>
<script type="text/javascript">
function reloadcaptcha() {
Dd('captchapng').src = '<?php echo AJ_PATH;?>api/captcha.png.php?action=image&refresh='+Math.random();
Dd('ccaptcha').innerHTML = '';
Dd('captcha').value = '';
}
function checkcaptcha(s) {
s = $.trim(s);
var t = encodeURIComponent(s);
if(t.indexOf('%E2%80%86') != -1) s = decodeURIComponent(t.replace(/%E2%80%86/g, ''));
if(!is_captcha(s)) return;
$.post(AJPath, 'action=captcha&captcha='+s,
function(data) {
if(data == '0') {
Dd('ccaptcha').innerHTML = '&nbsp;&nbsp;<img src="<?php echo AJ_STATIC;?>file/image/check-ok.png" align="absmiddle"/>';
<?php if($AJ_MOB['os'] == 'ios') { ?>
Dd('captcha').value = s;
<?php } ?>
} else {
Dd('captcha').focus;
Dd('ccaptcha').innerHTML = '&nbsp;&nbsp;<img src="<?php echo AJ_STATIC;?>file/image/check-ko.png" align="absmiddle"/>';
}
}
);
}
function is_captcha(v) {
if(v.match(/^[a-z0-9A-Z]{1,}$/)) {
return v.match(/^[a-z0-9A-Z]{4,}$/);
} else {
return v.length > 1;
}
}
$(function() {
$('#captcha').bind('keyup blur', function() {
checkcaptcha($('#captcha').val());
});
});
</script>