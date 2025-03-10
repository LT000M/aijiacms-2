<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellspacing="0" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;

<select name="typeid">
<?php foreach($NAME as $k=>$v) { ?>
<option value="<?php echo $k;?>"<?php echo $k==$typeid ? ' selected' : '';?>><?php echo $v;?></option>
<?php } ?>
</select>&nbsp;

<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<table cellspacing="0" class="tb ls">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="55">ID</th>
<th width="60">联系人</th>
<th>联系电话</th>
<th>楼盘</th>
<th>内容</th>
<th>提交时间</th>
<th>经纪人</th>
<th>状态</th>
<th >操作</th>

</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><?php echo $v['itemid'];?></td>
<td><?php echo $v['truename'];?></td>
<td align="left"><?php echo $v['telephone']?></td>
<td><?php echo $v['title']?></td>
<td><?php echo $v['content']?></td>
<td class="px12"><?php echo timetodate($v['addtime'], 6);?></td>
<td><a href="javascript:_user('<?php echo $v['fromuser'];?>');"><?php echo $v['fromuser'];?></a></td>

<td><?php if($v['status']) { ?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=status&itemid=<?php echo $v['itemid'];?>&status=0" class="t" >已联系</a>
<?php } else { ?>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=status&itemid=<?php echo $v['itemid'];?>&status=3" style="color:#F00" >待联系</a>
<?php } ?>
 </td>
<td>
                    <div class="layui-table-cell">
              <a href="javascript:Dwidget('?moduleid=2&file=subscribe&action=broker&itemid=<?php echo $v['itemid'];?>', '[选择]', 600, 300);" class="t">[分配经纪人]</a> &nbsp;&nbsp;|&nbsp;&nbsp;
              <a href="javascript:Dwidget('?moduleid=2&file=subscribe&action=befollow&subid=<?php echo $v['itemid'];?>', '[查看跟进]', 600, 300);" class="t">[看跟进]</a>&nbsp;&nbsp;|&nbsp;&nbsp;
              <a href="javascript:Dwidget('?moduleid=2&file=subscribe&action=addbefollow&subid=<?php echo $v['itemid'];?>', '[增加跟进]', 600, 300);" class="t">[增加跟进]</a>&nbsp;&nbsp;|&nbsp;&nbsp;
           <a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" class="t" onclick="return _delete();">[删除]</a>                  </div>
                </td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删 除 " class="btn-r" onclick="if(confirm('确定要删除选中信件吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>
</div>
</form>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<br/>
<?php include tpl('footer');?>