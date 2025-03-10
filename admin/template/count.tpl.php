<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$itemid) show_menu($menus);
?>
<table cellspacing="0" class="tb">
<tr>
<td class="tl"><a href="?moduleid=2&file=charge&status=0">待受理在线充值</a></td>
<td>&nbsp;<a href="?moduleid=2&file=charge&status=0"><span id="charge"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=cash&status=0">待受理资金提现</a></td>
<td>&nbsp;<a href="?moduleid=2&file=cash&status=0"><span id="cash"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?file=keyword&status=2">待审核搜索关键词</a></td>
<td>&nbsp;<a href="?file=keyword&status=2"><span id="keyword"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=3&file=guestbook">待回复网站留言</a></td>
<td>&nbsp;<a href="?moduleid=3&file=guestbook"><span id="guestbook"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td class="tl"><a href="?moduleid=2&file=validate&action=member">待审核资料修改</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=member"><span id="edit_check"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=ask&status=0">待受理客服中心</a></td>
<td>&nbsp;<a href="?moduleid=2&file=ask&status=0"><span id="ask"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=alert&action=check">待审核房源提醒</a></td>
<td>&nbsp;<a href="?moduleid=2&file=alert&action=check"><span id="alert"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=3&file=gift&action=order&fields=3&kw=%E5%A4%84%E7%90%86%E4%B8%AD">待处理礼品订单</a></td>
<td>&nbsp;<a href="?moduleid=3&file=gift&action=order&fields=3&kw=%E5%A4%84%E7%90%86%E4%B8%AD"><span id="gift"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td class="tl"><a href="?moduleid=2&file=news&action=check">待审核公司新闻</a></td>
<td>&nbsp;<a href="?moduleid=2&file=news&action=check"><span id="news"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=honor&action=check">待审核荣誉资质</a></td>
<td>&nbsp;<a href="?moduleid=2&file=honor&action=check"><span id="honor"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=page&action=check">待审核公司单页</a></td>
<td>&nbsp;<a href="?moduleid=2&file=page&action=check"><span id="page"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=link&action=check">待审核公司链接</a></td>
<td>&nbsp;<a href="?moduleid=2&file=link&action=check"><span id="comlink"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<tr>
<td class="tl"><a href="?moduleid=2&file=validate&action=company&status=2">待审核公司认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=company&status=2"><span id="vcompany"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=validate&action=truename&status=2">待审核实名认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=truename&status=2"><span id="vtruename"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=validate&action=mobile&status=2">待审核手机认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=mobile&status=2"><span id="vmobile"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=validate&action=email&status=2">待审核邮件认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=email&status=2"><span id="vemail"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>



<tr>
<td class="tl"><a href="?moduleid=3&file=ad&action=list&job=check">待审核广告购买</a></td>
<td>&nbsp;<a href="?moduleid=3&file=ad&action=list&job=check"><span id="ad"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=3&file=spread&action=check">待审核排名推广</a></td>
<td>&nbsp;<a href="?moduleid=3&file=spread&action=check"><span id="spread"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=3&file=comment&action=check">待审核评论</a></td>
<td>&nbsp;<a href="?moduleid=3&file=comment&action=check"><span id="comment"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=3&file=link&action=check">待审核友情链接</a></td>
<td>&nbsp;<a href="?moduleid=3&file=link&action=check"><span id="link"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td class="tl"><a href="?moduleid=2">会员</a></td>
<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=grade&action=check">会员升级</a></td>
<td width="10%">&nbsp;<a href="?moduleid=2&file=grade&action=check"><span id="member_upgrade"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&action=check">待审核</a></td>
<td width="10%">&nbsp;<a href="?moduleid=2&action=check"><span id="member_check"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&action=add">今日新增</a></td>
<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member_new"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<?php
foreach ($MODULE as $m) {
	if($m['moduleid'] < 5 || $m['islink']) continue;
?>
<tr>
<td class="tl"><a href="<?php echo $m['linkurl'];?>" target="_blank"><?php echo $m['name'];?></a></td>
<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>">已发布</a></td>
<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_1"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=check">待审核</a></td>
<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&action=check"><span id="m_<?php echo $m['moduleid'];?>_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=add">今日新增</a></td>
<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_3"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<?php } ?>
</table>
<script type="text/javascript">Menuon(0);</script>
<script type="text/javascript" src="?file=<?php echo $file;?>&action=js"></script>
<?php include tpl('footer');?>