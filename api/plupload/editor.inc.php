<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$swf_is_admin = defined('AJ_ADMIN');
?>
<script type="text/javascript">var swfu_max = <?php echo $MG[maxitem];?>;</script>
	<script type="text/javascript" src="<?php echo AJ_PATH;?>api/plupload/jquery.js"></script>
	<script type="text/javascript" src="<?php echo AJ_PATH;?>api/plupload/plupload.full.min.js"></script>
	<style type="text/css">
		
		
		#uploadBtn {
			height: 2em;
			background-color: #767997;
			border: none;
			outline: none;
			color: white;
			box-shadow: inset 2px 2px 2px #a9acca,
						inset -2px -2px 2px #434664;
		}
		#pic-list {
			list-style-type: none;
			
			
			padding: 5px;
			
			width: 1015px;
		}
		#pic-list #triangle {
			border: 10px solid #767997;
			border-color: transparent transparent #767997 transparent;
			position: absolute;
			top: -20px;
			left: 5px;
		}
		#pic-list #title {
			padding-bottom: 5px;
		}
		#pic-list #title span {
			font-weight: bold;
		}
		#pic-list #title b {
			float: right;
		}
		#pic-list #title b:hover {
			color: #434664;
		}
		#pic-list #title #hint {
			color: #434664;
			font-size: 12px;
			padding-top: .7em;
		}
		#pic-list li {
			position: relative;
			display: inline-block;
			float: left;
			margin: 5px 5px 0px 0px;
			font-size: 0px; /* 解決換行間隙問題 */
		}
		#pic-list li#addBtn {
			box-sizing: border-box;
			width: 100px;
			height: 100px;
			line-height: 90px;
			border: 2px dashed #CCC;
			color: #CCC;
			font-size: 80px;
			text-align: center;
			padding-bottom: 30px;
		}
		#pic-list li img {
			box-sizing: border-box;
			width: 100px;
			height: 100px;
			border: 2px dashed #CCC;
		}
		#pic-list li:not(#addBtn):hover {
			filter: alpha(Opacity=50);
			-moz-opacity: 0.5;
			opacity: 0.5;
		}
		#pic-list li#addBtn:hover {
			border-color: #767997;
			color: #767997;
		}
		#pic-list li b{
			display: none;
			position: absolute;
			right: 0px;
			top: 0px;
			color: black;
			font-size: 15px;
			text-align: center;
		}
		#pic-list li:not(#addBtn):hover b {
			display: block;
			width: 20px;
			height: 20px;
		}
		#pic-list li:not(#addBtn):hover b:hover {
			background-color: #808080;
		}
	
