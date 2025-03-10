
var APF={

log:function(A){


} 

} ;

APF.Namespace={

register:function(D){

var C=D.split(".");

var A=window;

for(var B=0;

B<C.length;

B++){

if(typeof A[C[B]]=="undefined"){

A[C[B]]=new Object()

} A=A[C[B]]

} 

} 

} ;

APF.Utils={

getWindowSize:function(){

var B=0,A=0;

if(typeof (window.innerWidth)=="number"){

B=window.innerWidth;

A=window.innerHeight

} else{

if(document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight)){

B=document.documentElement.clientWidth;

A=document.documentElement.clientHeight

} else{

if(document.body&&(document.body.clientWidth||document.body.clientHeight)){

B=document.body.clientWidth;

A=document.body.clientHeight

} 

} 

} return{

width:B,height:A

} 

} ,getScroll:function(){

var B=0,A=0;

if(typeof (window.pageYOffset)=="number"){

A=window.pageYOffset;

B=window.pageXOffset

} else{

if(document.body&&(document.body.scrollLeft||document.body.scrollTop)){

A=document.body.scrollTop;

B=document.body.scrollLeft

} else{

if(document.documentElement&&(document.documentElement.scrollLeft||document.documentElement.scrollTop)){

A=document.documentElement.scrollTop;

B=document.documentElement.scrollLeft

} 

} 

} return{

left:B,top:A

} 

} ,setCookie:function(C,E,A,H,D,G){

var B=new Date();

B.setTime(B.getTime());

if(A){

A=A*1000*60*60*24

} var F=new Date(B.getTime()+(A));

document.cookie=C+"="+escape(E)+((A)?";expires="+F.toGMTString():"")+((H)?";path="+H:"")+((D)?";domain="+D:"")+((G)?";secure":"")

} ,getCookie:function(A){

var F=document.cookie.split(";");

var B="";

var D="";

var E="";

var C=false;

for(i=0;

i<F.length;

i++){

B=F[i].split("=");

D=B[0].replace(/^\s+|\s+$/g,"");

if(D==A){

C=true;

if(B.length>1){

E=unescape(B[1].replace(/^\s+|\s+$/g,""))

} return E;

break

} B=null;

D=""

} if(!C){

return null

} 

} ,deleteCookie:function(A,C,B){

if(this.getCookie(A)){

document.cookie=A+"="+((C)?";path="+C:"")+((B)?";domain="+B:"")+";expires=Thu, 01-Jan-1970 00:00:01 GMT"

} 

} 

} ;

APF.Namespace.register("anjuke.global.header");

anjuke.global.header.CitySelector=Class.create({

initialize:function(D,C,A){

this.selector=$(D);

this.panelId=C;

this.hideTimeout=A;

var B=$(C);

this.iframe=B.select("iframe").first();

this.iframe.setStyle({

width:B.getWidth()+"px",height:B.getHeight()+"px"

} );

this.selector.observe("mouseover",function(){

window.clearTimeout(this.timeoutHandle);

$(this.panelId).show()

} .bind(this));

this.selector.observe("mouseout",function(){

window.clearTimeout(this.timeoutHandle);

this.timeoutHandle=window.setTimeout("$('"+this.panelId+"').hide()",this.hideTimeout)

} .bind(this));

var E=this.selector.select("a").first();

if(E!=undefined){

E.observe("click",function(F){

F.preventDefault()

} )

} 

} 

} );

APF.Namespace.register("anjuke.global.header");

anjuke.global.header.CornerLinks=Class.create({

initialize:function(A){

this.element=$(A)

} ,test:function(B,A){

$(B).hide();

A.className="myanjuke"

} ,bindEvents:function(C,B,A){

this.selector=$(C);

this.panelId=B;

this.panel=$(B);

this.hideTimeout=A;

this.selector.observe("mouseover",function(D){

window.clearTimeout(this.timeoutHandle);

this.panel.style.display="block";

this.selector.addClassName("myanjuke_hover")

} .bind(this));

this.panel.observe("mouseover",function(){

window.clearTimeout(this.timeoutHandle);

this.selector.addClassName("myanjuke_hover")

} .bind(this));

this.panel.observe("mouseout",function(){

window.clearTimeout(this.timeoutHandle);

this.timeoutHandle=window.setTimeout("$('"+this.panelId+"').hide();$('"+C+"').removeClassName('myanjuke_hover');",this.hideTimeout)

} .bind(this));

this.selector.observe("mouseout",function(){

window.clearTimeout(this.timeoutHandle);

this.timeoutHandle=window.setTimeout("$('"+this.panelId+"').hide();$('"+C+"').removeClassName('myanjuke_hover');",this.hideTimeout)

} .bind(this))

} 

} );

