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
<input type="text" name="ip" value="<?php echo $ip;?>" size="10" title="IP" placeholder="IP"/>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" placeholder="条/页" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '-', 1);?> 至 <?php echo dcalendar('todate', $todate, '-', 1);?>&nbsp;
<select name="robot">
<option value="">搜索引擎</option>
<option value="all"<?php echo $robot == 'all' ? ' selected' : '';?>>全部</option>
<?php
foreach($L['robot'] as $k=>$v) {
?>
<option value="<?php echo $k;?>" <?php echo $k == $robot ? ' selected' : '';?>><?php echo $v;?></option>
<?php
}
?>
</select>&nbsp;
<select name="pc">
<option value="-1">设备</option>
<option value="1"<?php echo $pc == 1 ? ' selected' : '';?>>电脑</option>
<option value="0"<?php echo $pc == 0 ? ' selected' : '';?>>手机</option>
</select>&nbsp;
</td>
</tr>
</table>
</form>
<table cellspacing="0" class="tb ls">
<tr>
<th width="25"></th>
<th width="150">时间</th>
<th>网址</th>
<th data-hide-1200="1" data-hide-1400="1">来源</th>
<th>设备</th>
<th>操作系统</th>
<th>浏览器</th>
<th>IP</th>
<th>归属地</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td>
<?php if($v['robot']) { ?>
<a href="javascript:;" onclick="Dq('robot','<?php echo $v['robot'];?>');"><img src="<?php echo AJ_STATIC;?>file/image/robot_ico_<?php echo $v['robot'];?>.gif" title="<?php echo $L['robot'][$v['robot']];?>"/></a>
<?php } else { ?>
&nbsp;
<?php } ?>
</td>
<td><a href="javascript:;" onclick="Dq('date',this.innerHTML);"><?php echo $v['addtime'];?></a></td>
<td title="<?php echo $v['url'];?>"><input type="text" size="50" value="<?php echo $v['url'];?>"/> <a href="<?php echo $v['url'];?>" target="_blank"><img src="admin/image/link.png" width="16" height="16" title="点击打开网址" alt="" align="absmiddle"/></a></td>
<td data-hide-1200="1" data-hide-1400="1" title="<?php echo $v['refer'];?>"><input type="text" size="25" value="<?php echo $v['refer'];?>"/> <a href="<?php echo $v['refer'] ? $v['refer'] : '###';?>"<?php echo $v['refer'] ? ' target="_blank"' : '';?>><img src="admin/image/link.png" width="16" height="16" title="点击打开网址" alt="" align="absmiddle"/></a></td>
<td><a href="javascript:;" onclick="Dq('pc','<?php echo $v['pc'];?>');" title="<?php echo $v['ua'];?>"><?php echo $v['pc'] ? '电脑' : '手机';?></a></td>
<td><a href="javascript:;" onclick="Dq('os','<?php echo $v['os'];?>');"><?php echo $v['os'];?></a></td>
<td><a href="javascript:;" onclick="Dq('bs','<?php echo $v['bs'];?>');"><?php echo $v['bs'];?></a></td>
<td><a href="javascript:;" onclick="Dq('ip','<?php echo $v['ip'];?>');"><?php echo $v['ip'];?></a></td>
<td title="<?php echo $v['area'];?>"><input type="text" size="15" value="<?php echo $v['area'];?>"/></td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="button" value="日志清理" class="btn-r" onclick="if(confirm('为了系统安全，系统仅删除30天之前的日志')){Go('?file=<?php echo $file;?>&action=clear');}"/>&nbsp;
</div>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(5);</script>
<?php include tpl('footer');?>