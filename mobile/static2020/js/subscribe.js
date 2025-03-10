/**
 * Created by junyv on 2018/4/5.
 */
$(function(){
    $('.follow').on('click',function(){
        var house_id = $(this).data('id'),model = $(this).data('model'),url = $(this).data('uri'),me = $(this);
        $.post(url,{house_id:house_id,model:model},function(result){
            if(result.code == 1)
            {
                layer.msg(result.msg,{icon:1});
                if(me.hasClass('on'))
                {
                    me.removeClass('on').text(result.text);
                }else{
                    me.addClass('on').text(result.text);
                }
            }else{
                layer.msg(result.msg,{icon:2});
            }
        });
    });
    $('.dialog').on('click',function(){
        var me=$(this),w = '90%',h = '260px',house_id=me.data('id'),model = me.data('model'),type = me.data('type'),url = me.data('uri'),money = me.data('money'),hname = me.data('hname'),username = me.data('username'),typename = me.data('typename');
        url = url + '?house_id='+house_id+'&type='+type+'&model='+model+'&money='+money+'&hname='+hname+'&username='+username+'&typename='+typename;
        layer.open({
            type: 2,
            title: false,
            fix:true,
            move:false,
            area: [w, h],
            shade: 0.8,
            closeBtn: 1,
            shadeClose: true,
            content: url
        });
    });
});