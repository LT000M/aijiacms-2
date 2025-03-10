<?php
require '../../common.inc.php';
class Baidu
{
    // appid
    private $_appid;

    // appsecret
    private $_appsecret;

    /**
     * [__construct 构造方法]

     */
  
  public function __construct($app_id, $app_secret)
    {
       // self::_appid       = 'wx09f23c73cd73986a';
        //self::_appsecret   = 'b16803877652f0b1ff795de4511c4d48';
		 // $data_post = input('post.');
    }

    /**
     * [DecryptData 检验数据的真实性，并且获取解密后的明文]
     */
  public static function DecryptData($encrypted_data, $iv, $openid, $key = 'user_info')
    {
        // 登录授权session
        $login_key = 'baidu_user_login_'.$openid;
		$session_data = cache_read($login_key);
        
        if(empty($session_data))
        {
            return ['status'=>-1, 'msg'=>'session key不存在'];
        }

        // iv长度
        if(strlen($iv) != 24)
        {
            return ['status'=>-1, 'msg'=>'iv长度错误'];
        }

        // 数据解密
        $session_key = base64_decode($session_data['session_key']);
        $iv = base64_decode($iv);
        $encrypted_data = base64_decode($encrypted_data);

        $plaintext = false;
        if (function_exists("openssl_decrypt")) {
            $plaintext = openssl_decrypt($encrypted_data, "AES-192-CBC", $session_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        } else {
            if(!function_exists('mcrypt_module_open'))
            {
                return ['status'=>-1, 'msg'=>'mcrypt_module_open方法不支持'];
            }
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, null, MCRYPT_MODE_CBC, null);
            mcrypt_generic_init($td, $session_key, $iv);
            $plaintext = mdecrypt_generic($td, $encrypted_data);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
        }
        if ($plaintext == false) {
            return ['status'=>-1, 'msg'=>'解密失败'];
        }

        // trim pkcs#7 padding
        $pad = ord(substr($plaintext, -1));
        $pad = ($pad < 1 || $pad > 32) ? 0 : $pad;
        $plaintext = substr($plaintext, 0, strlen($plaintext) - $pad);

        // trim header
        $plaintext = substr($plaintext, 16);
        // get content length
        $unpack = unpack("Nlen/", substr($plaintext, 0, 4));
        // get content
        $data = json_decode(substr($plaintext, 4, $unpack['len']), true);
        // get app_key
        $app_key_decode = substr($plaintext, $unpack['len'] + 4);


        // 缓存存储
        $data_key = 'baidu_'.$key.'_'.$openid;
		 cache_write($data_key, $data);
		
        //cache($data_key, $data);

        return ['status'=>0, 'data'=>$data];
    }

    /**
     * [GetAuthSessionKey 根据授权code获取 session_key 和 openid]
     */
    public static function GetAuthSessionKey($authcode)
    {
        global $AJ;
        if(empty($_POST['authcode']))
        {
           // return ['status'=>-1, 'msg'=>'授权码s有误'];
        }

        $data = [
            'code'      => $_POST['authcode'],
            'client_id' => $AJ['BaiduAppkey'],
            'sk'        => $AJ['BaiduAppSecret'],
        ];
		
	
        $result = json_decode(self::HttpRequestPost('https://spapi.baidu.com/oauth/jscode2sessionkey', $data), true);
		
        if(!empty($result['openid']))
        {
            // 缓存SessionKey
            $key = 'baidu_user_login_'.$result['openid'];

            // 缓存存储
            //cache($key, $result);
			   cache_write($key, $result);
            return ['status'=>0, 'msg'=>'授权成功', 'data'=>$result['openid']];
        }
        return ['status'=>-1, 'msg'=>$result['error_description']];
    }



   public static function BaiduUserAuth()
    {global $AJ;
		 $BaiduAppID = urlencode($AJ['BaiduAppID']);
			$BaiduAppkey = urlencode($AJ['BaiduAppkey']);
			$BaiduAppSecret = urlencode($AJ['BaiduAppSecret']);
		 
        $config = [
            'appid'     => $BaiduAppID,
            'key'       => $BaiduAppkey,
            'secret'    => $BaiduAppSecret,
        ];
	
            $result = self::GetAuthSessionKey($_POST['authcode']);
		
        if($result['status'] == 0)
        {
			
			
            // 先从数据库获取用户信息
            $user =  self::AppUserInfoHandle(null, 'baidu_openid', $result);
			
            if(empty($user))
            {
                return self::DataReturn('授权登录成功', 0, ['is_user_exist'=>0, 'openid'=>$result['data']]);
            }

            // 标记用户存在
            $user['is_user_exist'] = 1;
            return self::DataReturn('授权登录成功', 0, $user);
        }
        return self::DataReturn($result['msg'], -10);
    }

