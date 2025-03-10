function most(a,b,c){
 var result=a;
 if(b>result)result=b;
 if(c>result)result=c;
 return result;
}

function interest(){  
 //等额本息法
 //月还款总额
 var loan_a=0;
 var loan_b=0;
 var loan_c=0;
 var year1;      //按揭年数
 var year2;      //公积金贷款年数
 var year3;      //消费贷款年数
 var rate_a=0;          //按揭利息
 var rate_b=0;          //公积金利息
 var rate_c=0;          //消费贷款利息
 var month1=0;
 var monthpay1=0;
 var month2=0;
 var monthpay2=0;
 var month3=0;
 var monthpay3=0;
 var cumulativePrincipal=0;//累积归还本金
 var cumulativeInterest=0;//累积偿付利息
 var cumulativeMonthpay=0;//累积本息总付款额
 var firstMonthpay=0;//月均还款

 var loantotal=form1.loana.value*10000+form1.loanb.value*10000+form1.loanc.value*10000;
 
 if(form1.loana.value!=0&&form1.year1.value!=''){
  loan_a=form1.loana.value*10000;
  year1=form1.year1.value;      //按揭年数
  rate_a=form1.rate2a.value/12;
  month1=year1*12;
  monthpay1=Math.round((loan_a*rate_a/100)*Math.pow((1+rate_a/100),month1)/(Math.pow((1+rate_a/100),month1)-1)*100)/100;
 }
 
 var month=most(month1,month2,month3);
 var monthpay=0;
 var returntotal=monthpay1*month1+monthpay2*month2+monthpay3*month3;
 document.all.returntotal.innerText=changeTwoDecimal(returntotal/10000);
 document.all.interesttotal.innerText=changeTwoDecimal((returntotal-loantotal)/10000);
 document.all.loantotal.innerText=changeTwoDecimal(loantotal/10000);
 
 var interest=0;  //当月归还利息
 var principal=0; //当月归还本金
 var payday=new Date(form1.year.value,form1.month.value);
 var bgcolor='';
 //var str='<table border="0" cellpadding="0" cellspacing="1" class="blackfont">';
 var str='';
 for(i=1;i<=month;i++){
  monthpay=0;
  interest=0;
  principal=0;

  //按揭贷款
  if(form1.loana.value!=0&&form1.year1.value!=''&&i<=month1){
   interest+=loan_a*rate_a;
   monthpay+=monthpay1;
   principal+=monthpay1-loan_a*rate_a/100;
   loan_a=Math.round(loan_a*(100+rate_a)-monthpay1*100)/100;
  }
  else{
   loan_a=0;
  }
  
  

  interest=Math.round(interest)/100;
  principal=Math.round(principal*100)/100;
  cumulativePrincipal+=principal;//累积归还本金
  cumulativeInterest+=interest;//累积偿付利息
  cumulativeMonthpay+=monthpay;//累积本息总付款额
  
  if(i === 1){
	 firstMonthpay = FormatCur(monthpay);
  }
  payday.setMonth(payday.getMonth()+1);//放贷日
  loantotal=loan_a+loan_b+loan_c;//贷款总额
 }//end for
 
 window.document.all.i_firstMonthpay.innerHTML=firstMonthpay;
 window.document.all.i_year.innerHTML=year1;
 
}
function FormatCur(x){
    var s_x =Math.round(x);
	s_x = '&yen;' + s_x.toString();
    return s_x;
}

function principal(){
 //等额本金法
 //月还款总额
 var loan_a=0;
 var loan_b=0;
 var loan_c=0;
 var year1;      //按揭年数
 var year2;      //公积金贷款年数
 var year3;      //消费贷款年数
 var rate_a=0;          //按揭利息
 var rate_b=0;          //公积金利息
 var rate_c=0;          //消费贷款利息
 var month1=0;
 var monthpay1=0;
 var month2=0;
 var monthpay2=0;
 var month3=0;
 var monthpay3=0;
 var principala;
 var principalb;
 var principalc;
 var cumulativePrincipal=0;//累积归还本金
 var cumulativeInterest=0;//累积偿付利息
 var cumulativeMonthpay=0;//累积本息总付款额
 var firstMonthpay =0;

 var loantotal=form1.loana.value*10000+form1.loanb.value*10000+form1.loanc.value*10000;
 
 if(form1.loana.value!=0&&form1.year1.value!=''){
  loan_a=form1.loana.value*10000;
  year1=form1.year1.value;      //按揭年数
 
  rate_a=form1.rate2a.value/12; 
  month1=year1*12;
  principala=Math.round(loan_a/month1*100)/100; //当月归还本金
 }

 
 var month=most(month1,month2,month3);
 
 var principal=0;
 var restloan=loantotal;
 var resta=loan_a;
 var restb=loan_b;
 var restc=loan_c;
 var interest=0;  //当月归还利息
 var payday=new Date(form1.year.value,form1.month.value);
 var bgcolor='';
 var monthpay=0;
 var returntotal=0;
 var str='';
 var dijian = 0;//每月递减金额

 for(i=1;i<=month;i++){
  interest=0;
  principal=0;
  if(form1.loana.value!=0&&form1.year1.value!=''&&i<=month1){
   interest+=resta*rate_a
   principal+=principala;
   resta=Math.round(resta*100-principala*100)/100;
  }
  
  interest=Math.round(interest)/100;
  
  monthpay=principal+interest;
  returntotal=returntotal+monthpay;
  cumulativePrincipal+=principal;//累积归还本金
  cumulativeInterest+=interest;//累积偿付利息
  cumulativeMonthpay+=monthpay;//累积本息总付款额
  
  if(i===1){
	 firstMonthpay =  FormatCur(monthpay);
  }
  if(i===month){
	dijian = interest;
  }
  
  
  
  payday.setMonth(payday.getMonth()+1);//放贷日
  restloan=restloan-principal;//剩余贷款
 }//end for

 document.all.loantotal2.innerText=changeTwoDecimal(loantotal/10000);
 document.all.returntotal2.innerText=changeTwoDecimal(returntotal/10000);
 document.all.interesttotal2.innerText=changeTwoDecimal((returntotal-loantotal)/10000);
 window.document.all.i_firstMonthpay2.innerHTML=firstMonthpay;
 window.document.all.i_year2.innerHTML=year1;
 
 document.all.dijian.innerText=dijian;
}



function caculate1(){
 //商业贷款校验
 if(form1.loana_input.value!=''){
  if(String(parseFloat(form1.loana_input.value))=="NaN"){
   return;
  }
  form1.loana.value=form1.loana_input.value;
 }else{
  return;
 }
 form1.loanb.value=0;
 form1.loanc.value=0;
 principal();interest();
}
function sdRate(){
	var rate = document.getElementById('sd-rate');
	var rate2a = document.getElementById('rate2a');
	var zk = document.getElementById('sd-zk');
	rate2a.value = changeTwoDecimal(rate.value * zk.value);
	caculate1();
}
function changeTwoDecimal(x){//至多两位小数
	var f_x = parseFloat(x);
	if (isNaN(f_x)){
		alert('function:changeTwoDecimal->parameter error');
		return false;
	}
	f_x = Math.round(f_x *100)/100;
	return f_x;
}
