<?php
/**
 * 小程序接口定义
 *

 * @url 
 */


require '../../common.inc.php';
require AJ_ROOT.'/include/module.func.php';
class Response{
	public function result($list) {
		header('content-type:application/json;charset=utf-8');
		exit(json_encode($list));
	}
	
	
	 //用户登录
	 
    public function register(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		require AJ_ROOT.'/include/post.func.php';
		
		$this->table_member = AJ_PRE.'member';
		$this->table_member_misc = AJ_PRE.'member_misc';
		$this->table_member_check = AJ_PRE.'member_check';
		$this->table_company = AJ_PRE.'company';
		$this->table_company_data = AJ_PRE.'company_data';
		$val=json_decode(@file_get_contents("php://input"),true);
		$member['username'] = $val['mobile'];
		$member['passport'] = $val['mobile'];
		$member['mobile'] = $val['mobile'];
		$mobile = $val['mobile'];
		$ismobiles=DB::get_one("SELECT mobile FROM {$this->table_member} WHERE mobile='$mobile'");
		$ismobile=$ismobiles['mobile'];
		$password = $val['password'];
        $member['linkurl'] = userurl($member['username']);
		$member['groupid'] =5;
		$member['regid'] = 5;
		$member['passsalt'] = random(8);
		$member['paysalt'] = random(8);
		$member['password'] = dpassword($password, $member['passsalt']);
		$member['payword'] = dpassword($password, $member['paysalt']);
		$member['sound'] = 1;
		$member['letter'] = GetPinyin($member['company']);
		$member_fields = array('username','company','passport', 'password','payword','email','sound','gender','truename','mobile','qq','wx','wxqr','ali','skype','department','career','groupid','regid','areaid','edittime','inviter','passsalt', 'paysalt','companyid','oppid');
		$misc_fields = array('username','bank','banktype','branch','account','reply','black', 'send');
		$company_fields = array('username','groupid','company','type','catid','catids','areaid', 'mode','capital','regunit','size','regyear','sell','buy','business','telephone','fax','mail','gzh','gzhqr','address','postcode','homepage','introduce','thumb','keyword','linkurl','letter');
		$member_sqlk = $member_sqlv = $misc_sqlk = $misc_sqlv = $company_sqlk = $company_sqlv = '';
		foreach($member as $k=>$v) {
			if(in_array($k, $member_fields)) {$member_sqlk .= ','.$k; $member_sqlv .= ",'$v'";}
			if(in_array($k, $company_fields)) {$company_sqlk .= ','.$k; $company_sqlv .= ",'$v'";}
			if(in_array($k, $misc_fields)) {$misc_sqlk .= ','.$k; $misc_sqlv .= ",'$v'";}
		}
        $member_sqlk = substr($member_sqlk, 1);
		
        $member_sqlv = substr($member_sqlv, 1);
        $misc_sqlk = substr($misc_sqlk, 1);
        $misc_sqlv = substr($misc_sqlv, 1);
        $company_sqlk = substr($company_sqlk, 1);
        $company_sqlv = substr($company_sqlv, 1);
	if($ismobile) {
		$list = array('code' => 0,'msg'=>"手机号已注册") ;}
	else
	{
		
		DB::query("INSERT INTO {$this->table_member} ($member_sqlk,regip,regtime,loginip,logintime)  VALUES ($member_sqlv,'".AJ_IP."','".AJ_TIME."','".AJ_IP."','".AJ_TIME."')");
		$this->userid = DB::insert_id();
		if(!$this->userid) return 0;
		$member['userid'] = $this->userid;
		$this->username = $member['username'];
	    DB::query("INSERT INTO {$this->table_member_misc} (userid, $misc_sqlk) VALUES ('$this->userid', $misc_sqlv)");
	    DB::query("INSERT INTO {$this->table_company} (userid, $company_sqlk) VALUES ('$this->userid', $company_sqlv)");
		$content_table = content_table(4, $this->userid, is_file(AJ_CACHE.'/4.part'), $this->table_company_data);
	    DB::query("INSERT INTO {$content_table} (userid, content) VALUES ('$this->userid', '$member[content]')");
	
		
	    if($this->userid)
	   {
		  
		   $list = array('code' => 200,'msg'=>'注册成功');}
		   
		  
		
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
	   }
			return $this->result($list);
       
	 
	   
    }
	
	  	 //用户登录
    public function login(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
			require AJ_ROOT.'/include/post.func.php';
		$val=json_decode(@file_get_contents("php://input"),true);
         $username= $val['user_name'];
		  $login_password= $val['password'];
	   $r = $db->get_one("SELECT userid,username,mobile,truename,avatar,passsalt,password FROM {$AJ_PRE}member WHERE `username`='$username'");

	   if($username== $r['username'] && !empty($username) && $r['password'] == dpassword($login_password, $r['passsalt'])) 
	   {
		   $data = array('id'=>$r['userid'],'model'=>1,'user_name'=>$r['username'],'mobile'=>$r['mobile'],'nick_name'=>$r['truename']);
		   $list = array('code' => 200,'data'=>$data);}
	   else if($username!= $r['username'])
	   { $list = array('code' => 0,'msg'=>"用户不存在");
		  
	   }
	  
	   else if($r['password'] != dpassword($login_password, $r['passsalt'])) {
		   $list = array('code' => 0,'msg'=>"密码错误");
	   }
	  
			return $this->result($list);
       
	 
	   
    }
	
