<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
  
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="post[areaid]" value="<?php echo $areaid;?>"/>
<input type="hidden" name="post[houseid]" value="<?php echo $houseid;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>

<input name="post[username]" type="hidden"  size="20" value="<?php echo $username;?>" id="username"/> 

<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>预售证</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl"><span class="f_red">*</span> 预售证号</td>
<td><input name="post[title]" type="text" size="20" value="<?php echo $title;?>" id="level"/> <span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 项目名称</td>
<td><input name="post[project]" type="text" size="50" value="<?php echo $project;?>" id="level"/> <span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"> 总建面</td>
<td><input name="post[acreage]" type="text" size="10" value="<?php echo $acreage;?>" id="mj"/> 单位：M2<span id="dbh" class="f_red"></span></td>
</tr>

<tr>
<td class="tl">住宅套数</td>
<td>
<input name="post[residence]" type="text" size="2" value="<?php echo $residence;?>" id="residence"/>套
</td>
</tr>
<tr>
<td class="tl">非住宅套数</td>
<td>
<input name="post[noneresidence]" type="text" size="2" value="<?php echo $noneresidence;?>" id="noneresidence"/>套
</td>
</tr>
<tr>
<td class="tl"> 开发商</td>
<td><input name="post[kfs]" type="text" size="10" value="<?php echo $kfs;?>" /> <span id="dbh" class="f_red"></span></td>
</tr>


 <tr>
<td class="tl"><span class="f_hid">*</span> 证照</td>
<td><input name="post[thumb]" id="thumb" type="text" size="60" value="<?php echo $thumb;?>"/>&nbsp;&nbsp;<span onClick="Dthumb(<?php echo $moduleid;?>,Dd('level').value==2 ? 330 : <?php echo $MOD['thumb_width'];?>,Dd('level').value==2 ? 250 : <?php echo $MOD['thumb_height'];?>, Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onClick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onClick="Dd('thumb').value='';" class="jt">[删除]</span></td>
</tr>
          
</tbody>
<tr>
<td class="tl"> 备注</td>
<td><input name="post[note]" type="text" size="60" value="<?php echo $note;?>" id="note"/></td>
</tr>
<tr>
<td class="tl">信息状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
</td>
</tr>

<tr>
<td class="tl">发证时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('guest.js'); ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'title';
	l = Dd(f).value.length;
	if(l < 1) {
		Dmsg('请填写标题', f);
		return false;
	}
	if(Dd('ismember_1').checked) {
		f = 'username';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写会员名', f);
			return false;
		}
	} else {
		f = 'company';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写公司名称', f);
			return false;
		}
		if(Dd('areaid_1').value == 0) {
			Dmsg('请选择所在地区', 'areaid');
			return false;
		}
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>