    /**
     * 百度小程序获取用户信息
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-11-06
     * @desc    description
     */
    public static function BaiduUserInfo()
    {
        // 参数校验
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'openid',
                'error_msg'         => 'openid为空',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'encrypted_data',
                'error_msg'         => '解密数据为空',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'iv',
                'error_msg'         => 'iv为空,请重试',
            ]
        ];
       // $ret = ParamsChecked($_POST, $p);
      

        // 先从数据库获取用户信息
        $user = self::AppUserInfoHandle(null, 'baidu_openid', $_POST['openid']);
		 global $AJ;
		
		    $BaiduAppID = urlencode($AJ['BaiduAppID']);
			$BaiduAppkey = urlencode($AJ['BaiduAppkey']);
			$BaiduAppSecret = urlencode($AJ['BaiduAppSecret']);
        if(empty($user))
        {
            $config = [
                 'appid'     =>  $BaiduAppID,
            'key'       => $BaiduAppkey ,
            'secret'    => $BaiduAppSecret,
            ];
            $result = self::DecryptData($_POST['encrypted_data'], $_POST['iv'], $_POST['openid']);

            if($result['status'] == 0 && !empty($result['data']))
            {
                $result['nickname'] = isset($result['data']['nickname']) ? $result['data']['nickname'] : '';
                $result['avatar'] = isset($result['data']['headimgurl']) ? $result['data']['headimgurl'] : '';
                $result['gender'] = empty($result['data']['sex']) ? 0 : (($result['data']['sex'] == 2) ? 1 : 2);
                $result['openid'] = $result['data']['openid'];
				  $result['baidu_openid'] = $result['data']['baidu_openid'];
				
                $result['referrer']= isset($_POST['referrer']) ? $_POST['referrer'] : 0;
                return self::AuthUserProgram($result, 'baidu_openid');
            } else {
                return self::DataReturn($result['msg'], -1);
            }
        } else {
            return self::DataReturn('授权成功', 0, $user);
        }
        return self::DataReturn(empty($result['msg']) ? '获取用户信息失败' : $result['msg'], -100);
    }

