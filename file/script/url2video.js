/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
function _cutstr(str, mark1, mark2) {
	var p1 = str.indexOf(mark1);
	if(p1 == -1) return '';
	str = str.substr(p1 + mark1.length);
	var p2 = str.indexOf(mark2);
	if(p2 == -1) return str;
	return str.substr(0, p2);
}
function url2video(u) {
	var p,p1,p2;
	var d = _cutstr(u, '://', '/');
	var h = u.substr(0, 5) == 'https' ? 'https://' : 'http://';
	switch(d) {
		case 'v.youku.com':
			p = _cutstr(u, 'id_', '.html');
			if(p) return h+'player.youku.com/embed/'+p;
		break;
		case 'player.youku.com':
			p = _cutstr(u, 'sid/', '/');
			if(p) return h+'player.youku.com/embed/'+p;
			p = _cutstr(u, 'embed/', u.indexOf("'") != -1 ? "'" : '"');
			if(p) return h+'player.youku.com/embed/'+p;
		break;
		case 'imgcache.qq.com':
		case 'static.v.qq.com':
		case 'v.qq.com':
			p = _cutstr(u, 'vid=', '&');
			if(p) return h+'v.qq.com/iframe/player.html?vid='+p+'&tiny=0&auto=0';
			p = _cutstr(u, 'cover/', '.html');
			if(p) p = _cutstr(p, '/', '/');
			if(p) return h+'v.qq.com/iframe/player.html?vid='+p+'&tiny=0&auto=0';
		break;
		case 'open.iqiyi.com':
			p1 = _cutstr(u, 'vid=', '&');
			p2 = _cutstr(u, 'tvId=', '&');
			if(p1 && p2) return h+'m.iqiyi.com/shareplay.html?vid='+p1+'&tvid='+p2;
		break;
		case 'player.video.qiyi.com':
			p1 = _cutstr(u, 'player.video.qiyi.com/', '/');
			p2 = _cutstr(u, 'tvId=', '-');
			if(p1 && p2) return h+'m.iqiyi.com/shareplay.html?vid='+p1+'&tvid='+p2;
		break;
		case 'www.bilibili.com':
			p = _cutstr(u, '/video/', u.indexOf('?') == -1 ? '/' : '?');
			if(p) return h+'player.bilibili.com/player.html?bvid='+p;
		break;
		case 'www.acfun.cn':			
			p = _cutstr(u, '/v/', u.indexOf('?') == -1 ? '/' : '?');
			if(p) return h+'www.acfun.cn/player/'+p;
		break;
		case 'www.huya.com':
			p = _cutstr(u, 'www.huya.com/', '/');
			if(p) return h+'liveshare.huya.com/iframe/'+p;
		break;
		case 'www.douyu.com':
			p = _cutstr(u, 'www.douyu.com/', '/');
			if(p) return h+'staticlive.douyucdn.cn/common/share/play.swf?room_id='+p;
		break;
		case 'www.youtube.com':
			p = _cutstr(u, 'v=', '&');
			if(p) return h+'www.youtube.com/v/'+p;
		break;
		default:
		break;
	}
	return u;
}