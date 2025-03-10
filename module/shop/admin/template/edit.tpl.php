<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/player.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/url2video.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script src="<?php echo AJ_SKIN;?>js/sea.js?v=3" type="text/javascript"></script>	
	<script>var AGENT_URL="<?php echo $MODULE[1]['linkurl'];?>api/";var JS_URL="";var IMG_URL="";</script>
<link href="<?php echo AJ_SKIN;?>user_jjr.css?v=3" rel="stylesheet" type="text/css" />
<link href="<?php echo AJ_SKIN;?>adminreset.css?v=3" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo AJ_SKIN;?>js/jquery-1.7.1.js"></script>  
<script type="text/javascript">
$(function(){

$("#address").blur(function(){
$.get("<?php echo $MODULE[1][linkurl];?>api/house.php?action=map&address="+$("#address").val()+"&areaid="+$("#areaid_1").val(),null,function(data)
{
$("#map").val(data); 
});
}) 
})
</script> 
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="post[mycatid]" value="<?php echo $mycatid;?>"/>
<input type="hidden" name="swf_upload" id="swf_upload"/>
<div class="tt"></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 来源</td>
<td>
<?php foreach($TYPE as $k=>$v) {?>
<input type="radio" name="post[typeid]" value="<?php echo $k;?>" <?php if($k==$typeid) echo 'checked';?> id="typeid_<?php echo $k;?>"/> <label for="typeid_<?php echo $k;?>" id="t_<?php echo $k;?>"><?php echo $v;?></label>&nbsp;
<?php } ?>
</td>
</tr>

    <tr>
<td  class="tl"><span class="f_red">*</span>信息类型</td>
<td >
<input type="radio" name="post[leibie]" value="1" <?php if($leibie == 1) echo "checked=checked";?>  onclick="if(this.checked) Dd('chuzu').style.display='';Dd('zongjia').style.display='none';Dd('transferfee').style.display='none';"> <label >出租</label>&nbsp;
<input type="radio" name="post[leibie]" value="2" <?php if($leibie == 2) echo 'checked=checked';?> onclick="if(this.checked) Dd('transferfee').style.display='';"> <label for="typeid_1" id="t_1">转让</label>&nbsp;
<input type="radio" name="post[leibie]" value="3" <?php if($leibie ==3) echo 'checked=checked';?> onclick="if(this.checked) Dd('zongjia').style.display='';Dd('chuzu').style.display='none';Dd('transferfee').style.display='none';"> <label for="typeid_2" id="t_2">出售</label>&nbsp;

</td>
</tr>
<tr>
<td class="tl" ><span class="f_red">*</span> <?php echo $MOD['name'];?>标题</td>
<td><input name="post[title]" type="text" id="title" size="60" value="<?php echo $title;?>"/> <?php echo level_select('post[level]', '级别', $level, 'id="level"');?>&nbsp;&nbsp;<br/><span id="dtitle" class="f_red"></span></td>
</tr>
 <tr  id="villagenamecon">
            <td class="tl"><span class="f_red">*</span>商铺名称：</td>
            <td><input type="text" class="txt" id="villagename" name="post[housename]" value="<?php echo $housename;?>"  >
					<input type="hidden" name="post[houseid]" id="cid" value="<?php echo $houseid;?>">
			<div id="autoVn"></div>
		<span class="gray9">请输入小区名称，如：“青园”或“qyxq”，然后在下面打开的列表中选择即可。</span>
						       
							
									</td>
          </tr>
		  <tr>
<td class="tl"><span class="f_red">*</span> 区域</td>
<td><div id="catesch"></div><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?> 地址: <input name="post[address]" value="<?php echo $address;?>" id="address" type="text"><span id="dareaid" class="f_red"></span></td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span>商铺类型</td>
<td><div id="catesch"></div><?php echo category_select('post[catid]', '选择类型', $catid, $moduleid);?><span id="dcatid" class="f_red"></span></td>
</tr>

<?php if($CP) { ?>
<script type="text/javascript">
var property_catid = <?php echo $catid;?>;
var property_itemid = <?php echo $itemid;?>;
var property_admin = 1;
</script>
<script type="text/javascript" src="<?php echo AJ_PATH;?>file/script/property.js"></script>
<?php if($itemid) { ?><script type="text/javascript">setTimeout("load_property()", 1000);</script><?php } ?>
<tbody id="load_property" style="display:none;">
<tr><td></td><td></td></tr>
</tbody>
<?php } ?>

