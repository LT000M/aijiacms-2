(function($){
  $.fn.scrollFloor = function(options){
    var settings = {
      oNav: 'scroll_nav',
      navLi: 'li',
      floor:'floor',
      follow : false,
      reduceHeight : 50
    };
    if(options) {
      $.extend(settings, options);
    }
    var oNav = $('.'+settings.oNav);//导航壳
    var nav_li = oNav.find(settings.navLi);//导航
    var aDiv = $('.'+settings.floor);//楼层
    // var oTop = $('#goTop');
    var oNav_top = oNav.offset().top;
    var oNav_h = oNav.height();
    nav_li.click(function(){
      var t = aDiv.eq($(this).index()).offset().top - oNav_h - settings.reduceHeight;
      $('body,html').animate({"scrollTop":t},500);
      $(this).addClass('active').siblings().removeClass('active');
    });
    //导航和楼层联动
    if(settings.follow) {
      $(window).scroll(function(){
        var winH = $(window).height();//可视窗口高度
        var iTop = $(window).scrollTop();//鼠标滚动的距离
        var bodyH = $('body').height();

        if(iTop >= oNav_top){
          //鼠标滑动式改变
          aDiv.each(function(index){
            if(iTop == bodyH - winH){
              nav_li.removeClass('active');
              nav_li.eq(aDiv.length - 1).addClass('active');
            }
            else if(iTop >= $(this).offset().top-oNav_h + settings.reduceHeight){
              nav_li.removeClass('active');
              nav_li.eq(index).addClass('active');
            }
          })
        }
      });
    }
  }
})(jQuery);