	  	 //用户退出
    public function logout(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$_userid;
		DB::query("DELETE FROM ".AJ_PRE."online WHERE userid=$_userid");
		set_cookie('auth', '');
		set_cookie('userid', '');
		set_cookie('username', '');
	
	     $list = array('code' => 200);
	    
			return $this->result($list);
       
	 
	   
    }
	
	
		 //用户信息
    public function info(){
		global $db, $AJ,$AJ_PRE;
       $id=$_GET["id"];
	   $r = $db->get_one("SELECT userid,username,mobile,truename,avatar,email,inviter,groupid FROM {$AJ_PRE}member WHERE userid='$id'");
	     $avatar = useravatar($r['username'], 'large');
		  $groupname = $r['groupid']==5 ? '个人' : '经纪人';
		 $data = array('id'=>$r['userid'],'user_name'=>$r['username'],'nick_name'=>$r['truename'],'mobile'=>$r['mobile'],'email'=>$r['email'],'inviter'=>$r['inviter'],'groupid'=>$r['groupid'],'avatar'=>$avatar );
		 $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list);
       
	 
	   
    }
		//二手房条件筛选
	public function second_attr(){
		global $db, $AJ;
	 $result =$db->query("SELECT areaid,areaname,parentid FROM {$db->pre}area where  parentid=0  ORDER BY listorder DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
		
			$results = $db->query("SELECT areaid,areaname,parentid FROM {$db->pre}area WHERE parentid=$areaid ORDER BY listorder DESC");
			$childlists=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				
				$cr['name'] =$cr['areaname'];	
			  $childlists[]= $cr;
			  		
			}
			 $childlist[]= $childlists;
			if($r['child']) $r['_child'] =$childlist;	
			
		    $citys[]= $r;	
		   }
	 $city = array('city' => $citys,'area'=>$childlist);

		
//户型条件筛选