<tr>
<td class="tl">  当前状态</td>
<td><select class="select" name="post[shopstate]">
																		 						 <option value="1" <?php if($shopstate == 1) echo 'selected';?>>营业中</option>
						 												 						 <option value="2" <?php if($shopstate == 2) echo 'selected';?>>闲置中</option>
						 												 						 <option value="3" <?php if($shopstate == 3) echo 'selected';?>>新铺</option>
						 												 						
						 												 </select> </td>
</tr>
	<tr>
	<td class="tl">  建筑建面</td>
	<td><input name="post[houseearm]" type="text" size="10" value="<?php echo $houseearm;?>"/>平方米</td>
	</tr>
	<tr>
	<td class="tl">  楼    层</td>
	<td>第
  <input class="input" name="post[floor1]" type="text" size="1" value="<?php echo $floor1;?>"   /> 层 /
	  共<input class="input" name="post[floor2]" type="text" size="1" value="<?php echo $floor2;?>" valid="required|isInt" errmsg="请输入楼层总数!|请输入整数！" /> 层</td>
	</tr>
    <tr>
	<tr>
	<td class="tl">  面宽</td>
	 <td>
                                    <span>
                                        <input name="post[facewidth]" type="text" class="txt" value="<?php echo $facewidth;?>" id="facewidth" style="width: 50px;" maxlength="10" />
                                        <span class="mlr10 font14 gray6">米</span>
                                    </span>
                                    <span class="ml10"><strong>进深</strong></span>
                                    <span>
                                        <input name="post[depth]" type="text" class="txt"  value="<?php echo $depth;?>" id="depth" style="width: 50px;" maxlength="10" />
                                        <span class="mlr10 font14 gray6">米</span>
                                    </span>
                                    <span class="ml10"><strong>层高</strong></span>
                                    <span>
                                        <input name="post[floorheight]" type="text" class="txt"  value="<?php echo $floorheight;?>" id="floorheight" style="width: 50px;" maxlength="10" />
                                        <span class="mlr10 font14 gray6">米</span>
                                    </span>
                                    <span class="tishi_tanhao" id="sp_miankuan"></span>
                                </td>
	</tr>
	<tr>
	<td class="tl">  是否可分割</td>
	     <td>
                                            <input id="radio_fenge_sp_id_0" type="radio" name="post[fenge]" value="可分割"  <?php if($fenge == "可分割") echo 'checked="checked"';?>"  />
                                            <label for="radio_fenge_sp_id_0">可分割</label>
                                       
                                            <input id="radio_fenge_sp_id_1" type="radio" name="post[fenge]" value="不可分割"  <?php if($fenge == "不可分割") echo 'checked="checked"';?>" />
                                            <label for="radio_fenge_sp_id_1">不可分割</label>
                                        </td>
	</tr>
    <tr>
	<td class="tl">  装修程度</td>
	<td><select name="post[fitment]" id="{$k}">
    <option value="精装修"  selected=<?php if($fitment == '精装修') echo 'selected';?>>精装修</option>
    <option value="简装修" <?php if($fitment == '简装修') echo 'selected';?>>简装修</option>
     <option value="毛坯" <?php if($fitment == '毛坯') echo 'selected';?>>毛坯</option>
	
  </select>			</td>
	</tr>

	
