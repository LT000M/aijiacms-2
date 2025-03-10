//地图导航控件
function setMap(shop_x,shop_y,chrtitle,chraddress){
	var marker,latitude=shop_x,longitude=shop_y,point;
	var sContent =
	"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+chrtitle+"</h4>" + 
	"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+chraddress+"</p>" + 
	"</div>";
	
	var map = new BMap.Map("iframe_map");
	map.addControl(new BMap.NavigationControl());
	var infoWindow = new BMap.InfoWindow(sContent);
	
	point = new BMap.Point(latitude,longitude);
	translateCallback(point);
	function translateCallback(ggpoint){
		if(latitude===0||longitude===0){
			map.centerAndZoom(window['icity'],15);
		}else{
			var ico = new BMap.Icon("../static2019/images/arkers_new2_4ab0bc5.png", new BMap.Size(14,14),{anchor: new BMap.Size(7, 4),imageOffset:new BMap.Size(-105, 0),imageSize:new BMap.Size(150, 150)});
			marker = new BMap.Marker(ggpoint,{icon:ico});
			marker.disableMassClear();
			map.addOverlay(window['LmapMarker']);
			
			map.centerAndZoom(ggpoint, 15);
			map.addOverlay(marker);
			marker.openInfoWindow(infoWindow);
		}
	}
	map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
	map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
	map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
}
function showAddIframe(){
	scrollHe.pageOther = $('#pageOther2')
	scrollHe.showLayer();
	
	var iframe_map = $('#iframe_map');
	if(iframe_map.attr('data-isloaded') !=='1'){
		var w_h = $(window).height();
		iframe_map.css({'height':w_h-74+'px'});
		
		$('#closeReply2').click(function(e){
			e.preventDefault();
			scrollHe.hideLayer();
		});
		var quXY = $('#quXY'),loupanX=quXY.attr('data-loupanX'),loupanY=quXY.attr('data-loupanY'),chraddress = $('#chraddress').text(),chrtitle = $('#chrloupan').text();
		
		var dhurl = "http://map.baidu.com/mobile/webapp/search/search/qt=s&wd="+chraddress+"&c=340&searchFlag=bigBox&version=5&exptype=dep&src_from=webapp_all_bigbox&sug_forward=&src=0&nb_x="+loupanX+"&nb_y="+loupanY+"&center_rank=1/vt=";
		$('#chrtitle_str').html(chrtitle);
		$('#chraddress_str').html(chraddress);
		$('#daohang_gps').attr({'href':dhurl,'data-x':loupanX,'data-y':loupanY});
		setMap(parseFloat(loupanX),parseFloat(loupanY),chrtitle,chraddress);
	}
	return false;
}

//地图周边控件
window['map_local'] = null;
window['map'] = null;
window['mPoint'] = null;
var zb_style = 0;
//var zb_style_arr = [{'key':'教育','img':'jiaoyu.png'},{'key':'公交','img':'yiyuan.png'},{'key':'银行','img':'yinhang.png'},{'key':'超市','img':'chaoshi.gif'}];
var zb_style_arr = [{'key':'超市','img':'chaoshi.gif'},{'key':'公交','img':'gongjiao.gif'},{'key':'教育','img':'xuexiao.gif'},{'key':'医疗','img':'yiyuan.gif'}];

