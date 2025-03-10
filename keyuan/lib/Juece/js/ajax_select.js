function ajax_select_yonghu(obj,sousuomorentishi=""){
		var option="";
					$.ajax({
			          url:get_bumen_url,
			          type:"get",
			          async:false,
			          dataType:"json",
			          success:function(data){
			            var sousuo = data.sousuo;
			            var dede = "";
			            for(var i in sousuo){
			            	dede = dede + '<option title="'+sousuo[i]['bmming']+'" value="'+sousuo[i]['id']+'">'+sousuo[i]['bmming']+'</option>';
			            }
			            option = dede;
			          }
			        });
	
	var div = '<div id="get_find_select" style="width: 200px;  border: 1px; height: 350px;position: absolute;z-index:9999">'+
		        '<div class="row" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-md-12" style="padding: 0;">'+
		                '<span class="glyphicon glyphicon-search form-control-feedback" style="left: 0px;"></span>'+
		                '<span style="cursor:pointer;pointer-events:auto" id="guanbi" style="z-index: 999;" class="glyphicon glyphicon-remove form-control-feedback"></span>'+
		                '<input type="text" autocomplete="off" class="form-control"  placeholder="'+sousuomorentishi+'" style="margin: 0px; padding-left: 30px;" id="get_find_select_sousuo" name="red_money">'+
		            '</div>'+
		        '</div>'+
		        '<div class="row" id="greetings" style="margin-right: 0px;margin-left: 0px;display: none;position:absolute;z-index: 999; width:200px;height: 280px;">'+
		            '<select size="5" id="text_xiaoqu_s" name="text_xiaoqu_s" class="form-control " style="height: 280px;overflow-y:auto;">'+
		                    
		            '</select>'+
		        '</div>'+
		        '<div class="row" id="selects" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-xs-6" style="padding: 0;">'+
		                '<select size="5" id="select1" class="form-control " style="height: 280px;overflow-y:auto;">'+
		                option+
		                '</select>'+
		            '</div>'+
		            '<div class="col-xs-6"  style="padding: 0;">'+
		                '<select size="5" id="select2" class="form-control" style="height: 280px;overflow-y:auto;">'+
		                '</select>'+
		            '</div>'+
		        '</div>'+
			'</div>';
	$(obj).after(div);
	$("#get_find_select [name=red_money]:last").bind("keyup", moneyKeyUpBind);
	$("#select1 option").bind("click", moneychangeBind);
	$(obj).click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select").click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select #guanbi").click(function(){
		$('#get_find_select_sousuo').val("");
		$("#greetings").hide();
		event.stopPropagation(); 
	});
	$("body").click(function(){
		$('#get_find_select').remove();
	});
	$("#text_xiaoqu_s").on("dblclick","option", function() {  
     var Uarry=$("#text_xiaoqu_s option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     $(obj).val(Tresult);
     var id = $(obj).attr('data-for-input');
     $('#'+id).val(xiaoquid);
     $('#get_find_select').remove();
    })
	$("#select2").on("dblclick","option", function() {  
     var Uarry=$("#select2 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     var id = $(obj).attr('data-for-input');
     $('#'+id).val(xiaoquid);
     $(obj).val(Tresult);
     $('#get_find_select').remove();
    })

	event.stopPropagation(); 
}


function moneyKeyUpBind(){
	$("#greetings").show();
	var txt=$('#get_find_select_sousuo').val();
		if (txt!="") {
      $.ajax({
          url:get_yonghu_url,
          type:"get",
          data:"txt="+txt,
          dataType:"json",
          success:function(data){
            var sousuo = data.sousuo;
            $("#text_xiaoqu_s option").remove();
            for(var i in sousuo){
              var option=$("<option></option>");
              $(option).attr("title",sousuo[i]['ygmingcheng']);
	          $(option).val(sousuo[i]['id']);
	          $(option).html(sousuo[i]['ygmingcheng']);
	          $("#text_xiaoqu_s").append(option);
            }
            
          }
        });
	}else{
		$("#greetings").hide();
	}
}

function moneychangeBind(){
	var bmid=$(this).val();
     $.ajax({
          url:get_bumen_yonghu_url,
          type:"get",
          data:"bmid="+bmid,
          dataType:"json",
          success:function(data){
            var sousuo = data.sousuo;
            $("#select2 option").remove();
            for(var i in sousuo){
	          var option=$("<option></option>");
	          $(option).attr("title",sousuo[i]['ygmingcheng']);
	          $(option).val(sousuo[i]['id']);
	          $(option).html(sousuo[i]['ygmingcheng']);
	          $("#select2").append(option);
	        }
          }
        });
}

function ajax_select_xiaoqu(obj,sousuomorentishi=""){
	$('#get_find_select').remove();
		var option="";
					$.ajax({
			          url:get_xingzhengqu_url,
			          type:"get",
			          async:false,
			          dataType:"json",
			          success:function(data){
			            var sousuo = data.sousuo;
			            var dede = "";
			            for(var i in sousuo){
			            	dede = dede + '<option title="'+sousuo[i]['xzqming']+'" value="'+sousuo[i]['id']+'">'+sousuo[i]['xzqming']+'</option>';
			            }
			            option = dede;
			          }
			        });
	
	var div = '<div id="get_find_select" style="width: 300px;  border: 1px; height: 350px;position: absolute;z-index:9999">'+
		        '<div class="row" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-md-12" style="padding: 0;">'+
		                '<span class="glyphicon glyphicon-search form-control-feedback" style="left: 0px;"></span>'+
		                '<span style="cursor:pointer;pointer-events:auto" id="guanbi" style="z-index: 999;" class="glyphicon glyphicon-remove form-control-feedback"></span>'+
		                '<input type="text" autocomplete="off" class="form-control"  placeholder="'+sousuomorentishi+'" style="margin: 0px; padding-left: 30px;" id="get_find_select_sousuo" name="red_money">'+
		            '</div>'+
		        '</div>'+
		        '<div class="row" id="greetings" style="margin-right: 0px;margin-left: 0px;display: none;position:absolute;z-index: 999; width:300px;height: 280px;">'+
		            '<select size="5" id="text_xiaoqu_s" name="text_xiaoqu_s" class="form-control " style="height: 280px;overflow-y:auto;">'+
		                    
		            '</select>'+
		        '</div>'+
		        '<div class="row" id="selects" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-xs-4" style="padding: 0;">'+
		                '<select size="5" id="select1" class="form-control " style="height: 280px;overflow-y:auto;">'+
		                option+
		                '</select>'+
		            '</div>'+
		            '<div class="col-xs-4"  style="padding: 0;">'+
		                '<select size="5" id="select2" class="form-control" style="height: 280px;overflow-y:auto;">'+
		                '</select>'+
		            '</div>'+

		            '<div class="col-xs-4"  style="padding: 0;">'+
		                '<select size="5" id="select3" class="form-control" style="height: 280px;overflow-y:auto;">'+
		                '</select>'+
		            '</div>'+
		        '</div>'+
			'</div>';
	$(obj).after(div);
	$("#get_find_select [name=red_money]:last").bind("keyup", moneyKeyUpBind_xiaoqu);
	$("#select1 option").bind("click", moneychangeBind_xiaoqu_1);
	
	$(obj).click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select").click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select #guanbi").click(function(){
		$('#get_find_select_sousuo').val("");
		$("#greetings").hide();
		event.stopPropagation(); 
	});
	$("body").click(function(){
		$('#get_find_select').remove();
	});
	$("#text_xiaoqu_s").on("dblclick","option", function() {  
     var Uarry=$("#text_xiaoqu_s option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     $(obj).val(Tresult);
     var id = $(obj).attr('data-for-input');
     $('#'+id).val(xiaoquid);
     $('#get_find_select').remove();
     added(xiaoquid);

    });
	$("#select3").on("dblclick","option", function() {  
     var Uarry=$("#select3 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     var id = $(obj).attr('data-for-input');
     $('#'+id).val(xiaoquid);
     $(obj).val(Tresult);
     $('#get_find_select').remove();
     added(xiaoquid);
    });

	event.stopPropagation(); 
}
	
function moneyKeyUpBind_xiaoqu(){
	$("#greetings").show();
	var txt=$('#get_find_select_sousuo').val();
		if (txt!="") {
      $.ajax({
          url:get_xiaoqu_txt_url,
          type:"get",
          data:"txt="+txt,
          dataType:"json",
          success:function(data){
            var sousuo = data.sousuo;
            $("#text_xiaoqu_s option").remove();
            for(var i in sousuo){
              var option=$("<option></option>");
              $(option).attr("title",sousuo[i]['xiaoqum']);
	          $(option).val(sousuo[i]['id']);
	          $(option).html(sousuo[i]['xiaoqum']);
	          $("#text_xiaoqu_s").append(option);
            }
            
          }
        });
	}else{
		$("#greetings").hide();
	}
}

function moneychangeBind_xiaoqu_1(){
	var id=$(this).val();
     $.ajax({
          url:get_pianqu_url,
          type:"get",
          data:"id="+id,
          dataType:"json",
          success:function(data){
            var sousuo = data.sousuo;
            $("#select2 option").remove();
            for(var i in sousuo){
	          var option=$("<option></option>");
	          $(option).attr("title",sousuo[i]['pianqum']);
	          $(option).val(sousuo[i]['id']);
	          $(option).html(sousuo[i]['pianqum']);
	          $("#select2").append(option);
	          $("#select2 option").bind("click", moneychangeBind_xiaoqu_2);
	        }
          }
        });
}

function moneychangeBind_xiaoqu_2(){
	var id=$(this).val();
     $.ajax({
          url:get_xiaoqu_url,
          type:"get",
          data:"id="+id,
          dataType:"json",
          success:function(data){
            var sousuo = data.sousuo;
            $("#select3 option").remove();
            for(var i in sousuo){
	          var option=$("<option></option>");
	          $(option).attr("title",sousuo[i]['xiaoqum']);
	          $(option).val(sousuo[i]['id']);
	          $(option).html(sousuo[i]['xiaoqum']);
	          $("#select3").append(option);
	        }
          }
        });
}
	
function ajax_select_qujian(obj,danwei="",arr1,arr2){
	$('#get_find_select').remove();
		var id1 = $(obj).attr('startinput');
     	var start1=$('input[name="'+id1+'"]').val();
     	var id2 = $(obj).attr('endinput');
     	var end1=$('input[name="'+id2+'"]').val();
     		var dede1 = "";
			for(var i in arr1){
	        	dede1 = dede1 + '<option title="'+arr1[i]+'" value="'+arr1[i]+'">'+arr1[i]+danwei+'</option>';
	        }
        	option1 = dede1;
        	var dede2 = "";
			for(var i in arr2){
	        	dede2 = dede2 + '<option title="'+arr2[i]+'" value="'+arr2[i]+'">'+arr2[i]+danwei+'</option>';
	        }
        	option2 = dede2;
	
	var div = '<div id="get_find_select" style="width: 200px;  border: 1px; height: 350px;position: absolute;z-index:9999">'+
		        '<div class="row" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-md-12" style="padding: 0;">'+
		                
		                '<input type="text" autocomplete="off" value="'+start1+'" class="form-control"  placeholder="" style="float:left;width:100px;margin: 0px;" id="get_find_select_sousuo1" name="red_money">'+
		            	'<input type="text" autocomplete="off" value="'+end1+'" class="form-control"  placeholder="" style="float:left;width:100px;margin: 0px;" id="get_find_select_sousuo2" name="red_money">'+
		            '</div>'+
		        '</div>'+
		        '<div class="row" id="selects" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-xs-6" style="padding: 0;">'+
		                '<select size="5" id="select1" class="form-control " style="height: 280px;overflow-y:auto;">'+
			                option1+
		                '</select>'+
		            '</div>'+
		            '<div class="col-xs-6"  style="padding: 0;">'+
		                '<select size="5" id="select2" class="form-control" style="height: 280px;overflow-y:auto;">'+
		                	option2+
		                '</select>'+
		            '</div>'+
		        '</div>'+
			'</div>';

	$(obj).after(div);
	$("#get_find_select [name=red_money]:last").bind("keyup");
	$("#select1 option,#select2 option").bind("");
	
	$(obj).click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select").click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select #guanbi").click(function(){
		$('#get_find_select_sousuo').val("");
		$("#greetings").hide();
		event.stopPropagation(); 
	});
	$("body").click(function(){
		$('#get_find_select').remove();
	});
	$("#select1").on("click","option", function() {  
     var Uarry=$("#select1 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     $('#get_find_select_sousuo1').val(xiaoquid);
     
     	var inp1 = $('#get_find_select_sousuo1').val();
		var inp2 = $('#get_find_select_sousuo2').val();
		var val = "";
		if (inp1>0&&inp2==0) {
			val =inp1+danwei+"以上";
		}else if(inp1==0&&inp2>0){
			val =inp2+danwei+"以下";
		}else if(inp1>0&&inp2>0){
			if (parseInt(inp1)>parseInt(inp2)) {
				val =inp2+"-"+inp1+danwei;
			}else{
				val =inp1+"-"+inp2+danwei;
			}
		}
		var id1 = $(obj).attr('startinput');
     	$('input[name="'+id1+'"]').val(inp1);
     	var id2 = $(obj).attr('endinput');
     	$('input[name="'+id2+'"]').val(inp2);
		$(obj).val(val);
	});

	$("#select2").on("click","option", function() {  
     var Uarry=$("#select2 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     $('#get_find_select_sousuo2').val(xiaoquid);
     
     	var inp1 = $('#get_find_select_sousuo1').val();
		var inp2 = $('#get_find_select_sousuo2').val();
		var val = "";
		if (inp1>0&&inp2==0) {
			val =inp1+danwei+"以上";
		}else if(inp1==0&&inp2>0){
			val =inp2+danwei+"以下";
		}else if(inp1>0&&inp2>0){
			if (parseInt(inp1)>parseInt(inp2)) {
				val =inp2+"-"+inp1+danwei;
			}else{
				val =inp1+"-"+inp2+danwei;
			}
		}
		var id1 = $(obj).attr('startinput');
     	$('input[name="'+id1+'"]').val(inp1);
     	var id2 = $(obj).attr('endinput');
     	$('input[name="'+id2+'"]').val(inp2);
		$(obj).val(val);
	});
	$("#get_find_select_sousuo1,#get_find_select_sousuo2").bind("keyup",function(){
		var inp1 = $('#get_find_select_sousuo1').val();
		var inp2 = $('#get_find_select_sousuo2').val();
		var val = "";
		if (inp1>0&&inp2==0) {
			val =inp1+danwei+"以上";
		}else if(inp1==0&&inp2>0){
			val =inp2+danwei+"以下";
		}else if(inp1>0&&inp2>0){
			if (parseInt(inp1)>parseInt(inp2)) {
				val =inp2+"-"+inp1+danwei;
			}else{
				val =inp1+"-"+inp2+danwei;
			}
		}
		var id1 = $(obj).attr('startinput');
     	$('input[name="'+id1+'"]').val(inp1);
     	var id2 = $(obj).attr('endinput');
     	$('input[name="'+id2+'"]').val(inp2);
		$(obj).val(val);
	});
	

	event.stopPropagation(); 
}


function ajax_select_duoxuan(obj,sousuomorentishi=""){
	$('#get_find_select').remove();
		var option="";
					$.ajax({
			          url:get_xingzhengqu_url,
			          type:"get",
			          async:false,
			          dataType:"json",
			          success:function(data){
			            var sousuo = data.sousuo;
			            var dede = "";
			            for(var i in sousuo){
			            	dede = dede + '<option title="'+sousuo[i]['xzqming']+'" value="'+sousuo[i]['id']+'">'+sousuo[i]['xzqming']+'</option>';
			            }
			            option = dede;
			          }
			        });
	
	var div = '<div id="get_find_select" style="width: 300px;  border: 1px; height: 350px;position: absolute;z-index:9999">'+
		        '<div class="row" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-md-12" style="padding: 0;">'+
		                '<span class="glyphicon glyphicon-search form-control-feedback" style="left: 0px;"></span>'+
		                '<span style="cursor:pointer;pointer-events:auto" id="guanbi" style="z-index: 999;" class="glyphicon glyphicon-remove form-control-feedback"></span>'+
		                '<input type="text" autocomplete="off" class="form-control"  placeholder="'+sousuomorentishi+'" style="margin: 0px; padding-left: 30px;" id="get_find_select_sousuo" name="red_money">'+
		            '</div>'+
		        '</div>'+
		        '<div class="row" id="greetings" style="margin-right: 0px;margin-left: 0px;display: none;position:absolute;z-index: 999; width:300px;height: 280px;">'+
		            '<select size="5" id="text_xiaoqu_s" name="text_xiaoqu_s" class="form-control " style="height: 280px;overflow-y:auto;">'+
		                    
		            '</select>'+
		        '</div>'+
		        '<div class="row" id="selects" style="margin-right: 0px;margin-left: 0px;">'+
		            '<div class="col-xs-4" style="padding: 0;">'+
		                '<select size="5" id="select1" class="form-control " style="height: 280px;overflow-y:auto;">'+
		                option+
		                '</select>'+
		            '</div>'+
		            '<div class="col-xs-4"  style="padding: 0;">'+
		                '<select size="5" id="select2" class="form-control" style="height: 280px;overflow-y:auto;">'+
		                '</select>'+
		            '</div>'+

		            '<div class="col-xs-4"  style="padding: 0;">'+
		                '<select size="5" id="select3" class="form-control" style="height: 280px;overflow-y:auto;">'+
		                '</select>'+
		            '</div>'+
		        '</div>'+
			'</div>';
	$(obj).after(div);
	$("#get_find_select [name=red_money]:last").bind("keyup", moneyKeyUpBind_xiaoqu);
	$("#select1 option").bind("click", moneychangeBind_xiaoqu_1);
	
	$(obj).click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select").click(function(){
		event.stopPropagation(); 
	});
	$("#get_find_select #guanbi").click(function(){
		$('#get_find_select_sousuo').val("");
		$("#greetings").hide();
		event.stopPropagation(); 
	});
	$("body").click(function(){
		$('#get_find_select').remove();
	});
	$("#text_xiaoqu_s").on("dblclick","option", function() {  
     var Uarry=$("#text_xiaoqu_s option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     
     added(xiaoquid,Tresult,3);

    });
	$("#select1").on("dblclick","option", function() {  
     var Uarry=$("#select1 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     //var id = $(obj).attr('data-for-input');
     //$('#'+id).val(xiaoquid);
     added(xiaoquid,Tresult,1);
    });
    $("#select2").on("dblclick","option", function() {  
     var Uarry=$("#select2 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     //var id = $(obj).attr('data-for-input');
     //$('#'+id).val(xiaoquid);
     added(xiaoquid,Tresult,2);
     
    });
    $("#select3").on("dblclick","option", function() {  
     var Uarry=$("#select3 option");  
     var count=$(this).index();//获取li的下标  
     var Tresult=Uarry.eq(count).text();
     var xiaoquid=Uarry.eq(count).attr('value');
     //var id = $(obj).attr('data-for-input');
     //$('#'+id).val(xiaoquid);
     added(xiaoquid,Tresult,3);
    });

	event.stopPropagation(); 
}