</td>
</tr>

    <tr id="chuzu" style="display:<?php echo $leibie==1 ? '' : 'none';?>">
      <td class="tl">  租金</td>
      <td><input name="post[price]" type="text" size="10" value="<?php echo $price;?>"/><select name="post[paytype]" id="{$k}">
       
        <option value="1"  <?php if($paytype == 1) echo 'selected="selected"';?>>元/平米·天</option>
        <!-- <option value="2"  <?php if($paytype == 2) echo 'selected="selected"';?>>元/平米·月</option>-->
          <option value="3"  <?php if($paytype == 3) echo 'selected="selected"';?>>元/月</option>
        
        </select>	</td>
      </tr>
      
       <tr id="zongjia" style="display:<?php echo $leibie==3 ? '' : 'none';?>">
      <td class="tl">  总价</td>
      <td><input name="post[zongjia]" type="text" size="10" value="<?php echo $zongjia;?>"/>万元/套</td>
      </tr>
    <tr id="transferfee" style="display:<?php echo $leibie==2 ? '' : 'none';?>">
      <td class="tl">  转让费</td>
      <td><input name="post[transferfee]" type="text" size="10" value="<?php echo $transferfee;?>"/></td>
      </tr>
    <tr>
      <tr>
        <td class="tl">  是否含物业费</td>
        <td>
          <input value="是" name="post[wuye]" type="radio" id="wuye_xz" <?php if($wuye == "是") echo 'checked="checked"';?>"  />
          是
          <input value="否" name="post[wuye]" type="radio" id="nowuye_xz" <?php if($wuye == "否") echo 'checked="checked"';?>" />
          否
          </td>
        </tr>
    <tr>
      <td class="tl">  物 业 费</td>
      <td> <input name="post[wuyefei]" type="text" id="inputWuYeFee" size="10"  value="<?php echo $wuyefei;?>" maxlength="6" num="价格只能是数字" class="txt" value="0" onblur="Common.checkNum(this)" />
        <span class="mlr10 font14 gray6">元/平米/月</span> <span id="spWuYeFee" class="tishi_tanhao"></span>
        </td>
      </tr>
    <tr>
      <td class="tl">  支付方式</td>
      <td><select name="post[payinfo]" id="{$k}">
         <option value="面议"  selected=<?php if($payinfo == "面议") echo 'selected';?>>面议</option>
         <option value="月付"  selected=<?php if($payinfo == "月付") echo 'selected';?>>月付</option>
         <option value="季付"  selected=<?php if($payinfo == "季付") echo 'selected';?>>季付</option>
         <option value="半年付"  selected=<?php if($payinfo == "半年付") echo 'selected';?>>半年付</option>
         <option value="年付"  selected=<?php if($payinfo == "年付") echo 'selected';?>>年付</option> 
        </select>			</td>
      </tr>
    <tr>
      <td  class="tl">  免租期</td>
      <td><input name="post[freetime]" type="text" size="10" value="<?php echo $freetime;?>"/>月	</td>
      </tr>
    <tr>
      <td class="tl">  起租期</td>
      <td><input name="post[leasetime]" type="text" size="10" value="<?php echo $leasetime;?>"/>月	</td>
      </tr>
    
   
</td>
</tr>
<?php echo $FD ? fields_html('<td class="tl">', '<td>', $item) : '';?>
<tr>
<td class="tl"><span class="f_hid">*</span> 详细说明</td>
<td><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $MOD['editor'], '100%', 350);?><br/><span id="dcontent" class="f_red"></span>
</td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 交通状况</td>
<td><input id="bus" type="text" class="input" name="post[bus]"  size="50" value="<?php echo $bus;?>" />			
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 地图标注</td>
<td>
<?php echo include AJ_ROOT.'/api/map/'.$AJ['map'].'/post.inc.php';?>
 </td>
 <script src="<?php echo $MODULE[2]['linkurl'];?>plugins/layui/layui.js"></script>
<script src="<?php echo $MODULE[2]['linkurl'];?>build/js/app.js"></script>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 联系人</td>
<td class="tr"><input name="post[truename]" type="text" id="truename" size="20" value="<?php echo $truename;?>" /> <span id="dtruename" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 联系手机</td>
<td class="tr"><input name="post[mobile]" id="mobile" type="text" size="30" value="<?php echo $mobile;?>"/> <span id="dmobile" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 电子邮件</td>
<td class="tr"><input name="post[email]" id="email" type="text" size="30" value="<?php echo $email;?>" /> <span id="demail" class="f_red"></span></td>
</tr>
  <tr>