public static function DataReturn($msg = '', $code = 0, $data = '')
{
  
  
    
    // 默认情况下，手动调用当前方法
    if(empty($result))
    {
        $result = array('msg'=>$msg, 'code'=>$code, 'data'=>$data);
    }

    // 错误情况下，防止提示信息为空
    if($result['code'] != 0 && empty($result['msg']))
    {
        //$result['msg'] = '操作失败';
    }
  
    return $result;
}

   // 获取用户信息
   
   public static function AppUserInfoHandle($user_id = null, $where_field = null, $where_value = null, $user = [])
    {
        // 获取用户信息
        $field = 'username,nickname,mobile,baidu_openid,province,city';
     
	    if(!empty($user_id))
        {
			
            //$user = self::UserInfo('id', $user_id, $field);
			 $user = self::UserInfo($where_field, $where_value, $field);
        } elseif(!empty($where_field) && !empty($where_value) && empty($user))
        {   
            $user = self::UserInfo($where_field, $where_value, $field);
        }

        if(!empty($user))
        {
            // 用户信息处理
            $user = self::GetUserViewInfo(0, $user);
            // 基础处理
            if(isset($user['userid']))
            {
                  
				  
				    // token生成并存储缓存
                if($user['is_mandatory_bind_mobile'] == 0 || ($user['is_mandatory_bind_mobile'] == 1 && !empty($user['mobile'])))
                {
                    $user['token'] = md5(md5($user['id'].time()).rand(100, 1000000));
                    //cache(config('cache_user_info').$user['token'], $user);

                    // 非token数据库校验，则重新生成token更新到数据库
                    if($where_field != 'token')
                    {
                       $upd_time = time();
						$userid=$user['userid'];
						$token=$user['token'];
                      Db::query("UPDATE ".AJ_PRE."member SET  token='$token',logintime='$upd_time',logintimes=logintimes+1 where userid='$userid'");
					
                    }
                } else {
                    $user['token'] = '';
                }
				  
				  
			

               
            }
        }

        return $user;
    }


 /**
     * 根据字段获取用户信息
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-01-25
     * @desc    description
     * @param   [string]          $where_field      [字段名称]
     * @param   [string]          $where_value      [字段值]
     * @param   [string]          $field            [指定字段]
     */
    public static function UserInfo($where_field, $where_value, $field = '*')
    {
        
	
		
	
		$where_value=is_array($where_value) ? $where_value['data'] : $where_value;

        return  Db::get_one("SELECT * FROM ".AJ_PRE."member WHERE baidu_openid='$where_value'");
       
    }

  /**
     * 获取用户展示信息

     * @version 1.0.0
     * @desc    description
     * @param   [int]          $user_id     [用户id]
     * @param   [array]        $user        [指定用户信息]
     * @param   [boolean]      $is_privacy  [是否隐私处理展示用户名]
     */
    public static function GetUserViewInfo($user_id, $user = [], $is_privacy = false)
    {
        // 是否指定用户信息
        if(empty($user) && !empty($user_id))
        {
		
			$baidu_openid=$user_id['baidu_openid'];
           $user = Db::get_one("SELECT * FROM ".AJ_PRE."member WHERE baidu_openid='$baidu_openid'");
		   
        }
       
       

        return $user;
    }
	
	
	  /**
     * [ClientCenter 用户中心]
 
     * @version  1.0.0
     * @datetime 2018-05-21T15:21:52+0800
     */
    public function Center()
    {
        // 登录校验
      //  $this->IsLogin();
//login();

	 $baidu_openid=$_GET['token'];
       $user = Db::get_one("SELECT * FROM ".AJ_PRE."member WHERE token='$baidu_openid'");
	  $groupname = $user['groupid']==5 ? '个人' : '经纪人';
        // 初始化数据
        $result = array(
           
            'avatar'                            => $user['avatar'],
            'nickname'                          => $user['nickname'],
            'username'                          => $user['username'],
			  'mobile'                          => $user['mobile'],
			    'groupname'                          => $groupname,
          
        );

     

        // 返回数据
        return self::DataReturn('success', 0, $result);
    }
	
	
	  /**
     * [GetMiniAccessToken 获取access_token]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-01-02T19:53:42+0800
     */
    private function GetMiniAccessToken()
    {
        // 缓存key
        $key = $this->_appid.'_access_token';
        $result = cache($key);
        if(!empty($result))
        {
            if($result['expires_in'] > time())
            {
                return $result['access_token'];
            }
        }

        // 网络请求
        $url = 'https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&scope=smartapp_snsapi_base&client_id='.$this->_appkey.'&client_secret='.$this->_appsecret;
        $result = $this->HttpRequestGet($url);
        if(!empty($result['access_token']))
        {
            // 缓存存储
            $result['expires_in'] += time();
            cache($key, $result);
            return $result['access_token'];
        }
        return false;
    }

    /**
     * [HttpRequestGet get请求]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-01-03T19:21:38+0800
     * @param    [string]           $url [url地址]
     * @return   [array]                 [返回数据]
     */
    private function HttpRequestGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);
        return json_decode($res, true);
    }

    /**
     * [HttpRequestPost curl模拟post]
     */
   private function HttpRequestPost($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $body_string = '';
        if(is_array($data) && 0 < count($data))
        {
            foreach($data as $k => $v)
            {
                $body_string .= $k.'='.urlencode($v).'&';
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body_string);
        }
        $headers = array('content-type: application/x-www-form-urlencoded;charset=UTF-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $reponse = curl_exec($ch);
        if(curl_errno($ch))
        {
            return false;
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if(200 !== $httpStatusCode)
            {
                return false;
            }
        }
        curl_close($ch);
        return $reponse;
    }
	
 /**
     * 用户授权数据
     * @date    2018-11-06
     * @desc    description
     * @param   [array]          $params    [用户数据]
     * @param   [string]         $field     [平台字段名称]
     */
    public static function AuthUserProgram($params, $field)
    {
        // 用户信息
        $data = [
		     $field              => $params['openid'],
            'nickname'          => empty($params['nickname']) ? '' : $params['nickname'],
            'avatar'            => empty($params['avatar']) ? '' : $params['avatar'],
            'gender'            => empty($params['gender']) ? 0 : intval($params['gender']),
            'province'          => empty($params['province']) ? '' : $params['province'],
            'city'              => empty($params['city']) ? '' : $params['city'],
            'mobile'            => empty($params['mobile']) ? '' : $params['mobile'],
            'referrer'          => isset($params['referrer']) ? $params['referrer'] : 0,
        ];

        // 用户信息处理
        $user = self::AppUserInfoHandle(null, $field, $params['openid']);
		
        if(!empty($user))
        {
            return self::DataReturn('授权成功', 0, $user);
        } else {
            // 用户unionid
            $unionid = self::UserUnionidHandle($params);
            if(!empty($unionid['field']) && !empty($unionid['value']))
            {
                // unionid字段是否存在用户
                $user_unionid = self::AppUserInfoHandle(null, $unionid['field'], $unionid['value']);
                if(!empty($user_unionid))
                {
                    // openid绑定
                    $upd_time = time();
						$userid=$user_unionid['id'];
						$openid=$params['openid'];
                       Db::query("UPDATE ".AJ_PRE."member SET  openid='$openid',logintime='$upd_time' where userid='$userid'");
				  
                    {
                        // 直接返回用户信息
                        $user_unionid[$field] = $params['openid'];
                        return self::DataReturn('授权成功', 0, $user_unionid);
                    }
                }

                // 如果用户不存在数据库中，则unionid放入用户data中
                $data[$unionid['field']] = $unionid['value'];
            }

            // 不强制绑定手机则写入用户信息
         
            {
                $ret = self::UserInsert($data, $params);
			
                if($ret['code'] == 0)
                {
                    return self::DataReturn('授权成功', 0, self::AppUserInfoHandle(null, 'baidu_openid', $ret['data']));
                } else {
                    return $ret;
                }
            }
        }
        return DataReturn('授权成功', 0, self::AppUserInfoHandle(null, null, null, $data));
    }
	  
	  
	  
	  //用户登录
    public static function UserInsert($data, $params = [])
    {
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MOD;

		$module ="member";
require AJ_ROOT.'/module/member/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
require AJ_ROOT.'/module/member/member.class.php';
$wxxas = mt_rand(10000,999999);
$nameu = 'bd'.$wxxas; // 随机用户名

$password = '12345678';

$member = cache_read('module-2.php');


 // 发送验证码
		
		 

$datac = array();

$datac['regid'] = '5';
$datac['groupid'] = $member['checkuser'] == 1 ?' 4' : ''.$datac['regid'].'';
//echo $datac['groupid']; 
$datac['company'] = $data['nickname'];
$datac['username'] = $nameu;
$datac['password'] = $password;
$datac['cpassword'] = $password;
$datac['passport'] = $nameu;
$datac['truename'] = $data['nickname'];
$datac['nickname'] = $data['nickname'];
//$datac['groupid'] = '5';
$datac['catids'] = '111';
$datac['catid'] = '2';
$datac['catid'] = '2';
$datac['introduce'] = $data['nickname'];
$datac['content'] = $data['nickname'];
//$datac['province'] = $data['province'];
//$datac['city'] = $data['city'];
$datac['gender'] = $data['gender'];
$datac['baidu_openid'] = $data['baidu_openid'];
$datac['avatar'] = isset($data['avatar']) ? $data['avatar'] : 'errr';
$do = new member;
$user_id = $do->add($datac);
 $baidu_openid=$data['baidu_openid'];
	

	   
	    $result=$baidu_openid;
		
		
			 return self::DataReturn('添加成功', 0, $result);
       
	 
	   
    } 
	
	  
	 // 获取小程序手机号api 接口，对应下面小程序 js

public function getPhoneNumber()

{



//$encryptedData = I('get.encryptedData');

//$iv = I('get.iv');

//$this->sessionKey=I('get.session_key');
 $res = self::DecryptData($_POST['encryptedData'], $_POST['iv'], $_POST['openid']);
//$res = self::decryptData($encryptedData, $iv);

// $res = json_decode($res);
$openid=$_GET['openid'];
$phoneNumber=$res['phoneNumber'];

if($phoneNumber){

// $res->phoneNumbe 就是手机号可以 写入数据库或者做其他操作
$user=Db::get_one("SELECT username FROM ".AJ_PRE."member WHERE baidu_openid='$openid'");
$username=$user['username'];

  Db::query("UPDATE ".AJ_PRE."member SET  mobile='$phoneNumber',username='$phoneNumber',passport='$phoneNumber' where baidu_openid='$openid'");
   Db::query("UPDATE ".AJ_PRE."company SET username='$phoneNumber' where username='$username'");
   Db::query("UPDATE ".AJ_PRE."member_misc SET username='$phoneNumber' where username='$username'");

$content = '欢迎您注册,您的户名:'.$phoneNumber.',密码:12345678,请登录网站修改初始密码';
		
				$status =send_sms($phoneNumber, $content);


}

      return self::DataReturn('添加成功', 1, $res);
	 
//$this->ajaxReturn(['msg'=>$res,'status'=>'1']); //把手机号返回



}







	 /**
     * 用户unionid处理
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    private static function UserUnionidHandle($params = [])
    {
        // 用户unionid列表
        // 微信用户unionid
        $field = null;
        $value = null;
        $unionid_all = ['baidu_unionid', 'qq_unionid'];
        foreach($unionid_all as $unionid)
        {
            if(!empty($params[$unionid]))
            {
                $field = $unionid;
                $value = $params[$unionid];
                break;
            }
        }
        return ['field'=>$field, 'value'=>$value];
    }


}
?>