APF.Namespace.register("anjuke.global.search");

anjuke.global.search.Autocompleter=Class.create(Ajax.Autocompleter,{

initialize:function($super,C,D,B,A){

$super(C,D,B,A);

this._fixChineseInputMethodProblem()

} ,_fixChineseInputMethodProblem:function(){

var A=this.element.value;

var B=window.setInterval(function(){

if(A==this.element.value){

return 

} A=this.element.value;

if(this.observer){

clearTimeout(this.observer)

} this.observer=setTimeout(this.onObserverEvent.bind(this),0)

} .bind(this),this.options.frequency*1000)

} ,onKeyPress:function(A){

if(this.observer){

clearTimeout(this.observer);

this.observer=null

} if(this.active){

switch(A.keyCode){

case Event.KEY_TAB:case Event.KEY_RETURN:this.selectEntry();

Event.stop(A);

case Event.KEY_ESC:this.hide();

this.active=false;

Event.stop(A);

return ;

case Event.KEY_LEFT:case Event.KEY_RIGHT:return ;

case Event.KEY_UP:this.markPrevious();

this.render();

Event.stop(A);

return ;

case Event.KEY_DOWN:this.markNext();

this.render();

Event.stop(A);

return 

} 

} else{

if(A.keyCode==Event.KEY_TAB||A.keyCode==Event.KEY_RETURN||(Prototype.Browser.WebKit>0&&A.keyCode==0)){

return 

} 

} this.changed=true;

this.hasFocus=true

} ,show:function($super){

$super();

this.update.setStyle({

width:this.update.getWidth()-2+"px"

} )

} ,markPrevious:function(){

if(this.index>0){

this.index--

} else{

this.index=this.entryCount-1

} this.getEntry(this.index).scrollIntoView(false)

} ,getUpdatedChoices:function($super){

this.startIndicator();

var B=encodeURIComponent(this.options.paramName)+"="+encodeURIComponent(this.getToken());

this.options.parameters=this.options.callback?this.options.callback(this.element,B):B;

if(this.options.defaultParams){

this.options.parameters+="&"+this.options.defaultParams

} var A=new Ajax.Request(this.url,this.options);

this.requestingURL=A.url

} ,onComplete:function(A){

if(this.requestingURL==A.request.url){

this.requestingURL=null;

this.updateChoices(A.responseText)

} 

} 

} );

anjuke.global.search.SearchSuggestion=Class.create({

initialize:function(C,B,A){

this.options=A||{


} ;

this.element=$(C);

this.update=this.options.update?$(this.options.update):this._createUpdateElement();

this.url=B;

this.useSuggestion=false;

this.autocompleter=new anjuke.global.search.Autocompleter(this.element,this.update,this.url,{

method:"GET",frequency:0.2,minChars:1,afterUpdateElement:function(D,F){

D.value=F.firstDescendant().innerHTML;

var E=this._findParentForm(D);

if(E){

E.submit()

} 

} .bind(this),callback:function(D,E){

if(!this.options.onParameters){

return E

} var F=this.options.onParameters(E);

if(F&&"function"==typeof (F.toQueryString)){

return F.toQueryString()

} else{

return F

} 

} .bind(this)

} )

} ,_findParentForm:function(A){

var B=A;

while(B){

if(B.tagName=="FORM"){

break

} B=B.parentNode

} return B

} ,_createUpdateElement:function(){

var A=$(document.createElement("div"));

this.options.className=this.options.className||"SearchSuggestion";

A.addClassName(this.options.className);

var B=this._getInternetExplorerVersion();

if(B>0&&B<=7){

Element.insert(this.element.getOffsetParent(),{

after:A

} )

} else{

Element.insert(document.body,{

top:A

} )

} return A

} ,_getInternetExplorerVersion:function(){

var C=-1;

if(navigator.appName=="Microsoft Internet Explorer"){

var A=navigator.userAgent;

var B=new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})");

if(B.exec(A)!=null){

C=parseFloat(RegExp.$1)

} 

} return C

} 

} );

