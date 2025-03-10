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
<input type="text" size="50" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;

<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</form>
</div>
<form method="post">
<table cellspacing="0" class="tb ls">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th lay-data="{type:'numbers',align: 'center'}">序号</th>
				<th >编号</th>
				<th >状态</th>
				<th >用户名</th>
				<th >客户姓名</th>
				<th >咨询电话</th>
				<th >客户来源</th>
				
				<th >沟通阶段</th>
				<th >维护人</th>
				<th >当前跟进经纪人</th>
				
				<th>录入时间</th>
				<th >操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center" title="备注:<?php echo $v['note'];?>">
<td><input type="checkbox" name="id[]" value="<?php echo $v['id'];?>"/></td>
<td >&nbsp;<?php echo $v['id'];?></td>
<td>&nbsp;<?php echo $v['xqbianhao'];?></td>

<td >&nbsp;<?php echo $NAME[$v['zhuangtai']-1];?></td>
<td >&nbsp;<a href="javascript:_user('<?php echo $v['username'];?>');" title="<?php echo $v['username'];?>"><?php echo $v['username'];?></a></td>

<td >&nbsp;<?php echo $v['khxingming'];?></td>
<td >&nbsp;<?php echo $v['dianhua'];?></td>
<td >&nbsp;<?php echo $v['khlaiyuan'];?></td>

<td >&nbsp;<?php echo $v['gtjieduan'];?></td>
<td >&nbsp;<?php echo $v['weihuren'];?></td>
<td >&nbsp;<a href="javascript:_user('<?php echo $v['dkusername'];?>');" title="<?php echo $v['dkusername'];?>"><?php echo $v['dkusername'];?></a></td>
<td >&nbsp;<?php echo timetodate($v['lurusj'],5);?></td>



<td><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=show&id=<?php echo $v['id'];?>">详情</a>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&id=<?php echo $v['id'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&id=<?php echo $v['id'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删 除 " class="btn-r" onclick="if(confirm('确定要删除选中客源吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;&nbsp;&nbsp;
</div>
</form>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>