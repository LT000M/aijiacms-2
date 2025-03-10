<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?" id="search">
<div class="tt"><?php echo $MOD['name'];?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="layui-table">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;
<?php echo $level_select;?>&nbsp;
<?php echo category_select('catid', '物业类型', $catid, $moduleid);?>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;

&nbsp;<select name="datetype">
<option value="edittime" <?php if($datetype == 'edittime') echo 'selected';?>>更新日期</option>
<option value="addtime" <?php if($datetype == 'addtime') echo 'selected';?>>发布日期</option>
<option value="totime" <?php if($datetype == 'totime') echo 'selected';?>>到期日期</option>
</select>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;

ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;


<?php echo $order_select;?>&nbsp;

<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>

</table>


</form>
<form method="post">

<link rel="stylesheet" href="admin/layui/lib/layui-v2.5.4/css/layui.css" media="all">
<table  lay-filter="table" class="layui-table" >
		<thead>
			<tr>
				<th >序号  <a href="javascript:;" onclick="Dq('order','<?php echo $order == 11 ? 12 : 11;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 12 ? 'asc' : ($order == 11 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
				<th>图片</th>
				<th>小区</th>
				
				<th >来源</th>
				<th>地址</th>
				<th>建面<a href="javascript:;" onclick="Dq('order','<?php echo $order == 13 ? 14 : 13;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 14 ? 'asc' : ($order == 13 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
				<th>价格 <a href="javascript:;" onclick="Dq('order','<?php echo $order == 7 ? 8 : 7;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 8 ? 'asc' : ($order == 7 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
				
				<th>户型</th>
				<th>楼层</th>
				<th>朝向</th>
				<th>房龄</th>
				<th>标签</th>
				<th>类型</th>
				<th>装修</th>
				<th>录入时间 <a href="javascript:;" onclick="Dq('order','<?php echo $order == 3 ? 4 : 3;?>');"> <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 4 ? 'asc' : ($order == 3 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
				<th>经纪人</th>
				<th>电话</th>
				<th>操作</th>
			</tr>
		</thead>
        <?php foreach($lists as $k=>$v) {?>
        <tr>
				<th ><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></th>
				<th ><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php echo $v['thumb'] ? $v['thumb'] : AJ_SKIN.'image/nopic60.gif';?>" width="60" style="padding:5px;"/></a></th>
				
				<th ><a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['housename'];?></a></th>
				<th ><?php echo $v['typeid'] ? '中介' : '个人';?></th>
				<th ><?php echo dsubstr($v['address'], 20, $suffix = '...');?></th>
				<th ><?php echo $v['houseearm'];?>m²</th>
				<th><?php echo $v['price'] ? $v['price'] : '';?>万</th>
				
				<th ><?php echo $v['room'];?>室<?php echo $v['hall'];?>厅<?php echo $v['toilet'];?>卫</th>
				<th ><?php echo $v['floor1'];?>/<?php echo $v['floor2'];?></th>
				<th ><?php echo getbox_diaoval('toward','checkbox',$v['toward'],'sale_5');?></th>
				<th ><?php echo $v['houseyear'];?>年</th>
				<th ><?php echo $v['istop'] ? '置顶' : '';?>  <?php echo $v['ishot'] ? '急售' : '';?></th>
				<th ><a href="<?php echo $v['caturl'];?>" target="_blank"><?php echo $v['catname'];?></a></th>
				<th ><?php echo getbox_diaoval('fix','checkbox',$v['fix'],'sale_5');?></th>
				<th ><?php echo timetodate($v['addtime'], 5);?></th>
				<th ><?php echo $v['username'];?></th>
				<th ><?php echo $v['telephone'];?></th>
				<th ><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></th>
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