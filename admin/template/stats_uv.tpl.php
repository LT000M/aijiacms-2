<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?" id="search">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellspacing="0" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
<select name="robot">
<option value="">搜索引擎</option>
<option value="all"<?php echo $robot == 'all' ? ' selected' : '';?>>全部爬虫</option>
<?php
foreach($L['robot'] as $k=>$v) {
?>
<option value="<?php echo $k;?>"<?php echo $robot == $k ? ' selected' : '';?>><?php echo $v;?></option>
<?php
}
?>
</select>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" placeholder="条/页" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?file=<?php echo $file;?>&action=<?php echo $action;?>');"/></td>
</tr>
<tr>
<td>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '-', 1);?> 至 <?php echo dcalendar('todate', $todate, '-', 1);?>&nbsp;
<select name="pc">
<option value="-1">设备</option>
<option value="1"<?php echo $pc == 1 ? ' selected' : '';?>>电脑</option>
<option value="0"<?php echo $pc == 0 ? ' selected' : '';?>>手机</option>
</select>&nbsp;
<input type="text" name="ip" value="<?php echo $ip;?>" size="15" title="IP" placeholder="IP"/>&nbsp;
</td>
</tr>
</table>
</form>
<table cellspacing="0" class="tb ls">
<tr>
<th width="150"><a href="javascript:;" onclick="Dq('order','<?php echo $order == 2 ? 1 : 2;?>');">入站时间 <img src="<?php echo AJ_STATIC;?>file/image/ico-<?php echo $order == 2 ? 'asc' : ($order == 1 ? 'dsc' : 'ord');?>.png" width="11" height="11"/></a></th>
<th>IP</th>
<th>地区</th>
<th>设备</th>
<th>网络</th>
<th>操作系统</th>
<th>浏览器</th>
<th>分辨率</th>
<th>品牌</th>
<th data-hide-1200="1">客户端</th>
<th>爬虫</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td><a href="javascript:;" onclick="Dq('date',this.innerHTML);"><?php echo $v['addtime'];?></a></td>
<td title="归属地：<?php echo $v['area'];?>"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=pv&ip=<?php echo $v['ip'];?>', '<?php echo $v['ip'];?> - PV记录');"><?php echo $v['ip'];?></a></td>
<td><?php echo $v['location'];?></td>
<td><a href="javascript:;" onclick="Dq('pc','<?php echo $v['pc'];?>');"><?php echo $v['pc'] ? '电脑' : '手机';?></a></td>
<td><a href="javascript:;" onclick="Dq('network','<?php echo $v['network'];?>');"><?php echo $v['network'];?></td>
<td><a href="javascript:;" onclick="Dq('os','<?php echo $v['os'];?>');"><?php echo $v['os'];?></td>
<td><a href="javascript:;" onclick="Dq('bs','<?php echo $v['bs'];?>');"><?php echo $v['bs'];?></td>
<td><a href="javascript:;" onclick="Dq('screen','<?php echo $v['screen'];?>');"><?php echo $v['screen'];?></td>
<td><a href="javascript:;" onclick="Dq('bd','<?php echo $v['bd'];?>');"><?php echo $v['bd'];?></td>
<td data-hide-1200="1" title="<?php echo $v['ua'];?>"><input type="text" size="50" value="<?php echo $v['ua'];?>" onmouseover="this.select();"/></td>
<td><?php if($v['robot']) { ?><img src="<?php echo AJ_STATIC;?>file/image/robot_ico_<?php echo $v['robot'];?>.gif" title="<?php echo $L['robot'][$v['robot']];?>"/><?php } ?></td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="button" value="记录清理" class="btn-r" onclick="if(confirm('为了系统安全，系统仅删除1年之前的记录')){Go('?file=<?php echo $file;?>&action=clear_uv');}"/>&nbsp;
</div>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>