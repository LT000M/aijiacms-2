function sf(obj){
    if(obj.dj3.value=="" || !reg_Num(obj.dj3.value)){
        alert("请填写单价");
        return false;
    }
    if(obj.mj3.value=="" || !reg_Num(obj.mj3.value)){
        alert("请填写建面");
        return false;
    }
    dj3=parseFloat(obj.dj3.value)
    mj3=parseFloat(obj.mj3.value)
    fkz3=dj3*mj3
    yh=fkz3*0.0005
    if (dj3<=9432) q=fkz3*0.015
    else if (dj3>9432) q=fkz3*0.03
    if (mj3<=90)  q=fkz3*0.01
    if (mj3<=120)  fw=500;
    else if (120<mj3<=5000) fw=1500;
    if (mj3>5000)  fw=5000
    gzh=fkz3*0.003
    obj.yh.value=Math.round(yh*100,5)/100
    obj.fkz3.value=Math.round(fkz3*100,5)/100
    obj.q.value=Math.round(q*100,5)/100
    obj.gzh.value=Math.round(gzh*100,5)/100
    obj.wt.value=Math.round(gzh*100,5)/100
    obj.fw.value=Math.round(fw*100,5)/100
}
function is_NUM(o){
  if(isNaN(o.value)){
      alert('本域只能输入数值！'); 
      o.value = '';
  }
}

function chk02()
{
    if (parseFloat(document.getElementById('pg_gfzc').value) > parseFloat(document.getElementById('pg_ysr').value)*0.7)
	{
	    alert("您预计家庭每月可用于购房支出已超过预期家庭月收入的70%，"+"\n\n"+"是否确定不会影响您的正常生活消费？"+"\n\n"+"建议在40%（"+parseFloat(document.getElementById('pg_ysr').value)*0.4+"元）左右")
	}
}

function chk_nlpg()
{
	if (document.getElementById('pg_gfzj').value==""){
        alert("请填写现可用于购房的资金"); 
        return false;
    }else if (document.getElementById('pg_ysr').value==""){
        alert("请填写现家庭月收入"); 
        return false;
    }else if (document.getElementById('pg_gfzc').value==""){
        alert("请填写购房支出"); 
        return false;
    }else if (document.getElementById('pg_fwmj').value==""){
        alert("请填写您计划购买房屋的建面"); 
        return false;
    }else if ((parseFloat(document.getElementById('pg_gfzj').value))<4.7){
	    alert("--您确定是"+parseFloat(document.getElementById('pg_gfzj').value)+"万元?--"+"\n\n"+"那么您目前尚不具备购房能力，"+"\n\n"+"建议积攒积蓄或能筹集更多的资金。");
        return false;
	}else if((parseFloat(document.getElementById('pg_gfzj').value))>10000) {
        alert("您确定拥有超过一亿元的购房资金？"); 
        return false; 
    }else {
        return true;
    }
}


function gfnlpg(){
    if(!chk_nlpg()) return false;
    $('.dataBox').show();
    $('.nodata2').hide();
    var cal_1 = document.getElementById('pg_gfzj').value;
    var cal_3 = document.getElementById('pg_ysr').value;
    var cal_5 = document.getElementById('pg_gfzc').value;
    var cal_6 = document.getElementById('pg_dknx').value;
    var cal_7 = document.getElementById('pg_fwmj').value;

    var rhb =  Array(440.104,301.103,231.7,190.136,163.753,144.08,129.379,117.991,108.923,101.542,95.425,90.282,85.902,82.133,78.861,75.997,73.473,71.236,69.241,67.455,65.848,64.397,63.082,61.887,60.798,59.802,58.890,58.052,57.282);

    var yhz = Array(1.978,2.9344,3.8699,4.7847,5.6794,6.5544,7.4102,8.2472,9.0657,9.8662,10.6491,11.4148,12.1636,12.8959,13.6121,14.3126,14.9977,15.6677,16.3229,16.9637,17.5904,18.2034,18.8028,19.389,19.9624,20.5231,21.0715,21.6078,22.1323);

    var js00 = cal_1*10000;
    var js01 = cal_5;
    var js02 = Math.round(js01/rhb[cal_6/12-2])*10000;
    var js03 = cal_7;

    if(js02>js00*3.2) js02 = js00*3.2;
    var rs_1 = Math.round((js02+0.8*js00)*100)/100;
    var rs_2 = Math.round(rs_1/js03*100)/100;
    if(js03<120) var rs_3 = Math.round(rs_1*2)/100;
    else var rs_3 = Math.round((rs_1-rs_2*120)*4 + rs_2*120*2)/100;//契税
    var rs_4 = Math.round(rs_1*2)/100;//维修基金
    //var rs_5 = Math.round(rs_1*20)/100;//首付款
    var rs_6 = Math.round(rs_1*0.05/100*yhz[cal_6/12-2]*100)/100;//保险费
    var rs_7 = Math.round(rs_1*0.3)/100;//律师费
    var rs_8 = "200~500";//抵押登记费

    document.getElementById('rs_fwzj').value = rs_1;
    document.getElementById('rs_fwdj').value = rs_2;
    document.getElementById('rs_qs').value = rs_3;
    document.getElementById('rs_ggwxjj').value = rs_4;
    document.getElementById('rs_bxf').value = rs_6;
    document.getElementById('rs_lsf').value = rs_7;
    document.getElementById('rs_dydjf').value = rs_8;
    //document.getElementById('rs_8').value = rs_8;
}
(function($){
    var $obj = $('.hxjs').find('dd')
    $obj.eq(1).height($obj.eq(0).height());  
})(jQuery);


