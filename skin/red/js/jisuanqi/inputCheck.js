var data_ll = [
    { id: '0', value: '基准利率7折', countVal: 0.7 },
    { id: '1', value: '基准利率75折', countVal: 0.75 },
    { id: '2', value: '基准利率8折', countVal: 0.8 },
    { id: '3', value: '基准利率85折', countVal: 0.85 },
    { id: '4', value: '基准利率9折', countVal: 0.9 },
    { id: '5', value: '基准利率95折', countVal: 0.95 },
    { id: '6', value: '基准利率（3.25%）', countVal: 1 },
    { id: '7', value: '基准利率1.05倍', countVal: 1.05 },
    { id: '8', value: '基准利率1.1倍', countVal: 1.1 },
    { id: '9', value: '基准利率1.15倍', countVal: 1.15 },
    { id: '10', value: '基准利率1.2倍', countVal: 1.2 },
    { id: '11', value: '基准利率1.25倍', countVal: 1.25 },
    { id: '12', value: '基准利率1.3倍', countVal: 1.3 },
];
data_ll1 = [
    { id: '0', value: '基准利率7折', countVal: 0.7 },
    { id: '1', value: '基准利率75折', countVal: 0.75 },
    { id: '2', value: '基准利率8折', countVal: 0.8 },
    { id: '3', value: '基准利率85折', countVal: 0.85 },
    { id: '4', value: '基准利率9折', countVal: 0.9 },
    { id: '5', value: '基准利率95折', countVal: 0.95 },
    { id: '6', value: '基准利率（3.25%）', countVal: 1 },
    { id: '7', value: '基准利率1.05倍', countVal: 1.05 },
    { id: '8', value: '基准利率1.1倍', countVal: 1.1 },
    { id: '9', value: '基准利率1.15倍', countVal: 1.15 },
    { id: '10', value: '基准利率1.2倍', countVal: 1.2 },
    { id: '11', value: '基准利率1.25倍', countVal: 1.25 },
    { id: '12', value: '基准利率1.3倍', countVal: 1.3 },
];

function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
var hasArea = getUrlParam('area');
var hasPrice = getUrlParam('price');
if (hasArea !== null || hasPrice != null) {
    $('.fwzjBox').hide();
    $('.mjdjBox').hide();
    $('.countBtm li').removeClass('cur');
    $('.mjdjBox').show();
    $('.fwzjBox').hide();
    $($('.countBtm li')[1]).addClass('cur');
    $('#price_val1').val(hasPrice != null ? hasPrice : '');
    $('#area_val1').val(hasArea != null ? hasArea : '');
    $('#housePrice2').val(hasArea != null && hasPrice != null ? (Number(hasPrice) * Number(hasArea) / 10000).toFixed(2) : '');
    $('#loanAmount2').val(hasArea != null && hasPrice != null ? (Number(hasPrice) * Number(hasArea) / 10000 * 0.7).toFixed(2) : '');
}

var isLpr1 = 1;
var isLpr2 = 1;
var isLpr3 = 1;
function changeCounts(e, index) {
    $('.fwzjBox').hide();
    $('.mjdjBox').hide();
    $('.countBtm li').removeClass('cur');
    if (index == 1) {
        $('.mjdjBox').hide();
        $('.fwzjBox').show();
        $($('.countBtm li')[0]).addClass('cur');
    } else {
        $('.mjdjBox').show();
        $('.fwzjBox').hide();
        $($('.countBtm li')[1]).addClass('cur');
    }

}

function changeCounts1(e, index) {
    $('.fwzjBox1').hide();
    $('.mjdjBox1').hide();
    $('.countBtm1 li').removeClass('cur');
    if (index == 1) {
        $('.mjdjBox1').hide();
        $('.fwzjBox1').show();
        $($('.countBtm1 li')[0]).addClass('cur');
    } else {
        $('.mjdjBox1').show();
        $('.fwzjBox1').hide();
        $($('.countBtm1 li')[1]).addClass('cur');
    }

}