.bar {background-color: orange; display:block; width:0%; height:5px; }  
.percent{position:absolute; height:15px; top:1px; text-align:center; display:inline-block; left:12px; width:80px; color:#666; line-height:15px; font-size:12px; }  
	</style>
    
      <style type="text/css">
          
            /**********上傳樣式***********/

            .progress{position:relative;padding: 1px; border-radius:3px; margin:30px 0 0 0;}
            .bar{background-color: green; display:block; width:0%; height:20px; border-radius:3px;}
            .percent{position:absolute; height:20px; display:inline-block;top:3px; left:2%; color:#fff}
            .progress{
                height: 100px;
                padding: 30px 0 0;
                width:100px;
                border-radius: 0;
            }
            .btns{-webkit-border-radius:3px; -moz-border-radius:3px; -ms-border-radius:3px; -o-border-radius:3px; border-radius:3px;
                 background-color:#ff8400; color:#FFF; display:inline-block; height:28px; line-height:28px; text-align:center; padding:0 12px; 
                 transition:background-color .2s linear 0s; border:0; cursor:pointer;text-decoration: none}
            .btns:hover{
	background-color: #e95a00;
	text-decoration: none;
	color: #FFF;
}
            .photos_area .item {
                float: left;
                margin: 0 10px 10px 0;
                position: relative;
            }
            .photos_area .item{position: relative;float:left;margin:0 10px 10px 0;}
            .photos_area .item img{border: 1px solid #cdcdcd;}
            .photos_area .operate{background: rgba(33, 33, 33, 0.7) none repeat scroll 0 0; bottom: 0; padding:5px 0; left: 0; position: absolute; width: 102px; z-index: 5; line-height: 21px; text-align: center;}
            .photos_area .operate i{cursor: pointer; display: inline-block; font-size: 0; height: 12px; line-height: 0; margin: 0 5px; overflow: hidden; width: 12px; background: url("<?php echo $MODULE[1][linkurl];?>api/plupload/icon_aijia.png") no-repeat scroll 0 0;}
            .photos_area .operate .toright{background-position: -13px -13px; position: relative;top:1px;}
            .photos_area .operate .toleft{background-position: 0 -13px; position: relative;top:1px;}
            .photos_area .operate .del{background-position: -13px 0; position: relative;top:0px;}
            .photos_area .preview{background-color: #fff; font-family: arial; line-height: 90px; text-align: center; z-index: 4; left: 0; position: absolute; top: 0; height: 90px; overflow: hidden; width: 90px;}
           
        </style>
<tr id="logo_area_tr" class='logo_area_tr'><td class="tl"><span class="f_red">*</span> </td>
                        <td class="td_left"><a class="btns" id="logo_upload_btn" href="javascript:;" ><span  style="color: white;">上传图片</span> </a>


                            <div id="logo_upload_area" style='width:80%; height:200px'>
                                <div id='photos_area' class="photos_area clearfix">
                                    <?php
                                    if (isset($pics)) {
                                        foreach ($pics as $v) {
                                            ?>
                                            <div class='item'>
                                                <input type='hidden' name='post[pic][]' value='<?php echo $v; ?>'/>
                                                <img src='<?php echo $v; ?>'  width='100px' height='100px'/>
                                                <div class='operate'><i class='toleft'>左移</i><i class='toright'>右移</i><i class='del'>刪除</i></div>
                                            </div>
    <?php }
} ?>
                          </div>
      </td>
                    </tr>
	  <script type="text/javascript" src="<?php echo $MODULE[1]['linkurl'];?>api/plupload/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $MODULE[1]['linkurl'];?>api/plupload/plupload.full.min.js"></script>
        <script type="text/javascript">

            var uploader = new plupload.Uploader({
                runtimes: 'gears,html5,html4,silverlight,flash',
                browse_button: 'logo_upload_btn',
                url: "<?php echo $MODULE[1]['linkurl'];?>api/uploadajax.php",
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
                        $("#btn_submit").attr("disabled", "disabled").addClass("disabled").val("正在上傳...");
                        var item = '';
                        plupload.each(files, function(file) { //遍歷文件
                            item += "<div class='item' id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></div>";
                        });
                        $("#photos_area").append(item);
                        uploader.start();
                    },
                    UploadProgress: function(up, file) { //上傳中，顯示進度條 
                        var percent = file.percent;
                        $("#" + file.id).find('.bar').css({"width": percent + "%"});
                        $("#" + file.id).find(".percent").text(percent + "%");
                    },
                    FileUploaded: function(up, file, info) {
                        var data = eval("(" + info.response + ")");
                        $("#" + file.id).html("<input type=hidden name='post[pic][]' value='" + data.src + "'><img src='" + data.src + "' alt='" + data.name + "' width='100px' height='100px'>\n\
            <div class='operate'><i class='toleft'>左移</i><i class='toright'>右移</i><i class='del'>刪除</i></div>")

                        $("#btn_submit").removeAttr("disabled").removeClass("disabled").val("提 交");
                        if (data.error != 0) {
                            alert(data.error);
                        }
                    },
                    Error: function(up, err) {
                        if (err.code == -601) {
                            alert("請上傳jpg,png,gif,jpeg,zip或rar！");
                            $("#btn_submit").removeAttr("disabled").removeClass("disabled").val("提 交");
                        }
                    }
                }
            });
            uploader.init();
            //左右切換和刪除圖片
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
