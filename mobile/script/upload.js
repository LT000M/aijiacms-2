//$("#uploading").hide();
var progress = $("#container").Progress({
	percent: 10,
	width: 180,
	height: 20,
	fontSize: 14
});
var filechooser = document.getElementById("uploadimg");
var maxsize = 100 * 1024;
var maxnums = 3;
var scriptArgs = document.getElementById('uploadjs').getAttribute('data');
$("#addpic").on("click", function() {
imgnums = $("#imgslist li:not(#addpic)").size();
	  if(imgnums>=maxnums){
	   laymsg("您只能上传3张图片");
	  return false;
}

filechooser.click();
});
document.querySelector('#uploadimg').addEventListener('change', function () {
	if (!this.files.length) return;
    var files = Array.prototype.slice.call(this.files);

    var filenums = files.length;
    if (filenums + imgnums>3) {

      laymsg("最多同时只可上传3张图片");
      return;
    }
    laymsg("图片压缩上传中...");
	$("#uploading").show();
	    files.forEach(function(file, i) {

      if (!/\/(?:jpeg|png|gif|jpg)/i.test(file.type)) return;
	  
	  	 var reader = new FileReader();
		 reader.onload = function() {
        var result = this.result;
		progress.percent(60);
		upload(result);
		 };
		 reader.readAsDataURL(file);
		});
});


function upload(files) {

    // this.files[0] 是用户选择的文件
    lrz(files, {
        width: 880,
		quality: 0.5
    })
        .then(function (rst) {
            // 把处理的好的图片给用户看看呗
            var img = new Image();
            img.src = rst.base64;
			img.size = rst.fileLen;
			sourceSize = toFixed2(files.size / 1024),
            resultSize = toFixed2(rst.base64Len / 1024),
            img.onload = function () {
            };
            return rst;
        })
        .then(function (rst) {
            progress.percent(100);
			var from = 'album';
			var theimg = rst.base64;
			$.ajax({
		   type: "POST",
		   url: "upload.php",
		   data: {"moduleid":moduleid,"from":from,"base64":rst.base64,"size":resultSize,"width":thumb_width,"height":thumb_height},
		   dataType:"json",
		   success: function(data){
			   //progress.percent(100);
			   if (data.status == 0) {
			   var showImgHtml = '<li><a href="'+data.url+'"><img src="'+data.url+'"></a></li>';
			   $("#addpic").before(showImgHtml);
			   addPress($("#imgslist a[href='" + data.url + "']").parent("li"));
			   baguetteBox.run('.baguetteBoxOne');
			   $("#uploading").hide();
			   progress.percent(10);

				laymsg('上传成功');
				return false;
			 }else{
				laymsg(data.content);
				$("#uploading").hide();
			    progress.percent(10);
				//$(".imglist").append(attstr); 
			 }
		   }, 
			complete :function(XMLHttpRequest, textStatus){
			},
			error:function(XMLHttpRequest, textStatus, errorThrown){ //上传失败 
			   laymsg('上传失败，请重新上传');
			   $("#delAlbum").css('display','none');
			   $("#uploading").hide();
			   progress.percent(10);
			   $("#uploadimg").val(null);
			}
		}); 
            return rst;
        })
}

function toFixed2 (num) {
    return parseFloat(+num.toFixed(2));
}

function addPress(obj, index) {
// 获取目前长按的对象
var hammertime = new Hammer(obj[0]);
// 绑定长按对象
hammertime.on("press", function(e) {
					
dialog.alert({
  title:"温馨提示",
  msg:'确定删除图片吗',
  buttons:['取消','确定']
    },function(ret){
    if(ret){
	  if(ret.buttonIndex==2){
		obj.remove();
		laymsg('已经删除了');
	 }
    }
  })
 });
}