function addMarker(point,i_title,i_address,i_id){
  obj_Overlay[i_id] = new ComplexCustomOverlay(point,i_title,i_address,i_id);
  window['map'].addOverlay(obj_Overlay[i_id]);
}
var options = {
	onSearchComplete: function(results){
		if (window['map_local'].getStatus() == BMAP_STATUS_SUCCESS){
			if(!$.isEmptyObject(obj_Overlay)){
				for(var key in obj_Overlay){
					window['map'].removeOverlay(obj_Overlay[key]);
				}
				obj_Overlay={};
				$('#r-result').empty();
			}
			for (var i = 0; i < results.getCurrentNumPois(); i ++){
				var t_lng = results.getPoi(i).point.lng;
				var t_lat = results.getPoi(i).point.lat;
				var p1 = new BMap.Point(t_lng,t_lat);
				//addMarker(p1,results.getPoi(i).title,results.getPoi(i).address,results.getPoi(i).uid);
				addMarker(p1,results.getPoi(i).title,results.getPoi(i).address,results.getPoi(i).uid);
				
				results.getPoi(i).distance = (window['map'].getDistance(window['mPoint'],p1)).toFixed(0)+'米';
				var TPL=$('#tp').html().replace(/[\n\t\r]/g, '');
				$('#r-result').append(Mustache.to_html(TPL, results.getPoi(i)));
			}
			setTimeout(function(){
				//showSearchInfoWindow(new BMap.Point(results.getPoi(0).point.lng,results.getPoi(0).point.lat),results.getPoi(0).title,results.getPoi(0).address);
				$('#r-result').find('li').click(function(e){
					e.preventDefault();

					var p2 = new BMap.Point(parseFloat($(this).attr('data-x')),parseFloat($(this).attr('data-y')));
					remove_overlay();
					var tit = $( this ).find('h3').text();
					addMarker( p2, tit , null , 88 );

					window['map'].panTo(p2);
					$(this).siblings('li').removeClass('current');
					$(this).addClass('current');
				});
				//.eq(0).trigger('click');
			},200);
			function remove_overlay(){
				window['map'].clearOverlays();
			}
		}
	}
};
function setMap_default(){
	var quXY = $('#quXY'),loupanX=quXY.attr('data-loupanX'),loupanY=quXY.attr('data-loupanY'),chraddress = $('#chraddress').text(),chrtitle = $('#chrloupan').text();
	var marker,latitude=loupanX,longitude=loupanY;
	var sContent =
	"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+chrtitle+"</h4>" + 
	"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+chraddress+"</p>" + 
	"</div>";
	window['map'] = new BMap.Map("default_map");
	window['map'].addControl(new BMap.NavigationControl());
	//var infoWindow = new BMap.InfoWindow(sContent);
	
	window['mPoint'] = new BMap.Point(latitude,longitude);
	translateCallback(window['mPoint']);
	
	function translateCallback(ggpoint){
		if(latitude===0||longitude===0){
			window['map'].centerAndZoom(window['icity'],15);
		}else{
			var ico = new BMap.Icon("../static2019/images/markers_new2_4ab0bc5.png", new BMap.Size(14,14),{anchor: new BMap.Size(7, 4),imageOffset:new BMap.Size(-105, 0),imageSize:new BMap.Size(150, 150)});
			marker = new BMap.Marker(ggpoint,{icon:ico});
			marker.disableMassClear();
			window['map'].addOverlay(window['LmapMarker']);
			
			window['map'].centerAndZoom(ggpoint, 15);
			window['map'].addOverlay(marker);
			//marker.openInfoWindow(infoWindow);
		}
	}
	window['map'].enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
	window['map'].enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
	window['map'].addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
	//周边控件
	window['map_local'] = new BMap.LocalSearch(window['map'], options);
	window['map_local'].searchNearby(zb_style_arr[0].key,window['mPoint'],500);
	$('#mapSel li').click(function(e){
		e.preventDefault();
		$('#r-result').empty();
		$(this).siblings('li').removeClass('on');
		$(this).addClass('on');
		zb_style = parseInt($(this).attr('data-val'));
		window['map_local'].searchNearby(zb_style_arr[zb_style].key,window['mPoint'],500);
	});
}


var obj_Overlay = {};

