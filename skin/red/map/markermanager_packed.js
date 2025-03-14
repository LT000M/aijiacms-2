function MarkerManager(map, opt_opts) {
    var me = this;
    me.map_ = map;
    me.mapZoom_ = map.getZoom();
    me.projection_ = map.getCurrentMapType().getProjection();
    opt_opts = opt_opts || {};
    me.tileSize_ = MarkerManager.DEFAULT_TILE_SIZE_;
    var maxZoom = MarkerManager.DEFAULT_MAX_ZOOM_;
    if (opt_opts.maxZoom != undefined) {
        maxZoom = opt_opts.maxZoom
    }
    me.maxZoom_ = maxZoom;
    me.trackMarkers_ = opt_opts.trackMarkers;
    var padding;
    if (typeof opt_opts.borderPadding == "number") {
        padding = opt_opts.borderPadding
    } else {
        padding = MarkerManager.DEFAULT_BORDER_PADDING_
    }
    me.swPadding_ = new GSize( - padding, padding);
    me.nePadding_ = new GSize(padding, -padding);
    me.borderPadding_ = padding;
    me.gridWidth_ = [];
    me.grid_ = [];
    me.grid_[maxZoom] = [];
    me.numMarkers_ = [];
    me.numMarkers_[maxZoom] = 0;
    GEvent.bind(map, "moveend", me, me.onMapMoveEnd_);
    me.removeOverlay_ = function(marker) {
        map.removeOverlay(marker);
        me.shownMarkers_--
    };
    me.addOverlay_ = function(marker) {
        map.addOverlay(marker);
        me.shownMarkers_++
    };
    me.resetManager_();
    me.shownMarkers_ = 0;
    me.shownBounds_ = me.getMapGridBounds_()
};
MarkerManager.DEFAULT_TILE_SIZE_ = 1024;
MarkerManager.DEFAULT_MAX_ZOOM_ = 17;
MarkerManager.DEFAULT_BORDER_PADDING_ = 100;
MarkerManager.MERCATOR_ZOOM_LEVEL_ZERO_RANGE = 256;
MarkerManager.prototype.resetManager_ = function() {
    var me = this;
    var mapWidth = MarkerManager.MERCATOR_ZOOM_LEVEL_ZERO_RANGE;
    for (var zoom = 0; zoom <= me.maxZoom_; ++zoom) {
        me.grid_[zoom] = [];
        me.numMarkers_[zoom] = 0;
        me.gridWidth_[zoom] = Math.ceil(mapWidth / me.tileSize_);
        mapWidth <<= 1
    }
};
MarkerManager.prototype.clearMarkers = function() {
    var me = this;
    me.processAll_(me.shownBounds_, me.removeOverlay_);
    me.resetManager_()
};
MarkerManager.prototype.getTilePoint_ = function(latlng, zoom, padding) {
    var pixelPoint = this.projection_.fromLatLngToPixel(latlng, zoom);
    return new GPoint(Math.floor((pixelPoint.x + padding.width) / this.tileSize_), Math.floor((pixelPoint.y + padding.height) / this.tileSize_))
};
MarkerManager.prototype.addMarkerBatch_ = function(marker, minZoom, maxZoom) {
    var mPoint = marker.getPoint();
    if (this.trackMarkers_) {
        GEvent.bind(marker, "changed", this, this.onMarkerMoved_)
    }
    var gridPoint = this.getTilePoint_(mPoint, maxZoom, GSize.ZERO);
    for (var zoom = maxZoom; zoom >= minZoom; zoom--) {
        var cell = this.getGridCellCreate_(gridPoint.x, gridPoint.y, zoom);
        cell.push(marker);
        gridPoint.x = gridPoint.x >> 1;
        gridPoint.y = gridPoint.y >> 1
    }
};
MarkerManager.prototype.isGridPointVisible_ = function(point) {
    var me = this;
    var vertical = me.shownBounds_.minY <= point.y && point.y <= me.shownBounds_.maxY;
    var minX = me.shownBounds_.minX;
    var horizontal = minX <= point.x && point.x <= me.shownBounds_.maxX;
    if (!horizontal && minX < 0) {
        var width = me.gridWidth_[me.shownBounds_.z];
        horizontal = minX + width <= point.x && point.x <= width - 1
    }
    return vertical && horizontal
};
MarkerManager.prototype.onMarkerMoved_ = function(marker, oldPoint, newPoint) {
    var me = this;
    var zoom = me.maxZoom_;
    var changed = false;
    var oldGrid = me.getTilePoint_(oldPoint, zoom, GSize.ZERO);
    var newGrid = me.getTilePoint_(newPoint, zoom, GSize.ZERO);
    while (zoom >= 0 && (oldGrid.x != newGrid.x || oldGrid.y != newGrid.y)) {
        var cell = me.getGridCellNoCreate_(oldGrid.x, oldGrid.y, zoom);
        if (cell) {
            if (me.removeFromArray(cell, marker)) {
                me.getGridCellCreate_(newGrid.x, newGrid.y, zoom).push(marker)
            }
        }
        if (zoom == me.mapZoom_) {
            if (me.isGridPointVisible_(oldGrid)) {
                if (!me.isGridPointVisible_(newGrid)) {
                    me.removeOverlay_(marker);
                    changed = true
                }
            } else {
                if (me.isGridPointVisible_(newGrid)) {
                    me.addOverlay_(marker);
                    changed = true
                }
            }
        }
        oldGrid.x = oldGrid.x >> 1;
        oldGrid.y = oldGrid.y >> 1;
        newGrid.x = newGrid.x >> 1;
        newGrid.y = newGrid.y >> 1; --zoom
    }
    if (changed) {
        me.notifyListeners_()
    }
};
MarkerManager.prototype.removeMarker = function(marker) {
    var me = this;
    var zoom = me.maxZoom_;
    var changed = false;
    var point = marker.getPoint();
    var grid = me.getTilePoint_(point, zoom, GSize.ZERO);
    while (zoom >= 0) {
        var cell = me.getGridCellNoCreate_(grid.x, grid.y, zoom);
        if (cell) {
            me.removeFromArray(cell, marker)
        }
        if (zoom == me.mapZoom_) {
            if (me.isGridPointVisible_(grid)) {
                me.removeOverlay_(marker);
                changed = true
            }
        }
        grid.x = grid.x >> 1;
        grid.y = grid.y >> 1; --zoom
    }
    if (changed) {
        me.notifyListeners_()
    }
};
MarkerManager.prototype.addMarkers = function(markers, minZoom, opt_maxZoom) {
    var maxZoom = this.getOptMaxZoom_(opt_maxZoom);
    for (var i = markers.length - 1; i >= 0; i--) {
        this.addMarkerBatch_(markers[i], minZoom, maxZoom)
    }
    this.numMarkers_[minZoom] += markers.length
};
MarkerManager.prototype.getOptMaxZoom_ = function(opt_maxZoom) {
    return opt_maxZoom != undefined ? opt_maxZoom: this.maxZoom_
};
MarkerManager.prototype.getMarkerCount = function(zoom) {
    var total = 0;
    for (var z = 0; z <= zoom; z++) {
        total += this.numMarkers_[z]
    }
    return total
};
MarkerManager.prototype.addMarker = function(marker, minZoom, opt_maxZoom) {
    var me = this;
    var maxZoom = this.getOptMaxZoom_(opt_maxZoom);
    me.addMarkerBatch_(marker, minZoom, maxZoom);
    var gridPoint = me.getTilePoint_(marker.getPoint(), me.mapZoom_, GSize.ZERO);
    if (me.isGridPointVisible_(gridPoint) && minZoom <= me.shownBounds_.z && me.shownBounds_.z <= maxZoom) {
        me.addOverlay_(marker);
        me.notifyListeners_()
    }
    this.numMarkers_[minZoom]++
};
GBounds.prototype.containsPoint = function(point) {
    var outer = this;
    return (outer.minX <= point.x && outer.maxX >= point.x && outer.minY <= point.y && outer.maxY >= point.y)
};
MarkerManager.prototype.getGridCellCreate_ = function(x, y, z) {
    var grid = this.grid_[z];
    if (x < 0) {
        x += this.gridWidth_[z]
    }
    var gridCol = grid[x];
    if (!gridCol) {
        gridCol = grid[x] = [];
        return gridCol[y] = []
    }
    var gridCell = gridCol[y];
    if (!gridCell) {
        return gridCol[y] = []
    }
    return gridCell
};
MarkerManager.prototype.getGridCellNoCreate_ = function(x, y, z) {
    var grid = this.grid_[z];
    if (x < 0) {
        x += this.gridWidth_[z]
    }
    var gridCol = grid[x];
    return gridCol ? gridCol[y] : undefined
};
MarkerManager.prototype.getGridBounds_ = function(bounds, zoom, swPadding, nePadding) {
    zoom = Math.min(zoom, this.maxZoom_);
    var bl = bounds.getSouthWest();
    var tr = bounds.getNorthEast();
    var sw = this.getTilePoint_(bl, zoom, swPadding);
    var ne = this.getTilePoint_(tr, zoom, nePadding);
    var gw = this.gridWidth_[zoom];
    if (tr.lng() < bl.lng() || ne.x < sw.x) {
        sw.x -= gw
    }
    if (ne.x - sw.x + 1 >= gw) {
        sw.x = 0;
        ne.x = gw - 1
    }
    var gridBounds = new GBounds([sw, ne]);
    gridBounds.z = zoom;
    return gridBounds
};
MarkerManager.prototype.getMapGridBounds_ = function() {
    var me = this;
    return me.getGridBounds_(me.map_.getBounds(), me.mapZoom_, me.swPadding_, me.nePadding_)
};
MarkerManager.prototype.onMapMoveEnd_ = function() {
    var me = this;
    me.objectSetTimeout_(this, this.updateMarkers_, 0)
};
MarkerManager.prototype.objectSetTimeout_ = function(object, command, milliseconds) {
    return window.setTimeout(function() {
        command.call(object)
    },
    milliseconds)
};
MarkerManager.prototype.refresh = function() {
    var me = this;
    if (me.shownMarkers_ > 0) {
        me.processAll_(me.shownBounds_, me.removeOverlay_)
    }
    me.processAll_(me.shownBounds_, me.addOverlay_);
    me.notifyListeners_()
};
MarkerManager.prototype.updateMarkers_ = function() {
    var me = this;
    me.mapZoom_ = this.map_.getZoom();
    var newBounds = me.getMapGridBounds_();
    if (newBounds.equals(me.shownBounds_) && newBounds.z == me.shownBounds_.z) {
        return
    }
    if (newBounds.z != me.shownBounds_.z) {
        me.processAll_(me.shownBounds_, me.removeOverlay_);
        me.processAll_(newBounds, me.addOverlay_)
    } else {
        me.rectangleDiff_(me.shownBounds_, newBounds, me.removeCellMarkers_);
        me.rectangleDiff_(newBounds, me.shownBounds_, me.addCellMarkers_)
    }
    me.shownBounds_ = newBounds;
    me.notifyListeners_()
};
MarkerManager.prototype.notifyListeners_ = function() {
    GEvent.trigger(this, "changed", this.shownBounds_, this.shownMarkers_)
};
MarkerManager.prototype.processAll_ = function(bounds, callback) {
    for (var x = bounds.minX; x <= bounds.maxX; x++) {
        for (var y = bounds.minY; y <= bounds.maxY; y++) {
            this.processCellMarkers_(x, y, bounds.z, callback)
        }
    }
};
MarkerManager.prototype.processCellMarkers_ = function(x, y, z, callback) {
    var cell = this.getGridCellNoCreate_(x, y, z);
    if (cell) {
        for (var i = cell.length - 1; i >= 0; i--) {
            callback(cell[i])
        }
    }
};
MarkerManager.prototype.removeCellMarkers_ = function(x, y, z) {
    this.processCellMarkers_(x, y, z, this.removeOverlay_)
};
MarkerManager.prototype.addCellMarkers_ = function(x, y, z) {
    this.processCellMarkers_(x, y, z, this.addOverlay_)
};
MarkerManager.prototype.rectangleDiff_ = function(bounds1, bounds2, callback) {
    var me = this;
    me.rectangleDiffCoords(bounds1, bounds2, 
    function(x, y) {
        callback.apply(me, [x, y, bounds1.z])
    })
};
MarkerManager.prototype.rectangleDiffCoords = function(bounds1, bounds2, callback) {
    var minX1 = bounds1.minX;
    var minY1 = bounds1.minY;
    var maxX1 = bounds1.maxX;
    var maxY1 = bounds1.maxY;
    var minX2 = bounds2.minX;
    var minY2 = bounds2.minY;
    var maxX2 = bounds2.maxX;
    var maxY2 = bounds2.maxY;
    for (var x = minX1; x <= maxX1; x++) {
        for (var y = minY1; y <= maxY1 && y < minY2; y++) {
            callback(x, y)
        }
        for (var y = Math.max(maxY2 + 1, minY1); y <= maxY1; y++) {
            callback(x, y)
        }
    }
    for (var y = Math.max(minY1, minY2); y <= Math.min(maxY1, maxY2); y++) {
        for (var x = Math.min(maxX1 + 1, minX2) - 1; x >= minX1; x--) {
            callback(x, y)
        }
        for (var x = Math.max(minX1, maxX2 + 1); x <= maxX1; x++) {
            callback(x, y)
        }
    }
};
MarkerManager.prototype.removeFromArray = function(array, value, opt_notype) {
    var shift = 0;
    for (var i = 0; i < array.length; ++i) {
        if (array[i] === value || (opt_notype && array[i] == value)) {
            array.splice(i--, 1);
            shift++
        }
    }
    return shift
};