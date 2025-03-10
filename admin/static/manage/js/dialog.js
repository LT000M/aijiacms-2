/**
 * Created by junyv on 2017/9/12.
 */
layui.config({
    base: '/static/manage/js/'
});
layui.use(['layer','form','linkmenu'], function(){
    var layer = layui.layer, form = layui.form,$ = layui.jquery;
    /**
     * 弹出层异步提交表单
     */
    $(".J_showDialog").on('click',function(){
       var me = $(this),url = me.data('uri'),height = me.data('height'),width = me.data('width'),title = me.data('title'),btn = ['确定','取消'],btn_flag = me.data('show_btn');
        var num_reg = /\d+/;
        if(num_reg.test(width))
        {
            width = width + 'px';
        }else{
            width = '100%';
        }
        if(num_reg.test(height))
        {
            height = height + 'px';
        }else{
            height = '100%';
        }
        if(btn_flag == false)
        {
            btn = false;
        }
        layer.open({
            type : 2,
            title : title,
            area : [width,height],
            shade : 0.2,
            content : url,
            btn : btn,
            iframeAuto:true,
            yes : function(index,layero){
                var body = layer.getChildFrame('body', index);
                var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象，执行iframe页的方法：iframeWin.method();
                //var child_form = body.find("#info_form");
                //child_form.ajaxForm({success:complate,dataType:'json'}).submit();
                iframeWin.submitForm();
            },
            btn2 : function(index){
               layer.close(index);
            },
            end : function(){
                 //setTimeout(function(){
                 //    window.location.reload();
                 //},300);
            }
        });
    });
    /**
     * 处理单条记录删除
     */
    $(".J_confirm").on('click',this,function(){
        var me = $(this),url = me.data('uri'),msg = me.data('msg');
        layer.confirm(msg,{icon:3,title:'提示信息'},function(index){
            layer.msg('删除中,请稍候……');
            $.get(url,function(result){
                layer.closeAll();
                if(result.code == 1){
                    layer.msg(result.msg,{icon:1});
                    setTimeout(function(){window.location.reload();},1500);
                }else{
                    layer.msg(result.msg,{icon:2});
                }
            });
        });
    });
    //全选
    form.on('checkbox(checkAll)', function(data){
        if(data.elem.checked){
            $("input[lay-filter='checkOne']").prop('checked',true);
            $("input[lay-filter='checkAll']").prop('checked',true);
        }else{
            $("input[lay-filter='checkOne']").prop('checked',false);
            $("input[lay-filter='checkAll']").prop('checked',false);
        }
        form.render('checkbox');
    });
    //选择复选框
    form.on('checkbox(checkOne)', function(data){
        var is_check = true;
        if(data.elem.checked){
            $("input[lay-filter='checkOne']").each(function(){
                if(!$(this).prop('checked')){ is_check = false; }
            });
            if(is_check){
                $("input[lay-filter='checkAll']").prop('checked',true);
            }
        }else{
            $("input[lay-filter='checkAll']").prop('checked',false);
        }
        form.render('checkbox');
    });
    /**
     * 批量操作
     */
    form.on('submit(optionAll)',function(){
        var checkbox = $("input[lay-filter='checkOne']:checked"),result = [],ids = '',
            url = $(this).attr('data-uri'),msg = $(this).attr('data-msg');
            checkbox.each(function(){
                result.push(this.value);
            });
        if(result.length == 0){
            layer.msg('请选择要操作的项目',{icon:2});
        }else{
            ids = result.join(',');//组装id
            layer.confirm(msg,{icon:3,title:'提示信息'},function(index){
                layer.msg('操作中,请稍候……');
                $.get(url,{id:ids},function(result){
                    layer.closeAll();
                    if(result.code == 1){
                        layer.msg(result.msg,{icon:1});
                        setTimeout(function(){window.location.reload();},1500);
                    }else{
                        layer.msg(result.msg,{icon:2});
                    }
                });
            });
        }
    });
    /**
     * 状态切换
     */
    form.on('switch(switchStatus)',function(){
        var field = $(this).attr('data-field'),value = $(this).val(),id = $(this).attr('data-id');
        value     = this.checked ? 1 : 0;
        var url   = $(".list-table").data('uri');
        var param = {
            id : id,
            field : field,
            val   : value
        };
        $.get(url,param,function(result){
            if(result.code == 1){
                layer.msg('状态切换成功',{icon:1});
            }else{
                layer.msg('状态切换失败',{icon:2});
            }
        });
    });
    form.on("select(province)",function(data){
        var province_id = data.value,selectObj = data.elem,level = selectObj.getAttribute('data-level') || 3,  uri = selectObj.getAttribute('data-uri')+'?province_id='+province_id,citySelect = $(".J_city_select");
        $(selectObj).next().next().next().nextAll().remove();
        $("#J_city_id").val(0);
        citySelect.attr('data-uri',uri).html('');
        if(province_id > 0)
        {
            citySelect.select({field : 'J_city_id',id : 'J_city_select',level : level});
            form.render("select");
        }else{
            $(".J_city_select").html('');
            form.render("select");
        }
    });
    //图片预览
    $('.list-table td .thumb').hover(function(){
        $(this).append('<img class="thumb-show" src="'+$(this).attr('data-thumb')+'" >');
    },function(){
        $(this).find('img').remove();
    });
    //修改
    $('span[data-tdtype="edit"]').on('click',this, function() {
        var s_val   = $(this).text(),
            s_name  = $(this).attr('data-field'),
            s_id    = $(this).attr('data-id'),
            url     = $(".list-table").data('uri'),
            width   = $(this).parents('td').width() - 30;
        $('<input type="text" class="lt_input_text" value="'+s_val+'" />').width(width).focusout(function(){
            $(this).prev('span').show().text($(this).val());
            if($(this).val() != s_val) {
                $.getJSON(url, {id:s_id, field:s_name, val:$(this).val()}, function(result){
                    if(result.code == 0) {
                        layer.msg(result.msg,{icon:2});
                        $('span[data-field="'+s_name+'"][data-id="'+s_id+'"]').text(s_val);
                        return;
                    }
                });
            }
            $(this).remove();
        }).insertAfter($(this)).focus().select();
        $(this).hide();
        return false;
    });
    //提示
    $(".alert").hover(function(){
        var that = $(this),alert = that.data('title');
        layer.tips(alert, that, {
            tips: [2, '#0FA6D8']
            ,time:1000000
        });
    },function(){
        layer.closeAll();
    });
    //提示修改属性
    $(".attr-manage").hover(function(){
        var that = $(this),alert = that.data('title');
        layer.tips(alert, that, {
            tips: [2, '#0FA6D8']
            ,time:1000000
        });
    },function(){
        layer.closeAll('tips');
    }).on('click',function(){
        var id = $(this).data('id'),url = $("#attr").val()+"?id="+id,title = $(this).data('alert');
        var field = $(this).data('field'),value = 0,type = $(this).data('type'),cache_url = $("#attr-cache").val();
        param = {
            id : id,
            field : field,
            type  : type
        },box = $(this).parent().next(),value_arr = [];
        switch(type)
        {
            case 'radio':
                value = box.find("input[type='radio']:checked").val();
                break;
            case 'select':
                value = box.find("select").find("option:selected").val();
                break;
            case 'checkbox':
                obj = box.find("input[type='checkbox']:checked");
                obj.each(function(){
                    value_arr.push(this.value);
                });
                value = value_arr.join(',');
                break;
        }
        param.value = value;
        layer.open({
            type: 2,
            title: title,
            area: ['550px', '550px'],
            shade: 0.2,
            shadeClose: true,
            content: url,
            end : function(){
                $.get(cache_url,param,function(result){
                    if(result.code == 1)
                    {
                        box.html(result.data);
                        form.render();
                    }
                });
            }
        });
    });
});
