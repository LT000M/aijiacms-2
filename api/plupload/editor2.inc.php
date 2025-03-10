<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$swf_is_admin = defined('AJ_ADMIN');
?>
<link href="<?php echo AJ_PATH;?>api/plupload/style.css" rel="stylesheet" type="text/css"/>
<tr id="logo_area_tr" class='logo_area_tr'><td class="tl"><span class="f_red">*</span> 多图图片上传</td>
                        <td class="td_left"><a class="picbtns" id="logo_upload_btn" href="javascript:;" ><span  style="color: white;">上传图片</span> </a>


                            <div id="logo_upload_area" style='width:80%'>
                                <div id='photos_area' class="photos_area clearfix">
                                    <?php
                                    if (isset($pics)) {
                                        foreach ($pics as $v) {
                                            ?>
                                            <div class='item'>
                                                <input type='hidden' name='post[pic][]' value='<?php echo $v; ?>'/>
                                                <img src='<?php echo $v; ?>'  width='100px' height='100px'/>
                                                <div class='operate'><i class='toleft'>左移</i><i class='toright'>右移</i><i class='del'>删除</i></div>
                                            </div>
    <?php }
} ?>
                          </div>
      </td>
                    </tr>
                    <script type="text/javascript" src="<?php echo $AJPath;?>api/plupload/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $AJPath;?>api/plupload/plupload.full.min.js"></script>
        <script type="text/javascript">

            var uploader = new plupload.Uploader({
                runtimes: 'gears,html5,html4,silverlight,flash',
                browse_button: 'logo_upload_btn',
                url: "<?php echo $AJPath;?>api/uploadajax.php",
                flash_swf_url: 'plupload/Moxie.swf',
                silverlight_xap_url: 'plupload/Moxie.xap',
                filters: {
                    max_file_size: '25mb',
                    mime_types: [
                        {title: "files", extensions: "jpg,png,gif,jpeg"}
                    ]
                },
                multi_selection: true,
                init: {
                    FilesAdded: function(up, files) {
						
                        $("#btn_submit").attr("disabled", "disabled").addClass("disabled").val("正在上传...");
                        var item = '';
                        plupload.each(files, function(file) { //遍历文件
                            item += "<div class='item' id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></div>";
                        });
						
                        $("#photos_area").append(item);
                        uploader.start();
                    },
                    UploadProgress: function(up, file) { //上传中，显示进度条 
                        var percent = file.percent;
                        $("#" + file.id).find('.bar').css({"width": percent + "%"});
                        $("#" + file.id).find(".percent").text(percent + "%");
                    },
                    FileUploaded: function(up, file, info) {
                        var data = eval("(" + info.response + ")");
                        $("#" + file.id).html("<input type=hidden name='post[pic][]' value='" + data.src + "'><img src='" + data.src + "' alt='" + data.name + "' width='100px' height='100px'>\n\
            <div class='operate'><i class='toleft'>左移</i><i class='toright'>右移</i><i class='del'>删除</i></div>")

                        $("#btn_submit").removeAttr("disabled").removeClass("disabled").val("提 交");
                        if (data.error != 0) {
                            alert(data.error);
                        }
                    },
                    Error: function(up, err) {
                        if (err.code == -601) {
                            alert("请上传jpg,png,gif,jpeg,zip或rar！");
                            $("#btn_submit").removeAttr("disabled").removeClass("disabled").val("提 交");
                        }
                    }
                }
            });
            uploader.init();
            //左右切换和删除图片
            $(function() {
                $(".toleft").live("click", function() {
                    var item = $(this).parent().parent(".item");
                    var item_left = item.prev(".item");
                    if ($("#photos_area").children(".item").length >= 2) {
                        if (item_left.length == 0) {
                            item.insertAfter($("#photos_area").children(".item:last"));
                        } else {
                            item.insertBefore(item_left);
                        }
                    }

                })
                $(".toright").live("click", function() {
                    var item = $(this).parent().parent(".item");
                    var item_right = item.next(".item");
                    if ($("#photos_area").children(".item").length >= 2) {
                        if (item_right.length == 0) {
                            item.insertBefore($("#photos_area").children(".item:first"));
                        } else {
                            item.insertAfter(item_right);
                        }
                    }
                })
                $(".del").live("click", function() {
                    $(this).parent().parent(".item").remove();
                })
            })
        </script>