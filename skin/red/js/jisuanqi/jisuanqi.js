function getByClass(oBj, Class) {
	var re = new RegExp('\\b' + Class + '\\b');
	var oTmp = [];
	var aEle = document.getElementsByTagName('*');
	for (var i = 0; i < aEle.length; i++) {
		if (re.test(aEle[i].className)) {
			oTmp.push(aEle[i])
		};
	};
	return oTmp;
};
function FnTabSwitch(id, ul, li, div) {
	var oTuiJian = document.getElementById(id);
    if(!oTuiJian) return;
	var oUl = getByClass(oTuiJian, ul)[0];
	var aBtn = oUl.getElementsByTagName(li);
	var aDiv = getByClass(oTuiJian, div);
	for (var i = 0; i < aBtn.length; i++) {
		aBtn[i].index = i;
		aBtn[i].onclick = function () {
			for (var i = 0; i < aBtn.length; i++) {
				aBtn[i].className = '';
				aDiv[i].style.display = 'none';
			}
			this.className = 'cur';
			aDiv[this.index].style.display = 'block';
		}
	}
}
//FnTabSwitch('jisuanqi','jisuanqi-ul','li','jisuanqi-wrapper');
FnTabSwitch('tuijian', 'tuijian-ul', 'li', 'tuijian-wrapper');

function FnLiuChengMove() {
	var oLiuCheng = document.getElementById('liucheng');
	if(!oLiuCheng) return;
	var oUl = oLiuCheng.getElementsByTagName('ul')[0];
	var aBtn = oUl.getElementsByTagName('li');
	var oLiuChengBox = getByClass(oLiuCheng, 'liucheng-box')[0];
	var oLiuChengUl = getByClass(oLiuChengBox, 'liucheng-box-ul')[0];
	var aDiv = oLiuChengUl.getElementsByTagName('div');
	var oLiuChengUlWidth = aDiv[0].offsetWidth * aDiv.length;
	var oNow = 0;
	oLiuChengUl.innerHTML += oLiuChengUl.innerHTML;
	oLiuChengUl.style.width = aDiv[0].offsetWidth * aDiv.length + 'px';


	for (var i = 0; i < aBtn.length; i++) {
		(function (index) {
			aBtn[i].onclick = function () {
				for (var i = 0; i < aBtn.length; i++) {
					var activeIndex = 0;
					if (aBtn[i].className == 'cur') {
						activeIndex = i;
						break;
					}
				}
				oNow += index - activeIndex;
				FnTab();
			}
		})(i);
	}

	function FnTab() {
		for (var i = 0; i < aBtn.length; i++) {
			aBtn[i].className = '';
		}
		if (oNow > 0) {
			aBtn[oNow % aBtn.length].className = 'cur';
		} else {
			aBtn[(oNow % aBtn.length + aBtn.length) % aBtn.length].className = 'cur';
		}
		FnMove(oLiuChengUl, -oNow * aDiv[0].offsetWidth);
	}
	var left = 0;
	function FnMove(oBj, iTarget) {
		clearInterval(oBj.timer);
		oBj.timer = setInterval(function () {
			var oSpeed = (iTarget - left) / 5;
			oSpeed = oSpeed > 0 ? Math.ceil(oSpeed) : Math.floor(oSpeed);
			left += oSpeed;
			if (left < 0) {
				oBj.style.left = left % oLiuChengUlWidth + 'px';
			} else if (left > 0) {
				oBj.style.left = (left % oLiuChengUlWidth - oLiuChengUlWidth) % oLiuChengUlWidth + 'px';
			}
		}, 30)
	}
};

