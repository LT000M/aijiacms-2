<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="post[type]" value="<?php echo $type;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellspacing="0" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 任务名称</td>
<td><input name="post[title]" type="text" id="title" size="50" value="<?php echo $title;?>"/><span id="dtitle" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 脚本文件</td>
<td>
<select name="post[name]" id="name">
<?php
$F = glob(AJ_ROOT.'/api/cron/*.inc.php');
foreach($F as $f) {
	$f = substr(basename($f), 0, -8);
	if(check_name($f)) echo '<option value="'.$f.'"'.($name == $f ? ' selected' : '').'>api/cron/'.$f.'.inc.php</option>';
}
?>
</select>
<span id="dname" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 执行方式</td>
<td>
<input type="radio" name="post[run]" value="0"  <?php if(!$run){ ?>checked <?php } ?> onclick="Ds('run_0');Dh('run_1');"/> 间隔执行&nbsp;&nbsp;
<input type="radio" name="post[run]" value="1"  <?php if($run){ ?>checked <?php } ?> onclick="Dh('run_0');Ds('run_1');"/> 每天执行
</td>
</tr>
<tr id="run_0" style="display:<?php if($run) echo 'none';?>">
<td class="tl"><span class="f_hid">*</span> 间隔时间</td>
<td><input name="post[minute]" type="text" id="minute" size="5" value="<?php echo $minute;?>"/> 分钟 &nbsp;
<select onchange="Dd('minute').value=this.value;">
<option value="">快捷选择</option>
<option value="10">10分钟</option>
<option value="30">半小时</option>
<option value="60">一小时</option>
<option value="360">六小时</option>
<option value="720">十二小时</option>
<option value="1440">一天</option>
<option value="10080">一周</option>
<option value="43200">一月</option>
</select>&nbsp;<span id="dminute" class="f_red"></span>
</td>
</tr>
<tr id="run_1" style="display:<?php if(!$run) echo 'none';?>">
<td class="tl"><span class="f_hid">*</span> 执行时间</td>
<td>
<select name="post[hour]" id="hour">
<?php
for($i = 0; $i < 24; $i++) {
	echo '<option value="'.$i.'"'.($hour == $i ? ' selected' : '').'>'.($i < 10 ? '0'.$i : $i).'点</option>';
}
?>
</select>
<select name="post[mint]" id="mint">
<?php
for($i = 0; $i < 60; $i++) {
	echo '<option value="'.$i.'"'.($mint == $i ? ' selected' : '').'>'.($i < 10 ? '0'.$i : $i).'分</option>';
}
?>
</select>
<span id="dhour" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 运行参数</td>
<td class="nv">
<table cellspacing="1" class="ctb">
<tr bgcolor="#F7F7F7" align="center">
<td>参数名称</td>
<td>参数值</td>
<td>&nbsp;代码调用&nbsp;</td>
</tr>
<tr>
<td><input name="post[n1]" type="text" size="20" value="<?php echo $n1;?>" id="n1"/></td>
<td><input name="post[v1]" type="text" size="10" value="<?php echo $v1;?>" id="v1"/></td>
<td>$v1</td>
</tr>
<tr>
<td><input name="post[n2]" type="text" size="20" value="<?php echo $n2;?>" id="n2"/></td>
<td><input name="post[v2]" type="text" size="10" value="<?php echo $v2;?>" id="v2"/></td>
<td>$v2</td>
</tr>
<tr>
<td><input name="post[n3]" type="text" size="20" value="<?php echo $n3;?>" id="n3"/></td>
<td><input name="post[v3]" type="text" size="10" value="<?php echo $v3;?>" id="v3"/></td>
<td>$v3</td>
</tr>
<tr>
<td class="f_gray">例如：时间</td>
<td class="f_gray">例如：100</td>
<td class="f_gray"><?php tips('在计划任务PHP代码中使用$v1代表第一个参数的值');?></td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 任务状态</td>
<td>
<input type="radio" name="post[status]" value="0"  <?php if(!$status){ ?>checked <?php } ?>/> 正常&nbsp;&nbsp;
<input type="radio" name="post[status]" value="1"  <?php if($status){ ?>checked <?php } ?>/> 禁用
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 备注说明</td>
<td><textarea name="post[note]" style="width:300px;height:40px;"><?php echo $note;?></textarea></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value="<?php echo $itemid ? '修 改' : '添 加';?>" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo $itemid ? '返 回' : '取 消';?>" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/></div>
</form>
<script type="text/javascript">
function check() {
	if(Dd('title').value.length < 2) {
		Dmsg('请填写任务名称', 'domain');
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $itemid ? 1 : 0;?>);</script>
<?php include tpl('footer');?>