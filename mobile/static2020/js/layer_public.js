
//基于layer的

function showBox(boxWidth, bocHeight, urlstr) {
    boxWidth = boxWidth || "90%";
    bocHeight = bocHeight || "90%";
    parent.layer.open({
        type: 2,
        area: [boxWidth, bocHeight],
        fix: false, //不固定
        maxmin: true,
        content: urlstr
    });

}
function showThisBox(boxWidth, bocHeight,titleStr, urlstr) {
    boxWidth = boxWidth || "90%";
    bocHeight = bocHeight || "90%";
    titleStr = titleStr || "弹出窗";
    layer.open({
        type: 2,
        title: titleStr,
        area: [boxWidth, bocHeight],
        fix: false, //不固定
        maxmin: true,
        content: urlstr
    });

}
function showDiv(divid) {
    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        area: '400px',
        skin: 'layui-layer-nobg', //没有背景色
        shadeClose: true,
        content: $('#' + divid)
    });
}

function showMsg(msg, flag) {
    //0感叹号 1打勾 2打x 3问号 4锁 5不开心 6笑脸 16加载 
    if (parseInt(flag) >= 0) {
        layer.msg(msg, { icon: flag });
    } else {
        layer.msg(msg);
    }
}
function alertMsg(msg, flag) {
    if (parseInt(flag) >= 0) {
        layer.alert(msg, { icon: flag });
    } else {
        layer.alert(msg);
    }
}

function hideAllBox() {
    parent.layer.closeAll();
    layer.closeAll();
}
function hideThisBox() {
    layer.closeAll();
}

function checkData(type, $obj, msgStr) {
    if (type === "phone") {
        //手机号
        var reg = /^1(2|3|4|5|6|8|7|9)\d{9}$/;
        if ($obj.val() === "" || $obj.val() === msgStr) {
            alert_Box("手机号不能为空", 0);
            return false;
        } else {
            if (!reg.test($obj.val())) {
                alert_Box(msgStr, 2);
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "name") {
        //姓名
        var reg = /^[\u4e00-\u9fa5]{2,4}$/;
        if ($obj.val() === "" || $obj.val() === msgStr) {
            alert_Box("姓名不能为空", 0);
            return false;
        } else {
            if (!reg.test($obj.val())) {
                alert_Box(msgStr, 2);
                return false;
            } else {
                return true;
            }
        }
    }
    else if (type === "number") {
        //数字
        var reg = /^[\d.]+$/;
        if ($obj.val() === "" || $obj.val() === msgStr) {
            alert_Box("不能为空", 0);
            return false;
        } else {
            if (!reg.test($obj.val())) {
                alert_Box(msgStr, 2);
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "pagesize") {
        //pagesize
        var reg = /^\d{1,2}$/;
        if ($obj.val() === "" || $obj.val() === msgStr) {
            alert_Box("请输入小于100的正整数", 0);
            return false;
        } else {
            if (!reg.test($obj.val())) {
                alert_Box(msgStr, 2);
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "pwd") {
        //密码
        if ($obj.val().length < 4 || $obj.val().length > 16) {
            alert_Box("请正确输入4-16位密码！", 0);
            return false;
        } else {
            return true;
        }
    } else if (type === "pwdor") {
        //密码 可空
        if ($obj.val() === "" || $obj.val() === msgStr) {
            return true;
        } else {
            if ($obj.val().length < 4 || $obj.val().length > 16) {
                alert_Box("密码不修改则不需要填写，密码格式：4-16位任意字符！", 0);
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "email") {
        //邮箱
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if ($obj.val().length < 4 || $obj.val().length > 16) {
            alert_Box("邮箱不能为空", 0);
            return false;
        } else {
            if (!reg.test($obj.val())) {
                alert_Box(msgStr, 2);
                return false;
            } else {
                return true;
            }
        }
    } else if (type == "fd") {
        //浮点  两位小数点
        var reg = /^\d+(\.\d{1,2})?$/;
        if (!reg.test($obj.val())) {
            alert_Box(msgStr, 2);
            return false;
        } else {
            return true;
        }
    }
    else {
        //非空
        if ($obj.val() == "" || $obj.val() == msgStr) {
            alert_Box(msgStr, 2);
            return false;
        }
        else {
            return true;
        }
    }
}

//check 没有弹窗提示
function checkInput(type, $obj) {
    if (type === "phone") {
        //手机号
        var reg = /^1(2|3|4|5|6|8|7|9)\d{9}$/;
        if ($obj.val() === "") {
            return false;
        } else {
            if (!reg.test($obj.val())) {
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "name") {
        //姓名
        var reg = /^[\u4e00-\u9fa5]{2,4}$/;
        if ($obj.val() === "") {
            return false;
        } else {
            if (!reg.test($obj.val())) {
                return false;
            } else {
                return true;
            }
        }
    }
    else if (type === "number") {
        //数字
        var reg = /^[\d.]+$/;
        if ($obj.val() === "") {
            return false;
        } else {
            if (!reg.test($obj.val())) {
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "pagesize") {
        //pagesize
        var reg = /^\d{1,2}$/;
        if ($obj.val() === "") {
            return false;
        } else {
            if (!reg.test($obj.val())) {
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "pwd") {
        //密码
        if ($obj.val().length < 4 || $obj.val().length > 16) {
            return false;
        } else {
            return true;
        }
    } else if (type === "pwdor") {
        //密码 可空
        if ($obj.val() === "") {
            return true;
        } else {
            if ($obj.val().length < 4 || $obj.val().length > 16) {
                return false;
            } else {
                return true;
            }
        }
    } else if (type === "email") {
        //邮箱
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if ($obj.val().length < 4 || $obj.val().length > 16) {
            return false;
        } else {
            if (!reg.test($obj.val())) {
                return false;
            } else {
                return true;
            }
        }
    } else if (type == "fd") {
        //浮点  两位小数点
        var reg = /^\d+(\.\d{1,2})?$/;
        if (!reg.test($obj.val())) {
            return false;
        } else {
            return true;
        }
    }
    else if (type == "d") {
        //（正整数 + 0）
        var reg = /^\d+?$/;
        if (!reg.test($obj.val())) {
            return false;
        } else {
            return true;
        }
    }
    else {
        //非空
        if ($obj.val() == "") {
            return false;
        }
        else {
            return true;
        }
    }
}

//不允许点遮罩关闭
function alert_Box(msg, flag) {
    layer.open({
        content: msg,
        title: false,
        btn: '我知道了',
        closeBtn: 0,
        icon: flag,
        shadeClose: false
    });
}

function reloadBox(msg, flag) {
    layer.open({
        content: msg, btn: '我知道了', shadeClose: false, icon: flag, title: false, closeBtn: 0, yes: function (index) {
            location.reload();
            layer.close(index);
        }
    });
}

function showPopBox(urlstr, title, area) {
    layer.open({ type: 2, shade: 0.5, closeBtn: 1, title: title, shadeClose: true, area: area || ['90%', '90%'], content: urlstr });
}

//点确定后跳到指定页
function MsgBoxToLink(msg, flag, url,btnTxt) {
    layer.open({
        content: msg
        , btn: btnTxt||'确定'
        , shadeClose: false
        , title: false
        , closeBtn: 0
        ,icon: flag
        , yes: function (index) {
            layer.close(index);
            location.href = url;
        }
    });
}