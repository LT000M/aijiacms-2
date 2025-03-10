
//城市切换
$(".city,.city_box").click(function(){
   $(".city_box").toggle();
});
//搜索
$("#search").click(function () {
    $("#head_form").submit();
});
function msg_show(tip,i){
    layer.msg(tip, {time: 3000, icon:i});
}
function hideDiv(){
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index); //再执行关闭
}
function open_show(url,w,h){
    layer.open({
        type: 2,
        title: false,
        area: [w, h],
        shade: 0,
        closeBtn: 0,
        shadeClose: true,
        content:url
    });
}

function turn(url){
    window.location.href = url;
}

function ajaxPost(url,data){
    //请求ajax
    $.ajax({
        type: "post",
        url : url,
        dataType:'json',
        data:data,
        success: function(json){
            if(json.code==1){
                msg_show(json.msg,1);
                window.setTimeout(hideDiv,1000);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
}


$(".showAdd").click(function(){
    open_show($(this).attr('request-url'),$(this).attr('w'),$(this).attr('h'));
});
//视频播放
$(".v_play").click(function(){
    var url =$(this).attr('request-url');
    var title = $(this).attr('title') ? $(this).attr('title') :'视频播放'
    layer.open({
        type: 2,
        title: title,
        area: ['825px', '510px'],
        shade: 0,
        closeBtn: 1,
        shadeClose: true,
        content:url
    });
});
//获取楼盘图片
$(".g_h_pic").click(function () {
    var url = $(this).attr('request-url');
    var prev = $(".picHouseShow li:first").attr("data-pid");
    var next = $(".picHouseShow li:last").attr("data-pid");
    var li_ids = [];
    $(".picHouseShow li").each(function(i,v){
        li_ids[i] = $(this).attr("data-pid");
    });
    var ids = li_ids.join(",");
    if(!prev || !next){
        return false;
    }
    //请求ajax
    $.ajax({
        type: "post",
        url : url,
        dataType:'json',
        data:{'prev':prev,next:next,ids:ids},
        success: function(json){
            if(json.code==1){
                $(".picHouseShow").empty();
                $(".picHouseShow").append(json.html);
            }else{
                msg_show(json.msg,2)
            }
        }
    });

});
//提交咨询
$('#reply_btn').on('click',function() {
    var user_name = $('#user_name').val(),house_id = $("#house_id").val(),content = $("#content").val(), mobile = $("#mobile").val(), reg = /^1[3456789][0-9]{9}$/;
    if (!user_name) {
        msg_show('请填入您的姓名',2);
        return false;
    } else if (!reg.test(mobile)) {
        msg_show('手机号码格式不正确',2);
        return false;
    } else if (!content) {
        msg_show('请输入您提问的内容', 2);
        return false;
    }else{
        $("#reply_form").submit();
    }
});

//报名
$('#sub_btn').click(function(){
    var user_name = $('#user_name').val(),mobile = $('#mobile').val(),sms_code = $('#sms_code').val(),send_sms=$("#send_sms").val(),house_id=$("#house_id").val(),group_id=$("#group_id").val(),
        type=$("#type").val(),broker_id=$("#broker_id").val(),model=$("#model").val(),reg = /^1[3456789][0-9]{9}$/;
    if(!user_name)
    {
        layer.msg('请填写您的姓名',{icon:2});
        return false;
    }else if(!reg.test(mobile)){
        layer.msg('手机号码格式不正确',{icon:2});
        return false;
    }else if(!sms_code && send_sms == 1){
        layer.msg('请填写短信验证码',{icon:2});
        return false;
    }
    //请求ajax
    $.ajax({
        type: "post",
        url : $(this).attr('data-uri'),
        dataType:'json',
        data:{user_name:user_name,mobile:mobile,sms_code:sms_code,send_sms:send_sms,house_id:house_id,group_id:group_id,type:type,model:model,broker_id:broker_id,type:type},
        success: function(json){
            if(json.code==1){
                msg_show(json.msg,1);
                window.setTimeout(hideDiv,1000);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

//找房神探
$('#look_for').click(function(){
    var user_name = $('#user_name').val(),mobile = $('#mobile').val(),money = $('#money').val(),intention=$("#intention").val(),token = $("input[name='__token__']").val(),reg = /^1[3456789][0-9]{9}$/;
    var ids = Array();
    var ids_val = Array();
    $(".checkbox:checked").each(function(i,v){
        ids[i] = $(this).val();
        ids_val[i] = $(this).attr('data-desc');
    });
    var room = ids.join(",");
    var room_val = ids_val.join(",");
    if(!money){
        msg_show('请填写首付金额',2);
        return false;
    }else if(isNaN(Number(money))){
        msg_show('首付金额要填写数字',2);
        return false;
    }else if(!room){
        msg_show('请选择意向户型',2);
        return false;
    }else if(!user_name){
        msg_show('请填写您的姓名',2);
        return false;
    }else if(!reg.test(mobile)){
        msg_show('手机号码格式不正确',2);
        return false;
    }

    //请求ajax
    $.ajax({
        type: "post",
        url : $(this).attr('data-uri'),
        dataType:'json',
        data:{user_name:user_name,mobile:mobile,money:money,room:room,intention:intention,room_val:room_val,token:token,type:10},
        success: function(json){
            if(json.code==1){
                msg_show(json.msg,1);
                window.setTimeout(hideDiv,1000);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

//给经纪人留言
$('#user_message').click(function(){
    var user_name = $('#user_name').val(),mobile = $('#mobile').val(),content=$("#content").val(),broker_id = $("#broker_id").val(),token = $("input[name='__token__']").val(),reg = /^1[3456789][0-9]{9}$/;

    if(!user_name){
        msg_show('请填写您的姓名',2);
        return false;
    }else if(!reg.test(mobile)){
        msg_show('手机号码格式不正确',2);
        return false;
    }else if(!content){
        msg_show('请输入您的留言内容',2);
        return false;
    }

    //请求ajax
    $.ajax({
        type: "post",
        url : $(this).attr('data-uri'),
        dataType:'json',
        data:{user_name:user_name,mobile:mobile,content:content,broker_id:broker_id,token:token},
        success: function(json){
            if(json.code==1){
                msg_show(json.msg,1);
                window.setTimeout(hideDiv,1000);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

$(".request-url").click(function(){
    var url = $(this).attr('request-url');
    var house_id = $(this).attr('data-bid');
    //请求ajax
    $.ajax({
        type: "post",
        url : url,
        dataType:'json',
        data:{house_id:house_id},
        success: function(json){
            if(json.status==1){
                msg_show(json.msg,1);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

$("#getAuthCode").click(function(){
    var url = $("#sms_url").val();
    var house_id = $("#house_id").val();
    var type = $("#type").val();
    var phone = $("#phone").val();
    if(phone==''){
        msg_show('请输入您的手机号码',2);
        return false;
    }
    if(!/^1[34578][0-9]{9}$/.test(phone)){
        msg_show('请输入正确的手机号码',2);
        return false;
    }
    //请求ajax
    $.ajax({
        type: "post",
        url : url,
        dataType:'json',
        data:{house_id:house_id,type:type,phone:phone},
        success: function(json){
            if(json.status==1){
                msg_show(json.msg,1);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

//委托卖房
$('#wt_but').click(function() {
    var user_name = $('#user_name').val(), phone = $('#phone').val(), price = $('#price').val(),
        type = $('#type').val(), sex = $('#sex').val(), estate_name = $("#estate_name").val(),
        token = $("input[name='__token__']").val(), reg = /^1[3456789][0-9]{9}$/;
    var address = $("#add_ldh").val() + '_' + $("#add_dyh").val() + '_' + $("#add_fjh").val();
    var ids = Array();
    var ids_val = Array();
    $(".checkbox:checked").each(function (i, v) {
        ids[i] = $(this).val();
        ids_val[i] = $(this).attr('data-desc');
    });
    var house_type = ids.join(",");
    var house_type_val = ids_val.join(",");
    if (!reg.test(phone)) {
        msg_show('手机号码格式不正确', 2);
        return false;
    } else if (!user_name) {
        msg_show('请填写您的尊称', 2);
        return false;
    } else if (!house_type) {
        msg_show('请选择房产类型', 2);
        return false;
    } else if (!estate_name) {
        msg_show('请填写小区名称', 2);
        return false;
    } else if (!price) {
        msg_show('请填写期望价格', 2);
        return false;
    }
    //请求ajax
    $.ajax({
        type: "post",
        url : $(this).attr('data-uri'),
        dataType:'json',
        data:{user_name:user_name,phone:phone,price:price,estate_name:estate_name,address:address,type:type,sex:sex,house_type:house_type,token:token},
        success: function(json){
            if(json.code==1){
                msg_show(json.msg,1);
                window.setTimeout(hideDiv,1000);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
    });
    //委托找房
    $('#want_to_buy').click(function() {
        var user_name = $('#user_name').val(),phone = $('#phone').val(),price = $('#price').val();
        var type = $('#type').val();
        var sex = $('#sex').val();
        var area_id = $('#area_id').val();
        var token = $("input[name='__token__']").val(),reg = /^1[3456789][0-9]{9}$/;

        if (!reg.test(phone)) {
            msg_show('手机号码格式不正确', 2);
            return false;
        } else if (!user_name) {
            msg_show('请填写您的尊称', 2);
            return false;
        }else if (!price) {
            msg_show('请填写期望价格', 2);
            return false;
        }

        //请求ajax
        $.ajax({
            type: "post",
            url : $(this).attr('data-uri'),
            dataType:'json',
            data:{user_name:user_name,phone:phone,price:price,type:type,sex:sex,area_id:area_id,token:token},
            success: function(json){
                if(json.code==1){
                    msg_show(json.msg,1);
                    window.setTimeout(hideDiv,1000);
                }else{
                    msg_show(json.msg,2)
                }
            }
        });
    });


//搜索
$("#follow").click(function () {
    var house_id = $(this).attr('data-id');
    var url = $(this).attr('data-uri');
    var model = $(this).attr('data-model');
    //请求ajax
    $.ajax({
        type: "post",
        url : url,
        dataType:'json',
        data:{model:model,house_id:house_id},
        success: function(json){
            if(json.code==1){
                msg_show(json.msg,1);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

//加入新房
$("#join_house").click(function(){
    var house_id = $(this).attr('data-id');
    var url = $(this).attr('data-uri');
    //请求ajax
    $.ajax({
        type: "post",
        url : url,
        dataType:'json',
        data:{house_id:house_id},
        success: function(json){
            if(json.code==1){
                $("#join_house").html(json.text);
                msg_show(json.msg,1);
            }else{
                msg_show(json.msg,2)
            }
        }
    });
});

$(".customerBox li").mouseover(function(){
    var aa = $(this).index();
    $('.hk_show').hide().eq(aa).show();
});

//首页搜索
$("#index_tag li a").click(function () {
    var keys = $(this).attr('data-desc');
    var map_url = $(this).attr('data-uri');
    $("#search_val").val(keys);
    $("#map_url").attr('href',map_url);
    $("#index_tag li a").removeClass('selected');
    $(this).addClass('selected');

    $(".search_box p").hide();
    $(".index_"+keys+"_s").show();

});

//底部切换
$('#foot_ul li').mouseover(function(){
    var aa = $(this).index();
    $('#foot_ul a').removeClass("selected");
    $(this).find('a').addClass("selected");
    $('.f_n3').hide().eq(aa).show();
});

//显示二维码
$(".sm-tel").mouseover(function(){
    $(".qrcodebox").show();
});
$(".sm-tel").mouseout(function(){
    $(".qrcodebox").hide();
});

$(".hx_slt img").click(function () {
   var url = $(this).data('uri');
   $(".hx_con").find('img').attr('src',url);
   $(".hx_con").find('a').attr('href',url);
});