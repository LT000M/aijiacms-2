<?php
defined('IN_AIJIACMS') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
        <style type="text/css">
            #greetings{
                position: absolute;
                height: auto;
                border-left: 1px solid rgba(0, 0, 0, 0.11);
                border-right: 1px solid rgba(0, 0, 0, 0.11);
                left: 0px;
                z-index:5555; 
                display: none;
            }
            #greetings ul{
                list-style: none;
                box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.44);
                -webkit-margin-before: 0em;
                -webkit-margin-after: 0em;
                -webkit-margin-start: 0px;
                -webkit-margin-end: 0px;
                -webkit-padding-start: 0px;
            }
            #greetings li{
                text-align: left;
                padding: 5px;
                font-family: inherit;
                border-bottom: 1px solid rgba(0, 0, 0, 0.16);
                height: 25px;
                width: 180px;
                line-height: 25px;
                background-color: rgba(255, 255, 255, 0.8);
                cursor: pointer;
            }
            #greetings li:hover{
                background-color: rgba(175, 42, 0, 0.52);
                color: white;
            }
            #greetings2{
                position: absolute;
                height: auto;
                border-left: 1px solid rgba(0, 0, 0, 0.11);
                border-right: 1px solid rgba(0, 0, 0, 0.11);
                left: 0px;
                z-index:5555; 
                display: none;
            }
            #greetings2 ul{
                list-style: none;
                box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.44);
                -webkit-margin-before: 0em;
                -webkit-margin-after: 0em;
                -webkit-margin-start: 0px;
                -webkit-margin-end: 0px;
                -webkit-padding-start: 0px;
            }
            #greetings2 li{
                text-align: left;
                padding: 5px;
                font-family: inherit;
                border-bottom: 1px solid rgba(0, 0, 0, 0.16);
                height: 25px;
                width: 600px;
                line-height: 25px;
                background-color: rgba(255, 255, 255, 0.8);
                cursor: pointer;
            }
            #greetings2 li:hover{
                background-color: rgba(175, 42, 0, 0.52);
                color: white;
            }
            .lscxan:hover,.lscxalj a:hover{
                {$lscxanbk}
            }
            {$lscxb}
            {$lscxdiv}
        </style>
        <link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layui/css/layui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $MODULE[1][linkurl];?>keyuan/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    </head>
    <body>
        <div style="position:fixed;top:0;width: 100%; border-top-style: solid;border-top-width: 2px;border-top-color: {$lscx};z-index: 999;"></div>
        <form class="layui-form" action="?" method="post">
          
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
            <div class="layui-form-item">
                &nbsp;
            </div>
         
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="color:#f00;">
                        客户姓名
                    </label>
                    <div class="layui-input-inline" style="width:150px;">
                        <input type="text" name="post[khxingming]" lay-verify="required" value="<?php echo $khxingming;?>"  autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:120px;">
                        <select name="post[kehulx]" lay-filter="aihao" lay-verify="required">
                             <option value="先生"  <?php echo $kehulx == '先生'? ' selected=""' : '';?>>先生</option><option value="女士" <?php echo $kehulx == '女士' ? ' selected=""' : '';?>>女士</option><option value="公司"  <?php if($kehulx =='公司') echo 'selected=""'; ?>>公司</option>    
                        </select>
                    </div>
                </div>
                <div class="layui-inline lscxdiv">
                    <label class="layui-form-label" style="color:#f00;">
                        手机
                    </label>
                    <div class="layui-input-inline">
                        <input type="tel" name="post[dianhua]"  value="<?php echo $dianhua;?>" lay-verify="shouji1" autocomplete="off" class="layui-input">
                    </div>
                   
                </div>
            </div>
           
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="color:#f00;">
                        客户来源
                    </label>
                    <div class="layui-input-block">
					 <input type="text" name="post[khlaiyuan]"  value="<?php echo $khlaiyuan;?>"  autocomplete="off" class="layui-input">
                       
                    </div>
                </div>
               
            </div>
           
                <div class="layui-inline">
                    <label class="layui-form-label">沟通阶段</label>
                    <div class="layui-input-block">
                        <select name="post[gtjieduan]" lay-filter="aihao">
						 <option value="新注册" <?php echo $gtjieduan == '新注册' ? ' selected=""' : '';?>>新注册</option>
                          <option value="客户接待" <?php echo $gtjieduan == '客户接待' ? ' selected=""' : '';?>>客户接待</option>
                            <option value="已流失" <?php echo $gtjieduan == '已流失' ? ' selected=""' : '';?>>已流失</option>
                            <option value="首次带看" <?php echo $gtjieduan == '首次带看' ? ' selected=""' : '';?>>首次带看</option>
                            <option value="二次带看" <?php echo $gtjieduan == '二次带看' ? ' selected=""' : '';?>>二次带看</option>
                            <option value="守价阶段" <?php echo $gtjieduan == '守价阶段' ? ' selected=""' : '';?>>守价阶段</option>
                            <option value="杀价阶段" <?php echo $gtjieduan == '杀价阶段' ? ' selected=""' : '';?>>杀价阶段</option>
                            <option value="逼定阶段" <?php echo $gtjieduan == '逼定阶段' ? ' selected=""' : '';?>>逼定阶段</option>
                            <option value="签订合同" <?php echo $gtjieduan == '签订合同' ? ' selected=""' : '';?>>签订合同</option>
                             
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">国籍</label>
                    <div class="layui-input-block">
                        <select name="post[guoji]" lay-filter="aihao">
                            <option style="display:none"></option>
                              <option value="中国" <?php echo $guoji == '中国' ? ' selected=""' : '';?>>中国</option>
                            <option value="美国" <?php echo $guoji == '美国' ? ' selected=""' : '';?>>美国</option>
                          
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">民族</label>
                    <div class="layui-input-block">
                        <select name="post[minzu]" lay-filter="aihao">
                            <option style="display:none"></option>
                            <option value="汉族" <?php echo $minzu == '汉族' ? ' selected=""' : '';?>>汉族</option>
                            <option value="壮族" <?php echo $minzu == '壮族' ? ' selected=""' : '';?>>壮族</option>
                            <option value="满族" <?php echo $minzu == '满族' ? ' selected=""' : '';?>>满族</option>
                            <option value="回族" <?php echo $minzu == '回族' ? ' selected=""' : '';?>>回族</option>
                            <option value="苗族" <?php echo $minzu == '苗族' ? ' selected=""' : '';?>>苗族</option>
                             <option value="维吾尔族" <?php echo $minzu == '维吾尔族' ? ' selected=""' : '';?>>维吾尔族</option>
                            <option value="土家族" <?php echo $minzu == '土家族' ? ' selected=""' : '';?>>土家族</option>
                            <option value="彝族" <?php echo $minzu == '彝族' ? ' selected=""' : '';?>>彝族</option>
                            <option value="蒙古族" <?php echo $minzu == '蒙古族' ? ' selected=""' : '';?>>蒙古族</option>
                            <option value="藏族" <?php echo $minzu == '藏族' ? ' selected=""' : '';?>>藏族</option>
                             <option value="布依族" <?php echo $minzu == '布依族' ? ' selected=""' : '';?>>布依族</option>
                            <option value="侗族" <?php echo $minzu == '侗族' ? ' selected=""' : '';?>>侗族</option>
                            <option value="瑶族" <?php echo $minzu == '瑶族' ? ' selected=""' : '';?>>瑶族</option>
                            <option value="朝鲜族" <?php echo $minzu == '朝鲜族' ? ' selected=""' : '';?>>朝鲜族</option>
                            <option value="白族" <?php echo $minzu == '白族' ? ' selected=""' : '';?>>白族</option>
                             <option value="哈尼族" <?php echo $minzu == '哈尼族' ? ' selected=""' : '';?>>哈尼族</option>
                            <option value="哈萨克族" <?php echo $minzu == '哈萨克族' ? ' selected=""' : '';?>>哈萨克族</option>
                            <option value="黎族" <?php echo $minzu == '黎族' ? ' selected=""' : '';?>>黎族</option>
                            <option value="傣族" <?php echo $minzu == '傣族' ? ' selected=""' : '';?>>傣族</option>
                            <option value="畲族" <?php echo $minzu == '畲族' ? ' selected=""' : '';?>>畲族</option>
                             <option value="傈僳族" <?php echo $minzu == '傈僳族' ? ' selected=""' : '';?>>傈僳族</option>
                            <option value="仡佬族" <?php echo $minzu == '仡佬族' ? ' selected=""' : '';?>>仡佬族</option>
                            <option value="东乡族" <?php echo $minzu == '东乡族' ? ' selected=""' : '';?>>东乡族</option>
                            <option value="高山族" <?php echo $minzu == '高山族' ? ' selected=""' : '';?>>高山族</option>
                            <option value="拉祜族" <?php echo $minzu == '拉祜族' ? ' selected=""' : '';?>>拉祜族</option>
                             <option value="水族" <?php echo $minzu == '水族' ? ' selected=""' : '';?>>水族</option>
                            <option value="佤族" <?php echo $minzu == '佤族' ? ' selected=""' : '';?>>佤族</option>
                            <option value="纳西族" <?php echo $minzu == '纳西族' ? ' selected=""' : '';?>>纳西族</option>
                            <option value="羌族" <?php echo $minzu == '羌族' ? ' selected=""' : '';?>>羌族</option>
                            <option value="土族" <?php echo $minzu == '土族' ? ' selected=""' : '';?>>土族</option>
                             <option value="仫佬族" <?php echo $minzu == '仫佬族' ? ' selected=""' : '';?>>仫佬族</option>
                            <option value="锡伯族" <?php echo $minzu == '锡伯族' ? ' selected=""' : '';?>>锡伯族</option>
                            <option value="柯尔克孜族" <?php echo $minzu == '柯尔克孜族' ? ' selected=""' : '';?>>柯尔克孜族</option>
                            <option value="达斡尔族" <?php echo $minzu == '达斡尔族' ? ' selected=""' : '';?>>达斡尔族</option>
                            <option value="景颇族" <?php echo $minzu == '景颇族' ? ' selected=""' : '';?>>景颇族</option>
                             <option value="毛南族" <?php echo $minzu == '毛南族' ? ' selected=""' : '';?>>毛南族</option>
                            <option value="撒拉族" <?php echo $minzu == '撒拉族' ? ' selected=""' : '';?>>撒拉族</option>
                            <option value="塔吉克族" <?php echo $minzu == '塔吉克族' ? ' selected=""' : '';?>>塔吉克族</option>
                            <option value="阿昌族" <?php echo $minzu == '阿昌族' ? ' selected=""' : '';?>>阿昌族</option>
                            <option value="普米族" <?php echo $minzu == '普米族' ? ' selected=""' : '';?>>普米族</option>
                             <option value="鄂温克族" <?php echo $minzu == '鄂温克族' ? ' selected=""' : '';?>>鄂温克族</option>
                            <option value="怒族" <?php echo $minzu == '怒族' ? ' selected=""' : '';?>>怒族</option>
                            <option value="京族" <?php echo $minzu == '京族' ? ' selected=""' : '';?>>京族</option>
                            <option value="基诺族" <?php echo $minzu == '基诺族' ? ' selected=""' : '';?>>基诺族</option>
                            <option value="德昂族" <?php echo $minzu == '德昂族' ? ' selected=""' : '';?>>德昂族</option>
                             <option value="保安族" <?php echo $minzu == '保安族' ? ' selected=""' : '';?>>保安族</option>
                            <option value="俄罗斯族" <?php echo $minzu == '俄罗斯族' ? ' selected=""' : '';?>>俄罗斯族</option>
                            <option value="裕固族" <?php echo $minzu == '裕固族' ? ' selected=""' : '';?>>裕固族</option>
                            <option value="乌兹别克族" <?php echo $minzu == '乌兹别克族' ? ' selected=""' : '';?>>乌兹别克族</option>
                            <option value="门巴族" <?php echo $minzu == '门巴族' ? ' selected=""' : '';?>>门巴族</option>
                             <option value="鄂伦春族" <?php echo $minzu == '鄂伦春族' ? ' selected=""' : '';?>>鄂伦春族</option>
                            <option value="独龙族" <?php echo $minzu == '独龙族' ? ' selected=""' : '';?>>独龙族</option>
                            <option value="塔塔尔族" <?php echo $minzu == '塔塔尔族' ? ' selected=""' : '';?>>塔塔尔族</option>
                            <option value="赫哲族" <?php echo $minzu == '赫哲族' ? ' selected=""' : '';?>>赫哲族</option>
                            <option value="珞巴族" <?php echo $minzu == '珞巴族' ? ' selected=""' : '';?>>珞巴族</option>
                            <option value="布朗族" <?php echo $minzu == '布朗族' ? ' selected=""' : '';?>>布朗族</option>
                            
                         </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">消费理念</label>
                    <div class="layui-input-block">
                        <select name="post[xflinian]" lay-filter="aihao">
                            <option style="display:none"></option>
                              <option value="生存型消费" <?php echo $xflinian == '生存型消费' ? ' selected=""' : '';?>>生存型消费</option>
                            <option value="发展型消费" <?php echo $xflinian == '发展型消费' ? ' selected=""' : '';?>>发展型消费</option>
                            <option value="享受型消费" <?php echo $xflinian == '享受型消费' ? ' selected=""' : '';?>>享受型消费</option>
                                       
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">客源等级</label>
                    <div class="layui-input-block">
                        <select name="post[kydengji]" lay-filter="aihao">
                          <option value="A类客源" <?php echo $kydengji == 'A类客源' ? ' selected=""' : '';?>>A类客源</option>
                            <option value="B类客源" <?php echo $kydengji == 'B类客源' ? ' selected=""' : '';?>>B类客源</option>
                            <option value="C类客源" <?php echo $kydengji == 'C类客源' ? ' selected=""' : '';?>>C类客源</option>
                            <option value="D类客源" <?php echo $kydengji == 'D类客源' ? ' selected=""' : '';?>>D类客源</option>
                           
                        </select>
                    </div>
                </div>
            </div>
			
			 <div class="layui-form-item">
                <label class="layui-form-label">分配经纪人</label>
                <div class="layui-input-block" style="width: 666px;">
                   <input type="text" size="45" name="post[dkusername]" id="touser" value="<?php echo $dkusername;?>"/>&nbsp;&nbsp;<a href="javascript:Dwidget('member/zhiye.php?action=my', '[选择]', 600, 300);" class="t">[选择]</a>
                </div>
            </div>
		
            <div class="layui-form-item">
                <label class="layui-form-label">身份证</label>
                <div class="layui-input-block" style="width: 666px;">
                    <input type="text" name="post[sfzheng]" lay-verify="sfzheng1" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $sfzheng;?>">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">QQ</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="post[qqhao]" lay-verify="qqhao1" autocomplete="off" class="layui-input" value="<?php echo $qqhao;?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-inline">
                        <input type="text" name="post[youxiang]" lay-verify="youxiang1" autocomplete="off" class="layui-input" value="<?php echo $youxiang;?>">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">微信</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="post[weixin]" autocomplete="off" class="layui-input" value="<?php echo $weixin;?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">交通工具</label>
                    <div class="layui-input-block">
                      <select name="post[jtgongju]" lay-filter="aihao">
                            <option style="display:none"></option>
                              <option value="电动车" <?php echo $jtgongju == '电动车' ? ' selected=""' : '';?>>电动车</option>
                            <option value="汽车" <?php echo $jtgongju == '汽车' ? ' selected=""' : '';?>>汽车</option>
                            <option value="步行" <?php echo $jtgongju == '步行' ? ' selected=""' : '';?>>步行</option>
                           
                      </select>
                   </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">车型</label>
                    <div class="layui-input-inline">
                        <input type="tel" name="post[chexing]" autocomplete="off" class="layui-input" value="<?php echo $chexing;?>">
                    </div>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block" style="width: 666px;">
                    <textarea placeholder="请输入内容" class="layui-textarea" name="post[beizhu]" lay-verify="beizhu" value="<?php echo $beizhu;?>"></textarea>
                </div>
            </div>
            <div style="line-height:50PX;">&nbsp;</div>
            <div class="layui-form-item" style="width:100%;height:45px;margin:0 auto;background:#fff;position:fixed;bottom:0;text-align:center;border-top-style: solid;border-top-width: 1px;border-top-color: {$lscx};padding-top: 5px;" id="submit">
				<div class="layui-input-block" style="margin-left: -15px;">
                    <button class="layui-btn layui-btn-radius layui-btn-tijiao" name="submit" lay-submit="" lay-filter="demo1">
						<i class="Hui-iconfont">&#xe603;</i> 立即提交
					</button>
					<button type="reset" class="layui-btn layui-btn-radius layui-btn-primary lscxan">
						<i class="Hui-iconfont">&#xe72a;</i> 重置
					</button>
				
                </div>
            </div>
        </form>
     
        <script type="text/javascript" src="<?php echo $MODULE[1][linkurl];?>keyuan/lib/jquery/1.9.1/jquery.min.js"></script> 
        <script src="<?php echo $MODULE[1][linkurl];?>keyuan/lib/layui/layui.js" charset="utf-8"></script>
        <script>
            //Demo
            layui.use('form', function(){
                var form = layui.form();
                //监听提交
               
                form.verify({
                    title: function(value){
                        if(value.length < 5){
                            return '标题至少得5个字符啊';
                        }
                    }
                    ,shuzi1: [/^([1-9]{1})$|^(1[0]{1})$/, '请输入＞0≤10的整数！']
                    ,shuzi2: [/^([1-9][0-9]{0,4})$|^(1[0]{5})$/, '请输入＞0≤十亿的整数！']
                    ,shuzi3: [/^([1-9][0-9]{0,4})$|^(1[0]{5})$/, '请输入＞0≤十万的整数！']
                    ,shuzi4: [/^([1-9][0-9]{0,3})$|^(1[0]{4})$/, '请输入＞0≤一万的整数！']
                    ,shuzi5: [/^$|^([1-9]{1})$|^([1-9][0-9]{1})$|^(1[0-9]{2})$|^(2[0]{2})$/, '请输入＞0≤200的整数！']
                    ,shuzi6: [/^$|^([1-9][0-9]{0,2})$|^(1[0]{3})$/, '请输入＞0≤1000的整数！']
                    ,beizhu: [/^$|^[\s\S]{0,300}$/, '只能输入300个字符！']
                    ,qqhao1: [/^$|^[1-9][0-9]{4,}$/, '请输入正确的QQ号！']
                    ,youxiang1: [/^$|^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/, '请输入正确的邮箱！']
                    ,shouji1: [/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[189])\d{8}$|^0\d{2,3}-?\d{7,8}$/, '请输入正确的手机号码或电话号码！']
                    ,sfzheng1: [/^$|^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$|^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/, '请输入正确的身份证号！']
                    ,content: function(value){
                        layedit.sync(editIndex);
                    }
                });
                form.on('checkbox(quanxuan)', function(data){
                    if(data.elem.checked){
                        $(".peitao").prop("checked",true);
                        form.render('checkbox');
                    } else {
                        $(".peitao").prop("checked",false);
                        form.render('checkbox');
                    }
                });
                $("#xqhuxing1,#xqhuxing2").blur(function(){
                    var xqhuxing1=$("#xqhuxing1").val();
                    var xqhuxing2=$("#xqhuxing2").val();
                    if(xqhuxing1.length!=0 && xqhuxing2.length!=0){
                        if (parseInt(xqhuxing1) >parseInt(xqhuxing2) ) {
                            layer.alert('需求户型2小于需求户型1！！！', {icon: 5});
                            $("#submit").hide();
                        }else{
                            $("#submit").show();
                        }
                    }
                });
                $("#xqjiage1,#xqjiage2").blur(function(){
                    var xqjiage1=$("#xqjiage1").val();
                    var xqjiage2=$("#xqjiage2").val();
                    if(xqjiage1.length!=0 && xqjiage2.length!=0){
                        if (parseInt(xqjiage1) >parseInt(xqjiage2) ) {
                            layer.alert('价格范围2小于价格范围1！！！', {icon: 5});
                            $("#submit").hide();
                        }else{
                            $("#submit").show();
                        }
                    }
                });
                $("#xqmianji1,#xqmianji2").blur(function(){
                    var xqmianji1=$("#xqmianji1").val();
                    var xqmianji2=$("#xqmianji2").val();
                    if(xqmianji1.length!=0 && xqmianji2.length!=0){
                        if (parseInt(xqmianji1) >parseInt(xqmianji2) ) {
                            layer.alert('需求建面2小于需求建面1！！！', {icon: 5});
                            $("#submit").hide();
                        }else{
                            $("#submit").show();
                        }
                    }
                });
                $("#louceng1,#louceng2").blur(function(){
                    var louceng1=$("#louceng1").val();
                    var louceng2=$("#louceng2").val();
                    if(louceng1.length!=0 && louceng2.length!=0){
                        if (parseInt(louceng1) >parseInt(louceng2) ) {
                            layer.alert('需求楼层2小于需求楼层1！！！', {icon: 5});
                            $("#submit").hide();
                        }else{
                            $("#submit").show();
                        }
                    }
                });
                $("#fangling1,#fangling2").blur(function(){
                    var fangling1=$("#fangling1").val();
                    var fangling2=$("#fangling2").val();
                    if(fangling1.length!=0 && fangling2.length!=0){
                        if (parseInt(fangling1) >parseInt(fangling2) ) {
                            layer.alert('需求房龄2小于需求房龄1！！！', {icon: 5});
                            $("#submit").hide();
                        }else{
                            $("#submit").show();
                        }
                    }
                });
                $("#sousuo1").click(function(){
                    var display =$('#greetings').css('display');
                    if(display == 'none'){
                        $("#greetings").show();
                    }else{
                        $("#greetings").hide(); 
                    }
                });
                $("#sousuo").keyup(function(){
                    $("#greetings").show();
                    var txt=$("#sousuo").val();
                    if (txt!="") {
                        $.ajax({
                            url:'xiaoqu',
                            type:"get",
                            data:"txt="+txt,
                            dataType:"json",
                            success:function(data){
                                var district = data.lists;
                                $("#tcontent li").remove();
                                for(var i in district){
                                    var li=$("<li></li>");
                                    $(li).attr('dataid',district[i]['id']);
                                    $(li).html(district[i]['xiaoqum']);
                                    $("#tcontent").append(li);
                                }
                            }
                        });
                    }
                });
                $("#tcontent").on("click","li", function() {  
                    $("#greetings").show();
                    var Uarry=$("#tcontent li");
                    var count=$(this).index();
                    var Tresult=Uarry.eq(count).text();
                    var xiaoquid=Uarry.eq(count).attr('dataid');
                    var bb=$("#sousuo1").val();
                    bb+=Tresult+'；';
                    $("#xiaoqu").val(xiaoquid);
                    $("#sousuo1").val(bb);
                    $("#sousuo").val("");
                    $("#greetings").hide();
                });
                $("#cz1").click(function(){
                    $("#sousuo1").val("");
                });
                $("#sousuo3").click(function(){
                    var display =$('#greetings2').css('display');
                    if(display == 'none'){
                        $("#greetings2").show();
                    }else{
                        $("#greetings2").hide();
                    }
                });
            });
        </script>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>