function changeBase(e, index) {
    $('.fwzjBox .baseBox').hide();
    $('.fwzjBox .sdBox').hide();
    $('.LprBtm li').removeClass('cur');
    if (index == 2) {
        $('.fwzjBox .baseBox').hide();
        $('.fwzjBox .sdBox').show();
        $($('.LprBtm li')[0]).addClass('cur');
        isLpr1 = 1;

    } else {
        $('.fwzjBox .baseBox').show();
        $('.fwzjBox .sdBox').hide();
        $($('.LprBtm li')[1]).addClass('cur');
        isLpr1 = 2;

    }
}
function changeBase1(e, index) {
    $('.mjdjBox .baseBox').hide();
    $('.mjdjBox .sdBox').hide();
    $('.LprBtm1 li').removeClass('cur');
    if (index == 2) {
        $('.mjdjBox .baseBox').hide();
        $('.mjdjBox .sdBox').show();
        $($('.LprBtm1 li')[0]).addClass('cur');
        isLpr2 = 1;
    } else {
        $('.mjdjBox .baseBox').show();
        $('.mjdjBox .sdBox').hide();
        $($('.LprBtm1 li')[1]).addClass('cur');
        isLpr2 = 2;
    }
}
function changeBase2(e, index) {
    $('.mBox1 .baseBox').hide();
    $('.mBox1 .sdBox').hide();
    $('.LprBtm2 li').removeClass('cur');
    if (index == 2) {
        $('.mBox1 .baseBox').hide();
        $('.mBox1 .sdBox').show();
        $($('.LprBtm2 li')[0]).addClass('cur');
        isLpr3 = 1;
    } else {
        $('.mBox1 .baseBox').show();
        $('.mBox1 .sdBox').hide();
        $($('.LprBtm2 li')[1]).addClass('cur');
        isLpr3 = 2;
    }
}


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
var base_rate, lpr_rate, fund_rate;
function getRate() {
    $.ajax({
        //请求方式
        type: 'get',
        //发送请求的地址
        url: loupan_service_root_uri + '/latest.php',
        // url: 'http://service.testing.loupan.com/calculator/v1/rate/latest',
        //服务器返回的数据类型
        dataType: 'json',
        async: false,
        //发送到服务器的数据，对象必须为key/value的格式，jquery会自动转换为字符串格式
        headers: { 'Accept': 'application/json' },
        data: {},
        success: function (data, textStatus, jqXHR) {
            //请求成功函数内容
            if (jqXHR.status == 200) {
                base_rate = data.base_rate;
                lpr_rate = data.lpr_rate;
                fund_rate = data.fund_rate;
                data_ll[6].value = '基准利率（' + base_rate + '%）';
                data_ll1[6].value = '基准利率（' + fund_rate + '%）';
                // params_type1.base_rate = base_rate;
                // params_type1.lpr_rate = lpr_rate;
                // params_type1.fund_rate = fund_rate;
                $('.lpr_val').val(lpr_rate);
                rateSelect('#val_sd1', data_ll);
                rateSelect('#val_sd2', data_ll);
                rateSelect('#val_sd3', data_ll1);
                rateSelect('#val_sd4', data_ll1);
                rateSelect('#val_sd6', data_ll);
                rateSelect('#val_sd5', data_ll1);
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
}
getRate();

function rateSelect(el, data) {
    var box = $(el),
        str = '';
    for (var i = 0; i < data.length; i++) {
        str += '<option ' + (i == 6 ? 'selected' : '') + ' value="' + data[i].countVal + '">' + data[i].value + '</option>'

    }
    box.html(str)
}



var val_cs1 = 0.7;
var val_cs2 = 0.7;
var val_cs3 = 0.7;
var val_cs4 = 0.7;
var val_nx1 = 20;
var val_nx2 = 20;
var val_nx3 = 20;
var val_nx4 = 20;
var val_nx5 = 20;
var val_ll = base_rate;
var val_ll1 = base_rate;
var val_ll2 = fund_rate;
var val_ll3 = fund_rate;
var val_ll4 = fund_rate;
var val_ll5 = base_rate;
$('#val_ll1').val(Number(lpr_rate) + Number($('#val_jd1').val()));
$('#val_ll2').val(Number(lpr_rate) + Number($('#val_jd2').val()));
$('#val_ll3').val(Number(lpr_rate) + Number($('#val_jd3').val()));
$('#sdlv').text(Number(val_ll) * 1);
$('#sdlv2').text(Number(val_ll1) * 1);
$('#sdlv3').text(Number(val_ll2) * 1);
$('#sdlv4').text(Number(val_ll3) * 1);
$('#sdlv5').text(Number(val_ll4) * 1);
$('#sdlv6').text(Number(val_ll5) * 1);
/**校验房屋总价*/
$('.input_fwzj').keyup(function () {
    var cs_lx = $(this).data('index');
    var that = this;
    var sum = null;
    $(this).val(ChangeNumValue($(this).val()));

    switch (cs_lx) {
        case 1:
            sum = arithmetic.loansSum($(that).val(), val_cs1);
            $('#loanAmount1').val(sum.toFixed(2));
            break;
        case 2:
            sum = arithmetic.loansSum($(that).val(), val_cs3);
            $('#loanAmount3').val(sum.toFixed(2))
            break;
    }
    if ($(this).hasClass('red_border') && $(that).val() != '') {
        $(this).removeClass('red_border');
    }
});

$('#percentage').on('change', function (e) {
    var el = $(e.currentTarget);
    var sum = null;
    sum = arithmetic.loansSum($('#housePrice1').val(), el.val());
    $('#loanAmount1').val(sum.toFixed(2))
    val_cs1 = el.val();
});

$('#percentage1').on('change', function (e) {
    var el = $(e.currentTarget);
    var sum = null;
    sum = arithmetic.loansSum($('#housePrice2').val(), el.val());
    $('#loanAmount2').val(sum.toFixed(2))
    val_cs2 = el.val();
});

$('#percentage2').on('change', function (e) {
    var el = $(e.currentTarget);
    var sum = null;
    sum = arithmetic.loansSum($('#housePrice3').val(), el.val());
    $('#loanAmount3').val(sum.toFixed(2))
    val_cs2 = el.val();
});
$('#percentage3').on('change', function (e) {
    var el = $(e.currentTarget);
    var sum = null;
    sum = arithmetic.loansSum($('#housePrice4').val(), el.val());
    $('#loanAmount4').val(sum.toFixed(2))
    val_cs2 = el.val();
});
$('#years').on('change', function (e) {
    var el = $(e.currentTarget);
    val_nx1 = el.val();
});

$('#years1').on('change', function (e) {
    var el = $(e.currentTarget);
    val_nx2 = el.val();
});

$('#years2').on('change', function (e) {
    var el = $(e.currentTarget);
    val_nx3 = el.val();
});
$('#years3').on('change', function (e) {
    var el = $(e.currentTarget);
    val_nx4 = el.val();
});
$('#years4').on('change', function (e) {
    var el = $(e.currentTarget);
    val_nx5 = el.val();
});
$('#val_sd1').on('change', function (e) {
    var el = $(e.currentTarget);
    val_ll = Number(el.val()) * base_rate;
    $('#sdlv').text(val_ll.toFixed(2));
});
$('#val_sd2').on('change', function (e) {
    var el = $(e.currentTarget);
    val_ll1 = Number(el.val()) * base_rate;
    $('#sdlv2').text(val_ll1.toFixed(2));
});
$('#val_sd3').on('change', function (e) {
    var el = $(e.currentTarget);
    val_ll2 = Number(el.val()) * fund_rate;
    $('#sdlv3').text(val_ll2.toFixed(2));
});
$('#val_sd4').on('change', function (e) {
    var el = $(e.currentTarget);
    val_ll3 = Number(el.val()) * fund_rate;
    $('#sdlv4').text(val_ll3.toFixed(2));
});
$('#val_sd5').on('change', function (e) {
    var el = $(e.currentTarget);
    val_ll4 = Number(el.val()) * fund_rate;
    $('#sdlv5').text(val_ll4.toFixed(2));
});
$('#val_sd6').on('change', function (e) {
    var el = $(e.currentTarget);
    val_ll5 = Number(el.val()) * base_rate;
    $('#sdlv6').text(val_ll5.toFixed(2));
});
function ChangeNumValue(tmpVal) {
    if (tmpVal) {
        var tmpVal = tmpVal.replace(/[^\d\.]/g, '');
        var reg = /^(0(\.\d{0,2})?|[1-9][0-9]{0,5}(\.\d{0,2})?)$/; //正则验证保留 最多允许后输入两位小数
        var val_pre = '', val_after = '';
        if (!reg.test(tmpVal)) {
            tmpVal = tmpVal + "";
            if (tmpVal[0] == 0) {
                tmpVal = tmpVal.replace(/\b(0+)/gi, "");
                if (tmpVal.substr(0, 1) == '.') { //如果有小数点'.'时,前面加一个0
                    tmpVal = 0 + tmpVal;
                }
            }
            if (tmpVal[0] == '.') {
                return "";
              }
            if (tmpVal.indexOf(".") > 0) {
                val_pre = tmpVal.split('.')[0];
                val_after = tmpVal.split('.')[1];
                tmpVal = val_pre.substring(0, 6) + '.' + val_after.substring(0, 2);
            } else {
                tmpVal = tmpVal.substring(0, 6);
            }
        }
        return tmpVal;
    } else {
        return "";
    }
}

function ChangeNumValue1(tmpVal) {
    if (tmpVal) {
        var tmpVal = tmpVal.replace(/[^\d\.]/g, '');
        var reg = /^(0(\.\d{0,2})?|[1-9][0-9]{0,7}(\.\d{0,2})?)$/; //正则验证保留 最多允许后输入两位小数
        var val_pre = '', val_after = '';
        if (!reg.test(tmpVal)) {
            tmpVal = tmpVal + "";
            if (tmpVal[0] == 0) {
                tmpVal = tmpVal.replace(/\b(0+)/gi, "");
                if (tmpVal.substr(0, 1) == '.') { //如果有小数点'.'时,前面加一个0
                    tmpVal = 0 + tmpVal;
                }
            }
            if (tmpVal[0] == '.') {
                return "";
              }
            if (tmpVal.indexOf(".") > 0) {
                val_pre = tmpVal.split('.')[0];
                val_after = tmpVal.split('.')[1];
                tmpVal = val_pre.substring(0, 8) + '.' + val_after.substring(0, 2);
            } else {
                tmpVal = tmpVal.substring(0, 8);
            }
        }
        return tmpVal;
    } else {
        return "";
    }
}

$('.regRule').keyup(function () {
    var cs_lx = $(this).data('index');
    var that = this;
    var sum = null;
    var sum1 = null;
    $(this).val(ChangeNumValue1($(this).val()));
    if (cs_lx == 1 || cs_lx == 2) {
        sum = arithmetic.houseSum($('#price_val1').val(), $('#area_val1').val());
        $('#housePrice2').val(sum.toFixed(2));
        sum1 = arithmetic.loansSum(sum, val_cs2);
        $('#loanAmount2').val(sum1.toFixed(2));
    } else if (cs_lx == 3 || cs_lx == 4) {
        sum = arithmetic.houseSum($('#price_val2').val(), $('#area_val2').val());
        $('#housePrice4').val(sum.toFixed(2));
        sum1 = arithmetic.loansSum(sum, val_cs4);
        $('#loanAmount4').val(sum1.toFixed(2));
    }
    if ($(this).hasClass('red_border') && $(that).val() != '') {
        $(this).removeClass('red_border');
    }
});


function ChangeNumValue2(tmpVal) {
    if (tmpVal) {
        var tmpVal = tmpVal.replace(/[^\d\.]/g, '');
        var reg = /^(\d+\.\d{1,3}|\d+)$/;
        var val_pre = '', val_after = '';
        if (!reg.test(tmpVal)) {
            tmpVal = tmpVal + "";
            if (tmpVal[0] == 0) {
                tmpVal = tmpVal.replace(/\b(0+)/gi, "");
                if (tmpVal.substr(0, 1) == '.') { //如果有小数点'.'时,前面加一个0
                    tmpVal = 0 + tmpVal;
                }
            }
            if (tmpVal[0] == '.') {
                return "";
              }
            if (tmpVal.indexOf(".") > 0) {
                val_pre = tmpVal.split('.')[0];
                val_after = tmpVal.split('.')[1];
                tmpVal = val_pre.substring(0, 8) + '.' + val_after.substring(0, 3);
            } else {
                tmpVal = tmpVal.substring(0, 8);
            }
        }
        return tmpVal;
    } else {
        return "";
    }
}

$('.lrp').keyup(function () {
    var cs_lx = $(this).data('index');
    var that = this;
    var sum = null;
    var sum1 = null;
    $(this).val(ChangeNumValue2($(this).val()));
    if (cs_lx == 1) {
        sum = arithmetic.lprSum($('#lrp1').val(), $('#val_jd1').val());
        $('#val_ll1').val(sum.toFixed(2));
    } else if (cs_lx == 2) {
        sum = arithmetic.lprSum($('#lrp2').val(), $('#val_jd2').val());
        $('#val_ll2').val(sum.toFixed(2));
    } else if (cs_lx == 3) {
        sum = arithmetic.lprSum($('#lrp3').val(), $('#val_jd3').val());
        $('#val_ll3').val(sum.toFixed(2));
    }
    if ($(this).hasClass('red_border') && $(that).val() != '') {
        $(this).removeClass('red_border');
    }
});

/**计算按钮 */
$('#count1').on('click', function () {
    if ($('#housePrice1').val() == '' || $('#housePrice1').val() == undefined) {
        tg_tips('请输入房屋总价！', '');
        $('#housePrice1').addClass('red_border');
        return false
    }
    if (isLpr1 == 2 && $('#lrp1').val() == '' || $('#lrp1').val() == undefined) {
        tg_tips('请输入LPR！', '');
        $('#lrp1').addClass('red_border');
        return false
    }
    if (isLpr1 == 2 && $('#val_jd1').val() == '' || $('#val_jd1').val() == undefined) {
        tg_tips('请输入基点！', '');
        $('#val_jd1').addClass('red_border');
        return false
    }
    var APR = 0,
        houseTotal = 0,
        loanAmount = 0,
        allPhase = 0,
        permil = 0,
        average = 0,
        averageArr = [];
    houseTotal = Number($('#housePrice1').val()) * 10000;
    loanAmount = houseTotal * Number($('#percentage').val());
    allPhase = Number($('#years').val()) * 12;
    APR = Number(base_rate) * Number($('#val_sd1').val());
    $('#calc1 .fr .ll_box').html('<span class="syll">商业贷款利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    if (isLpr1 == 2) {
        APR = Number($('#lrp1').val()) + Number($('#val_jd1').val()) / 100;
        $('#calc1 .fr .ll_box').html('<span class="syll">LPR贷款利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    }
    permil = APR / 12 / 100;
    average = arithmetic.average(loanAmount, permil, allPhase);
    averageArr = arithmetic.averageArr(loanAmount, permil, allPhase);
    $('#calc1 .nodata1').hide();
    $('#calc1 .dataBox').show();
    $('#sf').text(((houseTotal - loanAmount) / 10000).toFixed(2));
    // $('#sydkll').text(base_rate);
    // $('#gjjdkll').text(fund_rate);
    $('#fqhk').text(average.toFixed(2));
    $('#zfll').text(((average * allPhase - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze').text(((average * allPhase) / 10000).toFixed(2) + '万');
    $('#sf1').text(averageArr[0].toFixed(2) + '元');
    $('#dj').text('(* 每期递减' + (averageArr[0] - averageArr[1]).toFixed(2) + '元)');

    var sum = 0;
    for (var i = 0; i < averageArr.length; i++) {
        sum += averageArr[i];
    }

    $('#zfll1').text(((sum - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze1').text(((sum) / 10000).toFixed(2) + '万');
    var fq_str = '';
    for (var i = 0; i < averageArr.length; i++) {
        fq_str += '<div class="item clearPad"><div>第' + (i + 1) + '期还款</div><div>' + averageArr[i].toFixed(2) + '元</div></div>'
    }
    $('#fqBox1').html(fq_str);

});

$('#count2').on('click', function () {
    if ($('#price_val1').val() == '' || $('#price_val1').val() == undefined) {
        tg_tips('请输入单价!', '');
        $('#price_val1').addClass('red_border');
        return false
    }
    if ($('#area_val1').val() == '' || $('#area_val1').val() == undefined) {
        tg_tips('请输入房屋建面!', '');
        $('#area_val1').addClass('red_border');
        return false
    }
    if (isLpr2 == 2 && $('#lrp2').val() == '' || $('#lrp2').val() == undefined) {
        tg_tips('请输入LPR！', '');
        $('#lrp2').addClass('red_border');
        return false
    }
    var APR = 0,
        houseTotal = 0,
        loanAmount = 0,
        allPhase = 0,
        permil = 0,
        average = 0,
        averageArr = [];
    houseTotal = Number($('#price_val1').val()) * Number($('#area_val1').val());
    loanAmount = houseTotal * Number($('#percentage1').val());
    allPhase = Number($('#years1').val()) * 12;
    APR = Number(base_rate) * Number($('#val_sd2').val());
    $('#calc1 .fr .ll_box').html('<span class="syll">商业贷款利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    if (isLpr2 == 2) {
        APR = Number($('#lrp2').val()) + Number($('#val_jd2').val()) / 100;
        $('#calc1 .fr .ll_box').html('<span class="syll">LPR贷款利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    }
    permil = APR / 12 / 100;
    average = arithmetic.average(loanAmount, permil, allPhase);
    averageArr = arithmetic.averageArr(loanAmount, permil, allPhase);
    $('#calc1 .nodata1').hide();
    $('#calc1 .dataBox').show();
    $('#sf').text(((houseTotal - loanAmount) / 10000).toFixed(2));
    // $('#sydkll').text(base_rate);
    // $('#gjjdkll').text(fund_rate);
    $('#fqhk').text(average.toFixed(2));
    $('#zfll').text(((average * allPhase - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze').text(((average * allPhase) / 10000).toFixed(2) + '万');
    $('#sf1').text(averageArr[0].toFixed(2) + '元');
    $('#dj').text('(* 每期递减' + (averageArr[0] - averageArr[1]).toFixed(2) + '元)');

    var sum = 0;
    for (var i = 0; i < averageArr.length; i++) {
        sum += averageArr[i];
    }

    $('#zfll1').text(((sum - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze1').text(((sum) / 10000).toFixed(2) + '万');
    var fq_str = '';
    for (var i = 0; i < averageArr.length; i++) {
        fq_str += '<div class="item clearPad"><div>第' + (i + 1) + '期还款</div><div>' + averageArr[i].toFixed(2) + '元</div></div>'
    }
    $('#fqBox1').html(fq_str);

});


$('#count3').on('click', function () {
    if ($('#housePrice3').val() == '' || $('#housePrice3').val() == undefined) {
        tg_tips('请输入房屋总价！', '');
        $('#housePrice3').addClass('red_border');
        return false
    }
    var APR = 0,
        houseTotal = 0,
        loanAmount = 0,
        allPhase = 0,
        permil = 0,
        average = 0,
        averageArr = [];
    houseTotal = Number($('#housePrice3').val()) * 10000;
    loanAmount = houseTotal * Number($('#percentage2').val());
    allPhase = Number($('#years2').val()) * 12;
    APR = Number(fund_rate) * Number($('#val_sd3').val());
    permil = APR / 12 / 100;
    average = arithmetic.average(loanAmount, permil, allPhase);
    averageArr = arithmetic.averageArr(loanAmount, permil, allPhase);
    $('#calc2 .fr .ll_box').html('<span class="syll">公积金利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    $('#calc2 .nodata1').hide();
    $('#calc2 .dataBox').show();
    $('#sf2').text(((houseTotal - loanAmount) / 10000).toFixed(2));
    // $('#sydkll1').text(base_rate);
    // $('#gjjdkll1').text(fund_rate);
    $('#fqhk1').text(average.toFixed(2));
    $('#zfll2').text(((average * allPhase - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze2').text(((average * allPhase) / 10000).toFixed(2) + '万');
    $('#sf3').text(averageArr[0].toFixed(2) + '元');
    $('#dj1').text('(* 每期递减' + (averageArr[0].toFixed(2) - averageArr[1]).toFixed(2) + '元)');

    var sum = 0;
    for (var i = 0; i < averageArr.length; i++) {
        sum += averageArr[i];
    }

    $('#zfll3').text(((sum - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze3').text(((sum) / 10000).toFixed(2) + '万');
    var fq_str = '';
    for (var i = 0; i < averageArr.length; i++) {
        fq_str += '<div class="item clearPad"><div>第' + (i + 1) + '期还款</div><div>' + averageArr[i].toFixed(2) + '元</div></div>'
    }
    $('#fqBox2').html(fq_str);

});


$('#count4').on('click', function () {
    if ($('#price_val2').val() == '' || $('#price_val2').val() == undefined) {
        tg_tips('请输入单价!', '');
        $('#price_val2').addClass('red_border');
        return false
    }
    if ($('#area_val2').val() == '' || $('#area_val2').val() == undefined) {
        tg_tips('请输入房屋建面!', '');
        $('#area_val2').addClass('red_border');
        return false
    }
    var APR = 0,
        houseTotal = 0,
        loanAmount = 0,
        allPhase = 0,
        permil = 0,
        average = 0,
        houseTotal1 = 0,
        loanAmount1 = 0,
        permil1 = 0,
        averageArr1 = [],
        averageArr = [];
    houseTotal = Number($('#price_val2').val()) * Number($('#area_val2').val());
    loanAmount = houseTotal * Number($('#percentage3').val());
    allPhase = Number($('#years3').val()) * 12;
    APR = Number(fund_rate) * Number($('#val_sd4').val());
    $('#calc2 .fr .ll_box').html('<span class="syll">公积金利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    permil = APR / 12 / 100;
    average = arithmetic.average(loanAmount, permil, allPhase);
    averageArr = arithmetic.averageArr(loanAmount, permil, allPhase);
    $('#calc2 .nodata1').hide();
    $('#calc2 .dataBox').show();
    $('#sf2').text(((houseTotal - loanAmount) / 10000).toFixed(2));
    // $('#sydkll1').text(base_rate);
    // $('#gjjdkll1').text(fund_rate);
    $('#fqhk1').text(average.toFixed(2));
    $('#zfll2').text(((average * allPhase - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze2').text(((average * allPhase) / 10000).toFixed(2) + '万');
    $('#sf3').text(averageArr[0].toFixed(2) + '元');
    $('#dj1').text('(* 每期递减' + (averageArr[0] - averageArr[1]).toFixed(2) + '元)');

    var sum = 0;
    for (var i = 0; i < averageArr.length; i++) {
        sum += averageArr[i];
    }

    $('#zfll3').text(((sum - loanAmount) / 10000).toFixed(2) + '万');
    $('#hkze3').text(((sum) / 10000).toFixed(2) + '万');
    var fq_str = '';
    for (var i = 0; i < averageArr.length; i++) {
        fq_str += '<div class="item clearPad"><div>第' + (i + 1) + '期还款</div><div>' + averageArr[i].toFixed(2) + '元</div></div>'
    }
    $('#fqBox2').html(fq_str);

});


$('#count5').on('click', function () {
    if ($('#loanAmount5').val() == '' || $('#loanAmount5').val() == undefined) {
        tg_tips('公积金贷款金额!', '');
        $('#loanAmount5').addClass('red_border');
        return false
    }
    if ($('#loanAmount6').val() == '' || $('#loanAmount6').val() == undefined) {
        tg_tips('请输入商业贷款金额!', '');
        $('#loanAmount6').addClass('red_border');
        return false
    }
    if (isLpr3 == 2 && $('#lrp3').val() == '' || $('#lrp3').val() == undefined) {
        tg_tips('请输入LPR！', '');
        $('#lrp3').addClass('red_border');
        return false
    }
    houseTotal = Number($('#loanAmount5').val()) * 10000;
    loanAmount = houseTotal;
    houseTotal1 = Number($('#loanAmount6').val()) * 10000;
    loanAmount1 = houseTotal1;
    allPhase = Number($('#years4').val()) * 12;
    APR = Number(fund_rate) * Number($('#val_sd5').val());
    APR1 = Number(base_rate) * Number($('#val_sd6').val())
    $('#calc3 .fr .ll_box').html('<span class="syll">商贷基准利率：<span id="sydkll">'+APR1.toFixed(2)+'</span> %</span>'+'<span class="syll">公积金利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    if (isLpr3 == 2) {
        APR1 = Number($('#lrp3').val()) + Number($('#val_jd3').val()) / 100;
        $('#calc3 .fr .ll_box').html('<span class="syll">LPR基准利率：<span id="sydkll">'+APR1.toFixed(2)+'</span> %</span>'+'<span class="syll">公积金利率：<span id="sydkll">'+APR.toFixed(2)+'</span> %</span>');
    }
    permil = APR / 12 / 100;
    permil1 = APR1 / 12 / 100;
    average = arithmetic.average(loanAmount, permil, allPhase) + arithmetic.average(loanAmount1, permil1, allPhase);
    averageArr = arithmetic.averageArr(loanAmount, permil, allPhase);
    averageArr1 = arithmetic.averageArr(loanAmount1, permil1, allPhase);
    var newArr = [];
    for (var i = 0; i < averageArr1.length; i++) {
        newArr.push(averageArr1[i] + averageArr[i]);
    }
    averageArr = newArr;
    $('#calc3 .nodata1').hide();
    $('#calc3 .dataBox').show();
    // $('#sydkll2').text(base_rate);
    // $('#gjjdkll2').text(fund_rate);
    $('#fqhk2').text(average.toFixed(2));
    $('#zfll4').text(((average * allPhase - (loanAmount+loanAmount1)) / 10000).toFixed(2) + '万');
    $('#hkze4').text(((average * allPhase) / 10000).toFixed(2) + '万');
    $('#dj2').text('(* 每期递减' + (averageArr[0].toFixed(2) - averageArr[1]).toFixed(2) + '元)');

    var sum = 0;
    for (var i = 0; i < averageArr.length; i++) {
        sum += averageArr[i];
    }
    $('#sf5').text(averageArr[0].toFixed(2) + '元');
    
    $('#zfll5').text(((sum - (loanAmount+loanAmount1)) / 10000).toFixed(2) + '万');
    $('#hkze5').text(((sum) / 10000).toFixed(2) + '万');
    var fq_str = '';
    for (var i = 0; i < averageArr.length; i++) {
        fq_str += '<div class="item clearPad"><div>第' + (i + 1) + '期还款</div><div>' + averageArr[i].toFixed(2) + '元</div></div>'
    }
    $('#fqBox3').html(fq_str);

});

$('#reset1').on('click', function () {
    $('#housePrice1').val('');
    $('#percentage').val(0.7);
    $('#years').val(20);
    $('#loanAmount1').val('');
    $('#val_sd1').val(1);
    $('#sdlv').text(Number(base_rate) * 1);
    $('#val_jd1').val(0);
    $('#val_ll1').val(Number(lpr_rate) + Number($('#val_jd1').val()));
    $('#calc1 .nodata1').show();
    $('#calc1 .dataBox').hide();
    $('#lrp1').val(lpr_rate);
})


$('#reset2').on('click', function () {
    $('#price_val1').val('');
    $('#area_val1').val('');
    $('#housePrice2').val('');
    $('#percentage1').val(0.7);
    $('#years1').val(20);
    $('#loanAmount2').val('');
    $('#val_sd2').val(1);
    $('#sdlv2').text(Number(base_rate) * 1);
    $('#val_jd2').val(0);
    $('#val_ll2').val(Number(lpr_rate) + Number($('#val_jd1').val()));
    $('#calc1 .nodata1').show();
    $('#calc1 .dataBox').hide();
    $('#lrp2').val(lpr_rate);
})

$('#reset3').on('click', function () {
    $('#housePrice3').val('');
    $('#percentage2').val(0.7);
    $('#years2').val(20);
    $('#loanAmount3').val('');
    $('#val_sd3').val(1);
    $('#sdlv3').text(Number(fund_rate) * 1);
    $('#calc2 .nodata1').show();
    $('#calc2 .dataBox').hide();
})

$('#reset4').on('click', function () {
    $('#price_val2').val('');
    $('#area_val2').val('');
    $('#housePrice4').val('');
    $('#percentage3').val(0.7);
    $('#years3').val(20);
    $('#loanAmount4').val('');
    $('#val_sd4').val(1);
    $('#sdlv4').text(Number(fund_rate) * 1);
    $('#calc2 .nodata1').show();
    $('#calc2 .dataBox').hide();
})

$('#reset5').on('click', function () {
    $('#loanAmount5').val('');
    $('#loanAmount6').val('');
    $('#years4').val(20);
    $('#val_sd5').val(1);
    $('#sdlv5').text(Number(fund_rate) * 1);
    $('#val_sd6').val(1);
    $('#sdlv6').text(Number(base_rate) * 1);
    $('#val_jd3').val(0);
    $('#val_ll3').val(Number(lpr_rate) + Number($('#val_jd1').val()));
    $('#calc3 .nodata1').show();
    $('#calc3 .dataBox').hide();
    $('#lrp3').val(lpr_rate);
})



