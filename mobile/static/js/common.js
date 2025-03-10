/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
function Dd(i) {return document.getElementById(i);}
function Ds(i) {Dd(i).style.display = '';}
function Dh(i) {Dd(i).style.display = 'none';}
function Go(u) {window.location = u;}
function Dback(u, r, e) {
	var m = e ? '/'+e+'/' : '';
	if(r && m && r.match(eval(m))) {
		Go(u ? u : 'index.php');
	} else if(r) {
		window.history.back();
	} else if(document.referrer) {
		window.history.back();
	} else {
		Go(u ? u : 'index.php');
	}
}
function GoPage(max, url) {
	if(max < 2) return;
	var page = parseInt(prompt('Go to page of (1-'+max+')', ''));
	if(page >= 1 && page <= max) Go(url.replace(/\{aijiacms_page\}/, page));
}
function DTrim(s) {
	s = s.trim();
	var t = encodeURIComponent(s);
	if(t.indexOf('%E2%80%86') != -1) s = decodeURIComponent(t.replace(/%E2%80%86/g, ''));
	return s;
}
function Dtoast(msg, id, time) {
	var time = time ? time : 2;
	var id = id ? id : '';
	$('.ui-toast').html(msg);
	var w = $('.ui-toast').width();
	if(w < 14) w = msg.length*14;
	$('.ui-toast').css('left', $(document).scrollLeft()+($(document).width()-w)/2 - 16);
	$('.ui-toast').fadeIn('fast', function() {
		setTimeout(function() {
			$('.ui-toast').fadeOut('slow', function() {
				if(id) $('#'+id).focus();
			});
		}, time*1000);
	});
}


