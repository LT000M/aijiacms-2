/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
var UA = navigator.userAgent.toLowerCase();
var isIE = (document.all && window.ActiveXObject && !window.opera) ? true : false;
var isGecko = UA.indexOf('webkit') != -1;
var DMURL = document.location.protocol+'//'+location.hostname+(location.port ? ':'+location.port : '')+'/';
if(DTPath.indexOf(DMURL) != -1) DMURL = DTPath;
var AJPath = DMURL+'ajax.php';
var UPPath = DMURL+'upload.php';
if(isIE) try {document.execCommand("BackgroundImageCache", false, true);} catch(e) {}
function Dd(i) {return document.getElementById(i);}
function Ds(i) {Dd(i).style.display = '';}
function Dh(i) {Dd(i).style.display = 'none';}
function Dsh(i) {Dd(i).style.display = Dd(i).style.display == 'none' ? '' : 'none';}
function Df(i) {Dd(i).focus();}
function Tab(ID) {
	var i = 0;
	while($('#Tab'+i).length > 0) {
		if(ID == i) {$('#Tab'+i).attr('class', 'tab_on');$('#Tabs'+i).show();} else {$('#Tab'+i).attr('class', 'tab');$('#Tabs'+i).hide();}
		i++;
	}
	if($('#tab').length > 0) $('#tab').val(ID);
}
function checkall(f, t) {
	var t = t ? t : 1;
	for(var i = 0; i < f.elements.length; i++) {
		var e = f.elements[i];
		if(e.type != 'checkbox' || e.name == 'msg' || e.name == 'eml' || e.name == 'sms' || e.name == 'wec') continue;
		if(t == 1) e.checked = e.checked ? false : true;
		if(t == 2) e.checked = true;
		if(t == 3) e.checked = false;	
	}
}
function Dmsg(str, i, s, t) {
	var t = t ? t : 5000; var s = s ? 1 : 0; var h = i == 'content' ? 450 : 50;
	try{
		if(typeof Dbrowser != 'undefined') {alert(str);return;}
		if(s || i == 'content'){$("html, body").animate({scrollTop:$('#d'+i).offset().top-h}, 100);}
		Dd('d'+i).innerHTML = '<img src="'+DTPath+'file/image/check-ko.png" width="16" height="16" align="absmiddle"/> '+str;
		Dd(i).focus();
	}catch(e){}
	window.setTimeout(function(){Dd('d'+i).innerHTML = '';}, t);
}
function Inner(i,s) {try {Dd(i).innerHTML = s;}catch(e){}}
function Go(u) {window.location = u;}
function confirmURI(m,f) {if(confirm(m)) Go(f);}
function showmsg(m, t) {
	var t = t ? t : 5000; var s = (m.indexOf(L['str_delete']) != -1 || m.indexOf(L['str_clear']) != -1) ? 'delete' : 'ok';
	try{Dd('msgbox').style.display = '';Dd('msgbox').innerHTML = m+sound(s);window.setTimeout('closemsg();', t);}catch(e){}
}
function closemsg() {try{Dd('msgbox').innerHTML = '';Dd('msgbox').style.display = 'none';}catch(e){}}
function sound(f) {return '<div style="float:left;" class="aijiacms-sound"><audio src="'+DTPath+'file/sound/'+f+'.mp3" height="0" width="0" autoplay="autoplay"></audio></div>';}
function Eh(t) {
	var t = t ? t : 'select';
	if(isIE) {
		var arVersion = navigator.appVersion.split("MSIE"); var IEversion = parseFloat(arVersion[1]);		
		if(IEversion >= 7 || IEversion < 5) return;
		$(t).css('visibility', 'hidden');
	}
}
function Es(t) {
	var t = t ? t : 'select';
	if(isIE) {
		var arVersion = navigator.appVersion.split("MSIE"); var IEversion = parseFloat(arVersion[1]);		
		if(IEversion >= 7 || IEversion < 5) return;
		$(t).css('visibility', 'visible');
	}
}
function EditorLen(i) {return EditorAPI(i, 'len');}
function Tb(o) {
	if(o.className == 'on') return;
	var t = o.id.split('-h-'); var p = t[0]; var k = t[1];
	$('#'+p+'-h').children().each(function() {
		var i = $(this).attr('id').replace(p+'-h-', '');
		if(i == k) {
			$('#'+p+'-h-'+i).attr('class', 'on');
			$('#'+p+'-b-'+i).fadeIn(100);
		} else {
			$('#'+p+'-h-'+i).attr('class', '');
			$('#'+p+'-b-'+i).hide();
		}
	});
}
function ext(v) {return v.substring(v.lastIndexOf('.')+1, v.length).toLowerCase();}
function Dstats() {$.post(AJPath, 'action=stats&screenw='+window.screen.width+'&screenh='+window.screen.height+'&uri='+encodeURIComponent(window.location.href)+'&refer='+encodeURIComponent(document.referrer), function(data) {});}
function GoMobile(url) {
	if((UA.indexOf('phone') != -1 || UA.indexOf('mobile') != -1 || UA.indexOf('android') != -1 || UA.indexOf('ipod') != -1) && get_cookie('mobile') != 'pc' && UA.indexOf('ipad') == -1) {
		Go(url);
	}
}
function PushNew() {
	$('#aijiacms_push').remove();
	s = document.createElement("script");
	s.type = "text/javascript";
	s.id = "aijiacms_push";
	s.src = DTPath+"api/push.js.php?refresh="+Math.random()+".js";
	document.body.appendChild(s);
}
function Dnotification(id, url, icon, title, content) {
	 if(window.webkitNotifications) {
		 if(webkitNotifications.checkPermission()==1) {
			 window.onclick = function() {
				window.webkitNotifications.requestPermission(function() {
					if(webkitNotifications.checkPermission()==0) {						
						var N = window.webkitNotifications.createNotification(icon, title, content);
						N.replaceId = id;N.onclick = function() {window.focus();window.top.location = url;N.cancel();};N.show();
					}
				});
			 };
		 } else if(webkitNotifications.checkPermission()==0) {	
			var N = window.webkitNotifications.createNotification(icon, title, content);
			N.replaceId = id;N.onclick = function() {window.focus();window.top.location = url;N.cancel();};N.show();
		 }
	 }
}
function set_cookie(n, v, d) {
	var e = ''; 
	var f = d ? d : 365;
	e = new Date((new Date()).getTime() + f * 86400000);
	e = "; expires=" + e.toGMTString();
	document.cookie = CKPrex + n + "=" + v + ((CKPath == "") ? "" : ("; path=" + CKPath)) + ((CKDomain =="") ? "" : ("; domain=" + CKDomain)) + e; 
}
function get_cookie(n) {
	var v = ''; var s = CKPrex + n + "=";
	if(document.cookie.length > 0) {
		o = document.cookie.indexOf(s);
		if(o != -1) {	
			o += s.length;
			end = document.cookie.indexOf(";", o);
			if(end == -1) end = document.cookie.length;
			v = unescape(document.cookie.substring(o, end));
		}
	}
	return v;
}
function del_cookie(n) {var e = new Date((new Date()).getTime() - 1 ); e = "; expires=" + e.toGMTString(); document.cookie = CKPrex + n + "=" + escape("") +";path=/"+ e;}
function set_local(n, v) {window.localStorage ? localStorage.setItem(CKPrex + n, v) : set_cookie(n, v);}
function get_local(n) {return window.localStorage ? localStorage.getItem(CKPrex + n) : get_cookie(n);}
function del_local(n) {window.localStorage ? localStorage.removeItem(CKPrex + n) : del_cookie(n);}
function substr_count(str, exp) {if(str == '') return 0;var s = str.split(exp);return s.length-1;}
function checked_count(id) {return $('#'+id+' :checked').length;}
function lang(s, a) {for(var i = 0; i < a.length; i++) {s = s.replace('{V'+i+'}', a[i]);} return s;}
function get_cart() {var cart = parseInt(get_cookie('cart'));return cart > 0 ? cart : 0;}
function cutstr(str, mark1, mark2) {
	var p1 = str.indexOf(mark1);
	if(p1 == -1) return '';
	str = str.substr(p1 + mark1.length);
	var p2 = str.indexOf(mark2);
	if(p2 == -1) return str;
	return str.substr(0, p2);
}
//增加全选开始
 function checkqx(name) {
            var el = document.getElementsByTagName('input');
            var flag = true;
//取document中所有的input，比如文本输入框、按钮等元件，全都取出来存入数组，可以用el.length取数量，el[i]取内容
            var len = el.length;
            for (var i = 0; i < len; i++) {
                if ((el[i].type == "checkbox") && (el[i].name == name)) {
                    if (el[i].checked == true) {//判断第一个checkbox是否已经选中
                        flag = false;
                    } else {
                        flag = true;
                    }
                    break;
                }
            }
            for (var i = 0; i < len; i++) {
                if ((el[i].type == "checkbox") && (el[i].name == name)) {
                    el[i].checked = flag;
                }
            }
        }
//增加全选结束		
document.onkeydown = function(e) {
	var k = typeof e == 'undefined' ? event.keyCode : e.keyCode;
	if(k == 37) {
		try{if(Dd('aijiacms_previous').value && typeof document.activeElement.name == 'undefined')Go(Dd('aijiacms_previous').value);}catch(e){}
	} else if(k == 39) {
		try{if(Dd('aijiacms_next').value && typeof document.activeElement.name == 'undefined')Go(Dd('aijiacms_next').value);}catch(e){}
	} else if(k == 38 || k == 40 || k == 13) {
		try{if(Dd('search_tips').style.display != 'none' || Dd('search_tips').innerHTML != ''){SCTip(k);return false;}}catch(e){}
	}
}
$(function(){
	$(window).bind("scroll.back2top", function() {
		var st = $(document).scrollTop(), winh = $(window).height();
        (st > 0) ? $('.back2top').show() : $('.back2top').hide();        
        if(!window.XMLHttpRequest) { $('.back2top').css("top", st + winh - 166);}//IE6
	});
	$('.back2top').click(function() {
		$('html, body').animate({scrollTop:0}, 200);
	});
});