<td class="tl"><span class="f_hid">*</span> 房源图片</td>
<td>
<div id="thumbs">
<?php if(is_array($thumbs)) { foreach($thumbs as $k => $v) { ?>
<div class="thumbs">
<input type="hidden" name="post[thumbs][]" id="thumb<?php echo $k;?>" value="<?php echo $v;?>"/>
<div><img src="<?php if($v) { ?><?php echo $v;?><?php } else { ?><?php echo AJ_SKIN;?>image/waitpic.gif<?php } ?>" width="100" height="100" id="showthumb<?php echo $k;?>" title="上传/预览图片" alt="" onerror="this.src='<?php echo AJ_SKIN;?>image/waitpic.gif';" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb<?php echo $k;?>').src, 1);}else{Dalbum(<?php echo $k;?>,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb<?php echo $k;?>').value, true);}"/></div>
<p><img src="<?php echo AJ_STATIC;?>file/image/ico-upl.png" width="11" height="11" title="上传" onclick="Dalbum(<?php echo $k;?>,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb<?php echo $k;?>').value, true);"/><img src="<?php echo AJ_STATIC;?>file/image/ico-sel.png" width="11" height="11" title="选择" onclick="selAlbum(<?php echo $k;?>);" style="margin:0 11px;"/><img src="<?php echo AJ_STATIC;?>file/image/ico-del.png" width="11" height="11" title="删除" onclick="delAlbum(<?php echo $k;?>,'wait');"/></p>
</div>
<?php } } ?>
</div>
<div class="dsn" id="thumbtpl">
<div class="thumbs">
<input type="hidden" name="post[thumbs][]" id="thumb-99" value=""/>
<div><img src="<?php echo AJ_SKIN;?>image/waitpic.gif" width="100" height="100" id="showthumb-99" title="上传/预览图片" alt="" onclick="if(this.src.indexOf('waitpic.gif') == -1){_preview(Dd('showthumb-99').src, 1);}else{Dalbum(-99,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb-99').value, true);}"/></div>
<p><img src="<?php echo AJ_STATIC;?>file/image/ico-upl.png" width="11" height="11" title="上传" onclick="Dalbum(-99,<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb<?php echo $thumbs ? $k : '0';?>').value, true);"/><img src="<?php echo AJ_STATIC;?>file/image/ico-sel.png" width="11" height="11" title="选择" onclick="selAlbum(-99);" style="margin:0 11px;"/><img src="<?php echo AJ_STATIC;?>file/image/ico-del.png" width="11" height="11" title="删除" onclick="delAlbum(-99,'wait');"/></p>
</div>
</div>
<div class="thumbs" id="thumbmuti" title="批量上传图片，按Ctrl键多选">
<div id="file-picker"><img src="<?php echo AJ_STATIC;?>file/image/addpic.gif" width="100" height="100" alt=""/></div>
<p>批量上传<span id="file-progress"></span></p>
</div>
<span id="dthumb" class="f_red"></span>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/webuploader.min.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript">
var album_max = parseInt(<?php echo $AJ['thumb_max'];?>);
if(album_max < 5 || album_max > 99) album_max = 9;
var fileu = WebUploader.create({
    auto: true,
    server: UPPath+'?moduleid=<?php echo $moduleid;?>&action=webuploader&from=album&width=<?php echo $MOD['thumb_width'];?>&height=<?php echo $MOD['thumb_height'];?>',
    pick: '#file-picker',
    accept: {
        title: 'image',
        extensions: 'jpg,jpeg,png,gif', 
        mimeTypes: 'image/*'
    },
    resize: false
});
fileu.on('fileQueued', function(file) {
    $('#file-progress').html('0%');
});
fileu.on('uploadProgress', function(file, percentage) {
var p = parseInt(percentage * 100);
if(p >= 100) p = 100;
$('#file-progress').html(p+'%');
});
fileu.on( 'uploadSuccess', function(file, data) {
if(data.error) {
Dmsg(data.message, 'thumb');
} else {
addAlbum(data.url);
}
});
fileu.on( 'uploadError', function(file, data) {
    Dmsg(data.message, 'thumb');
});
fileu.on('uploadFinished', function(file) {
    $('#file-progress').html('');
if($("#thumbs input[value!='']").length >= album_max) $('#thumbmuti').hide();
});
function addAlbum(url) {
for(var i = 0; i < album_max; i++) {
if($('#thumb'+i).length) {
if($('#thumb'+i).val() == '') {
$('#thumb'+i).val(url);
$('#showthumb'+i).attr('src', url);
return;
}
} else {
$('#thumbs').append($('#thumbtpl').html().replace(/-99/g, i));
$('#thumb'+i).val(url);
$('#showthumb'+i).attr('src', url);
return;
}
}
Dmsg('最多上传'+album_max+'张图片', 'thumb');
$('#thumbmuti').hide();
}
$(function(){
if($("#thumbs input[value!='']").length >= album_max) window.setTimeout(function(){$('#thumbmuti').hide();}, 3000);
});
</script>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 宣传视频</td>
<td><input name="post[video]" type="text" id="video" size="70" value="<?php echo $video;?>" onblur="UpdateURL();"/>&nbsp;&nbsp;<span id="video-picker" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="vs();" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('video').value='';vh();$('#video-progress').html('');" class="jt">[删除]</span>&nbsp;&nbsp;<span id="video-progress" class="f_gray"></span> <span id="dvideo" class="f_red"></span>
<script type="text/javascript">
$(function(){
	var filev = WebUploader.create({
	auto: true,
		server: UPPath+'?moduleid=<?php echo $moduleid;?>&action=webuploader&from=file',
		pick: '#video-picker',
		accept: {
			title: 'video',
			extensions: 'mp4', 
			mimeTypes: 'video/*'
		},
		resize: false
	});
	filev.on('fileQueued', function(file) {
		$('#video-progress').html('0%');
	});
	filev.on('uploadProgress', function(file, percentage) {
	var p = parseInt(percentage * 100);
	if(p >= 100) p = 100;
		$('#video-progress').html(p+'%');
	});
	filev.on( 'uploadSuccess', function(file, data) {
	if(data.error) {
		Dmsg(data.message, 'video');
	} else {
		$('#video-progress').html('100%');
		$('#video').val(data.url);
	}
	});
	filev.on( 'uploadError', function(file, data) {
		Dmsg(data.message, 'video');
	});
	filev.on('uploadComplete', function(file) {
		$('#video-progress').html('100%');
	});
});
function vs() {
	UpdateURL();
	if(Dd('video').value.length > 5) {
		Ds('v_player');
		Inner('v_play', player(Dd('video').value,400,300,1));
	} else {
		Dmsg('视频地址为空', 'video');
		vh();
	}
}
function vh() {Inner('v_play', '');Dh('v_player');}
function UpdateURL() {
	var str = url2video(Dd('video').value);
	if(str) Dd('video').value = str;
}
</script>
</td>
</tr>
<tr id="v_player" style="display:none;">
<td class="tl"><span class="f_hid">*</span> 视频预览</td>
<td><div id="v_play"></div><div style="padding-top:10px;"><a href="javascript:" onclick="vh();" class="t">[关闭预览]</a></div></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 过期时间</td>
<td><?php echo dcalendar('post[totime]', $totime, '-', 1);?>&nbsp;
<select onchange="Dd('posttotime').value=this.value;">
<option value="">快捷选择</option>
<option value="">长期有效</option>
<option value="<?php echo timetodate($AJ_TIME+86400*3, 3);?> 23:59:59">3天</option>
<option value="<?php echo timetodate($AJ_TIME+86400*7, 3);?> 23:59:59">一周</option>
<option value="<?php echo timetodate($AJ_TIME+86400*15, 3);?> 23:59:59">半月</option>
<option value="<?php echo timetodate($AJ_TIME+86400*30, 3);?> 23:59:59">一月</option>
<option value="<?php echo timetodate($AJ_TIME+86400*182, 3);?> 23:59:59">半年</option>
<option value="<?php echo timetodate($AJ_TIME+86400*365, 3);?> 23:59:59">一年</option>
</select>&nbsp;
<span id="dposttotime" class="f_red"></span> 不选表示长期有效</td>
</tr>


