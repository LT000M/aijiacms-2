<?php
require '../../../common.inc.php';
include AJ_ROOT.'/api/map/google/config.inc.php';
$map = isset($map) ? $map : '';
preg_match("/^[0-9\.\,\-]{20,50}$/", $map) or $map = $map_mid;
$address = isset($address) ? trim(strip_tags($address)) : '';
$address = isset($address) ? trim(strip_tags($address)) : '';
($address && $address) or exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Google Map</title>
<style type="text/css">
body {margin:0;}
</style>
<script type="text/javascript">window.onerror=function(){return true;}</script>
<script type="text/javascript" src="<?php echo AJ_PATH;?>file/script/config.js"></script>
<script src="http://ditu.google.cn/maps?file=api&hl=zh-CN&v=2&key=<?php echo $AJ['map_key'];?>" type="text/javascript"></script>

<script type="text/javascript">
var points = [];
var markers = [];
var counter = 0;
var map = null;
function mapOnLoad() {
	if (GBrowserIsCompatible()) {
		var mapObj = document.getElementById("map");
		if (mapObj != "undefined" && mapObj != null) {
			map = new GMap2(document.getElementById("map"));
			map.setCenter(new GLatLng(<?php echo $map;?>), 13, G_NORMAL_MAP);
			map.addControl(new GLargeMapControl3D());
			map.addControl(new GMenuMapTypeControl());
			map.addControl(new GScaleControl());
			map.addOverlay(new GMarker(new GLatLng(<?php echo $map;?>)));//
			var point = new GLatLng(<?php echo $map;?>);
			var marker = createMarker(point,"<?php echo $title;?>",[new GInfoWindowTab("Details", "<div id=\"gmapmarker\" style=\"font-size:13px;\"><strong><?php echo $address;?><\/strong><br \/><?php echo $address;?><\/div>")], 0, "");
			map.addOverlay(marker);
			GEvent.trigger(marker,"click");
		}
	} else {
		alert("The map could not be displayed on your browser.");
	}
}
function createMarker(point, title, html, n, tooltip) {
	if(n >=0) { n = -1; }
	var marker = new GMarker(point,{'title': title});
	if(isArray(html)) {GEvent.addListener(marker, "click", function() { marker.openInfoWindowTabsHtml(html); }); }
	else { GEvent.addListener(marker, "click", function() { marker.openInfoWindowHtml(html); }); }
	return marker;
}
function isArray(a) {return isObject(a) && a.constructor == Array;}
function isObject(a) {return (a && typeof a == 'object') || isFunction(a);}
function isFunction(a) {return typeof a == 'function';}
window.onload=mapOnLoad;
//]]>
</script>
</head>
<body>
<script type="text/javascript">
//<![CDATA[
if (GBrowserIsCompatible()) {
document.write('<div id="map" class="map" style="width:100%;height:300px;"></div>');
} else {
document.write('The map could not be displayed on your browser.');
}
//]]>
</script>
<noscript>The map requires javascript to be enabled.</noscript>
</body>
</html>