<?php
defined('AJ_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/webuploader.min.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/player.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/url2video.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellspacing="0" class="tb">
<?php if($history) { ?>
<tr>
<td class="tl" style="background:#FDE7E7;"><span class="f_red">*</span> 审核提示</td>
<td style="background:#FDE7E7;">该信息存在修改记录，<a href="javascript:Dwidget('?file=history&mid=<?php echo $moduleid;?>&itemid=<?php echo $itemid;?>', '修改详情');" class="t">点击查看</a> 修改详情</td>
</tr>
<?php } ?>
<tr>
<td class="tl"><span class="f_red">*</span> 所属分类</td>
<td><?php echo $_admin == 1 ? category_select('post[catid]', '选择分类', $catid, $moduleid) : ajax_category_select('post[catid]', '选择分类', $catid, $moduleid);?> <span id="dcatid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> <?php echo $MOD['name'];?>标题</td>
<td><input name="post[title]" type="text" id="title" size="70" value="<?php echo $title;?>"/> <?php echo level_select('post[level]', '级别', $level);?> <?php echo dstyle('post[style]', $style);?> <br/><span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 封面图片</td>
<td><input name="post[thumb]" id="thumb" type="text" size="70" value="<?php echo $thumb;?>" ondblclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value);"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span><span id="dthumb" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 视频地址</td>
<td><input name="post[video]" type="text" id="video" size="70" value="<?php echo $video;?>" onblur="UpdateURL();"/><?php if($MG['upload'] && check_group($_groupid, $MOD['group_upload'])) { ?>&nbsp;&nbsp;<span id="video-picker" class="jt">[上传]</span><?php } ?>&nbsp;&nbsp;<span onclick="vs();" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('video').value='';vh();$('#video-progress').html('');" class="jt">[删除]</span>&nbsp;&nbsp;<span id="video-progress" class="f_gray"></span> <span id="dvideo" class="f_red"></span>
<script type="text/javascript">
var filev = WebUploader.create({
auto: true,
    server: UPPath+'?moduleid=<?php echo $moduleid;?>&action=webuploader&from=file',
    pick: '#video-picker',
    accept: {
		title: 'video',
        extensions: '<?php echo str_replace('|', ',', $MOD['upload']);?>', 
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
</script>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 视频宽度</td>
<td><input name="post[width]" id="width" type="text" size="5" value="<?php echo $width;?>"/> px&nbsp;&nbsp;&nbsp;高度 <input name="post[height]" id="height" type="text" size="5" value="<?php echo $height;?>"/> px <span id="dsize" class="f_red"></span></td>
</tr>
<tr id="v_player" style="display:none;">
<td class="tl"><span class="f_hid">*</span> 视频预览</td>
<td><div id="v_play"></div><div style="padding-top:10px;"><a href="javascript:" onclick="vh();" class="t">[关闭预览]</a></div></td>
</tr>
<?php if($CP) { ?>
<script type="text/javascript">
var property_catid = <?php echo $catid;?>;
var property_itemid = <?php echo $itemid;?>;
var property_admin = 1;
</script>
<script type="text/javascript" src="<?php echo AJ_STATIC;?>file/script/property.js?v=<?php echo AJ_DEBUG ? AJ_TIME : AJ_REFRESH;?>"></script>
<tbody id="load_property" style="display:none;">
<tr><td></td><td></td></tr>
</tbody>
<?php } ?>
<?php echo $FD ? fields_html('<td class="tl">', '<td>', $item) : '';?>
<tr>
<td class="tl"><span class="f_hid">*</span> 视频说明</td>
<td><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $MOD['editor'], '98%', 350);?><br/><span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 视频系列</td>
<td><input name="post[album]" type="text" size="30" value="<?php echo $album;?>"/> <?php tips('填写一个视频的关键词或者系列名称，以便关联同系列的视频');?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 标签(Tag)</td>
<td><input name="post[tag]" type="text" size="70" value="<?php echo $tag;?>"/><?php tips('多个关键词请用空格隔开');?></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 会员名</td>
<td><input name="post[username]" type="text"  size="20" value="<?php echo $username;?>" id="username"/> <a href="javascript:_user(Dd('username').value);" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> <?php echo $MOD['name'];?>状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
<input type="radio" name="post[status]" value="1" <?php if($status == 1) echo 'checked';?> onclick="if(this.checked) Dd('note').style.display='';"/> 拒绝
<input type="radio" name="post[status]" value="0" <?php if($status == 0) echo 'checked';?>/> 删除
</td>
</tr>
<tr id="note" style="display:<?php echo $status==1 ? '' : 'none';?>">
<td class="tl"><span class="f_red">*</span> 拒绝理由</td>
<td><input name="post[note]" type="text"  size="40" value="<?php echo $note;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 添加时间</td>
<td><?php echo dcalendar('post[addtime]', $addtime, '-', 1);?></td>
</tr>
<?php if($AJ['city']) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 地区(分站)</td>
<td><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?></td>
</tr>
<?php } ?>
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
<td><input type="text" size="70" name="post[filepath]" value="<?php echo $filepath;?>" id="filepath"/>&nbsp;<input type="button" value="重名检测" onclick="ckpath(<?php echo $moduleid;?>, <?php echo $itemid;?>);" class="btn"/>&nbsp;<?php tips('可以包含目录和文件 例如 aijiacms/b2b.html<br/>请确保目录和文件名合法且可写入，否则可能生成失败');?>&nbsp; <span id="dfilepath" class="f_red"></span></td>
</tr>
<?php } ?>
</table>
<div class="sbt"><input type="submit" name="submit" value="<?php echo $action == 'edit' ? '修 改' : '添 加';?>" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="<?php echo $action == 'edit' ? '返 回' : '取 消';?>" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/></div>
</form>
<?php load('clear.js'); ?>
<?php if($action == 'add') { ?>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="tt">单页采编</div>
<table cellspacing="0" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 目标网址</td>
<td><input name="url" type="text" size="80" value="<?php echo $url;?>"/>&nbsp;&nbsp;<input type="submit" value=" 获 取 " class="btn"/>&nbsp;&nbsp;<input type="button" value=" 管理规则 " class="btn" onclick="Dwidget('?file=fetch', '管理规则');"/></td>
</tr>
</table>
</form>
<?php } ?>
<script type="text/javascript">
function check() {
	var l;
	var f;
	f = 'catid_1';
	if(Dd(f).value == 0) {
		Dmsg('请选择所属分类', 'catid', 1);
		return false;
	}
	f = 'title';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('请填写视频名称', f);
		return false;
	}
	f = 'thumb';
	l = Dd(f).value.length;
	if(l < 10) {
		Dmsg('请上传标题图片', f);
		return false;
	}
	UpdateURL();
	f = 'video';
	l = Dd(f).value.length;
	if(l < 10) {
		Dmsg('请填写视频地址', f);
		return false;
	}
	if(!Dd('width').value) {
		Dmsg('请填写视频宽度', 'size');
		return false;
	}
	if(!Dd('height').value) {
		Dmsg('请填写视频高度', 'size');
		return false;
	}
	<?php echo $FD ? fields_js() : '';?>
	<?php echo $CP ? property_js() : '';?>
	return true;
}
function vs() {
	UpdateURL();
	if(Dd('video').value.length > 5) {
		Ds('v_player');
		Inner('v_play', player(Dd('video').value,Dd('width').value,Dd('height').value,1));
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
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>