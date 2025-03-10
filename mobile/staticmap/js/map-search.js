/**
 * Created by junyv on 2017/7/15.
 */
$(function(){
    $("#select_head .item").on('click',function(){
        if($(this).hasClass('active')){
            $("#select_body").children().removeClass('active');
            $(this).removeClass('active');
            $('#select_bg').hide();
        }else{
            var index = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            $("#select_body").children().removeClass('active').eq(index).addClass('active');
            $('#select_bg').show();
        }
    });
    $('.one-level li').on('click',function(){
        var id = $(this).data('id'),child = '',text = $(this).text(),
            li = '<li class="active" data-id="'+id+'"><a href="javascript:;">全'+$(this).text()+'</a></li>',
            url = $(this).parent().data('uri');
        if(id!=0){
            $.get(url,{pid:id},function(result){
                if(result.code == 1)
                {
                    child = result.data;
                    for(var i in child){
                        li += '<li data-id="'+child[i]['id']+'"><a href="javascript:;">'+child[i]['name']+'</a></li>';
                    }
                    $("#select_head div:first").attr('data-id',id);
                    $(".two-level").html(li);console.log(result.data);
                }else{
                    hidePannel(id,text,0);
                    $(".two-level").html('');
                }
                BMapApplication.setCenter(result.points.lng,result.points.lat,result.points.name);
            });
        }else{
            hidePannel(id,$(this).text(),0);
        }
    });
    $(".two-level").on('click','li',function(){
        var id = $(this).data('id');
        $(this).addClass('active').siblings().removeClass('active');
        hidePannel(id,$(this).text(),0);
    });
    $(".attr li").on('click',function(){
        var id = $(this).data('id'),index = $('#select_head').find('.active').index();
        $(this).addClass('active').siblings().removeClass('active');
        hidePannel(id,$(this).text(),index);
    });
    $("#more li").on('click', function () {
        $(this).addClass('active').siblings().removeClass('active');
    });
    $("#more_reset").on('click',function(){
        var obj = $("#more ul");
        obj.each(function(){
            $(this).children().removeClass('active').eq(0).addClass('active');
        });
    });
    $('#search-btn').on('click', function () {
        $("#attr").removeClass('active');
        $("#select_head div:last").removeClass('active');
        $(this).parents('.item').removeClass('active');
        $('#select_bg').hide();
        $('#lists').html('');
        BMapApplication.requestParam = getParam();
        BMapApplication.getData();
    });
});
function hidePannel(id,txt,index){console.log(id,txt);
    $("#select_head").children().removeClass('active').eq(index).attr('data-id',id).find('.tit').text(txt);
    $("#select_body").children().eq(index).removeClass('active');
    $('#select_bg').hide();
    $('#lists').html('');
    BMapApplication.requestParam = getParam();
    BMapApplication.getData();
}
window.onload = function(){
    var h = document.documentElement.clientHeight,_h1 = $('.top').height(),_h2 = $('.lr-select-box').height();
    $("#map").height(h-_h1-_h2);
}