
/**
 * 百度地图
 */
var BMapApplication = {
    'map' : null,                      // 百度地图实例
    'panorama' : null,                 // 街景地图实例
    'sPoint' : null,                   // 基础地图坐标点实例
    'pPoint' : null,                   // 街景地图坐标点
    'title'  : '',
    'price'  : '',
    'lng'    : 0,
    'lat'    : 0,
    'template' : 'template',
    'content'  : 'house-detail',
    requestParam : {},
    viewDetail : false,
    resultList : [],
    _title : '',
    _price : '',
    _point : '',
    _id    : 0,
    requestUrl : '',
    /**
     * 初始化方法
     * @param lng
     * @param lat
     * @param elemId
     */
    'init' : function (args){
        var lng = args.lng ? args.lng : 0;
        var lat = args.lat ? args.lat : 0;
        var mapContainerId = args.mapContainerId ? args.mapContainerId : '';
        var streetContainerId = args.streetContainerId ? args.streetContainerId : '';
        if (mapContainerId != '')
        {
            this.setBmapContainer(mapContainerId);
            this.setSPoint(lng, lat);
        }
        if (streetContainerId != '')
        {
            this.setPanoramaContainer(streetContainerId);
            this.setPPoint(lng, lat);
        }
    },
    /**
     * 设置基本地图容器
     * @param elemId
     */
    'setBmapContainer' : function (elemId){
        elemId = elemId == undefined ? 'allmap' : elemId;
        this.map = (this.map == null) ? new BMap.Map(elemId,{ enableMapClick: false,minZoom : 14 }) : this.map;
    },
    /* 清空基本地图容器 */
    'clearBmapContainer' : function (){
        this.map = null;
    },
    /**
     * 设置街景地图容器
     * @param elemId
     */
    'setPanoramaContainer' : function (elemId){
        this.panorama = (this.panorama == null) ? new BMap.Panorama(elemId, {
            albumsControl: true    // 显示相册控件
        }) : this.panorama;
    },
    /**
     * 设置经纬坐标点
     * @param lng
     * @param lat
     */
    'setSPoint' : function (lng, lat){
        this.sPoint = (this.sPoint == null) ? new BMap.Point(lng, lat) : this.sPoint;
    },
    /**
     * 设置
     * @param lng
     * @param lat
     */
    'setPPoint' : function (lng, lat){
        this.pPoint = (this.pPoint == null) ? new BMap.Point(lng, lat) : this.pPoint;
    },
    /**
     * 根据球面坐标获得平面坐标
     * @param poi
     * @returns {*}
     */
    'getMecator' : function (poi){
        return this.map.getMapType().getProjection().lngLatToPoint(poi);
    },
    /**
     * 根据平面坐标获得球面坐标
     * @param mecator
     * @returns {*}
     */
    'getPoi' : function (mecator){
        return this.map.getMapType().getProjection().pointToLngLat(mecator);
    },
    getCurMap : function(){
        var point = new BMap.Point(this.lng,this.lat);
        this.map.enableScrollWheelZoom();
        this.map.centerAndZoom(point,15);
        this.setComplexPrototype();
        myCompOverlay = new this.ComplexCustomOverlay(point,this.title,this.price,1);
        this.map.addOverlay(myCompOverlay);
    },
    //获取可视化区域
    getMapBounds : function(){
        var bounds = this.map.getBounds();   //获取可视区域
        this.bssw = bounds.getSouthWest();   //可视区域左下角
        this.bsne = bounds.getNorthEast();
    },
    getMap : function(keyword, icon){
        var _this = this;                         // 解决闭包作用域问题
        this.map.enableScrollWheelZoom();
        this.map.centerAndZoom(this.sPoint,15);
        this.map.clearOverlays();    // 清除页面标记
        var circle = new BMap.Circle(this.sPoint, 1500, {fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.1, strokeOpacity: 0.1});
        var options = {
            pageCapacity: this.pageSize
        };
        this.setCurComplexPrototype();
        var myCompOverlay = new this.ComplexCustomOverlay();
        this.map.addOverlay(myCompOverlay);
        if(keyword == '楼盘') {
            this.getData();
        }else{
            options.onSearchComplete = function(results){
                _this.resultList = [];    // 清空搜索结果集合
                // 判断状态是否正确
                if (local.getStatus() == BMAP_STATUS_SUCCESS)
                {
                    _this.count = results.getCurrentNumPois();
                    for (var i = 0; i < results.getCurrentNumPois(); i ++)
                    {
                        ePoint = new BMap.Point(results.getPoi(i).point.lng, results.getPoi(i).point.lat);
                        distance = parseInt(_this.map.getDistance(_this.sPoint, ePoint));
                        var data = {key:i,address:results.getPoi(i).address,title:results.getPoi(i).title,distance:distance,lat:results.getPoi(i).point.lat,lng:results.getPoi(i).point.lng};
                        _this.addMarker(data,icon);
                    }
                }

            };
            var local = new BMap.LocalSearch(this.map, options);
            var bounds = this.getSquareBounds(circle.getCenter(), circle.getRadius());
            local.searchInBounds(keyword, bounds);
        }
    },
    getData : function(){
        var that = this,pointArr = [];
        this.getMapBounds();
        //按条件筛选在地图可视范围内 按楼盘名搜索不限制
        this.requestParam.bssw_lat = this.bssw.lat;
        this.requestParam.bssw_lng = this.bssw.lng;
        this.requestParam.bsne_lat = this.bsne.lat;
        this.requestParam.bsne_lng = this.bsne.lng;
        if(this.requestUrl){
            $.get(this.requestUrl,this.requestParam,function(result){
                if(result.code == 1 && result.data)
                {
                    $(result.data).each(function (i, ite) {
                        var title = ite.title,
                            price = ite.price,
                            total = 0;
                        that.setComplexPrototype();
                        var point = new BMap.Point(ite.lng,ite.lat);
                        var myCompOverlay = new that.ComplexCustomOverlay(point,title,price,ite.id);
                        that.map.addOverlay(myCompOverlay);
                    });
                }
            });
        }
    },
    setCenter :function(lng,lat,name){
        if(lng!=0 && lat!=0)
        {
            this.map.centerAndZoom(new BMap.Point(lng,lat),13);
        }else{
            this.map.centerAndZoom(name,13);
        }

    },
    /**
     * 得到圆的内接正方形bounds
     * @param {Point} centerPoi 圆形范围的圆心
     * @param {Number} r 圆形范围的半径
     * @return 无返回值
     */
    'getSquareBounds' : function (centerPoi, r){
        var a = Math.sqrt(2) * r;    // 正方形边长
        mPoi = this.getMecator(centerPoi);
        var x0 = mPoi.x, y0 = mPoi.y;
        var x1 = x0 + a / 2 , y1 = y0 + a / 2;    // 东北点
        var x2 = x0 - a / 2 , y2 = y0 - a / 2;    // 西南点
        var ne = this.getPoi(new BMap.Pixel(x1, y1)), sw = this.getPoi(new BMap.Pixel(x2, y2));
        return new BMap.Bounds(sw, ne);
    },
    addMarker : function(data,ico){
        var _this = this;
            var pt = new BMap.Point(data.lng, data.lat);
            var myIcon = new BMap.Icon("/static/mobile/images/icon/map/"+ico+".png", new BMap.Size(50,50));
            var myIcon2 = new BMap.Icon("/static/mobile/images/icon/map/"+ico+"-2.png", new BMap.Size(50,50));
            var marker = new BMap.Marker(pt,{icon:myIcon});  // 创建标注
            this.map.addOverlay(marker);
        var opts = {
            width : 200,     // 信息窗口宽度
            height: 90,     // 信息窗口高度
            title : data.title , // 信息窗口标题
            enableMessage:true,//设置允许信息窗发送短息
            message:data.address
        };
        var infoWindow = new BMap.InfoWindow(data.address+"<br />距小区直线距离"+data.distance+"米", opts);  // 创建信息窗口对象
        //打开信息窗
        marker.addEventListener("click", function(){
            this.setIcon(myIcon2);
            this.setTop(true);
            _this.map.openInfoWindow(infoWindow,pt); //开启信息窗口
        });
        //监听信息窗关闭事件 改变marker图标
        BMapLib.EventWrapper.addListener(infoWindow, 'close', function(e){
            marker.setIcon(myIcon);
            marker.setTop(false);
        });
    },
    getHouseInfoById : function(id) {
        var that = this,pointArr = [];
        var param = {id : id};
        var detail = $("#house-detail"),url = detail.data('uri');
        if(url){
            layer.msg('数据加载中……',{time:10000});
            $.get(url,param,function(result){
                layer.closeAll();
                if(result.code == 1 && result.data)
                {
                    var gettpl = document.getElementById(that.template).innerHTML;
                    laytpl(gettpl).render(result.data, function(html){
                        $('#'+that.content).html(html);
                    });
                    detail.show();
                }else{
                    detail.hide();
                    layer.msg(result.msg);
                }
            });
        }
    },
    ComplexCustomOverlay:function(point, text, text1,id){
        this._point = point;
        this._title = text;
        this._price = text1;
        this._id    = id;
    },
    setComplexPrototype : function(){
        this.ComplexCustomOverlay.prototype = new BMap.Overlay();
        var _this = this;
        this.ComplexCustomOverlay.prototype.initialize = function(){
            var that = this;
            var div = this._div = document.createElement("div");
            div.className = "map-house";
            var h2 = document.createElement("h2"),
                p = document.createElement("p");
            $(h2).html(this._title);
            $(p).html(this._price);
            div.appendChild(h2);
            div.appendChild(p);
            _this.map.getPanes().labelPane.appendChild(div);
            if(_this.viewDetail) {
                BMapLib.EventWrapper.addDomListener(div, "touchend", function(e){
                    $(this).toggleClass('active').siblings().removeClass('active');
                    if($(this).hasClass('active')) {
                        _this.getHouseInfoById(that._id);
                    }else{
                        $("#house-detail").hide();
                    }
                });
            }

            return div;
        };
        this.ComplexCustomOverlay.prototype.draw = function(){
            var map = _this.map;
            var pixel = map.pointToOverlayPixel(this._point);
            this._div.style.left = pixel.x - 55 + "px";
            this._div.style.top  = pixel.y - 50 + "px";
        }
    },
    setCurComplexPrototype : function(){
        this.ComplexCustomOverlay.prototype = new BMap.Overlay();
        var _this = this;
        this.ComplexCustomOverlay.prototype.initialize = function(){
            var that = this;
            var div = this._div = document.createElement("div");
            div.className = "map-marting-house";
            var h2 = document.createElement("h2"),
                p = document.createElement("p");
            $(h2).html(_this.title);
            $(p).html(_this.price);
            div.appendChild(h2);
            div.appendChild(p);
            _this.map.getPanes().labelPane.appendChild(div);
            return div;
        };
        this.ComplexCustomOverlay.prototype.draw = function(){
            var map = _this.map;
            var pixel = map.pointToOverlayPixel(_this.sPoint);
            this._div.style.left = pixel.x - 75 + "px";
            this._div.style.top  = pixel.y - 50 + "px";
        }
    }
};