APF.Namespace.register("anjuke.global.header");

anjuke.global.header.OptionList=Class.create({

initialize:function(G,D,F,E){

this.trigger=$(G);


this.panel=$(D);

var B=$(D);

var C=$(E);

var A=$(F);

this.trigger.observe("click",function(){

if(this.panel.style.display=="none"){

this.panel.style.display="block"

} else{

this.panel.style.display="none"

} 

} .bind(this));

A.observe("mouseover",function(){

A.addClassName("current_option_hover")

} );

A.observe("mouseout",function(){

if(B.visible()){

return 

} A.removeClassName("current_option_hover")

} );

A.observe("blur",function(H){

var I=H.explicitOriginalTarget==undefined?document.activeElement:H.explicitOriginalTarget;

if(Element.descendantOf(I,this.panel)){

A.focus();

return 

} A.removeClassName("current_option_hover");

B.hide()

} .bind(this));

this.panel.getElementsBySelector("span").each(function(H){

H.observe("click",function(){

A.value=H.innerHTML;

C.value=H.getAttribute("v");

if(C.value=="5"){

$("apf_id_8_keyword").value="请输入房源特征,地点或楼盘名..."

} else{

if(C.value=="3"){

$("apf_id_8_keyword").value="请输入小区名或路名..."

} else{

$("apf_id_8_keyword").value="请输入房源特征,地点或小区名..."

} 

} if(C.value=="3"){

$("sbtn").className="btn2"

} else{

$("sbtn").className="btn"

} A.removeClassName("current_option_hover");

B.hide();

Element.fire(document,"SearchBar:OptionList",C.value);

B.getElementsBySelector("span").each(function(I){

I.setAttribute("s","none");

I.setAttribute("class","item");

I.setAttribute("className","item")

} );

H.setAttribute("s","selected");

H.setAttribute("class","selected");

H.setAttribute("className","selected")

} );

H.observe("mouseover",function(){

if(H.getAttribute("s")!="selected"){

H.setAttribute("class","mousehover");

H.setAttribute("className","mousehover")

} 

} );

H.observe("mouseout",function(){

if(H.getAttribute("s")!="selected"){

H.setAttribute("class","item");

H.setAttribute("className","item")

} 

} )

} )

} ,descendantOfPanel:function(A){

if(A==null){

return false

} if(A==this.panel){

return true

} return this.descendantOfPanel(A.parentNode)

} 

} );

APF.Namespace.register("Anjuke.MapFindding");

