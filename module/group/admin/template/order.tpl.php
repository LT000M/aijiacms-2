<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<script type="text/javascript">var errimg = '<?php echo AJ_SKIN;?>image/nopic50.gif';</script>
<form action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
<table cellspacing="0" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词"/>&nbsp;
<?php echo $status_select;?>&nbsp;
<?php echo $order_select;?>&nbsp;
<select name="logistic">
<option value="-1">快递</option>
<option value="0" <?php if($logistic == 0) echo 'selected';?>>不需要</option>
<option value="1" <?php if($logistic == 1) echo 'selected';?>>需要</option>
</select>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&id=<?php echo $id;?>');"/>
</td>
</tr>
<?php if(!$id) { ?>
<tr>
<td>&nbsp;
<select name="timetype">
<option value="addtime" <?php if($timetype == 'addtime') echo 'selected';?>>下单时间</option>
<option value="updatetime" <?php if($timetype == 'updatetime') echo 'selected';?>>更新时间</option>
</select>&nbsp;
<?php echo dcalendar('fromdate', $fromdate);?> 至 <?php echo dcalendar('todate', $todate);?>&nbsp;
<select name="mtype">
<option value="money" <?php if($mtype == 'money') echo 'selected';?>>交易总额</option>
<option value="amount" <?php if($mtype == 'amount') echo 'selected';?>>下单金额</option>
<option value="price" <?php if($mtype == 'price') echo 'selected';?>>商品单价</option>
<option value="number" <?php if($mtype == 'number') echo 'selected';?>>购买数量</option>
</select>&nbsp;
<input type="text" name="minamount" value="<?php echo $minamount;?>" size="5"/> 至 
<input type="text" name="maxamount" value="<?php echo $maxamount;?>" size="5"/>&nbsp;
</td>
</tr>
<tr>
<td>&nbsp;
订单单号：<input type="text" name="itemid" value="<?php echo $itemid;?>" size="10"/>&nbsp;
商品单号：<input type="text" name="gid" value="<?php echo $gid;?>" size="10"/>&nbsp;
卖家：<input type="text" name="seller" value="<?php echo $seller;?>" size="10"/>&nbsp;
买家：<input type="text" name="buyer" value="<?php echo $buyer;?>" size="10"/>&nbsp;
</td>
</tr>
<?php } ?>
</table>
</form>
<form method="post">
<table cellspacing="0" class="tb ls">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>

<th>团购标题</th>


<th>用户名</th>
<th>姓名</th>
<th>电话号码</th>
<th width="75">下单时间</th>
<th width="75">更新时间</th>


</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>

<td align="left" class="f_gray">
&nbsp;
<a href="<?php echo $v['linkurl'];?>" target="_blank" class="t px14 f_b"><?php echo $v['title'];?></a><br/>&nbsp;
<strong>单号：</strong><?php echo $v['itemid'];?>&nbsp;

</td>



<td class="px12">
<a href="javascript:_user('<?php echo $v['buyer'];?>');"><?php echo $v['buyer'];?></a>
</td>
<td class="px12"><?php echo $v['buyer_name'];?></td>
<td class="px12"><?php echo $v['buyer_mobile'];?></td>
<td class="px12"><?php echo $v['addtime'];?></td>
<td class="px12"><?php echo $v['updatetime'];?></td>

<td>



</td>
</tr>
<?php }?>
<tr align="center">
<td></td>
<td><strong>小计</strong></td>
<td></td>
<td class="f_red f_b"><?php echo $money;?></td>
<td colspan="7">&nbsp;</td>
</tr>
</table>
<div class="btns">
<input type="submit" value="批量删除" class="btn-r" onclick="if(confirm('确定要删除选中记录吗？请谨慎!此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>
</div>
</form>
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>