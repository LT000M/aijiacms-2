
<?php
defined('AJ_ADMIN') or exit('Access Denied');

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>管理中心</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="admin/layui/lib/layui-v2.5.4/css/layui.css">
  
    <script src="admin/layui/lib/layui-v2.5.4/layui.js"></script>
    <style>
        .subnav{padding:5px 15px;}
        .layui-form-item label em{display:none;}
    </style>
</head>

<body class="body">
<div class="subnav">
        <div class="content_menu ib_a blue line_x">
    	    	<a class="layui-btn J_showDialog" href="javascript:void(0);" data-uri="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=addhouse&house_id=<?php echo $houseid;?>" data-title="添加楼栋" data-id="add" data-width="500" data-show_btn="1" data-height="500">添加楼栋</a>
                        <a href="?moduleid=6" class="layui-btn-xs ">楼盘列表</a>
                    </div>
    </div>
<div class="layui-fluid">

<!--沙盘列表-->
<link rel="stylesheet" href="admin/static/manage/css/shapan.css">
<style>
    #shapan{height:400px;position:relative;width:100%;overflow:scroll;z-index:10;}
    *,
    *:before,
    *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .container{width:100%;}
    .col-50{width:50%;overflow-y: auto;}
    .layui-fl{float:left;}
    .layui-fr{float:right;}
</style>
<div class="container list-table" data-uri="" style="padding-top:10px;">
    <div class="col-50 layui-fl">
        <div class="layui-form layui-border-box layui-table-view"  style="margin:0;">
            <table id="tree-table" class="layui-table list-table" cellspacing="0" cellpadding="0" border="0" data-uri="">
                <colgroup>
                    <col width="40%">
                    <col width="10%">
                  
                    <col width="10%">
                    <col width="40%">
                </colgroup>
                <thead>
                <tr>
                    <th>
                        <div class="layui-table-cell"><span>楼栋名称</span></div>
                    </th>
                    <th>
                        <div class="layui-table-cell"><span>楼层数</span></div>
                    </th>
                    <th>
                        <div class="layui-table-cell"><span>销售状态</span></div>
                    </th>
                   
                    <th>
                        <div class="layui-table-cell" align="center"><span>操作</span></div>
                    </th>

                </tr>
                </thead>
                <tbody>
                
              <?php foreach($shapanlist as $k=>$v) { ?>
                
                                <tr>
                    <td>
                        <div class="layui-table-cell">
                            <?php echo $v['title'];?>                        </div>
                    </td>
                    <td data-field="title">
                        <div class="layui-table-cell">
                         <?php echo $v['floor_num'];?>  
                                                    </div>
                    </td>

                    <td>
                        <div class="layui-table-cell">
                             <?php echo $v['sale_status'];?>                         </div>
                    </td>

                   
                    <td class="point">
                    <?php 
													$selected = 0;
													$text_str = '添加';
													$point_pos = '0,0';
													if(in_array($v['id'],$select_points)){
														$selected = 1;
														
														$text_str = '移除';
														$point_pos = $init_points[$v['id']];
													}
													$sale_status = $v['sale_status'];
													 ?>
                                            
                                            
                                            
                                            	<a data-select="<?php echo $selected; ?>" data-value="<?php echo $v['id']; ?>" id="shapan_<?php echo $v['id']; ?>" data-pos="<?php echo $point_pos; ?>" data-sale="<?php echo $v['sale_status']; ?>" data-title="<?php echo $v['title']; ?>(<?php echo $sale_status; ?>)" onclick="addPosition('<?php echo $v['id']; ?>','<?php echo $v['title']; ?>(<?php echo $sale_status; ?>)',this)" class="layui-btn layui-btn-xs">
														<?php echo $text_str; ?>
													</a>
                                                    
                                              
                        <a data-height="500" data-width="500" data-id="edit" data-uri="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edithouse&house_id=<?php echo $houseid;?>&id=<?php echo $v['id'];?>" data-title="编辑 - <?php echo $v['title'];?> " class="J_showDialog layui-btn layui-btn-xs layui-btn-normal" href="javascript:;">编辑</a>
                        
                        
                        <a data-uri="<?php echo $MODULE[1]['linkurl'];?>api/shapan/deletehouse.php?id=<?php echo $v['id'];?>" data-msg="确定要删除<?php echo $v['title'];?>  吗？" class="J_confirm layui-btn layui-btn-xs layui-btn-danger" href="javascript:;">删除</a>                    </td>
                </tr><?php } ?>
                                </tbody>
            </table>
        </div>
    </div>
    <div class="col-50 layui-fr" style="padding-left:10px;overflow-y:hidden; ">
        <div class="layui-form-item">
            <div class="layui-block">
                <button class="layui-btn" id="upload">上传沙盘图片</button>
                <button class="layui-btn layui-btn-normal" id="save" data-house_id="<?php echo $houseid;?>" data-id="<?php echo $sanpan['id'];?>" data-uri="<?php echo $MODULE[1]['linkurl'];?>api/shapan/savesand.php">保存沙盘</button>
                <button class="layui-btn layui-btn-danger" id="delete" data-house_id="<?php echo $houseid;?>" data-id="<?php echo $sanpan['id'];?>" data-uri="api/shapan/deletesand.php">删除沙盘</button>

            </div>
        </div>
        <div class="layui-border-box layui-table-view" style="height:400px;">
            <div id="shapan">
                <div id="shapan-i">
                    <img id="MapImages" src="<?php echo $sanpan['img']; ?>" />
                </div>
            </div>
        </div>
    </div>
