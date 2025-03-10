function kaidan_tab(obj){
                
    var bStop = false,
        bStopIndex = 0,
        href = $(obj).attr('data-href'),
        title = $(obj).attr("data-title"),
        topWindow = $(window.top.document),

        show_navLi = topWindow.find("#min_title_list li"),
        iframe_box = topWindow.find("#iframe_box");

        
    //console.log(topWindow);
    if(!href||href==""){
        
        return false;
    }if(!title){
        
        return false;
    }
    if(title==""){
        
        return false;
    }
    show_navLi.each(function() {
        if($(this).find('span').attr("data-href")==href){
            bStop=true;
            bStopIndex=show_navLi.index($(this));
            return false;
            
        }
    });
    if(!bStop){
        creatIframe(href,title);
        min_titleList();
        
    }
    else{
        show_navLi.removeClass("active").eq(bStopIndex).addClass("active");         
        iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src",href);
        
    }   
}

function creatIframe(href,titleName){
        var topWindow=$(window.top.document),
          show_nav=topWindow.find('#min_title_list'),
          iframe_box=topWindow.find('#iframe_box'),
          iframeBox=iframe_box.find('.show_iframe'),
          $tabNav = topWindow.find(".acrossTab"),
          $tabNavWp = topWindow.find(".Hui-tabNav-wp"),
          $tabNavmore =topWindow.find(".Hui-tabNav-more");
        var taballwidth=0;
        show_nav.find('li').removeClass("active");  
        show_nav.append('<li class="active"><span data-href="'+href+'">'+titleName+'</span><i></i><em></em></li>');
        if('function'==typeof $('#min_title_list li').contextMenu){
          $("#min_title_list li").contextMenu('Huiadminmenu', {
            bindings: {
              'closethis': function(t) {
                var $t = $(t);        
                if($t.find("i")){
                  $t.find("i").trigger("click");
                }
              },
              'closeall': function(t) {
                $("#min_title_list li i").trigger("click");
              },
            }
          });
        }else {} 
        var $tabNavitem = topWindow.find(".acrossTab li");
        if (!$tabNav[0]){return}
        $tabNavitem.each(function(index, element) {
              taballwidth+=Number(parseFloat($(this).width()+60))
          });
        $tabNav.width(taballwidth+25);
        var w = $tabNavWp.width();
        if(taballwidth+25>w){
          $tabNavmore.show()}
        else{
          $tabNavmore.hide();
          $tabNav.css({left:0})
        } 
        iframeBox.hide();
        iframe_box.append('<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src='+href+'></iframe></div>');
        var showBox=iframe_box.find('.show_iframe:visible');
        showBox.find('iframe').load(function(){
          showBox.find('.loading').hide();
        });
}

/*弹出层*/
/*
参数解释：
title 标题
url   请求的url
id    需要操作的数据id
w   弹出层宽度（缺省调默认值）
h   弹出层高度（缺省调默认值）
*/
function layer_show(title,url,w,h){
  if (title == null || title == '') {
    title=false;
  };
  if (url == null || url == '') {
    url="404.html";
  };
  if (w == null || w == '') {
    w=800;
  };
  if (h == null || h == '') {
    h=($(window).height() - 50);
  };
  layer.open({
    type: 2,
    area: [w+'px', h +'px'],
    fix: false, //不固定
    maxmin: true,
    shade:0.4,
    title: title,
    content: url
  });
}