<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?" id="search">
<div class="tt"><?php echo $MOD['name'];?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;
<?php echo $level_select;?>&nbsp;

<?php echo category_select('catid', '新房类型', $catid, $moduleid);?>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;
<?php echo $order_select;?>&nbsp;
ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>


</table>
</form>
<form method="post">

<div class="tt"><?php echo $menus[$menuid][0];?></div>

<link rel="stylesheet" href="admin/layui/lib/layui-v2.5.4/css/layui.css" media="all">
<table  lay-filter="table" class="layui-table" >
<thead>
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th >ID<a href="javascript:;" onclick="Dq('order','<?php echo $order == 15 ? 16 : 15;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 16 ? 'asc' : ($order == 15 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a> </th>
<th>名称</th>
<th>区域</th>

<th width="50">资讯</th>
<th width="50">相册</th>
<th width="50">户型图</th>
<th>沙盘</th>
<th>问房</th>
<th>点评</th>
<th>报价</th>
<th>参考价  <a href="javascript:;" onclick="Dq('order','<?php echo $order == 11 ? 12 : 11;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 12 ? 'asc' : ($order == 11 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
<th>  预售证</th>
<th>开盘时间  <a href="javascript:;" onclick="Dq('order','<?php echo $order == 5 ? 6 : 5;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 6 ? 'asc' : ($order == 5 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
<th>交房时间  <a href="javascript:;" onclick="Dq('order','<?php echo $order == 7 ? 8 : 7;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 8 ? 'asc' : ($order == 7 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>

<th width="120"><?php echo $timetype == 'add' ? '添加' : '更新';?>时间 <a href="javascript:;" onclick="Dq('order','<?php echo $order == 1 ? 2 : 1;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 2 ? 'asc' : ($order == 1 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>

<th>会员 </th>
<th width="120">管理操作</th>
</tr>
</thead>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><?php echo $v['itemid'];?></td>
<td><a href="<?php echo $v['linkurl'];?>" target="_blank"><?php if($v['thumb']) {?><font style="color:red">图&nbsp;</font><?php } ?><?php echo $v['title'];?></a><?php if($v['vip']) {?> <img src="<?php echo AJ_SKIN;?>image/vip.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>"/><?php } ?><?php if($v['isfx']) {?><font style="color:red">&nbsp;&nbsp;分销</font><?php } ?></td>
<td><?php echo area_pos($v['areaid'], ' ');?></td>


<td><a href="javascript:Dwidget('?moduleid=8&file=<?php echo $file;?>&houseid=<?php echo $v['itemid'];?>&housename=<?php echo $v['alt'];?>', '[<?php echo $v['alt'];?>] 资讯列表');">[<?php echo get_housenum('article_8',$v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=6&file=xiangce&houseid=<?php echo $v['itemid'];?>&title=<?php echo $v['alt'];?>', '[<?php echo $v['alt'];?>] 相册列表',800, 400)">[<?php echo get_xiangcenum($v['itemid'],'');?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=6&file=huxing&houseid=<?php echo $v['itemid'];?>&title=<?php echo $v['alt'];?>', '[<?php echo $v['alt'];?>] 户型列表',800, 400)">[<?php echo get_huxingnum($v['itemid'],'');?>]</a></td>
<td><a href="?moduleid=6&file=shapan&houseid=<?php echo $v['itemid'];?>">[沙盘]</a></td>


<td><a href="javascript:Dwidget('?moduleid=3&file=wenfang&item_id=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 问房列表');">[<?php echo get_wfnum($v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=3&file=comment&item_id=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 点评列表');">[<?php echo get_dpnum($v['itemid']);?>]</a></td>
<td><a href="javascript:Dwidget('?moduleid=6&file=price&action=add&pid=<?php echo $v['itemid'];?>&title=<?php echo $v['alt'];?>', '[<?php echo $v['alt'];?>] 添加报价');"><img src="admin/image/add.png" width="16" height="16" title="添加报价" alt=""/></a>&nbsp;&nbsp;&nbsp;<a href="javascript:Dwidget('?moduleid=6&file=price&pid=<?php echo $v['itemid'];?>&title=<?php echo $v['alt'];?>', '[<?php echo $v['alt'];?>] 报价列表');"><img src="admin/image/poll.png" width="16" height="16" title="报价记录" alt=""/></a></td>
<td><?php echo $v['price'] ? $v['price'] : '';?></td>
<td><a href="javascript:Dwidget('?moduleid=6&file=yushou&houseid=<?php echo $v['itemid'];?>&areaid=<?php echo $v['areaid'];?>', '[<?php echo $v['alt'];?>] 预售证',800, 400)">预售证</a></td>
<td><?php echo $v['selltime'] ? $v['selltime'] : '';?></td>
<td><?php echo $v['completion'] ? $v['completion'] : '';?></td>

<?php if($timetype == 'add') {?>
<td class="px11" title="更新时间<?php echo timetodate($v['edittime'], 5);?>"><?php echo timetodate($v['addtime'], 3);?></td>
<?php } else { ?>
<td class="px11" title="添加时间<?php echo timetodate($v['addtime'], 5);?>"><?php echo timetodate($v['edittime'], 3);?></td>
<?php } ?>
<td>
<?php if($v['username']) { ?>
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a>
<?php } else { ?>
	<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
<?php } ?>
</td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>">修改</a> |  
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();">删除</a> 
</td>
</tr>
<?php } ?>
</table>
<div class="btns">

<?php if($action == 'check') { ?>

<input type="submit" value=" 通过审核 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';"/>&nbsp;
<input type="submit" value=" 拒 绝 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'expire') { ?>

<span class="f_red f_r">
批量延长过期时间 <input type="text" size="3" name="days" id="days" value="60"/> 
天 <input type="submit" value=" 确 定 " class="btn" onclick="if(Dd('days').value==''){alert('请填写天数');return false;}if(confirm('确定要延长'+Dd('days').value+'天吗？')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=expire&refresh=1&extend=1'}else{return false;}"/>
</span>

<input type="submit" value="刷新过期" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=expire&refresh=1';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'reject') { ?>

<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'recycle') { ?>

<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 还 原 " class="btn" onclick="if(confirm('确定要还原选中<?php echo $MOD['name'];?>吗？状态将被设置为已通过')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=restore'}else{return false;}"/>&nbsp;
<input type="submit" value=" 清 空 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=clear';"/>

<?php } else { ?>

<input type="submit" value="刷新信息" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refresh';" title="刷新时间为最新"/>&nbsp;
<input type="submit" value=" 更新信息 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update';"/>&nbsp;
<?php if($MOD['show_html']) { ?><input type="submit" value=" 生成网页 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=tohtml';"/>&nbsp;<?php } ?>
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中<?php echo $MOD['name'];?>吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level\';this.form.submit();"');?>&nbsp;
<select name="tid" onchange="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=type';this.form.submit();">
<option value="">设置类型为</option>
<?php foreach($TYPE as $k=>$v) { ?>
<option value="<?php echo $k;?>"><?php echo $v;?></option>
<?php } ?>
</select>
<?php } ?>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>