function ComplexCustomOverlay( point, text, address, sid ){
	window['maplist'] ='';
	this._point = point;
	this._text  = text;
	this._overText = text ;
	this._address = address;
	this._sid = sid;
}
ComplexCustomOverlay.prototype = new BMap.Overlay();
ComplexCustomOverlay.prototype.initialize = function(map){
	this._map = map;
	var div = this._div = document.createElement("div");
	div.style.position = "absolute";
	div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
	div.style.color = "#fff";
	div.style.height = "30px";
	div.style.padding = "0 15px";
	div.style.lineHeight = "30px";
	div.style.whiteSpace = "nowrap";
	div.style.MozUserSelect = "none";
	div.style.backgroundColor = "#199752";
	div.style.opacity = ".8";
	div.style.borderRadius = "3px";
	div.style.fontSize = "14px";
	div.style.cursor = "pointer";
	var span = this._span = document.createElement("span");
	div.appendChild(span);
	span.appendChild(document.createTextNode(this._text));
	var span2 = document.createElement("span");
	span2.style.position = 'absolute';
	span2.style.width='0';
	span2.style.height='0';
	span2.style.borderTop= '6px solid #199752';
	span2.style.borderLeft='6px solid transparent';
	span2.style.borderRight='6px solid transparent';
	span2.style.top='30px';
	span2.style.left= '26px';
	div.appendChild(span2);
	var that = this;
	div.onmouseover = function(){
		this.getElementsByTagName("span")[1].style.borderTop = '6px solid #f9b337';
		this.style.backgroundColor = '#f9b337';
		this.style.zIndex = 99;
	}
	div.onmouseout = function(){
		this.getElementsByTagName("span")[1].style.borderTop = '6px solid #199752';
		this.style.backgroundColor = '#199752';
		this.style.zIndex = BMap.Overlay.getZIndex(that._point.lat);
	}
	map.getPanes().labelPane.appendChild(div);
	return div;
}
ComplexCustomOverlay.prototype.draw = function(){
	var map = this._map;
	var pixel = map.pointToOverlayPixel(this._point);
	this._div.style.left = pixel.x - 20 + "px";
	this._div.style.top  = pixel.y - 33 + "px";
}

/* 
function ComplexCustomOverlay(point, text, address, sid){
  this._point = point;
  this._text = text;
  this._address = address;
  this._sid = sid;
}
ComplexCustomOverlay.prototype = new BMap.Overlay();
ComplexCustomOverlay.prototype.initialize = function(map){
  this._map = map;
  var div = this._div = document.createElement("div");
  div.style.position = "absolute";
  div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
  div.style.height = "18px";
  div.style.width = "18px";
  div.style.cursor = "pointer";
  div.style.MozUserSelect = "none";
  div.style.background = "url("+window['Default_tplPath']+"images/Map/"+zb_style_arr[zb_style].img+") no-repeat 0 0/18px auto";

  var that = this;
  div.onmouseover = function(){
	this.style.zIndex = 99;
  }
  div.onmouseout = function(){
	this.style.zIndex = BMap.Overlay.getZIndex(that._point.lat);
  }
  div.onclick = function(){
	showSearchInfoWindow(that._point,that._text,that._address)
  }
  map.getPanes().labelPane.appendChild(div);
  return div;
}
ComplexCustomOverlay.prototype.draw = function(){
  var map = this._map;
  var pixel = map.pointToOverlayPixel(this._point);
  this._div.style.left = pixel.x-11 + "px";
  this._div.style.top  = pixel.y-11 + "px";
} */
function showSearchInfoWindow(point,text,address){
	var content = '<div style="margin:0;line-height:20px;padding:2px;">'+address+'</div>';
	var searchInfoWindow = null;
	searchInfoWindow = new BMapLib.SearchInfoWindow(map, content, {
		title  : text,      //标题
		width  : 300,             //宽度
		height : 60,              //高度
		panel  : "panel",         //检索结果面板
		enableAutoPan : true,     //自动平移
		searchTypes   :[
			BMAPLIB_TAB_SEARCH,   //周边检索
			BMAPLIB_TAB_TO_HERE,  //到这里去
			BMAPLIB_TAB_FROM_HERE //从这里出发
		]
	});
	searchInfoWindow.open(point);
}
