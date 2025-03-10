function direction(hid,fromid,types){
var xmlHttpReq = new XMLHttpRequest();
xmlHttpReq.open("GET", "browse_log.php?hid="+hid+"&fromid="+fromid+"&types="+types, false);
xmlHttpReq.send(null);  
}