FnLiuChengMove();

 /* 帮您找房拖拽模块 */
 var helpHouse = (function() {
	var box = $('.helpHouse'),
		panel = $('.helpHouse .box'),
		width = $(window).width(),
		fx = 'right',
		isOpen = false,
		open = function() {
			// if (panel.is(':hidden')) {
			//     panel.addClass('open');
			//     box.animate({
			//         'left': width - 150 - 58 - 17 + 'px'
			//     }, 300);
			//     isOpen = true;
			// }
		}

	/* 关闭 */
	box.on('click', '.close', function() {
		if (!panel.is(':hidden')) {
			panel.removeClass('open');
			box.animate({
				'left': width - 116 + 'px'
			}, 300);
			isOpen = false;
		}
	});

	/* 拖拽 */
	$(document).on('mousedown', '.helpHouse', function(e) {
		var e = e || window.event,
			that = this,
			dx = e.clientX - that.offsetLeft,
			dy = e.clientY - that.offsetTop,
			start = (new Date()).valueOf();

		document.onmousemove = function(e) {
			var e = e || window.event,
				mx = e.clientX - dx,
				my = e.clientY - dy;

			$(that).css({
				'left': mx + 'px',
				'top': my + 60 + 'px'
			});
		}
		document.onmouseup = function() {
			this.onmousemove = null;
			this.onmouseup = null;
			var end = (new Date()).valueOf();
			if (end - start < 300) {
				open();
			} else {
				if (isOpen) {
					box.animate({
						'left': width - 150 - 58 - 17 + 'px'
					}, 300);
				} else {
					box.animate({
						'left': width - 116 + 'px'
					}, 300);
				}
			}
		}
	});
})();


$('.bnzf').on('click',function(){
	$('.ccgPopup').show();
})
$('.ccgPopup .close').on('click',function(){
	$('.ccgPopup').hide();
})
$('.jisuan-result .tit').on('click',function(){
	$('.bzPop').show();
})
$('.bzPop .close').on('click',function(){
	$('.bzPop').hide();
})


/* tips */
function tg_tips(title, desc, time, fn) {
    var body = $(document.body),
        html = '',
        time = time || 2000;
    html += '<div class="boxTips">';
    html += '<div class="tips">';
    if (title !== '') {
        html += '<div class="tit">' + title + '</div>';
    }
    html += '<div class="desc">' + desc + '</div>';
    html += '</div>';
    html += '</div>';
    body.append(html);
    var timer = setTimeout(function () {
        $('.boxTips').remove();
        clearTimeout(timer);
        if (typeof fn === 'function') {
            fn();
        }
    }, time);
}


var data_city = [],
    initProvName = '',
    initSiteName = '',
    prov_index,
    site_index;

function getIndex(val) {
    var index;
    for (var i = 0; i < data_city.length; i++) {
        if (val == data_city[i].id) {
            index = i;
            break;
        }
    }
    return index
}
function getIndex1(val) {
    var index;
    for (var i = 0; i < data_city[prov_index].childs.length; i++) {
        if (val == data_city[prov_index].childs[i].id) {
            index = i;
            break;
        }
    }
    return index
}


function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$('#site_id').on('change', function (e) {
    var el = $(e.currentTarget);
    site_id = el.val();
});

$('.ccgPopup .btn').on('click', function (e) {
    var el = $(e.currentTarget),
        phone = /^[1][3,4,5,6,7,8,9][0-9]{9}$/,
        mobile = $("#mobile").val();
    var buy_id = $("#mobile").attr('data-from-id');
    if (!buy_id){
        buy_id = 10040;
    }
    if (mobile == '' || mobile == undefined) {
        tg_tips('请输入手机号码!', '');
        return false
    }
    if (!phone.test(mobile)) {
        tg_tips('请输入正确的手机号码!', '');
        return false
    }
    $.ajax({
        //请求方式
        type: 'post',
        //发送请求的地址
        url: group_buy_domain  + '/group_buy/group_buy_sign_in',
        // url: 'http://service.testing.loupan.com/calculator/v1/rate/latest',
        //服务器返回的数据类型
        dataType: 'json',
        // async: false,
        //发送到服务器的数据，对象必须为key/value的格式，jquery会自动转换为字符串格式
        headers: { 'Accept': 'application/json' },
        data: {
            "site_id": site_id,
            "group_buy_id": buy_id,
            "isapp": 0,
            'mobile': mobile
        },
        success: function (data, textStatus, jqXHR) {
            //请求成功函数内容
            if (data.code == 200) {
                tg_tips(data.msg, '');
            } else {
                tg_tips(data.msg, '');
            }
        },

        error: function (jqXHR) {
            if (JSON.parse(jqXHR.responseText).context.length > 0) {
                tg_tips(JSON.parse(jqXHR.responseText).context[0], '');
            } else {
                tg_tips(JSON.parse(jqXHR.responseText).message, '');
            }


        }
    });
});
