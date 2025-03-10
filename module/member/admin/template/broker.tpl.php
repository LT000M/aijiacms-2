<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');

?>
<div class="sbox">
<form action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>



<input type="text" size="30" name="kw" value="<?php echo $kw;?>" placeholder="请输入用户名" title="请输入用户名"/>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
</form>
</div>
<form method="post" action="?" id="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>

<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellspacing="0" class="tb ls">
<?php if($lists) { ?>
<tr>
<th width="30">头像</th>
<th>姓名</th>
<th >公司 </th>
<th>会员</th>
<th width="130">在线</th>
<th>选择</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td><img src="<?php echo useravatar($v['username'], 'small');?>" width="20" height="20"/></td>
<td><a href="<?php echo userurl($v['username']);?>" target="_blank"><?php echo $v['truename'];?></a></td>

<td align="left">&nbsp;<a href="<?php echo userurl($v['username']);?>" target="_blank"><?php echo $v['company'];?></a></td>
<td class="px12"><?php echo $v['username'];?></td>
<td class="px12"><?php echo im_web($v['username']);?></td>
<td class="px12"><a href="?moduleid=2&file=subscribe&action=choosebroker&itemid=<?php echo $itemid;?>&username=<?php echo $v['username'];?>" onclick="return _index();">[选择]</a></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td colspan="6" class="f_red">&nbsp;&nbsp;没有找到可用的信息，请重新筛选</td>
</tr>
<?php } ?>
<tr>

</tr>
</table>
</form>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>