</div>
<script src="admin/static/js/jquery.3.3.1.min.js"></script>
<script src="admin/static/js/layer/layer.js"></script>
<script src="admin/static/js/plugins/jqmodal.js"></script>
<script>
    $(function(){
        //初始化所有点
      var init_point = '<?php echo $sanpan['data']; ?>';
	
        if(init_point){
            init_point = eval('('+init_point+')');
            for(var i in init_point){
                var d = init_point[i],p= d['point'].split(','),left_point=parseInt(p[0]),top_point=parseInt(p[1]);
                sha_idot(d.id, d.title, d.sale,left_point,top_point);
            }
        }

        var param = [];
        $("#save").on('click',function(){
            var house_id = $(this).data('house_id');
            var img      = $('#MapImages').attr('src'),url=$(this).data('uri'),
                    obj = $(".point").find("a[data-select=1]"),id=$(this).data('id');
            if(obj.length==0){
               layer.msg('请先添加楼栋再保存',{icon:2});
                return false;
            }else if(!img){
                layer.msg('请先上传沙盘图片再保存',{icon:2});
                return false;
            }else{
                layer.load(1);
                obj.each(function(i,o){
                    var tmp = {};
                    tmp.id = $(o).data('value');
                    tmp.point = $(o).data('pos');
                    tmp.title = $(o).data('title');
                    tmp.sale  = $(o).data('sale');
                    param.push(tmp);
                });
            }
            var data = {
                house_id : house_id,
                img      : img,
                data     : param
            };
            if(id){
                data.id = id;
            }
            $.post(url,data,function(result){
                layer.closeAll();
                if(result.code == 1){
                    layer.msg('沙盘保存成功',{icon:1},function(){
                        window.location.reload();
                    });
                }else{
                    layer.msg('沙盘保存失败', {icon:2});
                }
            });
        });
        $("#delete").on('click',function(){
            var id = $(this).data('id'),url=$(this).data('uri'),deleteImgUrl = "";
            layer.confirm('确定要删除沙盘么?',{icon:3,title:'提示信息'},function(index){
                layer.close(index);
                if(!id)
                {
                    var img = $('#MapImages').attr('src');
                    var param = {
                        'path' : img
                    };
                    $.post(deleteImgUrl,param,function(res){
                        if(res.code == 1){
                            $('#MapImages').attr('src','');
                        }else{
                            layer.msg(res.msg,{icon:2});
                        }
                    });
                }else{
                    $.get(url,{id:id},function(res){
                        if(res.code == 1)
                        {
                            layer.msg('删除沙盘成功',{icon:1},function(){
                                window.location.reload();
                            });
                        }else{
                            layer.msg('删除沙盘失败', {icon:2});
                        }
                    });

                }
            });
        });
    });
    // 增加一个点
    function addPosition(id,msg,o){
        var a = $(o),status= a.data('sale');
        if(a.attr('data-select') == 0){
            sha_idot(id,msg,status,10,10);
            a.attr('data-select',1);
            a.text('移除');
        }else{
            a.attr('data-select',0);
            pointDel(id);
            a.text('添加');
        }
    }
    // 删除一个点
    function pointDel(id){
        $('#dot_'+id).remove();
        $('#shapan_'+id).attr('data-select',0).text('添加');
        //清理表单项目
    }

    // 显示一个点
    //id:楼栋ID
    //ldmc:楼栋名称
    function sha_idot(id,title,status,left,top){
		 if(status == '预售'){
                status = 31;
			}else if(status == '售完'){
                status = 32;
			}
			else if(status == '在售'){
                status = 30;
			}
        $('<a>',{
            id: 'dot_'+id,
            'class': 'sha-dot sha-dot-'+status,
            html: title+'<i></i><b title="close"></b>'
        }).css({
            left: left,
            top: top
        }).jqDrag({
            attachment:'#shapan-i'
        })
                .on('dragEnd', function (el, l, t) {
                    $('#' + this.id.replace('dot','shapan')).attr('data-pos',l+','+t);
                })
                .appendTo('#shapan-i')
                .find('b').click(function(){ pointDel(id); })
    }
</script>
<script>
    var uploadUrl = "<?php echo $MODULE[1]['linkurl'];?>api/shapan/ajaxuploadimg.php",deleteImgUrl = "/house_sand/deleteimg.html";
    layui.use(['upload'],function(){
        var upload = layui.upload;
        upload.render({
            elem: '#upload'
            ,url: uploadUrl
            ,done: function(res){console.log(res);
                //如果上传失败
                if(res.code == 0){
                    return layer.msg('上传失败');
                }else{
                    $("#MapImages").attr('src',res.data);
                }
                //上传成功
            }

        });
    });
</script>

</div>

<script src="admin/static/manage/js/dialog.js"></script>
<script>
    layui.config({
        base: 'admin/static/manage/js/'
    });
</script>
</body>
</html>

