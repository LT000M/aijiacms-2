<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="post[event_type]" value="1"/>
<input type="hidden" name="post[platform]" value="weixin"/>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellspacing="0" class="tb">

<tr>
<td class="tl"><span class="f_red">*</span> 名称</td>
<td><input type="text" name="post[name]" placeholder="名称" minlength="2" maxlength="60" data-validation-message="名称格式 2~60 个字符" class="am-radius"  value="<?php echo $name;?>" required /><span id="dtitle" class="f_red"></span></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 网站地址</td>
<td><input type="text" name="post[event_value]" placeholder="事件值" data-validation-message="事件值最多 255 个字符" class="am-radius"  value="<?php echo $event_value;?>" /> 例如：/pages/user/user
</td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 导航图标</td>
<td><input name="post[images_url]" type="text" id="thumb" size="40" value="<?php echo $images_url;?>"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,100,100, Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 顺序</td>
<td>	<input type="number" placeholder="顺序" name="post[listorder]" min="0" max="255" data-validation-message="顺序 0~255 之间的数值" class="am-radius" value="<?php echo $listorder;?>" required />
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 是否启用</td>
<td>
<input type="radio" name="post[is_enable]" value="1" <?php if($is_enable==1) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="post[is_enable]" value="0" <?php if($is_enable==0) echo 'checked';?>/> 否
</td>
</tr>

</table>
<div class="sbt"><input type="submit" name="submit" value="<?php echo $action == 'edit' ? '修 改' : '添 加';?>" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo $action == 'edit' ? '返 回' : '取 消';?>" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?><?php echo $status == 2 ? '&action=check' : '';?>');"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'name';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('请输入名称', f);
		return false;
	}
	f = 'event_value';
	l = Dd(f).value.length;
	if(l < 12) {
		Dmsg('请输入地址', f);
		return false;
	}
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>