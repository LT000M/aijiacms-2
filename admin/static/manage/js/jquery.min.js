var version= IEVersion();
if(version < 9)
{
    //require("/static/js/jquery.3.3.1.min.js");
    document.write("<script language=javascript src='/static/js/jquery.1.10.1.min.js'></script>");
}else{
   // require("/static/js/jquery.1.10.1.min.js");
    document.write("<script language=javascript src='/static/js/jquery.3.3.1.min.js'></script>");
}

function IEVersion() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if(isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        return fIEVersion;
    } else if(isEdge) {
        return 'edge';//edge
    } else if(isIE11) {
        return 'ie11'; //IE11
    }else{
        return 'other';//不是ie浏览器
    }
}