Anjuke.MapFindding.FinddingCanvas=Class.create({

initialize:function(D,B,F){

this.allowQueryBounds=true;

this.returningToSavedPosition=false;

this.canvas=$(D+"_canvas");

this.canvasId=D+"_canvas";

this.tradeType=B;

this.container=$("container");

this.headerHeight=$("header").getHeight();

this.latlng=new GLatLng(F.lat,F.lng);

this.zoom=F.zoom;

this.cityNameZh=F.name;

this.html_html_id=$("html_html_id");

this.filters={

price:0,areaRange:0,houseModel:0,usetype:0

} ;

var G=document.location.hash.substring(1).toQueryParams();

if(G){

if(G.p1&&G.p1!="0"){

this.filters.p1=G.p1;

this.setFilter($(this.html_html_id.value+"_select_area"),G.p1);

var C="/map/block.asp?p1="+G.p1+"&p2="+this.html_html_id.value;

new Ajax.Updater(this.html_html_id.value+"_select_block",C,{

method:"get",asynchronous:false,onComplete:function(){

$(this.html_html_id.value+"_select_block").disabled=false;

s=$(this.html_html_id.value+"_select_block");

for(i=0;

i<s.options.length;

i++){

if(parseInt(s.options[i].value)==parseInt(G.p2)){

s.options[i].selected=true

} 

} 

} 

} )

} if(G.p2&&G.p2!="0"){

if($(this.html_html_id.value+"_select_block").disabled){

$(this.html_html_id.value+"_select_block").disabled=false;

this.setFilter($(this.html_html_id.value+"_select_block"),G.p2)

} 

} if(G.p2=="0"){

$(this.html_html_id.value+"_select_block").disabled=true

} if(G.f1){

this.filters.price=G.f1;

this.setFilter($(this.html_html_id.value+"_select_price"),G.f1)

} if(G.f2){

this.filters.areaRange=G.f2;

this.setFilter($(this.html_html_id.value+"_select_range"),G.f2)

} if(G.f3){

this.filters.houseModel=G.f3;

this.setFilter($(this.html_html_id.value+"_select_model"),G.f3)

} if(G.f4){

this.filters.usetype=G.f4;

this.setFilter($(this.html_html_id.value+"_select_uestype"),G.f4)

} if(G.kw){

$(this.html_html_id.value+"_map_keywords").value=G.kw

} if(G.flag){

this.filters.flag=G.flag;

this.filters.flagname=G.flagname

} if(G.kw){

this.filters.kw=G.kw;

this.geoRequester(G.kw)

} else{

if(G.l1&&G.l2&&G.l3){

this.latlng=new GLatLng(G.l1,G.l2);

this.zoom=G.l3

} if(G.p1&&G.p1!="0"){

var A=$(this.html_html_id.value+"_select_area_"+G.p1).readAttribute("lat");

var E=$(this.html_html_id.value+"_select_area_"+G.p1).readAttribute("lng");

this.latlng=new GLatLng(A,E)

} if(G.p2&&G.p2!="0"){

var A=$(this.html_html_id.value+"_select_block_"+G.p2).readAttribute("lat");

var E=$(this.html_html_id.value+"_select_block_"+G.p2).readAttribute("lng");

this.filters.p2=G.p2;

this.latlng=new GLatLng(A,E)

} 

} 

} this.mapMarkers=new Hash();

this.canvas.observe("map:searchBounds",function(H){

this.queryBounds()

} .bind(this));

this.canvas.observe("map:pan",function(I){

this.map.closeExtInfoWindow();

var H=new GLatLng(I.memo.lat,I.memo.lng);

this.map.panTo(H)

} .bind(this));

this.canvas.observe("set:area",function(H){

this.areas.areaId=H.memo.value;

this.map.closeExtInfoWindow()

} .bind(this));

this.canvas.observe("set:block",function(H){

this.areas.blockId=H.memo.value;

this.map.closeExtInfoWindow()

} .bind(this));

this.canvas.observe("set:price",function(H){

this.filters.price=H.memo.value;

this.map.closeExtInfoWindow()

} .bind(this));

this.canvas.observe("set:range",function(H){

this.filters.areaRange=H.memo.value;

this.map.closeExtInfoWindow()

} .bind(this));

this.canvas.observe("set:model",function(H){

this.filters.houseModel=H.memo.value;

this.map.closeExtInfoWindow()

} .bind(this));

this.canvas.observe("set:usetype",function(H){

this.filters.usetype=H.memo.value;

this.map.closeExtInfoWindow()

} .bind(this));

this.canvas.observe("update:extInfo",function(H){

this.updateMapFinddingCanvasExtInfoWindow(H.memo.commId,H.memo.page,H.memo.order)

} .bind(this));

this.canvas.observe("map:drawCanvas",function(){

this.drawCanvas()

} .bind(this));

this.canvas.observe("set:keywords",function(H){

this.geoRequester(H.memo.value)

} .bind(this));

this.resResultErr=$("mapFinddingFilter_Err");

this.divTopTip=$(D+"_toptip");

this.divTopTip.setOpacity(0.9);

new Draggable(this.divTopTip);

this.splitLine=350;

this.minHeight=370;

this.minWidth=800;

this.maxMarkersNum=50

} ,geoRequester:function(B){

var C=new GClientGeocoder();

var A=B;

if(!A.blank()){

A=this.cityNameZh+"+"+A;

C.getLocations(A,function(D){

this.geoResponser(D)

} .bind(this))

} 

} ,geoResponser:function(C){

if(!C||C.Status.code!=200){

this.showResultErr();

APF.log("NO ADDRESS")

} else{

this.hideResultErr();

var B=C.Placemark[0];

var A=new GLatLng(B.Point.coordinates[1],B.Point.coordinates[0]);

this.map.setCenter(A);

try{

addressLine=B.AddressDetails.Country.AdministrativeArea.DependentLocality.AddressLine

} catch(D){

addressLine=B.AddressDetails.AddressLine

} if(addressLine==undefined){

try{

addressLine=B.AddressDetails.Country.AdministrativeArea.DependentLocality.Thoroughfare.ThoroughfareName

} catch(D){

addressLine=B.address

} 

} this.drawSearchMarker(A,addressLine)

} 

} ,setFilter:function(A,B){

if(A==undefined){

return 

} for(i=0;

i<A.options.length;

i++){

if(parseInt(A.options[i].value)==parseInt(B)){

A.options[i].selected=true;

break

} 

} 

} ,drawSearchMarker:function(A,B){

var E=this.map.fromLatLngToDivPixel(A);

var D=E.y;

var C=E.x;

this.divGeoPointer.update(B);

this.divGeoPointer.className="mapFinddingCanvasGeoPointer";

this.divGeoPointer.setStyle({

top:D-59+"px",left:C-22+"px",display:"block"

} );

this.divGeoArrow.className="mapFinddingCanvasGeoArrow";

this.divGeoArrow.setStyle({

top:D-40+"px",left:C-12+"px",display:"block"

} )

} ,drawCanvas:function(){

var B=this.getCanvasHeight()+"px";

var A=this.getViewportWidth();

if(A<this.minWidth){

this.container.setStyle({

width:"800px"

} )

} else{

this.container.setStyle({

width:"auto"

} )

} this.canvas.getOffsetParent().setStyle({

height:B

} );

this.canvas.setStyle({

height:B

} )

} ,getCanvasHeight:function(){

var D=10;

var A=30;

var B=this.getViewportHeight();

var C=B-this.headerHeight-D+A;

if(!Element.visible("header")){

C=B-D-D

} if(C<this.minHeight){

C=this.minHeight

} return C

} ,getViewportHeight:function(){

return document.viewport.getHeight()

} ,getViewportWidth:function(){

return document.viewport.getWidth()

} ,drawMap:function(){

var A=new GMap2(this.canvas);

A.enableScrollWheelZoom();

A.enableGoogleBar();

A.addControl(new GLargeMapControl3D());

A.addControl(new GOverviewMapControl());

A.addControl(new GMapTypeControl());

G_NORMAL_MAP.getMinimumResolution=function(){

return 11

} ;

G_NORMAL_MAP.getMaximumResolution=function(){

return 19

} ;

this.zoom=parseInt(this.zoom);

A.setCenter(this.latlng,this.zoom);

GEvent.addListener(A,"dragstart",function(){

this.divCommName.hide();

this.allowQueryBounds=false;

window.clearTimeout(this.timeoutHandle)

} .bind(this));

GEvent.addListener(A,"dragend",function(){

this.allowQueryBounds=true;

this.fireSearch()

} .bind(this));

GEvent.addListener(A,"zoomstart",function(){

this.divCommName.hide();

this.allowQueryBounds=false;

window.clearTimeout(this.timeoutHandle)

} .bind(this));

GEvent.addListener(A,"zoomend",function(){

this.allowQueryBounds=true;

this.fireSearch()

} .bind(this));

GEvent.addListener(A,"movestart",function(){

this.divCommName.hide();

window.clearTimeout(this.timeoutHandle)

} .bind(this));

GEvent.addListener(A,"moveend",function(){

this.fireSearch()

} .bind(this));

GEvent.addListener(A,"extinfowindowopen",function(){

this.allowQueryBounds=false;

window.clearTimeout(this.timeoutHandle)

} .bind(this));

GEvent.addListener(A,"extinfowindowclose",function(){

this.allowQueryBounds=true;

this.map.returnToSavedPosition()

} .bind(this));

this.map=A;

this.divCommName=$(document.createElement("div"));

this.divCommName.setStyle({

display:"none",whiteSpace:"nowrap"

} );

Element.insert(A.getPane(G_MAP_MARKER_PANE),this.divCommName);

this.divGeoPointer=$(document.createElement("div"));

this.divGeoPointer.setStyle({

display:"none",whiteSpace:"nowrap"

} );

Element.insert(A.getPane(G_MAP_MARKER_PANE),this.divGeoPointer);

this.divGeoArrow=$(document.createElement("div"));

this.divGeoArrow.setStyle({

display:"none"

} );

Element.insert(A.getPane(G_MAP_MARKER_PANE),this.divGeoArrow);

if(this.filters.flag=="1"){

this.drawSearchMarker(this.latlng,this.filters.flagname)

} this.markerManager=new MarkerManager(this.map)

} ,fireSearch:function(){

window.clearTimeout(this.timeoutHandle);

if(!this.allowQueryBounds){

return 

} this.timeoutHandle=window.setTimeout(function(){

this.queryBounds()

} .bind(this),800)

} ,setBounds:function(){

this.bounds=this.getBounds()

} ,getBounds:function(){

var F=80;

var H=this.map.fromContainerPixelToLatLng(new GPoint(F,F));

var E=this.map.fromContainerPixelToLatLng(new GPoint(this.canvas.getWidth()-F/2,this.canvas.getHeight()-F/2));

var B=E.lat().toFixed(3);

var A=H.lat().toFixed(3);

var G=H.lng().toFixed(3);

var C=E.lng().toFixed(3);

var D={

slatFrom:B,slatTo:A,slngFrom:G,slngTo:C

} ;

return D

} ,queryBounds:function(){

if(!this.allowQueryBounds){

return 

} this.setBounds();

this.hideTopTip();

this.divTopTip.update("正在为您读取数据，请稍候……");

this.showTopTip();

this.updateLocationHref();

var url=this.buildUrl(0,0,0);

new Ajax.Request(url,{

method:"get",onSuccess:function(transport){

var script=transport.responseText;
//alert(script);
this.metaMarkers=new Hash();

eval(script);

this.drawMarkers();

if(this.markersNum==this.maxMarkersNum){

this.divTopTip.update("找到超过"+this.maxMarkersNum+"个小区，您可以调整筛选条件，或者放大视图试试。")

} else{

if(this.markersNum==0){

this.divTopTip.update("没有找到任何房子，您可以调整筛选条件，或者缩小视图试试。")

} else{

this.hideTopTip()

} 

} this.map.savePosition()

} .bind(this)

} )

} ,showTopTip:function(){

this.divTopTip.setStyle({

display:"block"

} )

} ,hideTopTip:function(){

this.divTopTip.setStyle({

display:"none"

} )

} ,buildUrl:function(D,E,B){

var A=$H({

p2:this.tradeType,p3:this.bounds.slatFrom,p4:this.bounds.slatTo,p5:this.bounds.slngFrom,p6:this.bounds.slngTo,p7:this.filters.price,p8:this.filters.areaRange,p9:this.filters.houseModel,p10:this.filters.usetype,p11:D,p12:E,p13:B

} ).toQueryString();

var C="newhousemap.php?"+A;

return C

} ,drawMarkers:function(){

this.mapMarkers.each(function(B){

if(this.metaMarkers.get(B.key)==undefined){

this.markerManager.removeMarker(this.mapMarkers.get(B.key));

this.mapMarkers.unset(B.key)

} 

} .bind(this));

var A=0;

this.metaMarkers.each(function(B){

window.setTimeout(function(){

if(this.mapMarkers.get(B.key)!=undefined&&this.mapMarkers.get(B.key).propNum!=B.value.num){

this.markerManager.removeMarker(this.mapMarkers.get(B.key));

this.mapMarkers.unset(B.key)

} if(this.mapMarkers.get(B.key)==undefined){

var C=this.createMarker(B.value);

this.mapMarkers.set(B.key,C);

this.markerManager.addMarker(this.mapMarkers.get(B.key),0)

} 

} .bind(this),++A*20)

} .bind(this))

} ,createMarker:function(C){

var B=new GIcon();

B.image="images/lable_normal_50x40.png";

B.iconSize=new GSize(90,40);

B.iconAnchor=new GPoint(25,40);

B.infoWindowAnchor=new GPoint(20,0);

var D=new GLatLng(C.lat,C.lng);

var A=new LabeledMarker(D,{

icon:B,labelText:"<span>"+C.name+"</span>",labelClass:"mapFinddingCanvasLabelStyle",labelOffset:new GSize(-25,-40)

} );

A.disableDragging();

A.propNum=C.num;

GEvent.addListener(A,"mouseover",function(){

var E=this.map.fromLatLngToDivPixel(A.getLatLng());

//this.drawCommName(E.y,E.x,C.name);

this.hoverMarker(A,true)

} .bind(this));

GEvent.addListener(A,"mouseout",function(){

this.divCommName.hide();

this.hoverMarker(A,false)

} .bind(this));

GEvent.addListener(A,"click",function(){

this.divCommName.hide();

this.hoverMarker(A,false);

this.allowQueryBounds=false;

A.openExtInfoWindow(this.map,"mapFinddingCanvasExtInfoWindow","<div>"+C.name+"</div><div>loading...</div>");

this.updateMapFinddingCanvasExtInfoWindow(C.id,1,0)

} .bind(this));

return A

} ,hoverMarker:function(B,A){

if(A){

B.setImage("images/lable_hover_50x40.png");

var D=GOverlay.getZIndex(-90);

B.div_.style.zIndex=D;

this.divCommName.style.zIndex=D+1;

try{

B.yr.style.zIndex=D

} catch(C){


} this.map.disableDragging()

} else{

B.setImage("images/lable_normal_50x40.png");

var D=GOverlay.getZIndex(B.getLatLng().lat());

B.div_.style.zIndex=D;

try{

B.yr.style.zIndex=D

} catch(C){


} this.map.enableDragging()

} 

} ,updateMapFinddingCanvasExtInfoWindow:function(C,D,A){

var B=this.buildUrl(C,D,A);
//alert(B);
new Ajax.Request(B,{

method:"get",onSuccess:function(K){

$("mapFinddingCanvasExtInfoWindow_contents").update(K.responseText);
//alert(K.responseText);
//document.write(K.responseText);
this.map.getExtInfoWindow().resize();

var E="page_next";

var F="page_prev";

var I="select_order";

var H=$(E);

var J=$(F);

var G=$(I);

if(H!=null){

Event.observe(E,"click",function(){

H.fire("update:extInfo",{

commId:C,page:D+1,order:A

} )

} )

} if(J!=null){

Event.observe(F,"click",function(){

J.fire("update:extInfo",{

commId:C,page:D-1,order:A

} )

} )

} if(G!=null){

Event.observe(I,"change",function(){

A=G.value;

G.fire("update:extInfo",{

commId:C,page:1,order:A

} )

} )

} 

} .bind(this)

} )

} ,drawCommName:function(D,C,B){

this.divCommName.update(B);

this.divCommName.className="mapFinddingCanvasCommNameRight";

this.divCommName.setStyle({

top:D-40+"px",left:C+20+"px",display:"block"

} );

return ;

if(C>this.splitLine){

var A=this.divCommName.getWidth();

this.divCommName.className="mapFinddingCanvasCommNameLeft";

this.divCommName.setStyle({

top:D-40+"px",left:C-20-A+"px",display:"block"

} )

} else{

this.divCommName.className="mapFinddingCanvasCommNameRight";

this.divCommName.setStyle({

top:D-40+"px",left:C+20+"px",display:"block"

} )

} 

} ,updateLocationHref:function(){

var B=document.location.hash.substring(1).toQueryParams();

var C=this.map.getCenter();

var A=this.map.getZoom();

upparams={


} ;

upparams.l1=C.lat();

upparams.l2=C.lng();

upparams.l3=A;

B.kw="";

upparams.f1=this.filters.price;

upparams.f2=this.filters.areaRange;

upparams.f3=this.filters.houseModel;

upparams.f4=this.filters.usetype;

document.location.hash=Object.toQueryString(upparams)

} ,showResultErr:function(){

this.resResultErr.setStyle({

display:"block"

} )

} ,hideResultErr:function(){

this.resResultErr.setStyle({

display:"none"

} )

} 

} );