function APlay(id) {
	var h = parseInt(document.body.clientWidth*9/16);
	var t = $('#album-'+id).height();
	if(h < t) $('#albums-'+id+' p').css('height', t+'px');
	var htm = $('#albums-'+id+' pre:first').html();
	if(htm.indexOf('autoplay') == -1) htm = htm.replace('data-video', 'autoplay="autoplay" data-video');
	$('#albums-'+id+' p:first').html(htm);
	$('#albums-'+id+' p').show();
	$('#albums-'+id+' i').show();

}
function AHide(id) {
	$('#albums-'+id+' p:first').children().remove();
	$('#albums-'+id+' p').hide();
	$('#albums-'+id+' i').hide();
}
function Dalbum(id) {
	if($('#album-item-'+id).length == 0);
	if($('#album-item-'+id).html().indexOf('<img') == -1) return;
	var _this = this;
	this.w = document.body.clientWidth;
	this.c = 0;
	this.src = [];
	this.alt = [];
	$('#album-item-'+id).find('img').each(function(i) {
		_this.src.push($(this).attr('src'));
		_this.alt.push($(this).attr('alt'));
	});
	if(!this.src[0]) return;
	this.max = this.src.length;
	this.htm = '<ul id="album-ul-'+id+'" style="position:relative;width:'+this.w*(this.max+1)+'px;z-index:1;overflow:hidden;">';
	for(var i = 0; i < this.max; i++) {
		this.htm += '<li><img src="'+this.src[i]+'" width="'+this.w+'"/></li>';
	}
	this.htm += '</ul>';
	$('#album-'+id).html(this.htm);
	$('#album-no-'+id).html('1/'+this.max);
	$('#album-'+id).on('swipeleft',function(e){
		_this.slide(_this.c+1);
	});
	$('#album-'+id).on('swiperight',function(e){
		_this.slide(_this.c-1);
	});
	$('#album-ul-'+id+' img').on('click',function(e){
		Dviewer(id, $(this).attr('src'), $('#album-ul-'+id));
	});
	$(window).bind('orientationchange.slide'+id, function(e){
		window.setTimeout(function() {
			_this.w = document.body.clientWidth;
			$('#album-'+id).find('ul').css('width', _this.w*(_this.max+1));
			$('#album-'+id).find('img').css('width', _this.w);
			_this.p = 0;
		}, 300);
	});
	this.slide = function(o) {
		if(o < 0 || o > this.max-1 || o == this.c) return;
		$('#album-ul-'+id).animate({'left':-o*this.w},500);
		this.c = o;
		$('#album-no-'+id).html((o+1)+'/'+this.max);
		if($('#albums-'+id+' strong').length > 0) {
			if(this.alt[o]) {
				$('#albums-'+id+' strong').html(this.alt[o]);
				$('#albums-'+id+' strong').show();
			} else {
				$('#albums-'+id+' strong').html('');
				$('#albums-'+id+' strong').hide();
			}
		}
	}
	if($('#albums-'+id+' p').length > 0) {
		window.setTimeout(function() {
			var h = parseInt(($('#album-'+id).height()/2)-25);
			if(h > 80) $('#albums-'+id+' b').css('margin', h+'px 0 0 -24px');
		}, 300);
	}
	return true;
}
function Dviewer(id, src, obj) {
	if($('#viewer-'+id).length == 0) return;
	var _this = this;
	this.w = document.body.clientWidth;
	this.c = 0;
	this.d = 0;
	this.src = [];
	this.alt = [];
	obj.find('img').each(function(i) {
		if($(this).width() > 99 || $(this).attr('src').indexOf('.thumb.') != -1) {
			_this.src.push($(this).attr('src'));
			_this.alt.push($(this).attr('alt'));
		}
	});
	if(!this.src[0]) return;
	this.max = this.src.length;
	this.htm = '<ul id="viewer-ul-'+id+'" style="position:relative;width:'+this.w*(this.max+1)+'px;z-index:210;overflow:hidden;margin-top:64px;">';
	for(var i = 0; i < this.max; i++) {
		if(src == this.src[i]) this.d = i;
		var s = this.src[i];
		if(s.indexOf('.middle.') != -1) {
			var t = s.split('.middle.');
			s = t[0];
		} else if(s.indexOf('.thumb.') != -1) {
			var t = s.split('.thumb.');
			s = t[0];
		}
		this.htm += '<li><img src="'+s+'" width="'+this.w+'"/></li>';
	}
	this.htm += '</ul>';
	$('#viewer-'+id).html('<b>'+(this.d+1)+'/'+this.max+'</b><i></i>'+this.htm+'<p></p>');
	$('#viewer-'+id+' ul').on('swipeleft',function(e){
		_this.slide(_this.c+1, 1);
	});
	$('#viewer-'+id+' ul').on('swiperight',function(e){
		_this.slide(_this.c-1, 1);
	});
	$('#viewer-'+id+' i').on('click',function(e){
		_this.close();
	});
	$(window).bind('orientationchange.slide'+id, function(e){
		_this.close();
	});
	this.slide = function(o, a) {
		if(o < 0 || o > this.max-1 || o == this.c) return;
		if(a) {
			$('#viewer-ul-'+id).animate({'left':-o*this.w},500);
		} else {
			$('#viewer-ul-'+id).css('left', (-o*this.w)+'px');
		}
		this.c = o;
		$('#viewer-'+id+' b').html((o+1)+'/'+this.max);
		if(this.alt[o]) {
			$('#viewer-'+id+' p').html(this.alt[o]);
			$('#viewer-'+id+' p').show();
		} else {
			$('#viewer-'+id+' p').html('');		
			$('#viewer-'+id+' p').hide();
		}
	}
	this.close = function() {
		$('#viewer-'+id).html('');
		$('#viewer-'+id).fadeOut();
	}
	$('#viewer-'+id).fadeIn(300, function() {
		if(_this.d) {
			_this.slide(_this.d, 0);
		} else {
			if(_this.alt[0]) {
				$('#viewer-'+id+' p').html(_this.alt[0]);
				$('#viewer-'+id+' p').show();
			}
		}
		window.setTimeout(function() {
			var h = $('#viewer-ul-'+id).height();
			if(h > 100 && h < document.body.clientHeight) $('#viewer-ul-'+id).css('margin-top', parseInt((document.body.clientHeight-h)/2)+'px');
		}, 300);
	});
	return true;
}
function Dsheet(action, cancel, msg) {
	if(action) {
		action = action.replace(/&#34;/g, '"').replace(/&#39;/g, "'");
		var arr = action.split('|');
		var htm = '<div>';
		if(msg) htm += '<em>'+msg+'</em>';
		htm += '<ul>';
		for(var i=0;i<arr.length;i++) {
			if(i > 4) break;
			htm += '<li'+(i==0&&!msg ? ' style="border:none;"' : '')+'>'+arr[i]+'</li>';
		}
		htm += '</ul></div>';
		if(cancel) htm += '<p onclick="Dsheet(0);">'+cancel+'</p>';
		$('.ui-sheet').html(htm);
		var h = $('.ui-sheet').height();
		if(h < 50) h = 400;
		$('.ui-mask').fadeIn('fast');
		$('.ui-sheet').css('bottom', -h);
		$('.ui-sheet').show();
		$('.ui-sheet').animate({'bottom':'0'}, 300);
		if(cancel) $('.ui-mask').on('tap swipe scrollstart', function() {Dsheet(0);});
		$('.ui-sheet li').on('tap', function() {
			var _htm = $('.ui-sheet div').html();
			setTimeout(function(){
				if(_htm == $('.ui-sheet div').html()) Dsheet(0);
			}, 1000);}
		);
	} else {
		$('.ui-mask').fadeOut('fast');
		$('.ui-sheet').animate({'bottom':-$('.ui-sheet').height()}, 300, function() {
			$('.ui-sheet').html('');
			$('.ui-sheet').hide();
		});
	}
}
//$(document).ready(function(){
$(document).on('pageinit', function(event) {
	$('.head-bar-title').on('click',function(event) {
		if($('#channel').length>0) $('#channel').removeClass('channel_fix');
		$('html, body').animate({scrollTop:0}, 500);
	});
	$('.head-bar-title').on('taphold', function(event){
		window.location.reload();
	});	
	$('.ui-icon-loading').on('click', function(event) {
		window.location.reload();
	});
	$('.list-txt li,.list-set li,.list-img').on('tap', function(event) {
		$(this).css('background-color', '#F6F6F6');
	});
	$('.list-txt li,.list-set li,.list-img').on('mouseout', function(event) {
		$(this).css('background-color', '#FFFFFF');
	});
});