<tbody id="d_member" style="display:<?php echo $username ? '' : 'none';?>">
<tr>
<td class="tl"><span class="f_red">*</span> 会员名</td>
<td><input name="post[username]" type="text"  size="20" value="<?php echo $username;?>" id="username"/> <a href="javascript:_user(Dd('username').value);" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 会员推荐房源</td>
<td>
<input type="radio" name="post[elite]" value="1" <?php if($elite == 1) echo 'checked';?>/> 是&nbsp;&nbsp;&nbsp;
<input type="radio" name="post[elite]" value="0" <?php if($elite == 0) echo 'checked';?>/> 否
</td>
</tr>
</tbody>

<tr>
<td class="tl"><span class="f_hid">*</span> 信息状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
<input type="radio" name="post[status]" value="1" <?php if($status == 1) echo 'checked';?> onclick="if(this.checked) Dd('note').style.display='';"/> 拒绝
<input type="radio" name="post[status]" value="4" <?php if($status == 4) echo 'checked';?>/> 过期
<input type="radio" name="post[status]" value="0" <?php if($status == 0) echo 'checked';?>/> 删除
</td>
</tr>
<tr id="note" style="display:<?php echo $status==1 ? '' : 'none';?>">
<td class="tl"><span class="f_red">*</span> 拒绝理由</td>
<td><input name="post[note]" type="text"  size="40" value="<?php echo $note;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 添加时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 浏览次数</td>
<td><input name="post[hits]" type="text" size="10" value="<?php echo $hits;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 内容收费</td>
<td><input name="post[fee]" type="text" size="5" value="<?php echo $fee;?>"/><?php tips('不填或填0表示继承模块设置价格，-1表示不收费<br/>大于0的数字表示具体收费价格');?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 内容模板</td>
<td><?php echo tpl_select('show', $module, 'post[template]', '默认模板', $template, 'id="template"');?><?php tips('如果没有特殊需要，一般不需要选择<br/>系统会自动继承分类或模块设置');?></td>
</tr>
<?php if($MOD['show_html']) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 自定义文件路径</td>
<td><input type="text" size="50" name="post[filepath]" value="<?php echo $filepath;?>" id="filepath"/>&nbsp;<input type="button" value="重名检测" onclick="ckpath(<?php echo $moduleid;?>, <?php echo $itemid;?>);" class="btn"/>&nbsp;<?php tips('可以包含目录和文件 例如 aijiacms/house.html<br/>请确保目录和文件名合法且可写入，否则可能生成失败');?>&nbsp; <span id="dfilepath" class="f_red"></span></td>
</tr>
<?php } ?>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<?php if($action == 'add') { ?>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="tt">单页采编</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 目标网址</td>
<td><input name="url" type="text" size="80" value="<?php echo $url;?>"/>&nbsp;&nbsp;<input type="submit" value=" 获 取 " class="btn"/>&nbsp;&nbsp;<input type="button" value=" 管理规则 " class="btn" onclick="window.open('?file=fetch');"/></td>
</tr>
</table>
</form>
<?php } ?>
<script type="text/javascript">
function _p() {
	if(Dd('tag').value) {
		Ds('reccate');
	}
}
function check() {
	f = 'titles';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('标题最少2字，当前已输入'+l+'字', f);
		return false;
	}
	f = 'content';
		l = Dd(f).value.length;
		if(l < 5) {
			Dmsg('内容最少5字，当前已输入'+l+'字', f);
			return false;
		}
	f = 'thumb';
		l = Dd(f).value.length;
		if(l < 5) {
			Dmsg('请上传图片', f);
			return false;
		}	
	var l;
	var f;
	f = 'catid_1';
	if(Dd(f).value == 0) {
		Dmsg('请选择所属类型', 'catid', 1);
		return false;
	}
	
	if(Dd('areaid_1').value == 0) {
			Dmsg('请选择所在地区', 'areaid', 1);
			return false;
		}
	if(Dd('ismember_1').checked) {
		f = 'username';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写会员名', f);
			return false;
		}
	} else {
		f = 'company';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写公司名称', f);
			return false;
		}
		
		f = 'truename';
		l = Dd(f).value.length;
		if(l < 2) {
			Dmsg('请填写联系人', f);
			return false;
		}
		f = 'mobile';
		l = Dd(f).value.length;
		if(l < 7) {
			Dmsg('请填写手机', f);
			return false;
		}
	}
		<?php echo $FD ? fields_js() : '';?>
	<?php echo $CP ? property_js() : '';?>
	if(Dd('property_require') != null) {
		var ptrs = Dd('property_require').getElementsByTagName('option');
		for(var i = 0; i < ptrs.length; i++) {		
			f = 'property-'+ptrs[i].value;
			if(Dd(f).value == 0 || Dd(f).value == '') {
				Dmsg('请填写或选择'+ptrs[i].innerHTML, f);
				return false;
			}
		}
	}
	return true;
}
</script>


<script type="text/javascript">
seajs.use("jjrfbcon",function(fb){
	fb.init("esf",{
  autoc:AGENT_URL + "house.php?action=xq",
  

	});
})
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>