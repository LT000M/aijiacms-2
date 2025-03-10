<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($navmenus);
?>
<form method="post" action="?" onsubmit="return check();">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>

<table cellspacing="0" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 上级菜单</td>
<td><?php echo navmenu_select('post[parentid]', '请选择', $parentid);?><?php tips('如果不选择，则为顶级菜单');?></td>
</tr>
<tr>
<td class="tl"> 菜单名称</td>
<td><input name="post[title]" type="text" id="title" size="10"/></td>
</tr>
<tr>
<td class="tl"> 菜单标题[英文名]</td>
<td><input name="post[name]" type="text"  size="10"/> </td>
</tr>
<tr>
<td class="tl"> 是否显示</td>
<td><input type="radio" name="post[status]" value="1" checked/> 是&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="post[status]" value="0" /> 否</td>
</tr>
<tr>
<td class="tl"> 新窗口打开</td>
<td><input type="radio" name="post[target]" value="1" checked/> 是&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="post[target]" value="0"  /> 否</td>
</tr>

<tr>
<td class="tl"> 链接地址</td>
<td><input name="post[href]" type="text" id="href" size="40"/> <span id="dhref" class="f_red"></span></td>
</tr>


<tr>
<td class="tl"> icon样式</td>
<td><input name="post[icon]" type="text" id="icon" size="30"/> <?php tips('输入样式名称，比如 fa-tachometer');?> <span id="dicon" class="f_red"></span> </td>
</tr>

</table>
<div class="sbt"><input type="submit" name="submit" value="确 定" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('&file=<?php echo $file;?>');"/></div>
</form>

<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>