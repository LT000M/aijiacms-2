var lasthouse;  //上一次被点击的房源id
var lastzindex;  //上一次被点击的房源层
var mapzindex = 1; //标注轴

function ComplexCustomOverlay(pointx, pointy, text, mouseoverText,myid,url){
      this._point = new BMap.Point(pointx, pointy);
      this._pointx = pointx;
      this._pointy = pointy;
      this._text = text;
      this._overText = mouseoverText;
      this._myid = myid;
      this.url = url;
    }

function createmap(maplocate){
  // 将标注添加到地图中


var map = new BMap.Map(maplocate);    // 创建Map实例
 map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
map.addControl(new BMap.ScaleControl()); // 添加默认比例尺控件
map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT})); // 左下
//mp.addControl(new BMap.NavigationControl()); //添加默认缩放平移控件
var point = new BMap.Point(BASE_MAP);

//mp.centerAndZoom('滕州', 16);

// 复杂的自定义覆盖物


 return map;



}

ComplexCustomOverlay.prototype = new BMap.Overlay();
ComplexCustomOverlay.prototype.initialize = function(map){
  this._map = map;
  var div = this._div = document.createElement("div");
  var _this = this;
  div.style.position = "absolute";
  div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
  //div.style.backgroundColor = "#f57f00";
  div.style.background = "url("+STATIC_URL+"map_arrow.png) no-repeat 9px 35px";
  //div.style.border = "1px solid #BC3B3A";
  div.style.color = "white";
  div.style.height = "44px";
  //div.style.padding = "2px";
  div.style.lineHeight = "35px";
  div.style.whiteSpace = "nowrap";
  div.style.MozUserSelect = "none";
  div.style.fontSize = "12px";
  div.setAttribute('map_x',this._pointx);
  div.setAttribute('map_y',this._pointy);
  div.setAttribute('housetext',this._text);
  div.setAttribute('id','houseid'+this._myid);

  var arrow = this._arrow = document.createElement("div");
  arrow.style.background = "url("+STATIC_URL+"list_map_ico.png) no-repeat";
  arrow.style.position = "absolute";
  arrow.style.width = "15px";
  arrow.style.height = "21px";
  arrow.style.top = "10px";
  arrow.style.left = "8px";
  arrow.style.overflow = "hidden";
  div.appendChild(arrow);
  house_id =_this._myid.replace(/[a-z]+/,'');
  house_url = _this.url
  div.onmouseover = function(house_id){
    openinfo($(this).attr('map_x'),$(this).attr('map_y'),$(this).attr('housetext'));
    house_id =_this._myid.replace(/[a-z]+/,'');
    arrow.style.background = "url("+STATIC_URL+"list_map_ico0.png) no-repeat";
    var divElement = document.getElementById('srollmap'+house_id);
    var item_hover = 'item-hover';
    if(!divElement.className.match(new RegExp('(\\s|^)' + item_hover + '(\\s|$)'))){
      document.getElementById('srollmap'+house_id).className +=' item-hover';
    }
  }

  div.onclick = function(house_id){
    house_id =_this._myid.replace(/[a-z]+/,'');
    // window.open(BASE_URL+house_id);
    window.open(house_url);
  }
  div.onmouseout = function(e){
      $('#mapinfo').hide();
      house_id =_this._myid.replace(/[a-z]+/,'');
     
      if(e.pageX >  ($('#srollmap'+house_id).offset().left+$('#srollmap'+house_id).width())){
      var divElement = document.getElementById('srollmap'+house_id);
      var item_hover = 'item-hover';
      if(divElement.className.match(new RegExp('(\\s|^)' + item_hover + '(\\s|$)'))){
        var reg = new RegExp('(\\s|^)' + item_hover + '(\\s|$)');
        divElement.className = divElement.className.replace(reg, ' ');
      }

    }

    arrow.style.background = "url("+STATIC_URL+"list_map_ico.png) no-repeat";
  }
  map.getPanes().labelPane.appendChild(div);
  return div;
}
ComplexCustomOverlay.prototype.draw = function(){
  var map = this._map;
  var pixel = map.pointToOverlayPixel(this._point);
  this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
  this._div.style.top  = pixel.y - 30 + "px";
}

function markermap(markerArr,mp){
  // 将标注添加到地图中
mp.clearOverlays();
var point_list = new Array();
for (var i = 0; i < markerArr.length; i++) {
    var json=markerArr[i]
    var txt = markerArr[i].title;
    var txt2 = markerArr[i].title;
    var myid = markerArr[i].id;
    var url = markerArr[i].url;
    var pointx = markerArr[i].point.split(',')[0];
    var pointy = markerArr[i].point.split(',')[1];
    point_list[i] = new BMap.Point(pointx, pointy);
    var myCompOverlay=new ComplexCustomOverlay(pointx, pointy, txt, txt2,myid,url); //这步是将覆盖物存到变量，以便下面使用。
    // console.log(myCompOverlay)
    mp.addOverlay(myCompOverlay);
    // (function(){
    //     var index = i;
    //     var p0 = json.point.split("|")[0];
    //     var p1 = json.point.split("|")[1];
    //     var point = new BMap.Point(p0,p1);
    //     var _marker = myCompOverlay; //当初存的覆盖物变量，这里派上用场了。
    // })()
}
  setTimeout(function(){
    mp.setViewport(point_list);

  },100);

}

function openinfo(pointx,pointy,housetext){
  var mypoint = new BMap.Point(pointx,pointy);
  var pixel_postion = map.pointToPixel(mypoint);
  $('#maptext').text(housetext);
  $('#mapinfo').css('left',pixel_postion.x-$('#mapinfo').width()+9);
  $('#mapinfo').css('top',pixel_postion.y+36);
  $('#mapinfo').show();
}
function closeinfo(){
  $('#mapinfo').hide();
}
//列表悬浮修改地图标注点背景色为红色
function pointred(houseid){
  var info = $('#houseidmyid'+houseid).find('div');
  var img =  STATIC_URL+"list_map_ico0.png";
  var background = info.css('background-image','url('+img+')');

}
//列表鼠标离开还原地图标注点背景色为绿色
function pointblue(houseid){
  var info = $('#houseidmyid'+houseid).find('div');
  var img =  STATIC_URL+"list_map_ico.png";
  var background = info.css('background-image','url('+img+')');
}

//显示提示框