//装修条件筛选
$zhuangxiu=array();
	
		$zhuangxiu = getbox_name('fix','sale_5');
		foreach($zhuangxiu as $key=>$v) {
  $fix['id'] =$key;	
$fix['name'] =$v;
$zhuangxiu[$key]= $fix;	
}
//装修条件筛选
$supporting=array();
	
		$peitao = getbox_name('peitao','sale_5');
		
		foreach($peitao as $key=>$v) {
  $peitao['id'] =$key;	
$peitao['name'] =$v;
$supporting[$key]= $peitao;	
}	

   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=5 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'renovation'=>$zhuangxiu,'house_type'=>$category,'supporting'=>$supporting,'acreage_unit'=>'㎡');
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }
	
	
	//小区
	 //新房列表
    public function xiaoqulist(){
		global $db, $AJ;
	    $pagesize = 10;
		 $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		 $table="{$db->pre}newhouse_6";
		 $condition="status=3  ";
		 if($keyword) $condition.= " and (title like '%$keyword%' or letter like '%$keyword%'  or pinyin like '%$keyword%')";


       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
     
		$result = $db->query("SELECT itemid,title,address,areaid FROM {$db->pre}newhouse_6 WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
				$r['id'] =$r['itemid'];
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	
	 	 //二手房发布
    public function save_second(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		 $id=$_GET["id"];
		$val=json_decode(@file_get_contents("php://input"),true);
        	$fields = array(
				'title' => $title,
				);
			//$fields = dhtmlspecialchars($fields);
		
			$keyword = $communityname.','.$price.','.$address.','.$area.',';
			//$title = $communityname.','.$area.'平米'.$price.$unit;
			$fields['title'] = $val['title'];
		    $fields['adddate'] = timetodate($AJ_TIME, 3);
			$fields['price'] = $val['price'];
			$fields['telephone'] = $val['contact_phone'];
			$fields['username'] = $val['username'];
			$fields['catid'] = $val['house_type'];
			$fields['areaid'] = $val['city'];
			$fields['map'] = $val['name'];
			$fields['address'] = $val['address'];
			$fields['truename'] = $val['contact_name'];
			$fields['mobile'] = $val['contact_phone'];
			$fields['room'] = $val['room'];
			$fields['hall'] = $val['living_room'];
			$fields['toilet'] = $val['toilet'];
			$fields['houseearm'] = $val['acreage'];
			$fields['housename'] = $val['estate_name'];
			$fields['houseid'] =$val['estate_id'];
			$fields['keyword'] = $val['title'];
			$fields['fix'] = $val['renovation'];
			$fields['floor1'] = $val['floor'];
			$fields['floor2'] = $val['total_floor'];
		   //$fields['thumb'] = $val['imgPrview'];
			$fields['peitao'] = $val['supporting'];
			$fields['typeid'] = 0;
			$fields['status'] = 2;
			$fields['ip'] = $AJ_IP;
			$fields['addtime'] = $AJ_TIME;
			//$fields['video'] = remove_quote($val['files']);	
				if($val['file'])
				{
			$preg = '/"url":[\"|\']?(.*?)[\"|\']/i';//匹配img标签的正则表达式
preg_match_all($preg, $val['file'], $allImg);//这里匹配所有的img
 $fields['thumb'] = array_shift($allImg[1]);
	$fields['thumbs'] = implode('|', $allImg[1]);
			
			}
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			$info = $val['info'];
			if($fields['title']){
			$db->query("INSERT INTO {$db->pre}sale_5 ($sqlk) VALUES ($sqlv)");
			$itemid = $db->insert_id();
		   $db->query("INSERT INTO {$db->pre}sale_data_5 (itemid,content) VALUES ('$itemid', '$info')");
		   $linkurl = 'show-'.$itemid.'.html';
			$db->query("UPDATE {$db->pre}sale_5 SET  linkurl='$linkurl' where itemid=$itemid");
			}
		
			
	    if($itemid)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
 	function remove_quote(&$str) {
        if (preg_match("/^\"/",$str)){
            $str = substr($str, 1, strlen($str) - 1);
        }
        //判断字符串是否以'"'结束
        if (preg_match("/\"$/",$str)){
            $str = substr($str, 0, strlen($str) - 1);;
        }
        return $str;
  }
		 //二手房编辑
    public function save_editsecond(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		
		$val=json_decode(@file_get_contents("php://input"),true);
		 $id=$val['id'];
		  
        	$this->split = $MOD['split'];
		$this->fields = array('catid','areaid','title','price','thumb','addtime','adddate','edittime','editdate','truename','telephone','mobile','housename','houseid','room','hall','fix','houseearm','floor1','floor2','toilet','thumbs','video');
			//$fields = dhtmlspecialchars($fields);
		
			$keyword = $communityname.','.$price.','.$address.','.$area.',';
			//$title = $communityname.','.$area.'平米'.$price.$unit;
			$fields['title'] = $val['title'];
		    $fields['adddate'] = timetodate($AJ_TIME, 3);
			$fields['price'] = $val['price'];
			$fields['telephone'] = $val['contact_phone'];
			$fields['username'] = $val['username'];
			$fields['catid'] = $val['house_type'];
			$fields['areaid'] = $val['city'];
			$fields['map'] = $val['name'];
			$fields['address'] = $val['address'];
			$fields['truename'] = $val['contact_name'];
			$fields['mobile'] = $val['contact_phone'];
			$fields['room'] = $val['room'];
			$fields['hall'] = $val['living_room'];
			$fields['toilet'] = $val['toilet'];
			$fields['houseearm'] = $val['acreage'];
			$fields['housename'] = $val['estate_name'];
			$fields['houseid'] =$val['estate_id'];
			$fields['keyword'] = $val['title'];
			$fields['fix'] = $val['renovation'];
			$fields['floor1'] = $val['floor'];
			$fields['floor2'] = $val['total_floor'];
		  // $fields['thumb'] = $val['imgPrview'];
			$fields['peitao'] = $val['supporting'];
	    // if($val['files'])	$fields['video'] =remove_quote($val['files']);
         
	        $salethumb = $db->get_one("SELECT thumbs FROM {$db->pre}sale_5 WHERE itemid=$id");
		       $photolist = get_thumbs($salethumb);
		   
				if($val['file'])
				{
			$preg = '/"url":[\"|\']?(.*?)[\"|\']/i';//匹配img标签的正则表达式
			
preg_match_all($preg, $val['file'], $allImg);//这里匹配所有的img
            $fields['thumb'] = $photolist[1];
	$photolists = array_merge($allImg[1], $photolist);	   
	$fields['thumbs'] = implode('|', $photolists);
			
			}	
			
		echo 	$fields['thumbs'];
			$fields['ip'] = $AJ_IP;
			$fields['addtime'] = $AJ_TIME;
			$info = $val['info'];
			
				$sql = '';
		foreach($fields as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
		
	    DB::query("UPDATE {$db->pre}sale_5 SET $sql WHERE itemid=$id");
		DB::query("REPLACE INTO {$db->pre}sale_data_5 (itemid,content) VALUES ('$id', '$info')");
	

		
		
	    if($id)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
	
	
		//二手房
	public function mysalelist(){
			global $db, $AJ,$MODULE;
	    $pagesize = 10;
		 $username=$_GET["username"];
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		    $id=$_GET["id"];
		 $username= $this->get_username($id);  
		 $table="{$db->pre}sale_5";
		$condition = "username='$username'";
		 if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		 if (isset($room) &&!empty($room))$condition.=" and `room` = '$room'";
		 if($renovation) $condition .= " AND FIND_IN_SET(".$renovation.",`fix`)" ;
	     if($type) $condition .= " AND FIND_IN_SET(".$type.",`catid`)" ;
		 if(isset($acreage) &&!empty($acreage))$condition .=$this->getsearchap($acreage,'houseearm',$AJ['salearea']); 
		 if(isset($price) &&!empty($price))$condition .=$this->getsearchap($price,'price',$AJ['saleprice']); 
		 $ARE = get_area($city);
         if($city) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$city";


       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
     
		$result = $db->query("SELECT title,itemid,price,thumb,adddate,room,hall,toilet,houseearm,status FROM $table WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			
			$r['status_name']  =  $r['status'] == 2 ? '审核' : '上架'; 
			$r['id']  =  $r['itemid'];
			$r['areaname'] =area_pos($r['areaid'], '');
			if (strpos($r['thumb'], '..')!== false) {
			    $r['thumb']=str_replace('../','',$r['thumb']);
	$r['thumb']=ltrim($r['thumb'], "/"); 
	$r['thumb']=$MODULE[1]['linkurl'].$r['thumb'];	
			}
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	
	//获取会员companyid
 public function get_username($userid) {
	global $db, $dc, $CFG;
	$user=DB::get_one("SELECT userid,username FROM ".AJ_PRE."member WHERE userid='$userid'");
      $username=$user['username'];
	return $username;
}

 public function uploadimg()
    {
		global $AJ, $dc, $CFG;
	require AJ_ROOT.'/include/image.class.php';

date_default_timezone_set("Asia/Shanghai"); //设置时区
$code = $_FILES['file'];//获取小程序传来的图片
$path = '../file/upload/'.timetodate($AJ_TIME, $AJ['uploaddir']).'/';

$path1 = 'file/upload/'.timetodate($AJ_TIME, $AJ['uploaddir']).'/';
is_dir(AJ_ROOT.'/'.$path1) or dir_create(AJ_ROOT.'/'.$path1);
$paths=AJ_ROOT.'/'.$path1;

if(is_uploaded_file($_FILES['file']['tmp_name'])) {  
    //把文件转存到你希望的目录（不要使用copy函数）  
    $uploaded_file=$_FILES['file']['tmp_name'];  
    $username = "min_img";
    //我们给每个用户动态的创建一个文件夹  
    $user_path=$paths;
     
    //判断该用户文件夹是否已经有这个文件夹  
    if(!file_exists($user_path)) { 
        mkdir($user_path,0777,true);
    }  
 
 
    $file_true_name=$_FILES['file']['name']; 
	  $type = strtolower(substr(strrchr($file_true_name, '.'), 1)); // 获取文件类型
	$pic_name = time().rand(10000, 99999); // 重命名图片
	
    $move_to_file=$user_path."/".$pic_name.substr($file_true_name,strrpos($file_true_name,"."));//strrops($file_true,".")查找“.”在字符串中最后一次出现的位置  
   
    if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {  
	 $pic_url = $path . $move_to_file; //上传后图片路径+名称
	 
    $pic_url = $path . $pic_name.".".$type; //上传后图片路径+名称
     if($AJ['ftp_remote'] && $AJ['remote_url']) {
						$pic_url=str_replace('../','',$pic_url);
						$picurl=str_replace('../','',$pic_url);
						 								
		        require AJ_ROOT.'/include/ftp.class.php';
		$ftp = new dftp($AJ['ftp_host'], $AJ['ftp_user'], $AJ['ftp_pass'], $AJ['ftp_port'], $AJ['ftp_path'], $AJ['ftp_pasv'], $AJ['ftp_ssl']);
		if($ftp->connected) {
			$exp = explode("file/upload/", $pic_url);
			$remote = $exp[1];
			if($ftp->dftp_put($pic_url, $remote)) {
				$pic_url = $AJ['remote_url'].$remote;
			}
	      $AJ['ftp_save'] or file_del(AJ_ROOT.'/'.$picurl);

		}
		
	}
	if($AJ['water_type']) {
					$image = new image($pic_url);
					if($AJ['water_type'] == 2) {
						$image->waterimage();
					} else if($AJ['water_type'] == 1) {
						$image->watertext();
					}
				}
	$data= array('url' => $pic_url,'title'=>'');
	 $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list);
			
	
 
    } else {  
        $list = array('code' => 400,'msg'=>"上传失败");
		
			return $this->result($list);
 
    }  
} else {  
    $list = array('code' => 400,'msg'=>"上传有误，清检查服务器配置！");
		
			return $this->result($list);
}  
       
    }
    
    //上传视频
    
    public function uploadvideo()
    {
		global $AJ, $dc, $CFG,$AJ_ROOT;
	

date_default_timezone_set("Asia/Shanghai"); //设置时区
$code = $_FILES['file'];//获取小程序传来的图片
$path = '../file/upload/'.timetodate($AJ_TIME, $AJ['uploaddir']).'/';

$path1 = 'file/upload/'.timetodate($AJ_TIME, $AJ['uploaddir']).'/';
is_dir(AJ_ROOT.'/'.$path1) or dir_create(AJ_ROOT.'/'.$path1);
$paths=AJ_ROOT.'/'.$path1;

if(is_uploaded_file($_FILES['file']['tmp_name'])) {  
    //把文件转存到你希望的目录（不要使用copy函数）  
    $uploaded_file=$_FILES['file']['tmp_name'];  
    $username = "min_img";
    //我们给每个用户动态的创建一个文件夹  
    $user_path=$paths;
     
    //判断该用户文件夹是否已经有这个文件夹  
    if(!file_exists($user_path)) { 
        mkdir($user_path,0777,true);
    }  
 
 
    $file_true_name=$_FILES['file']['name']; 
	  $type = strtolower(substr(strrchr($file_true_name, '.'), 1)); // 获取文件类型
	$pic_name = time().rand(10000, 99999); // 重命名图片
	
    $move_to_file=$user_path."/".$pic_name.substr($file_true_name,strrpos($file_true_name,"."));//strrops($file_true,".")查找“.”在字符串中最后一次出现的位置  
   
    if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {  
	 $pic_url = $path . $move_to_file; //上传后图片路径+名称
	 
    $pic_url = $path . $pic_name.".".$type; //上传后图片路径+名称
    
    
	
					
						$pic_url=str_replace('../','',$pic_url);
						$picurl=str_replace('../','',$pic_url); 								
		        require AJ_ROOT.'/include/ftp.class.php';
		$ftp = new dftp($AJ['ftp_host'], $AJ['ftp_user'], $AJ['ftp_pass'], $AJ['ftp_port'], $AJ['ftp_path'], $AJ['ftp_pasv'], $AJ['ftp_ssl']);
	
			$exp = explode("file/upload/", $pic_url);
			$remote = $exp[1];
		
				$pic_url = $AJ['remote_url'].$remote;
				$AJ['ftp_save'] or file_del(AJ_ROOT.'/'.$picurl);
			
	      

	
		


    
	$data= array('video' => $pic_url,'title'=>'');
	 $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list);
			
	
 
    } else {  
        $list = array('code' => 400,'msg'=>"上传失败");
		
			return $this->result($list);
 
    }  
} else {  
    $list = array('code' => 400,'msg'=>"上传有误，清检查服务器配置！");
		
			return $this->result($list);
}  
       
    }
	
	 //编辑二手房
    public function read_second(){
	global $db, $AJ,$MODULE;
	   	  $itemid = $_GET['id'];
		 
		 $table="{$db->pre}sale_5";
		
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
		
		$map=  $data['map'];
//	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
	 $data['create_time'] =timetodate($data['addtime'], 5);
	 $areaid =$data['areaid'];
	  $city = $db->get_one("SELECT areaid,arrparentid FROM {$db->pre}area where areaid=$areaid  ORDER BY listorder DESC");
	  
	  $citys = substr($city['arrparentid'],2);
	  $citys  = $citys ? $citys : 0;
	$citys .=','.$data['areaid'];
	$saleprice=array();
		$saleprice = explode(',', trim($citys));
	
		//$data['orientations']=getbox_diaoval('toward','checkbox',$data['toward'],'sale_5');
		//$data['renovation']=getbox_diaoval('fix','checkbox',$data['fix'],'sale_5');
		$data['average_price']=floor($data['price']*10000/$data['houseearm']);
		$data['sale_status'] = $TYPE[$data['typeid']];
		$data['typeid'] = $data['typeid']+1;
		//$data['city'] =area_pos($data['areaid'], '');
		$data['city'] =$data['areaid'];
		$data['id'] =$data['itemid'];
		$data['estate_name'] =$data['housename'];
		$data['estate_id'] =$data['houseid'];
		$data['city_ids'] =$saleprice;
		$data['house_type'] =$data['catid'];
		$data['renovation'] =$data['fix'];
		$data['acreage'] =$data['houseearm'];
		$data['contact_name'] =$data['truename'];
		$data['contact_phone'] =$data['mobile'];
		$data['living_room'] =$data['hall'];
	      $data['floor'] = $data['floor1'];
		$data['total_floor'] = $data['floor2'];
	
		

		$t = $db->get_one("SELECT content FROM {$db->pre}sale_data_5 WHERE itemid=$itemid");
       $data['info'] =$t['content'];
	  

	//房源图片
$photolist=array();
       $photolist = get_albums($data);
     
		 $data['photo_total'] =count($photolist);
	
		foreach($photolist as $key=>$v) {
  $photo['id'] =$key;
  if(strpos($v,'../') !== false){ 
  $v=str_replace('../','',$v);
	$v=ltrim($v, "/"); 
	$v=$MODULE[1]['linkurl'].$v;
  }
$photo['thumb'] =$v;
$photolists[]= $photo;	
}		
		
			
	 $data['file'] = $photolists;
		//$data['latitude'] =$x;
		 // $data['longitude'] =$y;	
		 
	
		
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	   
    }
	
	 //编辑资料
    public function save_info(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		 $id=$_GET['id'];
		$val=json_decode(@file_get_contents("php://input"),true);
		
        	
		$this->fields = array('email','truename','mobile','mobile','inviter','groupid');
		
			$fields['truename'] = $val['nick_name'];
			$fields['mobile'] = $val['mobile'];
			$fields['email'] = $val['email'];
			$fields['inviter'] = $val['inviter'];
			$fields['groupid'] =7;
		
		
			
				$sql = '';
		foreach($fields as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
		
	    DB::query("UPDATE {$db->pre}member SET $sql WHERE userid=$id");

	    if($id)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
	 //绑定pc账户
    public function update_info(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		 $id=$_GET['id'];
		$val=json_decode(@file_get_contents("php://input"),true);
		
		
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
			require AJ_ROOT.'/include/post.func.php';
		$val=json_decode(@file_get_contents("php://input"),true);
         $username= $val['user_name'];
		  $login_password= $val['password'];
	   $r = $db->get_one("SELECT userid,username,mobile,truename,avatar,passsalt,password FROM {$AJ_PRE}member WHERE `username`='$username'");
        $user=Db::get_one("SELECT weixin_openid,avatar FROM ".AJ_PRE."member WHERE userid='$id'");
		
          $weixin_openid=$user['weixin_openid'];
		   $avatar=$user['avatar'];
	   if($username== $r['username'] && !empty($username) && $r['password'] == dpassword($login_password, $r['passsalt'])) 
	   {
		  
		   Db::query("UPDATE {$db->pre}member SET weixin_openid='$weixin_openid',avatar='$avatar' where `username`='$username'");
		 // DB::query("DELETE FROM ".AJ_PRE."member WHERE userid='$id'");
		 //  DB::query("DELETE FROM ".AJ_PRE."member_misc WHERE userid='$id'");
		 // DB::query("DELETE FROM ".AJ_PRE."member_check WHERE userid='$id'");
		 //  DB::query("DELETE FROM ".AJ_PRE."company WHERE userid='$id'");
			// DB::query("DELETE FROM ".AJ_PRE."company_data WHERE userid='$id'");
		   $list = array('code' => 200,'msg'=>"绑定成功");}
	   else if($username!= $r['username'])
	   { $list = array('code' => 0,'msg'=>"用户不存在");
		  
	   }
	  
	   else if($r['password'] != dpassword($login_password, $r['passsalt'])) {
		   $list = array('code' => 0,'msg'=>"密码错误");
	   }
		
	

  
   
        	
		

			return $this->result($list);
       
	 
	   
    }
	
	//租房列表
	
		
	public function myrentlist(){
			global $db, $AJ;
	    $pagesize = 10;
		 $username=$_GET["username"];
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		    $id=$_GET["id"];
		 $username= $this->get_username($id);  
		 $table="{$db->pre}rent_7";
		$condition = "username='$username'";
		 if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
	
		 $ARE = get_area($city);
         if($city) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$city";


       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
     
		$result = $db->query("SELECT title,itemid,price,thumb,adddate,room,hall,toilet,houseearm,status FROM $table WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			
			$r['status_name']  =  $r['status'] == 2 ? '审核' : '上架'; 
			$r['id']  =  $r['itemid'];
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	
	//租房信息
    public function read_rent(){
		global $db, $AJ;
	   	  $itemid = $_GET['id'];
		 
		 $table="{$db->pre}rent_7";
		
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
		
		$map=  $data['map'];
	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
	 $data['create_time'] =timetodate($data['addtime'], 5);
	 $areaid =$data['areaid'];
	  $city = $db->get_one("SELECT areaid,arrparentid FROM {$db->pre}area where areaid=$areaid  ORDER BY listorder DESC");
	  
	  $citys = substr($city['arrparentid'],2);
	  $citys  = $citys ? $citys : 0;
	$citys .=','.$data['areaid'];
	$saleprice=array();
		$saleprice = explode(',', trim($citys));
	
		$data['sale_status'] = $TYPE[$data['typeid']];
		$data['typeid'] = $data['typeid']+1;
		
		$data['city'] =$data['areaid'];
		$data['id'] =$data['itemid'];
		$data['estate_name'] =$data['housename'];
		$data['estate_id'] =$data['houseid'];
		$data['city_ids'] =$saleprice;
		$data['house_type'] =$data['catid'];
		$data['renovation'] =$data['zhuanxiu'];
		$data['acreage'] =$data['houseearm'];
		$data['contact_name'] =$data['truename'];
		$data['contact_phone'] =$data['mobile'];
		$data['living_room'] =$data['hall'];
	      $data['floor'] = $data['floor1'];
		$data['total_floor'] = $data['floor2'];
	
		

		$t = $db->get_one("SELECT content FROM {$db->pre}rent_data_7 WHERE itemid=$itemid");
       $data['info'] =$t['content'];

	//房源图片
$photolist=array();
       $photolist = get_albums($data);
     
		 $data['photo_total'] =count($photolist);
	
		foreach($photolist as $key=>$v) {
  $photo['id'] =$key;
  if(strpos($v,'../') !== false){ 
  $v=str_replace('../','',$v);
	$v=ltrim($v, "/"); 
	//$v=$MODULE[1]['linkurl'].$v;
  }
$photo['thumb'] =$v;
$photolists[]= $photo;	
}		
		
			
	 $data['file'] = $photolists;
		 
		
		
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	   
    }
		//租房条件筛选
	public function rent_attr(){
		global $db, $AJ;
	 $result =$db->query("SELECT areaid,areaname,parentid FROM {$db->pre}area where  parentid=0  ORDER BY listorder DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
		
			$results = $db->query("SELECT areaid,areaname,parentid FROM {$db->pre}area WHERE parentid=$areaid ORDER BY listorder DESC");
			$childlists=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				
				$cr['name'] =$cr['areaname'];	
			  $childlists[]= $cr;
			  		
			}
			 $childlist[]= $childlists;
			if($r['child']) $r['_child'] =$childlist;	
			
		    $citys[]= $r;	
		   }
	 $city = array('city' => $citys,'area'=>$childlist);

		
//户型条件筛选

//装修条件筛选
$zhuangxiu=array();
	
		$zhuangxiu = getbox_name('zhuanxiu','rent_7');
		foreach($zhuangxiu as $key=>$v) {
  $fix['id'] =$key;	
$fix['name'] =$v;
$zhuangxiu[$key]= $fix;	
}
//装修条件筛选
$supporting=array();
	
		$peitao = getbox_name('peitaor','rent_7');
		
		foreach($peitao as $key=>$v) {
  $peitao['id'] =$key;	
$peitao['name'] =$v;
$supporting[$key]= $peitao;	
}	

   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=7 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'renovation'=>$zhuangxiu,'house_type'=>$category,'supporting'=>$supporting,'acreage_unit'=>'㎡');
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }
	
	 //租房发布
    public function save_rent(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		 $id=$_GET["id"];
		$val=json_decode(@file_get_contents("php://input"),true);
        	$fields = array(
				'title' => $title,
				);
			//$fields = dhtmlspecialchars($fields);
		
			$keyword = $communityname.','.$price.','.$address.','.$area.',';
			//$title = $communityname.','.$area.'平米'.$price.$unit;
			$fields['title'] = $val['title'];
		    $fields['adddate'] = timetodate($AJ_TIME, 3);
			$fields['price'] = $val['price'];
			$fields['telephone'] = $val['contact_phone'];
			$fields['username'] = $val['username'];
			$fields['catid'] = $val['house_type'];
			$fields['areaid'] = $val['city'];
			$fields['map'] = $val['name'];
			$fields['address'] = $val['address'];
			$fields['truename'] = $val['contact_name'];
			$fields['mobile'] = $val['contact_phone'];
			$fields['room'] = $val['room'];
			$fields['hall'] = $val['living_room'];
			$fields['toilet'] = $val['toilet'];
			$fields['houseearm'] = $val['acreage'];
			$fields['housename'] = $val['estate_name'];
			$fields['houseid'] =$val['estate_id'];
			$fields['keyword'] = $val['title'];
			$fields['zhuanxiu'] = $val['renovation'];
			$fields['floor1'] = $val['floor'];
			$fields['floor2'] = $val['total_floor'];
		 
			$fields['peitaor'] = $val['supporting'];
			$fields['typeid'] = 0;
			$fields['status'] = 2;
			$fields['ip'] = $AJ_IP;
			$fields['addtime'] = $AJ_TIME;
			//$fields['video'] = remove_quote($val['files']);	
				if($val['file'])
				{
			$preg = '/"url":[\"|\']?(.*?)[\"|\']/i';//匹配img标签的正则表达式
preg_match_all($preg, $val['file'], $allImg);//这里匹配所有的img
 $fields['thumb'] = array_shift($allImg[1]);
	$fields['thumbs'] = implode('|', $allImg[1]);
			
			}
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			$info = $val['info'];
			if($fields['title']){
			$db->query("INSERT INTO {$db->pre}rent_7 ($sqlk) VALUES ($sqlv)");
			$itemid = $db->insert_id();
		   $db->query("INSERT INTO {$db->pre}rent_data_7 (itemid,content) VALUES ('$itemid', '$info')");
		   $linkurl = 'show-'.$itemid.'.html';
			$db->query("UPDATE {$db->pre}rent_7 SET  linkurl='$linkurl' where itemid=$itemid");
			}
		
			
			
	    if($itemid)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
	
		 //租房编辑
    public function save_editrent(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		
		$val=json_decode(@file_get_contents("php://input"),true);
		 $id=$val['id'];
        	
		$this->fields = array('catid','areaid','title','price','thumb','addtime','adddate','edittime','editdate','truename','telephone','mobile','housename','houseid','room','hall','zhuanxiu','houseearm','floor1','floor2','toilet','thumbs');
			//$fields = dhtmlspecialchars($fields);
		
			$keyword = $communityname.','.$price.','.$address.','.$area.',';
			//$title = $communityname.','.$area.'平米'.$price.$unit;
			$fields['title'] = $val['title'];
		    $fields['adddate'] = timetodate($AJ_TIME, 3);
			$fields['price'] = $val['price'];
			$fields['telephone'] = $val['contact_phone'];
			$fields['username'] = $val['username'];
			$fields['catid'] = $val['house_type'];
			$fields['areaid'] = $val['city'];
			$fields['map'] = $val['name'];
			$fields['address'] = $val['address'];
			$fields['truename'] = $val['contact_name'];
			$fields['mobile'] = $val['contact_phone'];
			$fields['room'] = $val['room'];
			$fields['hall'] = $val['living_room'];
			$fields['toilet'] = $val['toilet'];
			$fields['houseearm'] = $val['acreage'];
			$fields['housename'] = $val['estate_name'];
			$fields['houseid'] =$val['estate_id'];
			$fields['keyword'] = $val['title'];
			$fields['zhuanxiu'] = $val['renovation'];
			$fields['floor1'] = $val['floor'];
			$fields['floor2'] = $val['total_floor'];
		 
			$fields['peitao'] = $val['supporting'];
			// if($val['files'])	$fields['video'] =remove_quote($val['files']);
         
	        $salethumb =$db->get_one("SELECT thumbs FROM {$db->pre}rent_7 WHERE itemid=$id");
	       
		      $photolist = get_thumbs($salethumb);
		 
				if($val['file'])
				{
			$preg = '/"url":[\"|\']?(.*?)[\"|\']/i';//匹配img标签的正则表达式
			
preg_match_all($preg, $val['file'], $allImg);//这里匹配所有的img
            $fields['thumb'] = $photolist[1];
	 
$photolists = array_merge($allImg[1], $photolist);
$fields['thumbs'] = implode('|', $photolists);
			
			}	
	
			$fields['ip'] = $AJ_IP;
			$fields['addtime'] = $AJ_TIME;
			$info = $val['info'];
			
				$sql = '';
		foreach($fields as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
		
	    DB::query("UPDATE {$db->pre}rent_7 SET $sql WHERE itemid=$id");
		DB::query("REPLACE INTO {$db->pre}rent_data_7 (itemid,content) VALUES ('$id', '$info')");

	
		
		
	    if($id)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
	
	
	
	 //二手房删除
    public function delete(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		
		$val=json_decode(@file_get_contents("php://input"),true);
		 $id=$val['id'];
    
		DB::query("DELETE FROM {$db->pre}sale_5 WHERE itemid=$id");
		DB::query("DELETE FROM {$db->pre}sale_data_5 WHERE itemid=$id");
		DB::query("DELETE FROM {$db->pre}sale_search_5 WHERE itemid=$id");
	
		
	    if($id)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	 //租房删除
    public function rentdelete(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		
		$val=json_decode(@file_get_contents("php://input"),true);
		 $id=$val['id'];
    
		DB::query("DELETE FROM {$db->pre}rent_7 WHERE itemid=$id");
		DB::query("DELETE FROM {$db->pre}rent_data_7 WHERE itemid=$id");
		DB::query("DELETE FROM {$db->pre}rent_search_7 WHERE itemid=$id");
	
		
	    if($id)
	   {
		  
		   $list = array('code' => 200,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
	 //编辑资料
    public function save_broker(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		 $id=$_GET['id'];
		$val=json_decode(@file_get_contents("php://input"),true);
		
        	
		$this->fields = array('groupid','xiaoqu');
		
			$fields['xiaoqu'] = $val['xiaoqu'];
			$fields['groupid'] = 6;
			
		
		
			
				$sql = '';
		foreach($fields as $k=>$v) {
			if(in_array($k, $this->fields)) $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
		
	    DB::query("UPDATE {$db->pre}member SET $sql WHERE userid=$id");

	    if($id)
	   {
		  
		   $list = array('code' => 200,'msg'=>'升级成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
 
   
  
	
	
	  //20220920增加
     //部门发布
    public  function save_bumen(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		
		$val=json_decode(@file_get_contents("php://input"),true);
        	$fields = array(
				'bumenname' => $bumenname,
				);
			
			
			$fields['bumenname'] = $val['bumenname'];
		   
			$fields['address'] = $val['address'];
		//$fields['parentid'] = $val['parentid'];
			$fields['arrparentid'] = $val['arrparentid'];
			$fields['child'] = $val['child'];
			$fields['arrchildid'] = $val['arrchildid'];
			$fields['areaid'] = $val['city'];
			$fields['companyid'] = $val['companyid'];
	
			$fields['status'] = 2;
			$fields['parentid'] = empty($val['parentidtwo']) ? $val['parentid'] : $val['parentidtwo'];
				
				
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			
			if($fields['bumenname']){
			$db->query("INSERT INTO {$db->pre}bumen ($sqlk) VALUES ($sqlv)");
			$bumenid = $db->insert_id();
		if($fields['parentid']) {
			$fields['bumenid'] = $bumenid;
			$this->bumen[$bumenid] = $bumen;
			$arrparentid = $this->get_arrparentid($bumenid, $this->bumen);
		} else {
			$arrparentid = 0;
		}
		DB::query("UPDATE {$this->table} SET arrchildid='$bumenid',listorder=$bumenid,arrparentid='$arrparentid' WHERE bumenid=$bumenid");
	 
			}
			 self::repair();
		
			
	    if($bumenid)
	   {
		  
		   $list = array('code' => 200,'msg'=>'添加成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	
	
	
	
	
	
		//部门列表
	public function bumenlist(){
			global $db, $AJ,$MODULE;
	    $pagesize = 10;
		 $companyid=$_GET["companyid"];
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		   // $id=$_GET["id"];
		    
		 $username= $this->get_username($id);  
		 $table="{$db->pre}bumen";
		$condition = "companyid='$companyid'";
	
		

       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
    
		$result = $db->query("SELECT * FROM $table WHERE  $condition  ORDER BY bumenid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			
			$r['status_name']  =  $r['status'] == 2 ? '审核' : '上架'; 
			$r['id']  =  $r['bumenid'];
		
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
    
	//部门分类
	public function bumen_cat($id){
		global $db, $AJ;
		$companyid=$_GET["companyid"];
	
		$bumenlist = array();
	 $result =$db->query("SELECT bumenid,bumenname,child FROM {$db->pre}bumen where  parentid=0 and companyid=$companyid  ORDER BY listorder DESC");

		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['bumenname'];	
			$r['id'] =$r['bumenid'];
			$r['child'] =$r['child'];
			$r['level'] =1;
			 $bumenlist[]= $r;	
	    
		}

	 
		  $bumen = array('msg' => 'success','code' => 0, 'data'=>$bumenlist);
			return $this->result($bumen);
      
    }
	//部门子分类
	public function bumen_cattwo(){
		global $db, $AJ;
		$companyid=$_GET["companyid"];
		 $id=$_POST["pid"];
		$bumenlist = array();
	 $result =$db->query("SELECT bumenid,bumenname FROM {$db->pre}bumen where  parentid=$id and companyid=$companyid ORDER BY listorder DESC");
	
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['bumenname'];	
			$r['id'] =$r['bumenid'];
			$r['level'] =2;
			 $bumenlist[]= $r;	
	    
		}

	   $errno = $bumenlist ? 0 : 1;
	   $msg = $bumenlist ? 'success' : 'fail';
		  $bumen = array('msg' => $msg,'code' =>$errno, 'data'=>$bumenlist);
			return $this->result($bumen);
      
    }
	
	//部门筛选
	public function bumen_attr($id){
		global $db, $AJ;
	 $result =$db->query("SELECT areaid,areaname,parentid FROM {$db->pre}area where  parentid=0  ORDER BY listorder DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
		
			$results = $db->query("SELECT areaid,areaname,parentid FROM {$db->pre}area WHERE parentid=$areaid ORDER BY listorder DESC");
			$childlists=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				
				$cr['name'] =$cr['areaname'];	
			  $childlists[]= $cr;
			  		
			}
			 $childlist[]= $childlists;
			if($r['child']) $r['_child'] =$childlist;	
			
		    $citys[]= $r;	
		   }
	 $city = array('city' => $citys,'area'=>$childlist);


   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=$id ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'house_type'=>$category);
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }
	
	
	
	function repair() {		
	global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		$query = DB::query("SELECT * FROM {$db->pre}bumen ORDER BY listorder,bumenid");
		
		$AREA = array();
		while($r = DB::fetch_array($query)) {
			$AREA[$r['bumenid']] = $r;
		}
		$childs = array();
		foreach($AREA as $bumenid => $area) {
			$arrparentid = $this->get_arrparentid($bumenid, $AREA);
			DB::query("UPDATE {$db->pre}bumen SET arrparentid='$arrparentid' WHERE bumenid=$bumenid");
			if($arrparentid) {
				$arr = explode(',', $arrparentid);
				foreach($arr as $a) {
					if($a == 0) continue;
					isset($childs[$a]) or $childs[$a] = '';
					$childs[$a] .= ','.$bumenid;
				}
			}
		}
		foreach($AREA as $bumenid => $area) {
			if(isset($childs[$bumenid])) {
				$arrchildid = $bumenid.$childs[$bumenid];
				DB::query("UPDATE {$db->pre}bumen SET arrchildid='$arrchildid',child=1 WHERE bumenid='$bumenid'");
			} else {
				DB::query("UPDATE {$db->pre}bumen SET arrchildid='$bumenid',child=0 WHERE bumenid='$bumenid'");
			}
		}
		//echo "UPDATE {$db->pre}bumen SET arrchildid='$bumenid',child=0 WHERE bumenid='$bumenid'";
        return true;
	}
	
    function get_arrparentid($bumenid, $AREA) {
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		if($AREA[$bumenid]['parentid'] && $AREA[$bumenid]['parentid'] != $bumenid) {
			$parents = array();
			$aid = $bumenid;
			while($bumenid) {
				if($AREA[$aid]['parentid']) {
					$parents[] = $aid = $AREA[$aid]['parentid'];
				} else {
					break;
				}
			}
			$parents[] = 0;
			return implode(',', array_reverse($parents));
		} else {
			return '0';
		}
	}

	function get_arrchildid($bumenid, $AREA) {
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		$arrchildid = '';
		foreach($AREA as $bumen) {
			if(strpos(','.$post['arrparentid'].',', ','.$bumenid.',') !== false) $arrchildid .= ','.$post['bumenid'];
		}
		return $arrchildid ? $bumenid.$arrchildid : $bumenid;
	}
	  //20220922增加
     //经纪人发布
    public  function save_broken(){
	  	global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		require AJ_ROOT.'/include/post.func.php';
		
		
        	$fields = array(
				'username' => $username,
				);
			
			
		
		   
		 
		
		$this->table_member = AJ_PRE.'member';
		$this->table_member_misc = AJ_PRE.'member_misc';
		$this->table_member_check = AJ_PRE.'member_check';
		$this->table_company = AJ_PRE.'company';
		$this->table_company_data = AJ_PRE.'company_data';
		$val=json_decode(@file_get_contents("php://input"),true);
		$member['username'] = $val['username'];
		$member['passport'] = $val['username'];
		$member['company'] = $val['truename'];
		$member['mobile'] = $val['mobile'];
		$member['truename'] = $val['truename'];
		$mobile = $val['mobile'];
		$member['areaid'] = $val['city'];
		$member['companyid'] = $val['companyid'];
		$member['bumenid'] = empty($val['parentidtwo']) ? $val['parentid'] : $val['parentidtwo'];
		$member['role'] = $val['role'];
		$ismobiles=DB::get_one("SELECT mobile FROM {$this->table_member} WHERE mobile='$mobile'");
		$ismobile=$ismobiles['mobile'];
		$password = $val['password'];
        $member['linkurl'] = userurl($member['username']);
		$member['groupid'] =6;
		$member['regid'] = 6;
		$member['passsalt'] = random(8);
		$member['paysalt'] = random(8);
		$member['password'] = dpassword($password, $member['passsalt']);
		$member['payword'] = dpassword($password, $member['paysalt']);
		$member['sound'] = 1;
		$member['letter'] = GetPinyin($member['company']);
		$member_fields = array('username','company','passport', 'password','payword','email','sound','gender','truename','mobile','role','wx','wxqr','ali','department','career','groupid','regid','areaid','edittime','inviter','passsalt', 'paysalt','companyid','bumenid');
		$misc_fields = array('username','bank','banktype','branch','account','reply','black', 'send');
		$company_fields = array('username','groupid','company','type','catid','catids','areaid', 'mode','capital','regunit','size','regyear','sell','buy','business','telephone','fax','mail','gzh','gzhqr','address','postcode','homepage','introduce','thumb','keyword','linkurl','letter');
		$member_sqlk = $member_sqlv = $misc_sqlk = $misc_sqlv = $company_sqlk = $company_sqlv = '';
		foreach($member as $k=>$v) {
			if(in_array($k, $member_fields)) {$member_sqlk .= ','.$k; $member_sqlv .= ",'$v'";}
			if(in_array($k, $company_fields)) {$company_sqlk .= ','.$k; $company_sqlv .= ",'$v'";}
			if(in_array($k, $misc_fields)) {$misc_sqlk .= ','.$k; $misc_sqlv .= ",'$v'";}
		}
        $member_sqlk = substr($member_sqlk, 1);
		
        $member_sqlv = substr($member_sqlv, 1);
        $misc_sqlk = substr($misc_sqlk, 1);
        $misc_sqlv = substr($misc_sqlv, 1);
        $company_sqlk = substr($company_sqlk, 1);
        $company_sqlv = substr($company_sqlv, 1);
	if($ismobile) {
		$list = array('code' => 0,'msg'=>"手机号已注册") ;}
	else
	{
		
		DB::query("INSERT INTO {$this->table_member} ($member_sqlk,regip,regtime,loginip,logintime)  VALUES ($member_sqlv,'".AJ_IP."','".AJ_TIME."','".AJ_IP."','".AJ_TIME."')");
		$this->userid = DB::insert_id();
		if(!$this->userid) return 0;
		$member['userid'] = $this->userid;
		$this->username = $member['username'];
	    DB::query("INSERT INTO {$this->table_member_misc} (userid, $misc_sqlk) VALUES ('$this->userid', $misc_sqlv)");
	    DB::query("INSERT INTO {$this->table_company} (userid, $company_sqlk) VALUES ('$this->userid', $company_sqlv)");
		$content_table = content_table(4, $this->userid, is_file(AJ_CACHE.'/4.part'), $this->table_company_data);
	    DB::query("INSERT INTO {$content_table} (userid, content) VALUES ('$this->userid', '$member[content]')");
	
		
	    if($this->userid)
	   {
		  
		   $list = array('code' => 200,'msg'=>'注册成功');}
		   
		  
		
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
	   }
			return $this->result($list);
       
		
	 
	   
    }
	
	
	
	
	
	
		//经纪人列表
	public function brokenlist(){
			global $db, $AJ,$MODULE;
	    $pagesize = 10;
		 $companyid=$_GET["companyid"];
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		   // $id=$_GET["id"];
		    
		 $username= $this->get_username($id);  
		 $table="{$db->pre}member";
		$condition = "companyid='$companyid'";
	
		

       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
    
		$result = $db->query("SELECT * FROM $table WHERE  $condition  ORDER BY userid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			
			
			$r['id']  =  $r['userid'];
		
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
}