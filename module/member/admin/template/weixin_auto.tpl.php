<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="sbox">
<form action="?" id="search">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="text" size="50" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" placeholder="条/页" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</form>
</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellspacing="0" class="tb ls">
<tr>
<th width="40"><input type="checkbox" onclick="checkall(this.form);" title="全选/反选"/></th>
<th width="360">关键词</th>
<th width="360">回复</th>
<th></th>
</tr>
<?php foreach($lists as $k=>$v) { ?>
<tr align="center">
<td><input name="post[<?php echo $v['itemid'];?>][delete]" type="checkbox" value="1"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][keyword]" type="text" size="50" value="<?php echo $v['keyword'];?>"/></td>
<td><textarea name="post[<?php echo $v['itemid'];?>][reply]" rows="3" cols="50"><?php echo $v['reply'];?></textarea></td>
<td></td>
</tr>
<?php } ?>
<tr align="center">
<td class="f_green">新增</td>
<td><textarea name="post[0][keyword]" rows="10" cols="50"></textarea></td>
<td><textarea name="post[0][reply]" rows="10" cols="50"></textarea></td>
<td></td>
</tr>
<tr>
<td></td>
<td height="30" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" value="保 存" onclick="if($(':checkbox:checked').length && !confirm('确定要删除'+$(':checkbox:checked').length+'个选中项吗？此操作将不可撤销')) return false;" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" value="删 除" onclick="if($(':checkbox:checked').length){if(!confirm('确定要删除'+$(':checkbox:checked').length+'个选中项吗？此操作将不可撤销')) return false;}else{confirm('请选择要删除的项目');return false;}" class="btn-r"/>&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<?php if($pages) { ?>
<tr>
<td colspan="5"><?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?></td>
</tr>
<?php } ?>
<tr>
<td> </td>
<td colspan="4" class="lh20">
&nbsp;&nbsp;1、批量添加时，关键词和回复一行一个，互相对应<br/>
&nbsp;&nbsp;2、关键词请控制在30个字符以内<br/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">Menuon(3);</script>
<?php include tpl('footer');?>