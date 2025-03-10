<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($navmenus);
?>
<div class="sbox">
<form action="?">
<input type="hidden" name="mid" value="<?php echo $mid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
<input type="submit" name="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 搜" class="btn" onclick="Go('?mid=<?php echo $mid;?>&file=<?php echo $file;?>');"/>&nbsp;
</form>
</div>
<form method="post">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<?php if($parentid) {?>
<div class="tt">
<span class="f_r"><a href="?file=<?php echo $file;?>&mid=<?php echo $mid;?>&parentid=<?php echo $CATEGORY[$parentid]['parentid'];?>" class="t" style="font-weight:normal;">返回上级</a></span>
<?php echo $CATEGORY[$parentid]['catname'];?>
</div>
<?php }?>
<table cellspacing="0" class="tb ls">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>排序</th>
<th data-hide="1200">ID</th>
<th>菜单名称</th>
<th>控制器方法</th>
<th>样式</th>
<th>状态</th>
<th>子菜单</th>
<th width="80">操作</th>
</tr>
<?php foreach($AJCAT as $k=>$v) {?>
<tr align="center">
<td><input type="checkbox" name="navids[]" value="<?php echo $v['navid'];?>"/></td>
<td><input name="post[<?php echo $v['navid'];?>][listorder]" type="text" size="3" value="<?php echo $v['listorder'];?>"/></td>
<td data-hide="1200">&nbsp;<a href="<?php echo $MODULE[$mid]['linkurl'].$v['linkurl'];?>" target="_blank"><?php echo $v['navid'];?></a>&nbsp;</td>


<td>
<input name="post[<?php echo $v['navid'];?>][title]" type="text" value="<?php echo $v['title'];?>" size="10"/>
</td>
<td>
<input name="post[<?php echo $v['navid'];?>][href]" type="text" value="<?php echo $v['href'];?>" size="30"/>
</td>
<td>
<input name="post[<?php echo $v['navid'];?>][icon]" type="text" value="<?php echo $v['icon'];?>" size="20"/>
</td>
<td>
<?php echo $v['status'] ? '显示' : '隐藏';?>
</td>
<td title="管理子菜单"><a href="?file=<?php echo $file;?>&parentid=<?php echo $v['navid'];?>"><?php echo $v['childs'];?></a></td>
<td>
<a href="?file=<?php echo $file;?>&action=add&parentid=<?php echo $v['navid'];?>"><img src="admin/image/add.png" width="16" height="16" title="添加子菜单" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=edit&navid=<?php echo $v['navid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=delete&navid=<?php echo $v['navid'];?>&parentid=<?php echo $parentid;?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
</tr>
<?php }?>
</table>
<div class="btns">

&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" value="更新菜单" class="btn-g" onclick="this.form.action='?file=<?php echo $file;?>&parentid=<?php echo $parentid;?>&action=update'"/>&nbsp;&nbsp;
<input type="submit" value="删除选中" class="btn-r" onclick="if(confirm('确定要删除选中菜单吗？此操作将不可撤销')){this.form.action='?file=<?php echo $file;?>&parentid=<?php echo $parentid;?>&action=delete'}else{return false;}"/>&nbsp;&nbsp;
</div>
</form>



<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>