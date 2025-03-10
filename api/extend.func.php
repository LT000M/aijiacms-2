<?php
/*
	 www.aijiacms.com 爱家房产系统
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');


 function gmt_iso8601($time)
{
    return str_replace('+00:00', '.000Z', gmdate('c', $time));
}

function verify()
{

}
// php函数开始
/**
 * 获取相应模块下对应id的评论数 商城模块不适用
 * $mid  模块id 例如二手房为5
 * $itemid  信息id 比如1
 */
function gl_get_comments($mid,$itemid) {
global $db;
$nums = $db->get_one("SELECT COUNT(*) AS num FROM {$db->pre}comment WHERE item_mid='$mid' and item_id='$itemid'");
return $nums['num'] ;
}

/**
 * 获取相应id下对应的分类名称
 */
function gl_cat_name($catid) {
	global $db;
	$catid = intval($catid);
	$catname = '';
    $r = $db->get_one("SELECT catname FROM {$db->pre}category WHERE catid=$catid");
    $catname = $r['catname'];
	return $catname;
}

/**
 * 获取相应id下对应的地区名称
 */
function gl_area_name($areaid) {
	global $db;
	$catid = intval($areaid);
	$areaname = '';
    $r = $db->get_one("SELECT areaid,areaname FROM {$db->pre}area WHERE areaid=$areaid");
    $areaname = $r['areaname'];
	return $areaname;
}

function gl_exit($error='error',$path='',$message='') {
  exit('{"error":"'.$error.'","path":"'.$path.'","message":"'.$message.'"}');
}

//获取分类父id
function gl_get_parcatid($catid) {
	global $db;
		$r = $db->get_one("SELECT parentid FROM {$db->pre}category WHERE catid=$catid");
		if($r['parentid']==0){
			$catid = $catid;
		}else{
		$catid = $r['parentid'];
		}

		return $catid;
}

//获取分类父id
function gl_get_parareaid($areaid) {
	global $db;
		$r = $db->get_one("SELECT parentid FROM {$db->pre}area WHERE areaid=$areaid");
		if($r['parentid']==0){
			$areaid = $areaid;
		}else{
		$areaid = $r['parentid'];
		}

		return $areaid;
}

function gl_bdcity($ip) {
	global $AJ;
	$ch = curl_init();
    $url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$ip;
    $header = array(
        'apikey: '.$AJ['cloud_bdapi_key'].'',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
	$ipdata = json_decode($res,true);

		$data = $ipdata;
		if($data['errMsg']=='success') {
			$area = '';
			if(isset($ipdata['retData']['country']) && strpos($res, "\u4e2d\u56fd") === false) $area .= $ipdata['retData']['country'];
			if(isset($ipdata['retData']['province'])) $area .= $ipdata['retData']['province'].'&#x7701;';//省
			if(isset($ipdata['retData']['city'])) $area .= $ipdata['retData']['city'].'&#x5E02;';//市
			if(isset($ipdata['retData']['district'])) $area .= $ipdata['retData']['district'];//地区
			//if(isset($ipdata['retData']['carrier'])) $area .= '-'.$ipdata['retData']['carrier'];
			if(isset($ipdata['retData']['city'])) $mycity = $ipdata['retData']['city'];//市
			return $mycity ? convert($mycity, 'UTF-8', AJ_CHARSET) : '';
		}
		return 'API Error';
	}

//获取资讯详细内容中的图片地址 并输出
function gl_acontent_thumb($moduleid,$itemid,$nums = 0) {
	global $db, $AJ, $AJ_TIME;
	$$thumbs = '';
	$table = get_table($moduleid,1);
	$r = $db->get_one("SELECT content FROM {$table} WHERE itemid='$itemid'");
	$content = $r['content'];
	if(!$content) return '';
	$ext = 'jpg|jpeg|png|bmp';
	if(!preg_match_all("/src=([\"|']?)([^ \"'>]+\.($ext))\\1/i", $content, $matches)) return '';
	$mnums = count($matches[2]);
	if($mnums>=$nums) $thumbs = array_slice($matches[2], 0, $nums);
    return $thumbs;
}

//时间格式化 传入时间戳格式1464662723
function gl_format_date($time){
    $t = time()-$time;
	$timer = '前';
	if($t<0){
		$t = $time - time();
		$timer = '后';
	}
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.$timer;
        }
    }
};

     //用户名、邮箱、手机账号中间字符串以*隐藏 
    function xhdestar($str) { 
        if (strpos($str, '@')) { 
            $email_array = explode("@", $str); 
            $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀 
            $count = 0; 
            $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count); 
            $rs = $prevfix . $str; 
        } else { 
            $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i'; 
            if (preg_match($pattern, $str)) { 
                $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4); 
            } else { 
                $rs = substr($str, 0, 3) . "***" . substr($str, -1); 
            } 
        } 
        return $rs; 
    }





    


