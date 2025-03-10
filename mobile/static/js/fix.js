var _ua = navigator.userAgent.toLowerCase();
if(_ua.indexOf('iphone')!=-1 || _ua.indexOf('ipod')!=-1 || _ua.indexOf('ipad')!=-1) {
	document.write('<style type="text/css">');
	if(parseInt(_ua.match(/os (\d+)_/)[1]) > 7) {/*IOS8+ 细线*/
		document.write('.bd-b,.head-bar,.list-set,.list-img,.list-msg li {border-bottom:#D3D3D3 0.5px solid;}.bd-t,.foot-bar,.list-set div,.list-set {border-top:#D3D3D3 0.5px solid;}.bd-r {border-right:#D3D3D3 0.5px solid;}.bd-l {border-left:#D3D3D3 0.5px solid;}');
	}
	if(Dbrowser == 'app') {
		document.write('.head-bar{border-top:#F7F7F7 20px solid;}.head-bar-fix{height:68px;background:#F7F7F7;}');
	} else if(_ua.indexOf('micromessenger/')!=-1) {/*微信*/
		document.write('.head-bar{background:#EDEDED;}.head-bar-left {padding:0 0 0 18px;}.head-bar-back {padding:0 0 0 16px;}');
	} else if(_ua.indexOf('tim/')!=-1) {/*TIM*/
		document.write('.head-bar{background:#FFFFFF;}.head-bar-left {padding:0 0 0 10px;}.head-bar-back {padding:0 0 0 8px;}.head-bar-right {padding:0 6px 0 0;}');
	} else if(_ua.indexOf('qq/')!=-1) {/*QQ*/
		document.write('.head-bar{background:#FFFFFF;}.head-bar-back {padding:0 0 0 12px;}.head-bar-right {padding:0 12px 0 0;}');
	}
	document.write('</style>');
	if(Dbrowser != 'screen' && navigator.standalone) {/*IOS 主屏打开*/
		document.write('<script type="text/javascript" src="'+AJPath+'?action=screen"></sc'+'ript>');
	}
} else if(_ua.indexOf('android')!=-1) {
	document.write('<style type="text/css">');
	if(_ua.indexOf('micromessenger/')!=-1) {/*微信*/
		document.write('.head-bar {background:#EDEDED;}.head-bar-left {padding:0 0 0 8px;}.head-bar-back {padding:0 0 0 6px;}.head-bar-right {padding:0 14px 0 0;}');
	} else if(_ua.indexOf('tim/')!=-1) {/*TIM*/
		document.write('.head-bar{background:#FFFFFF;}.head-bar-left {padding:0 0 0 10px;}.head-bar-back {padding:0 0 0 8px;}.head-bar-right {padding:0 14px 0 0;}');
	} else if(_ua.indexOf('qq/')!=-1) {/*QQ*/
		document.write('.head-bar-left {padding:0 0 0 8px;}.head-bar-back {padding:0 0 0 4px;.head-bar-right {padding:0 8px 0 0;}');
	}
	document.write('</style>');
}