<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">预售证</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="15" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;
<?php echo $order_select;?>&nbsp;


<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&pid=<?php echo $pid;?>');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>发证时间</th>
<th>区域</th>
<th>许可证号</th>
<th>项目名称</th>
<th >公司名称</th>
<th>住宅/非住宅</th>
<th>总建面</th>

<th>会员</th>


<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>

<td><?php echo timetodate($v['addtime'], 3);?></td>
<td><?php echo area_pos($v['areaid'], ' ');?></td>
<td ><?php echo $v['title'];?></td>
<td><a href="house/<?php echo $v['houseid'];?>/" target="_blank"><?php echo $v['project'];?></a></td>
<td ><?php echo $v['kfs'];?></td>
<td align="px11"><?php echo $v['residence'];?>/<?php echo $v['noneresidence'];?></td>

<td align="left"><?php echo $v['acreage'];?>㎡</td>

<td>
<?php if($v['username']) { ?>
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a>
<?php } else { ?>
	<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
<?php } ?>
</td>

<td class="px11"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&action=item&itemid=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 图片列表');"><?php echo $v['items'];?></a></
<td>

<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>

<div class="btns">

<?php if($action == 'check') { ?>

<input type="submit" value=" 通过审核 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';"/>&nbsp;
<input type="submit" value=" 拒 绝 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';"/>&nbsp;

<input type="submit" value=" 删除 " class="btn" onclick="if(confirm('确定要删除选中预售证吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>

<?php } else if($action == 'reject') { ?>


<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中预售证吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>





<?php } else { ?>



<input type="submit" value=" 删除 " class="btn" onclick="if(confirm('确定要删除选中预售证吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } ?>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<?php if(isset($id) && isset($tm) && $id && $tm > $AJ_TIME) { ?>
<script type="text/javascript">Dwidget('?moduleid=<?php echo $moduleid;?>&action=item&itemid=<?php echo $id;?>', '请上传图片');</script>
<?php } ?>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>