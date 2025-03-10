<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="sbox">
<form action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php echo $fields_select;?>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;

<span data-hide="1200"><?php echo $order_select;?>&nbsp;</span>
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/>
</form>
</div>
<form method="post">
<table cellspacing="0" class="tb ls">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<?php if($action != 'check') {?><th width="50">排序</th><?php } ?>
<th>名称</th>
<th>导航图标</th>
<th>事件值</th>
<th>是否启用</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center" >
<td><input type="checkbox" name="id[]" value="<?php echo $v['id'];?>"/></td>
<?php if($action != 'check') {?><td><input type="text" size="2" name="listorder[<?php echo $v['id'];?>]" value="<?php echo $v['listorder'];?>"/></td><?php } ?>
<td><?php echo $v['name'];?></td>
<td><img src="<?php echo $v['images_url'];?>" width="88" /></td>
<td><?php echo $v['event_value'];?></td>
<td><?php echo $v['is_enable'] ? '是' : '否';?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&id=<?php echo $v['id'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&id=<?php echo $v['id'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">

<input type="submit" value="更新排序" class="btn-g" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=order';"/>&nbsp;

<input type="submit" value="删 除" class="btn-r" onclick="if(confirm('确定要删除选中链接吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

</div>
</form>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>