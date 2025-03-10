var supportsPassive = false, DOAPPEND = 1, SMS_WAIT_TIME = 120, lm = false, URLEXT = '';
try {
    var opts = Object.defineProperty({}, 'passive', {
        get: function () {
            supportsPassive = true;
        }
    });
    window.addEventListener("test", null, opts);
} catch (e) {
}
function in_array(needle, haystack) {
    if(typeof needle == 'string' || typeof needle == 'number') {
        for(var i in haystack) {
            if(haystack[i] == needle) {
                return true;
            }
        }
    }
    return false;
}
function tip_common(msg) {
    var msgar = msg.split('|');
    var type = '';
    if(msgar[0]=='error'){
        type = 'cancel';
    }else if(msgar[0]=='loading'){
        $.showLoading(msgar[1]);
        if (msgar[2]) { setTimeout(function () {
            var jpurl = msgar[2]+(msgar[2].indexOf(_APPNAME+'?id')!==-1?_URLEXT:'');
            if(typeof wx !=='undefined' && jpurl.indexOf('javascript')===-1){
                if (window.__wxjs_environment === 'miniprogram') {
                    GSITE = GSITE.replace(/http:\/\//, 'https://');
                    var needfix = (jpurl.indexOf('http://')===-1&&jpurl.indexOf('https://')===-1) ? (GSITE+''+jpurl) : jpurl;
                    wx.miniProgram.navigateTo({url:'/pages/index/index?url='+encodeURIComponent(needfix)});
                    return false;
                }
            }
            window.location.href = jpurl;
        }, 100); }
        return msgar;
    }
    $.toast(msgar[1], type);
    if (msgar[2]) {
        setTimeout(function () {
            if(msgar[2] == 'reload'){
                window.location.reload();
            }else{
                var jpurl = msgar[2]+(msgar[2].indexOf(_APPNAME+'?id')!==-1?_URLEXT:'');
                if(typeof wx !=='undefined' && jpurl.indexOf('javascript')===-1){
                    if (window.__wxjs_environment === 'miniprogram') {
                        GSITE = GSITE.replace(/http:\/\//, 'https://');
                        var needfix = (jpurl.indexOf('http://')===-1&&jpurl.indexOf('https://')===-1) ? (GSITE+''+jpurl) : jpurl;
                        wx.miniProgram.navigateTo({url:'/pages/index/index?url='+encodeURIComponent(needfix)});
                        return false;
                    }
                }
                window.location.href = jpurl;
            }
        }, 2000);
    }
    return msgar;
}
function hb_jump(jpurl){
    if(typeof wx !=='undefined' && jpurl.indexOf('javascript')===-1){
        if (window.__wxjs_environment === 'miniprogram') {
            GSITE = GSITE.replace(/http:\/\//, 'https://');
            var needfix = (jpurl.indexOf('http://')===-1&&jpurl.indexOf('https://')===-1) ? (GSITE+''+jpurl) : jpurl;
            wx.miniProgram.navigateTo({url:'/pages/index/index?url='+encodeURIComponent(needfix)});
            return false;
        }
    }
    window.location.href = jpurl;
}
function setTypeid(id, obj) {
    $('#tagid').val(id);
    if ($(obj).hasClass('tag-on')) {
        $(obj).removeClass('tag-on');
        $('input[name="form[tagid][' + id + ']"]').val('0');
    } else {
        var MaxTagNum = parseInt(MAXTAG);
        if(MaxTagNum>0 && $('.tag-on').length>MaxTagNum-1){
            $.toast(MAXTAGTIP);
            return false;
        }
        $(obj).addClass('tag-on');
        $('input[name="form[tagid][' + id + ']"]').val('1');
    }
}
function hb_slider(_this, auto) {
    var bullets = _this.find('nav.bullets');
    var position = _this.find('ul.position');
    new Swipe2(_this[0], {
        startSlide: 0, speed: 500, auto: auto, continuous: true, callback: function (index) {
            if (bullets.length > 0) {
                bullets.find('em:first-child').text(index + 1);
            }
            if (position.length > 0) {
                var selectors = position[0].children;
                for (var t = 0; t < selectors.length; t++) {
                    selectors[t].className = selectors[t].className.replace("current", "");
                }
                selectors[(index) % (selectors.length)].className = "current";
            }
        }
    });
}
function confirm_del(word, url, id) {
    $.confirm(word, function () {
        $.showLoading();
        $.ajax({
            type: 'post',
            url: url + _URLEXT + '&inajax=1',
            dataType: 'xml',
            success: function (data) {
                $.hideLoading();
                if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                var s = data.lastChild.firstChild.nodeValue;
                tip_common(s);
                $('#li_'+id).remove();
            },
            error: function () {
                $.hideLoading();
            }
        });
    }, function () {
    });
    return false;
}
function do_comment(pubid, touid, title, type, cmtid) {
    if(ISADMINID && typeof cmtid!='undefined'){
        $.modal({
            title: title,
            text: "<div class=\"b-color13\"><textarea class=\"weui-textarea weui-prompt-input needsclick\" id=\"weui-modal-input\" placeholder=\""+PLZINPUT+"\" rows=\"3\"></textarea></div>",
            buttons: [
                { text: QUXIAO, className: "default", onClick: function(){} },
                { text: SHANCHU, className: "default", onClick: function(){
                    $.showLoading();
                    $.ajax({ type: 'post', url: _APPNAME +'?id=tfy&ac=misc&do=comment&do1=del&inajax=1', data: {'cmtid': cmtid, 'formhash' :FORMHASH},dataType: 'xml',
                        success: function (data) { $.hideLoading();
                            if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                            var s = data.lastChild.firstChild.nodeValue;
                            tip_common(s);
                        }, error: function () {$.hideLoading(); }
                    });} },
                { text: QUEDING, className: "primary", onClick: function(){
                        var input = $('#weui-modal-input').val();
                        $.showLoading();
                        $.ajax({
                            type: 'post',
                            url: _APPNAME +'?id=tfy&ac=misc&do=comment&inajax=1&type='+type+'&pubid='+pubid,
                            data: {'comment': input, 'touid': touid, 'formhash' :FORMHASH},
                            dataType: 'xml',
                            success: function (data) {
                                $.hideLoading();
                                if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                                var s = data.lastChild.firstChild.nodeValue;
                                var msgar = tip_common(s);
                                if(msgar[0] =='success'){
                                    var cmurl = _APPNAME +'?id=tfy&ac=comment_li&cid='+msgar[3]+'&inajax=1';
                                    if($('#comment_ul_'+pubid).length>0) {
                                        cmurl= cmurl +'&multi=1';
                                    }
                                    $.ajax({
                                        type: 'get',
                                        url: cmurl,
                                        dataType: 'xml',
                                        success: function (data) {
                                            if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                                            var s = data.lastChild.firstChild.nodeValue;
                                            $('#cmt_wrap_'+pubid).show();
                                            $('#r_'+pubid).show();
                                            $('#cmt_list_'+pubid).show().prepend(s);
                                            $('#comment_ul_'+pubid).show().prepend(s);
                                        }
                                    });
                                }
                            },
                            error: function () { $.hideLoading();}
                        });
                    } },
            ]
        });
        return false;
    }
    $.prompt({
        title: title,
        input: PLZINPUT,
        empty: false,
        onOK: function (input) {
            $.showLoading();
            $.ajax({
                type: 'post',
                url: _APPNAME +'?id=tfy&ac=misc&do=comment&inajax=1&type='+type+'&pubid='+pubid,
                data: {'comment': input, 'touid': touid, 'formhash' :FORMHASH},
                dataType: 'xml',
                success: function (data) {
                    $.hideLoading();
                    if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                    var s = data.lastChild.firstChild.nodeValue;
                    var msgar = tip_common(s);
                    if(msgar[0] =='success'){
                        var cmurl = _APPNAME +'?id=tfy&ac=comment_li&cid='+msgar[3]+'&inajax=1';
                        if($('#comment_ul_'+pubid).length>0) {
                            cmurl= cmurl +'&multi=1';
                        }
                        $.ajax({
                            type: 'get',
                            url: cmurl,
                            dataType: 'xml',
                            success: function (data) {
                                if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                                var s = data.lastChild.firstChild.nodeValue;
                                $('#cmt_wrap_'+pubid).show();
                                $('#r_'+pubid).show();
                                $('#cmt_list_'+pubid).show().prepend(s);
                                $('#comment_ul_'+pubid).show().prepend(s);
                            }
                        });
                    }
                },
                error: function () {
                    $.hideLoading();
                }
            });
        },
        onCancel: function () {
        }
    });
}
function load_morelist(){
    if(page<=0 || typeof loadingurl=='undefined'){return;}
    if(!loadingurl){ return; }
    if(lm){ return;}
    lm = true;

    $('#loading-show').removeClass('hidden');
    $.ajax({
        type: 'get',
        url: loadingurl+''+page+_URLEXT,
        dataType: 'xml',
        success: function (data) {
            if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
            var s = $.trim(data.lastChild.firstChild.nodeValue);
            $('#loading-show').addClass('hidden');
            if(!s){
                $('#loading-none').removeClass('hidden');
                page = -1;
                return ;
            }
            $("#list").append(s);
            hb_incr(s);
            lm = false;
            console.log('curpage:'+page);
            if(typeof loadingCallback !=='undefined'){
                loadingCallback();
            }
            page ++;
        },
        error: function() {
            lm = false;
            $('#loading-show').addClass('hidden');
        }
    });
}
function load_common_list(url, id){
    $.ajax({
        type: 'get',
        url: url+_URLEXT,
        dataType: 'xml',
        success: function (data) {
            if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
            var s = data.lastChild.firstChild.nodeValue;
            $("#"+id).append(s);
        }
    });
}
function showfull(id, mobile, telp, catid, callwx){
    var html = '';
    $('#view_jump_'+id).removeClass('is-three');
    if(catid){
        html = '<a class="mb8 h30 weui-btn weui-btn_mini" href="javascript:hb_paytel('+id+','+telp+','+catid+');"><i class="iconfont icon-dianhua2"></i>'+BODA+'</a>';
    }else if(callwx){
        html = '<a class="mb8 h30 weui-btn weui-btn_mini" href="javascript:;" onclick="lxfs_tip(this, \''+mobile+'\', \''+callwx+'\');return false;">'+CKLXFS+'</a>';
    }else if(mobile){
        html = '<a class="mb8 h30 weui-btn weui-btn_mini" href="tel:'+mobile+'"><i class="iconfont icon-dianhua2"></i>'+BODA+'</a>';
    }
    $('#showfull_'+id).replaceWith(html);
    $.ajax({
        type: 'post',
        url: _APPNAME +'?id=tfy&ac=incr&incr_type=views&pubid='+id+'&inajax=1',
        data: {'formhash':FORMHASH},
        dataType: 'xml',
        success: function (data) {},
        error: function () {}
    });
}
function hb_setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
    if (seconds) {
        var expires = new Date();
        expires.setTime(expires.getTime() + seconds * 1000);
    }
    domain = !domain ? cookiedomain : domain;
    path = !path ? cookiepath : path;
    document.cookie = encodeURIComponent(cookiepre + cookieName) + '=' + encodeURIComponent(cookieValue) + (expires ? '; expires=' + expires.toGMTString() : '') + (path ? '; path=' + path : '/') + (domain ? '; domain=' + domain : '') + (secure ? '; secure' : '');
}
function hb_getcookie(name, nounescape) {
    name = cookiepre + name;
    var cookie_start = document.cookie.indexOf(name);
    var cookie_end = document.cookie.indexOf(";", cookie_start);
    if(cookie_start === -1) {
        return '';
    } else {
        var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
        return !nounescape ? unescape(v) : v;
    }
}
function hb_incr(s){
    if(LISTINCR!='1'){ return; }
    var viewsid = '';
    $(s).find('.view_jump').each(function () {
        viewsid+=','+$(this).data('id');
    });
    if(viewsid){
        $.ajax({
            type: 'post',
            url: _APPNAME +'?id=tfy&ac=incr&incr_type=views&pubids='+viewsid+'&inajax=1',
            data: {'formhash':FORMHASH}, dataType: 'xml'
        });
    }
}
var toutiao_timeout;
function noti_toutiao(text, duration, index) {
    if(!text){return ;}
    var $t = $('.noti').remove();
    $t = $('<div class="noti"></div>').appendTo(document.body);
    $t.html(text);
    clearTimeout(toutiao_timeout);
    if(!$t.hasClass('noti_visible')) {
        $t.addClass('noti_visible');
    }
    toutiao_timeout = setTimeout(function() {
        $t.removeClass('noti_visible').transitionEnd(function() {
            $t.remove();
        });
        noti_toutiao(TOUTIAOS[index+1], duration+1000, index+1);
    }, duration);
}
$(function () {
    FastClick.attach(document.body);
    $("#datetime-picker").datetimePicker();
    $('div.swipe').each(function () {
        hb_slider($(this), $(this).data('speed') || 3000);
        $(this).css('height', 'auto');
    });
    $('nav.swipe').each(function () {
        hb_slider($(this), 0);
        $(this).css('height', 'auto');
    });
    if($('#newsSlider').length>0){
        var newsObj = $('#newsSlider');
        var newsSlider = new Swiper('#newsSlider', {
            autoplay: typeof newsObj.data('autoplay')!=='undefined' ? newsObj.data('autoplay') : 3000,
            spped:  typeof newsObj.data('spped')!=='undefined' ? newsObj.data('spped') : 1000,
            direction:'vertical',
            onlyExternal:true,
            loop: true
        });
    }
    var imgswiper =null, lgtbox = $('#globalLightbox');
    $(document).on('click', '.imgloading', function () {
        var that = $(this), imgh = '';
        if(that.hasClass('view_jump')){
            return false;
        }
        that.parent().find('img').each(function () {
            imgh += "<div class=\"swiper-slide\"><img src=\""+$(this).attr('src')+"\"></div>";
        });
        $('#globalWrapper').html(imgh);
        lgtbox.show().removeClass('zoomOut').addClass('zoomIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            lgtbox.show();
        });
        imgswiper = new Swiper('#globalLightbox', {
            pagination: '.lightbox-pagination',
            paginationType: 'fraction',
            loop: true
        });
        imgswiper.slideTo(that.parent().find('.imgloading').index(that)+1,0);
        return false;
    });
    $(document).on('click', '#globalLightbox', function () {
        lgtbox.removeClass('zoomIn').addClass('zoomOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            lgtbox.hide();
            imgswiper.destroy();
        });
        return false;
    });
    $(document).on('click', '.weui-uploader__file', function () {
        var that = $(this);
        $.confirm(DELCONFIRM, function () {
            that.remove();
        }, function () {
        });
        return false;
    });
    $(document).on('submit', '#form', function () {
        var that = $(this);
        $.showLoading();
        $('#dosubmit').attr('disabled', '1');
        $.ajax({
            type: 'post',
            url: that.attr('action') + '&inajax=1'+_URLEXT,
            data: that.serialize(),
            dataType: 'xml',
            success: function (data) {
                $.hideLoading();
                $('#dosubmit').removeAttr('disabled');
                if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                var s = data.lastChild.firstChild.nodeValue;
                tip_common(s);
            },
            error: function () {
                $.hideLoading();
                $('#dosubmit').removeAttr('disabled');
            }
        });
        return false;
    });
    $(document).on('change', '.hb_switch', function () {
        var that = $(this);
        if (that.is(':checked')) {
            $('#hb_field').slideDown();
        } else {
            $('#hb_field').slideUp();
        }
        return false;
    });
    $(document).on('change', '.kl_switch', function () {
        var that = $(this);
        if (that.is(':checked')) {
            $('#kl_field').slideDown().css('display', 'flex');
        } else {
            $('#kl_field').slideUp();
        }
        return false;
    });
    $(document).on('click', '.c-icon', function () {
        var nxt = $(this).next('.touch-panel');
        if(nxt.hasClass('slideInRight')){
            nxt.removeClass('slideInRight').addClass('slideOutRight');
        }else{
            nxt.removeClass('slideOutRight').addClass('slideInRight');
        }
        return false;
    });
    $(document).on('click', '.praise', function () {
        var that = $(this);
        var did = that.attr('data-id');
        if(!that.attr('data-href')){
            return false;
        }
        if(UID <1){
            window.location.href = "member.php?mod=logging&action=login";
            return false;
        }
        $.ajax({
            type: 'post',
            url: that.attr('data-href') + '&inajax=1',
            data: that.serialize(),
            dataType: 'xml',
            success: function (data) {
                if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                var s = data.lastChild.firstChild.nodeValue;
                if(s.indexOf('success')!==-1){
                    $('#praise_'+did).removeClass('icon-jinlingyingcaiwangtubiao44').addClass('icon-jinlingyingcaiwangtubiao24');
                    $('#heart').addClass('heartAnimation');
                    var old = parseInt($('#praises_'+did).text());
                    $('#praises_'+did).text(old+1);
                    $('#praise_list_'+did).prepend('<a><img src="'+AVATAR+'" /> </a>');

                    $('#cmt_wrap_'+did).show();
                    $('#r_'+did).show();
                }else{
                    tip_common(s);
                }
            },
            error: function () {
            }
        });
        $('#c_icon_'+did).trigger('click');
        return false;
    });
    $(document).on('click', '.comment', function () {
        var that = $(this);
        var cmtid= that.data('id');
        do_comment(cmtid, 0, SUIBIANSHUO, 0);
        $('#c_icon_'+cmtid).trigger('click');
        return false;
    });
    $(document).on('click', '.comment_to', function () {
        var that = $(this);
        do_comment(0, that.data('uid'), FASIXIN, 1);
        $('#c_icon_'+that.data('id')).trigger('click');
        return false;
    });
    $(document).on('click', '.cmt_p', function () {
        var that = $(this);
        var _pbid = that.parent().data('id') || that.data('pubid');
        do_comment(_pbid,  that.data('authorid'), HUIFU1+ that.data('author'), that.data('type')?1:0, that.data('cmtid'));
        return false;
    });
    $(document).on('click', '.view_jump', function () {
        var that = $(this);
        var jmpurl = _APPNAME +'?id=tfy&ac=view&pubid='+that.data('id')+(that.data('stid')? '&st='+that.data('stid') : '')+(typeof _URLEXT!=='undefined'? _URLEXT : '');
        if(typeof mag !== 'undefined'){
            mag.newWin(GSITE+jmpurl);
            return false;
        }
        if(typeof sq !== 'undefined'){
            sq.urlRequest(GSITE+jmpurl);
            return false;
        }
        if(typeof wx !=='undefined'){
            if (window.__wxjs_environment === 'miniprogram') {
                GSITE = GSITE.replace(/http:\/\//, 'https://');
                wx.miniProgram.navigateTo({url:'/pages/index/index?url='+encodeURIComponent(GSITE+jmpurl)});
                return false;
            }
        }
        if(typeof QFH5 !== 'undefined'){
            QFH5.jumpNewWebview(GSITE+jmpurl);
            return false;
        }
        window.location.href = jmpurl;
        return false;
    });

    var re_ac = md5(window.location.href);
    var re_sto = 'ofst_'+re_ac;
    var re_page = 'listpage_'+re_ac;
    var re_data = 'listdata_'+re_ac;
    if($("#list").length>0){
        var infi = $(document.body);
        if($('.page__ios').length>0){ infi = $('.page__ios');}
        infi.infinite().on("infinite", function() {load_morelist();});

        if(scrollto && sessionStorage.getItem(re_page)){
            $('#list').html(sessionStorage.getItem(re_data));
            page = sessionStorage.getItem(re_page);
            $(document).scrollTop(sessionStorage.getItem(re_sto));
        }else{
            load_morelist();
        }
    }
    $(window).scroll(function() {
        if ($(window).scrollTop()> 350) {
            $('#backtotop').addClass('backtotop_show');
            if(scrollto){
                sessionStorage.setItem(re_sto, $(window).scrollTop());
                sessionStorage.setItem(re_data, $('#list').html());
                if(page>=1){ sessionStorage.setItem(re_page, page); }
            }
        } else {
            $('#backtotop').removeClass('backtotop_show');
            if(scrollto){
                sessionStorage.removeItem(re_page);
                sessionStorage.removeItem(re_data);
                sessionStorage.removeItem(re_sto);
            }
        }
    });

    $(document).on('click', '.qiang', function () {
        if(typeof hbareaallow !=='undefined') {
            if(!hbareaallow()){
                return false;
            }
        }
        if(typeof menuShareGet == 'function'){
            menuShareGet();
            return false;
        }
        if($('#media').length>0){
            var audio = document.getElementById("media");
            audio.play();
        }
        $('.we_share,.hs_share').trigger('click');
        return false;
    });
    $(document).on('click','#backtotop', function () {
        $('body,html').animate({scrollTop: 0}, 500);
        return false;
    });
    $(document).on('click','.dist_nav', function () {
        $(this).addClass('weui_bar__item_on').siblings().removeClass('weui_bar__item_on');
        var curt = $('#dist_show_'+$(this).data('id'));
        curt.siblings().removeClass('show');
        curt.toggleClass('show');
        if(curt.hasClass('show')){
            $('.mask').show();
        }else{
            $('.mask').hide();
        }
        if(IN_APP=='magapp'){
            $('#backtotop').trigger('click');
        }
        return false;
    });
    $(document).on('click','.mask', function () {
        $('.dist_show').find('.nav_expand_panel').removeClass('show');
        $(this).hide();
    });
    $(document).on('click','.first_check', function () {
        var that = $(this);
        if(that.data('id')){
            $('.sub_cheker').hide();
            $('#sub_cheker_'+that.data('id')).show().parent().addClass('checked');
            that.addClass('checked main_color').siblings().removeClass('checked main_color');
            if(IN_APP=='magapp'){
                $('#backtotop').trigger('click');
            }
            return false;
        }
    });
    $(document).on('click','.first_cat_check', function () {
        var that = $(this);
        if(that.data('id')){
            $('.sub_cat_cheker').hide();
            $('#sub_cat_cheker_'+that.data('id')).show().addClass('checked');
            that.addClass('checked main_color').siblings().removeClass('checked main_color');
            if(IN_APP=='magapp'){
                $('#backtotop').trigger('click');
            }
            return false;
        }
    });
    $(document).on('click','.ajaxcat', function () {
        var that = $(this);
        page = 1;
        loadingurl = window.location.href+'&ac=list_item&inajax=1&cat_id='+that.data('id')+'&page=';
        if(that.data('loadingurl')){
            loadingurl = that.data('loadingurl');
        }
        that.addClass('weui_bar__item_on').siblings().removeClass('weui_bar__item_on');
        DOAPPEND = 0;
        $.ajax({
            type: 'get',
            url: loadingurl+''+page,
            dataType: 'xml',
            success: function (data) {
                if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                var s = data.lastChild.firstChild.nodeValue;
                $('#loading-show').addClass('hidden');
                if(!s){
                    $('#loading-show').addClass('hidden');
                    $('#loading-none').removeClass('hidden');
                    setTimeout(function () {
                        $('#loading-show').addClass('hidden');
                        $('#loading-none').removeClass('hidden');
                    }, 300);
                    $("#list").html(s);
                    page = -1;
                    return ;
                }
                $("#list").html(s);
                if(typeof loadingCallback !=='undefined'){
                    loadingCallback();
                }
                page ++;
                hb_incr(s);
            },
            error: function() {
            }
        });
    });
    $(document).on('click','.we_share', function () {
        var that = $(this);
        var pbid = that.data('id');
        $('#wechat-mask').show();
        if(sessionStorage.getItem('ws'+pbid)){
            /*return false;*/
        }
        $.ajax({
            type: 'post',
            url: _APPNAME +'?id=tfy&ac=incr&incr_type=shares&pubid='+pbid+'&inajax=1',
            data: {'formhash':FORMHASH},
            dataType: 'xml',
            success: function (data) {
                sessionStorage.setItem('ws'+pbid, 1);
            }
        });
    });
    $(document).on('click','#wechat-mask', function () {
        $('#wechat-mask').hide();
    });
    $(document).on('click','.hong_close', function () {
        $('#hong_res').addClass('zoomOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $('#hong_res').hide();
        });
    });
    $(document).on('click', '#vcodebtn', function () {
        var mobile = $.trim($('input[name="form[mobile]"]').val());
        if(mobile){
            $.ajax({
                type: 'post',
                url: _APPNAME +'?id=tfy&ac=sendsms&inajax=1',
                data: {'formhash':FORMHASH, 'mobile':mobile},
                dataType: 'xml',
                success: function (data) {
                    if(null==data){ tip_common('error|'+ERROR_TIP); return false;}
                    var s = data.lastChild.firstChild.nodeValue;
                    if(s.split('|')[0]=='success'){
                        sms_time();
                    }else{
                        tip_common(s);
                    }
                },
                error: function () {}
            });
        }else{
            $.toast(plzinput_mobile);
        }
    });
    $(document).on('click','.weui-dialog__bd,.weui-dialog__hd', function () { $('.needsclick').focus(); });
    $(document).on('click','#fav_guide_mask', function () { $(this).hide(); hb_setcookie('disfav_uid', 1, 86400) });
    $(document).on('click', '.view_ctrl', function(){
        $('.view_tools').removeClass('none');
        $('.view_tools_mask').removeClass('none');
    });
    $(document).on('click', '.view_tools_mask', function(){
        $(this).addClass('none');
        $('.view_tools').addClass('none');
    });
    $(document).on('click', '.sh_jump', function () {
        var that = $(this);
        var jmpurl = _APPNAME +'?id=xigua_hs&ac=view&shid='+that.data('id')+(typeof _URLEXT!=='undefined'? _URLEXT : '');
        if(typeof mag !== 'undefined'){
            mag.newWin(GSITE+jmpurl);
            return false;
        }
        if(typeof sq !== 'undefined'){
            sq.urlRequest(GSITE+jmpurl);
            return false;
        }
        if(typeof wx !=='undefined'){
            if (window.__wxjs_environment === 'miniprogram') {
                GSITE = GSITE.replace(/http:\/\//, 'https://');
                wx.miniProgram.navigateTo({url:'/pages/index/index?url='+encodeURIComponent(GSITE+jmpurl)});
                return false;
            }
        }
        if(typeof QFH5 !== 'undefined'){
            QFH5.jumpNewWebview(GSITE+jmpurl);
            return false;
        }
        window.location.href = jmpurl;
        return false;
    });
    if($('#fav_guide_mask').length >0 ){
        hb_setcookie('disfav_uid', 1, 86400);
    }
    if(typeof QFH5 !== 'undefined' || typeof sq !== 'undefined'/* || typeof mag !== 'undefined'*/){
        $('a').each(function () {
            var that = $(this);
            var thhf = that.attr('href');
            if (thhf && thhf.indexOf('tel') === -1 && thhf.indexOf('sms') === -1 && thhf.indexOf('java') === -1 && thhf !== _APPNAME+'?id=tfy' && thhf.indexOf('&city=') === -1) {
                that.attr('xcx-href', thhf+(typeof _URLEXT!=='undefined'? _URLEXT : ''));
                that.removeAttr('href');
            }
        });
        $(document).on('click', 'a', function () {
            var jmpurl = $(this).attr('xcx-href');
            if(typeof jmpurl!=='undefined' && jmpurl) {
                if (jmpurl.indexOf('https://') === -1 && jmpurl.indexOf('http://') === -1) {
                    jmpurl = GSITE + jmpurl;
                }
                if(typeof sq !== 'undefined'){
                    sq.urlRequest(jmpurl);
                    return false;
                }
                if(typeof mag !== 'undefined'){
                    mag.newWin(jmpurl);
                }else if(typeof QFH5 !== 'undefined'){
                    QFH5.jumpNewWebview(jmpurl);
                }else{
                    jmpurl = jmpurl.replace(/http:\/\//, 'https://');
                    wx.miniProgram.navigateTo({url: '/pages/index/index?url=' + encodeURIComponent(jmpurl)});
                }
                return false;
            }
        });
    }else if(typeof _URLEXT!=='undefined'){
        if(_URLEXT!=='&' && _URLEXT){
            $(document).on('click','a', function () {
                var that = $(this);
                var hrf = that.attr('href');
                if(hrf && hrf.indexOf('javascript')===-1&& hrf.indexOf('tel')===-1&& hrf.indexOf('sms')===-1&& hrf.indexOf('st=')===-1){
                    console.log(hrf);
                    if(hrf.indexOf('?')===-1){
                        window.location.href = hrf.replace(_URLEXT,'')+'?'+_URLEXT;
                    }else{
                        window.location.href = hrf.replace(_URLEXT,'')+_URLEXT;
                    }
                    return false;
                }
                return true;
            });
        }
    }
    /*if(typeof TOUTIAOS !== 'undefined'){
        if(TOUTIAOS){
            noti_toutiao(TOUTIAOS[0], 3000, 0);
        }
    }
    if(UID>0){$.ajax({type: 'get',url: _APPNAME +'?id=tfy&ac=reach&formhash='+FORMHASH,dataType: 'xml',success: function (data) {},});}*/
    if(typeof mag !== 'undefined' && typeof f_getOption!=='undefined' ){
        var f_option = f_getOption();
        mag.setTitle(f_option.title);mag.showMore();
    }
    if(typeof XL!=='undefined'){$(document.body).pullToRefresh(function() {window.location.reload();$(document.body).pullToRefreshDone();});}
});