function gl_input_trim($wd) {
	return urldecode(str_replace('%E2%80%86', '', urlencode($wd)));
}
function userinfot($username,$names) {
	global $db, $dc, $CFG;

	$result = DB::query("SELECT * FROM ".AJ_PRE."member  WHERE username='$username'");
	while($r = DB::fetch_array($result)) {
		$city[] = $r;
		
	
      $truename=$r[''.$names.''];
		
	}
	return $truename;
}
 function get_truename($userid) {
	global $db, $dc, $CFG;
	$user=DB::get_one("SELECT userid,truename FROM ".AJ_PRE."member WHERE userid='$userid'");
      $truename=$user['truename'];
	return $truename;
}
//20220803后台发布文章实时主动推送
    function baiduping($url){
    global $AJ;
    $api = "http://data.zz.baidu.com/urls?site=".$AJ['baidu_site']."&token=".$AJ['baidu_token'];
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $url,
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    if($result['not_same_site']){
      $code = '推送地址错误';
      }
    if($result['error']){
      $code = $result['message'];
      }
    if($result['success']){
      $code = $result['success'];
      }
      return $code;
    }
     
    function baidu($itemid,$table) {
      global $MOD, $db;
      if(is_array($itemid)) {
        foreach($itemid as $v) { baidu($v,$table); }
      } else {
        $item = $db->get_one("SELECT linkurl FROM {$table} WHERE itemid='$itemid'");
        $item['linkurl'] = $MOD['linkurl'].$item['linkurl'];
        $baidu = baiduping($item['linkurl']);
        return true;
      }
    }
// php函数结束
//阿里云短信插件
function ali_sms($mobile,$id,$data){
    global $AJ_TIME,$_username,$db,$AJ;
    
    include AJ_ROOT.'/api/aliyun/sendsms.class.php';
   
    $params = array ();
    $accessKeyId = $AJ['sms_uid']; //AccessKey ID
    $accessKeySecret = $AJ['sms_key']; //Access Key Secret
    $params["PhoneNumbers"] = $mobile;
    $params["SignName"] =$AJ['sms_sign']; //短信签名
    $params["TemplateCode"] = $id;
    $params['TemplateParam'] = $data;
     // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $res = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );
    $res = json_decode( json_encode( $res),true);
    $code = $res['Code'];

    $message = $id . "||" .json_encode( $data) ;
    $word = '';
    $db->query("INSERT INTO {$db->pre}sms (mobile,message,word,editor,sendtime,code) VALUES ('$mobile','$message','$word','$_username','$AJ_TIME','$code')");
    return $code;
}

//阿里云短信插件小程序端
function aliapi_sms($mobile,$id,$data,$mobilecode){
    global $AJ_TIME,$_username,$db,$AJ;
    
    include AJ_ROOT.'/api/aliyun/sendsms.class.php';
   
    $params = array ();
    $accessKeyId = $AJ['sms_uid']; //AccessKey ID
    $accessKeySecret = $AJ['sms_key']; //Access Key Secret
    $params["PhoneNumbers"] = $mobile;
    $params["SignName"] =$AJ['sms_sign']; //短信签名
    $params["TemplateCode"] = $id;
    $params['TemplateParam'] = $data;
     // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $res = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );
    $res = json_decode( json_encode( $res),true);
    $code = $res['Code'];

    $message = $id . "||" .json_encode( $data) ;
    $word = '';
   // $db->query("INSERT INTO {$db->pre}sms (mobile,message,word,editor,sendtime,code) VALUES ('$mobile','$message','$word','$_username','$AJ_TIME','$code')");
	$db->query("INSERT INTO {$db->pre}sms (mobile,message,word,editor,sendtime,ip,code,encode) VALUES ('$mobile','$message','$word','$_username','".AJ_TIME."','".AJ_IP."','$code','$mobilecode')");
    return $code;
}
function sendapi_sms($mobile, $message, $mobilecode,  $word = 0, $time = 0) {
         global $db, $AJ, $AJ_TIME, $AJ_IP, $_username;
		 $id = urlencode($AJ['sms_uid']);
			$pwd = urlencode($AJ['sms_key']);
		  if($AJ['sms_type']==1){
		  
		  	$statusStr = array(
		"0" => "短信发送成功",
		"-1" => "参数不全",
		"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
		"30" => "密码错误",
		"40" => "账号不存在",
		"41" => "余额不足",
		"42" => "帐户已过期",
		"43" => "IP地址限制",
		"50" => "内容含有敏感词"
	);
		  
		  if(!$AJ['sms'] || !is_mobile($mobile) || strlen($message) < 5) return false;
	$word or $word = word_count($message);
	$sms_message = $message;
	$data = 'u='.$id.'&p='.md5($pwd).'&m='.$mobile.'&c='.rawurlencode($sms_message);
	$code = dcurl('http://api.smsbao.com/sms', $data);
    if($code == 0) {
		$code = $statusStr[$code];
	} else {
		$code = 'Can Not Connect SMS Server';
	}
		  
		  }
		  else
		  { 
         if(!$AJ['sms'] || !$AJ['sms_uid'] || !$AJ['sms_key']) return false;
			 $url="http://service.winic.org/sys_port/gateway/?";
	      $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
			$to = urlencode($mobile);
			 $word or $word = word_count($message);
			$content=$message;
			 $content = urlencode(iconv("UTF-8","GB2312",$content)); 
      $rdata = sprintf($data, $id, $pwd, $to, $content); 
      $ch = curl_init();
	  curl_setopt($ch, CURLOPT_POST,1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
	  curl_setopt($ch, CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	  //打印一下参数 可以看到 在GB2312编码模式的浏览器下 显示字符是正常的
      $result = curl_exec($ch);
      curl_close($ch);
		$code='';	
if(!$result==$AJ['sms_ok']){
    $code = 'Can Not Connect SMS Server';
}
else{
    $code =$AJ['sms_ok'];
}
}
DB::query("INSERT INTO ".AJ_PRE."sms (mobile,message,word,editor,sendtime,ip,code,encode) VALUES ('$mobile','$message','$word','$_username','".AJ_TIME."','".AJ_IP."','$code','$mobilecode')");

    return $code;   

}

?>