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
	 //新房列表
    public function houselist(){
		
		global $db, $AJ;
		
	    $pagesize = 10;
		 $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		 $table="{$db->pre}newhouse_6";
		 $condition="status=3  and isnew=1 ";
		 if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		   $special = $_GET['special'];
			 $price = $_GET['price'];
			 $sort = $_GET['sort'];
			 $city = $_GET['city'];
			 $type = $_GET['type'];
			 $renovation = $_GET['renovation'];
			  if (isset($status) &&!empty($status))$condition.=" and `typeid` = '$status'";
		 if($renovation) $condition .= " AND FIND_IN_SET(".$renovation.",`fitment`)" ;
		 if($special) $condition .= " AND FIND_IN_SET(".$special.",`special`)" ;
	     if($type) $condition .= " AND FIND_IN_SET(".$type.",`catid`)" ;
		
		 if(isset($price) &&!empty($price))$condition .=$this->getsearchap($price,'price',$AJ['houseprice']); 
		 $ARE = get_area($city);
         if($city) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$city";

		if($sort)
	{
		
			if($sort=='1')
		{
			$order=" order by price asc";
		}
		elseif($sort=='2')
		{
			$order=" order by price desc";
		}
		elseif($sort=='3')
		{
			$order=" order by selltime asc";
		}
		elseif($sort=='4')
		{
			$order="order by selltime desc";
		}
		
		
		
	}
	else
	{
		$order = " ORDER BY itemid DESC";
	
	}
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
      $TYPE = explode('|', trim('待售|在售|尾盘|售完'));
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_6 WHERE  $condition  $order LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$r['catname'] = search_cats($r['catid'],6);
			$r['typename'] = $TYPE[$r['typeid']-1];
			$r['buildtype'] =getbox_val('buildtype','checkbox',$r['buildtype'],'newhouse_6');
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	 //新房详情
	 public function gethouse(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id'];
		 
		 $table="{$db->pre}newhouse_6";
		
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
		//
		$map=  $data['map'];
	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
		$TYPE = explode('|', trim('待售|在售|尾盘|售完'));
		$data['sale_status'] = $TYPE[$data['typeid']-1];
		$data['areaname'] =area_pos($data['areaid'], '');
		$data['pano_url'] =base64_encode($data['quanjing']);
		
		$data['id'] =$data['itemid'];
if($map){
$map_mid = $map;
}else{
$map_mid=$AJ['map_mid'];}
$map_mid=$this->baiduttx($map_mid);

$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['1'];
		   $y=$map['0']; 
		}
		$t = $db->get_one("SELECT content FROM {$db->pre}newhouse_data_6 WHERE itemid=$itemid");
       $data['info'] =$t['content'];
	   $picnum = $db->get_one("SELECT COUNT(*) AS num FROM {$db->pre}newhouse_xiangce    where houseid=$itemid ");
	    $data['photo_total'] =$picnum['num'];
	   $photolist = array();
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_xiangce WHERE  houseid=$itemid  ORDER BY itemid DESC ");
		while($r = $db->fetch_array($result)) {
			$r['catname'] = search_cats($r['catid'],12);
			$photolist[] = $r;
			
		}	
	 $data['photo'] = $photolist;
	 
	 //关联资讯
	 $newslist = array();
		$result = $db->query("SELECT * FROM {$db->pre}article_8 WHERE  houseid=$itemid  ORDER BY itemid DESC ");
		while($r = $db->fetch_array($result)) {
			 $r['introduce'] =dsubstr($r[introduce], 50, $suffix = '.....');
			$newslist[] = $r;
			
		}	
	 $data['topNews'] = $newslist;
	 
	  //关联户型
	 $huxinglist = array();
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_huxing WHERE  houseid=$itemid  ORDER BY itemid DESC ");
		while($r = $db->fetch_array($result)) {
			
			$huxinglist[] = $r;
			
		}	
	 $data['room'] = $huxinglist;
	 
		
		  $data['latitude'] =$x;
		  $data['longitude'] =$y;
	
	 
		 header('content-type:application/json;charset=utf-8');
		 
		  $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list);
			
       
	 
	   
    }
	//预留提交信息
	public function subscribe(){
		
		global $db, $AJ;
		 $table="{$db->pre}newhouse_6";
		$itemid = $_GET['id'];
        $data = $db->get_one("SELECT itemid,title FROM $table WHERE itemid=$itemid");
		$data['id'] =$data['itemid'];
		$data['title'] =$data['title'];
		  $list = array('code' => 200,'data'=>$data,'send_sms'=>0,'token'=>'');
		
			return $this->result($list);
		
	}
	//预留提交信息
	public function subscribedata(){
		global $db, $AJ;

$mobile=$_GET['mobile'];
$truename=$_GET['user_name'];
$title=$_GET['title'];
$addtime=time();
$username=$_username ? $_username : '游客';
$content='通过小程序提交信息'.$_GET['title'];
if(!empty($mobile) && !empty($truename)){
$db->query("UPDATE {$db->pre}member SET message=message+1 WHERE username='$touser'");
  $db->query("INSERT INTO {$db->pre}message (title,typeid,touser,fromuser,content,addtime,ip,status,telephone,truename,sex,email,linkurl) VALUES ('$title', 1,'$touser','$fromuser','$content','$addtime','$AJ_IP',3,'$mobile','$truename','$sex','$email','$linkurl')");
}
		
	 $errno = $mobile ? 200 : 0;
		 $msg = $mobile ? '提交成功' : '参数错误';
		
		  $list = array('code' =>$errno,'msg'=>$msg,);
		
			return $this->result($list);
		
	}
	//二手房
	public function salelist(){
			global $db, $AJ;
	    $pagesize = 10;
		
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		     $room = $_GET['room'];
			 $price = $_GET['price'];
			 $acreage = $_GET['acreage'];
			 $sort = $_GET['sort'];
			 $city = $_GET['city'];
			 $type = $_GET['type'];
			 $renovation = $_GET['renovation'];
		 $table="{$db->pre}sale_5";
		 $condition="status=3  ";
		 if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		 if (isset($room) &&!empty($room))$condition.=" and `room` = '$room'";
		 if($renovation) $condition .= " AND FIND_IN_SET(".$renovation.",`fix`)" ;
	     if($type) $condition .= " AND FIND_IN_SET(".$type.",`catid`)" ;
		 if(isset($acreage) &&!empty($acreage))$condition .=$this->getsearchap($acreage,'houseearm',$AJ['salearea']); 
		 if(isset($price) &&!empty($price))$condition .=$this->getsearchap($price,'price',$AJ['saleprice']); 
		 $ARE = get_area($city);
         if($city) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$city";


		if($sort)
	{
		
		if($sort=='1')
		{
		    $order = " order by edittime desc";
		
		}
		if($sort=='2')
		{
		    $order = " order by houseearm desc";
			$order_name = "建面从大到小";
		}
		elseif($sort=='3')
		{
				$order = " order by houseearm ASC";
			$order_name = "建面从小到大";
		}
		elseif($sort=='4')
		{
			$order = " order by price/houseearm desc";
			$order_name = "单价从高到低";
		}
		elseif($sort=='5')
		{
			$order = " order by price/houseearm ASC";
			$order_name = "单价从低到高";
		}
		elseif($sort=='6')
		{
				$order = " order by (price+0) desc";
			$order_name = "总价从高到低";
		}
		elseif($sort=='7')
		{
				$order = " order by (price+0) ASC";
			$order_name = "总价从低到高";
		}
		
		
		
	}
	else
	{
		$order = " ORDER BY itemid DESC";
	
	}
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
     
		$result = $db->query("SELECT * FROM $table WHERE  $condition  {$order} LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			
			if($r['floor1']<=7) {$t['floor1']='低层';}
			elseif($r['floor1']<=17 && $r['floor1']>7) {$t['floor1']='中层';}
			elseif($r['floor1']>17) {$t['floor1']='高层';}
			$r['id'] =$r['itemid'];
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']=str_replace("..",$MODULE[1]['linkurl'],$r['thumb']);
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	
	//二手房详情
	
	public function getsale(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id'];
		 
		 $table="{$db->pre}sale_5";
		
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
		
		$map=  $data['map'];
		if($data['floor1']<=7) {$data['floor1']='低层';}
			elseif($data['floor1']<=17 && $data['floor1']>7) {$data['floor1']='中层';}
			elseif($data['floor1']>17) {$data['floor1']='高层';}
	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
	 $data['create_time'] =timetodate($data['addtime'], 5);
		$data['orientations']=getbox_diaoval('toward','checkbox',$data['toward'],'sale_5');
		$data['renovation']=getbox_diaoval('fix','checkbox',$data['fix'],'sale_5');
		if($data['houseearm'])$data['average_price']=floor($data['price']*10000/$data['houseearm']);
		$data['sale_status'] = $TYPE[$data['typeid']];
		$data['typeid'] = $data['typeid']+1;
		$data['areaname'] =area_pos($data['areaid'], '');
		$data['id'] =$data['itemid'];
if($map){
$map_mid = $map;
}else{
$map_mid=$AJ['map_mid'] ;}
$map_mid=$this->baiduttx($map_mid);

$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['1'];
		   $y=$map['0']; 
		}
		$t = $db->get_one("SELECT content FROM {$db->pre}sale_data_5 WHERE itemid=$itemid");
       $data['info'] =$t['content'];

	//房源图片
$photolist=array();
       $photolist = get_albums($data);
		 $data['photo_total'] =count($photolist);
		foreach($photolist as $key=>$v) {
  $photo['id'] =$key;	
$photo['thumb'] =$v;
$photolist[$key]= $photo;	
}				
	
	 $data['file'] = $photolist;
		$data['latitude'] =$x;
		  $data['longitude'] =$y;	
		 
		
		
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	 
	   
    }
	//
	//二手房条件筛选
	public function second_attr(){
		global $db, $AJ;
	 $result =$db->query("SELECT * FROM {$db->pre}area where  parentid=0  ORDER BY areaid DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
			$r['pid'] =$r['parentid'];
			$results = $db->query("SELECT * FROM {$db->pre}area WHERE parentid=$areaid ORDER BY areaid DESC");
			$childlist=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				$cr['pid'] =$cr['parentid'];
				$cr['name'] =$cr['areaname'];	
			  $childlist[$cr['areaid']] = $cr;
			  		
			}
			
			if($r['child']) $r['_child'] =$childlist;	
		    $city[$areaid]= $r;	
		   }
	
		$saleprice=array();
		$saleprice = explode(',', trim('0,'.$AJ['saleprice']));
	
		foreach($saleprice as $key=>$v) {
  $key++;
 
  if($key==1) {
	  $name=$saleprice[$key].'万以下';
	  }
  elseif($key==count($saleprice))
  {
	  $name=$v.'万以上';
  }
  else
  {$name=$v.'-'.$saleprice[$key].'万';}
   $price.= '{"id":'.$key.',"name":"'.$name.'"},';

}

   $price = rtrim($price, ','); 
  
$str = '{ "result": ['.$price.'],
  "content_type": "application/json"
}';
$res = json_decode($str,true);
$saleprice = $res['result'];

//建面条件筛选
$salearea=array();

		$salearea = explode(',', trim('0,'.$AJ['salearea']));
	
		foreach($salearea as $key=>$v) {
  $key++;
 
  if($key==1) {
	  $name=$salearea[$key].'平以下';
	  }
  elseif($key==count($salearea))
  {
	  $name=$v.'平以上';
  }
  else
  {$name=$v.'-'.$salearea[$key].'平';}
   $salemj.= '{"id":'.$key.',"name":"'.$name.'"},';

}

   $salemj = rtrim($salemj, ','); 
  
$salemj = '{ "result": ['.$salemj.'],
  "content_type": "application/json"
}';
$res = json_decode($salemj,true);
$salearea = $res['result'];
//户型条件筛选
$huxing=array();
	
		$huxing = array('不限','一室', '二室', '三室', '四室', '五室以上');
		foreach($huxing as $key=>$v) {
  $room['id'] =$key;	
$room['name'] =$v;
$huxing[$key]= $room;	
}
//装修条件筛选
$zhuangxiu=array();
	
		$zhuangxiu = getbox_name('fix','sale_5');
		foreach($zhuangxiu as $key=>$v) {
  $fix['id'] =$key;	
$fix['name'] =$v;
$zhuangxiu[$key]= $fix;	
}
	
//排序条件筛选
$paixu=array();
	
		$paixu = array('默认', '更新时间排序', '建面从大到小', '建面从小到大', '单价从高到低', '单价从低到高', '总价从高到低', '总价从低到高');
		
		foreach($paixu as $key=>$v) {
  $sort['id'] =$key;	
$sort['name'] =$v;
$paixu[$key]= $sort;	
}
   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=5 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'price'=>$saleprice,'type'=>$category,'renovation'=>$zhuangxiu,'acreage'=>$salearea,'room'=>$huxing,'sort'=>$paixu);
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }
	//新房条件筛选
	public function house_attr(){
		global $db, $AJ;
	 $result =$db->query("SELECT * FROM {$db->pre}area where  parentid=0  ORDER BY areaid DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
			$r['pid'] =$r['parentid'];
			$results = $db->query("SELECT * FROM {$db->pre}area WHERE parentid=$areaid ORDER BY areaid DESC");
			$childlist=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				$cr['pid'] =$cr['parentid'];
				$cr['name'] =$cr['areaname'];	
			  $childlist[$cr['areaid']] = $cr;
			  		
			}
			
			if($r['child']) $r['_child'] =$childlist;	
		    $city[$areaid]= $r;	
		   }
	
		$saleprice=array();
		$saleprice = explode(',', trim('0,'.$AJ['houseprice']));
	
		foreach($saleprice as $key=>$v) {
  $key++;
 
  if($key==1) {
	  $name=$saleprice[$key].'元以下';
	  }
  elseif($key==count($saleprice))
  {
	  $name=$v.'元以上';
  }
  else
  {$name=$v.'-'.$saleprice[$key].'元';}
   $price.= '{"id":'.$key.',"name":"'.$name.'"},';

}

   $price = rtrim($price, ','); 
  
$str = '{ "result": ['.$price.'],
  "content_type": "application/json"
}';
$res = json_decode($str,true);
$saleprice = $res['result'];


//装修条件筛选
$zhuangxiu=array();
	
		$zhuangxiu = getbox_name('fitment','newhouse_6');
		foreach($zhuangxiu as $key=>$v) {
  $fitment['id'] =$key;	
$fitment['name'] =$v;
$zhuangxiu[$key]= $fitment;	
}
//楼盘特色条件筛选
$tese=array();
	
		$tese = getbox_name('lpts','newhouse_6');
		foreach($tese as $key=>$v) {
  $lpts['id'] =$key;	
$lpts['name'] =$v;
$tese[$key]= $lpts;	
}	
//状态条件筛选
$zhuangtai=array();
	    $zhuangtai = explode('|', trim('不限|待售|在售|尾盘|售完'));
;
		foreach($zhuangtai as $key=>$v) {
  $status['id'] =$key;	
$status['name'] =$v;
$zhuangtai[$key]= $status;	
}
//排序条件筛选
$paixu=array();
	
		$paixu = array('默认', '价格从低到高', '价格从高到低', '开盘时间降序', '开盘时间升序');
		
		foreach($paixu as $key=>$v) {
  $sort['id'] =$key;	
$sort['name'] =$v;
$paixu[$key]= $sort;	
}
   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=6 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'price'=>$saleprice,'type'=>$category,'renovation'=>$zhuangxiu,'special'=>$tese,'status'=>$zhuangtai,'sort'=>$paixu);
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }



  public  function getsearchap($zhi,$name,$lai){
		global $db, $AJ;
	$salearea=array();
		$salearea = explode(',', trim('0,'.$lai));
		foreach($salearea as $key=>$v) {
  $key++;
 
  if($zhi==1) {
	   $condition=" and ".$name."<=".$salearea[1]."";
	 
	  }
  elseif($zhi==count($salearea))
  {
	  $condition=" and ".$name.">".$v."";
  }
  else
  {
  $condition=" and ".$name.">=".$salearea[($zhi-1)]." and ".$name."<".$salearea[$zhi]."";
  }
 

       }
	   

		return $condition;
       }
	   
	  	 //资讯列表
    public function articlelist(){
		global $db, $AJ;
	    $pagesize = 10;
		 $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		   $catid = $_GET['cate'];
		 $table="{$db->pre}article_8";
		 $condition="status=3  ";
		 if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		 if($keywords) $condition .= " AND keyword LIKE '%$keyword%'";
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
      $total = ceil($items/$pagesize);
	$articlelist = array();

		$result = $db->query("SELECT * FROM {$db->pre}article_8 WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$r['catname'] = search_cats($r['catid'],6);
			$r['thumb']  = !empty($r['thumb']) ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$articlelist[] = $r;
		}
     $errno = $articlelist ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$articlelist);
		
			return $this->result($list);
       
	 
	   
    }
	 //资讯分类
    public function articlecata(){
		global $db, $AJ;
	    
	$articlelist = array();

	$result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=8 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[]= $r;	
		}
     $errno = $category ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'data'=>$category);
		
			return $this->result($list);
       
	 
	   
    }
	//资讯详情
	
	public function articledetail(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id']; 
		 $table="{$db->pre}article_8";
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
		$data['id'] =$data['itemid'];
		$data['create_time'] = timetodate($data['addtime'], 5);
		$t = $db->get_one("SELECT content FROM {$db->pre}article_data_8 WHERE itemid=$itemid");
       $data['info'] =$t['content'];
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	 
	   
    }
	 //网站首页
	 public function index(){
		global $db, $EXT;
	//幻灯片
	$pid = intval($EXT['mobile_pid']);
	   $slides = array();
		$result = $db->query("SELECT image_src,image_url FROM {$db->pre}ad WHERE  pid=$pid  ORDER BY listorder ASC,addtime ASC LIMIT 0,10  ");
		
		while($r = $db->fetch_array($result)) {
			$slides[] = $r;
			
		}	
	 
	 //关联资讯
	 $news = array();
		$result = $db->query("SELECT * FROM {$db->pre}article_8 WHERE  status=3 and level>2 ORDER BY itemid DESC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
				
			$news[] = $r;
			
		}	
	 
	 
	  //新房
	 $house = array();
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_6 WHERE status=3 and isnew=1    ORDER BY level DESC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
			$r['catname'] = search_cats($r['catid'],6);
			$r['typename'] = $TYPE[$r['typeid']];
			$r['buildtype'] =getbox_val('buildtype','checkbox',$r['buildtype'],'newhouse_6');
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$house[] = $r;
			
		}
		 //二手房
	 $sale = array();
		$result = $db->query("SELECT * FROM {$db->pre}sale_5 WHERE status=3  ORDER BY itemid DESC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$sale[] = $r;
			
		}		
	
	 
		   $data = array('slides' => $slides,'news'=>$news,'house'=>$house,'second'=>$sale);
		  $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list);
			
       
	 
	   
    }
	//租房
	//租房
	public function rentlist(){
			global $db, $AJ;
	    $pagesize = 10;
		
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		     $room = $_GET['room'];
			 $price = $_GET['price'];
			 $acreage = $_GET['acreage'];
			 $sort = $_GET['sort'];
			 $city = $_GET['city'];
			 $type = $_GET['type'];
			 $renovation = $_GET['renovation'];
		 $table="{$db->pre}rent_7";
		 $condition="status=3";
		 if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		 if (isset($room) &&!empty($room))$condition.=" and `room` = '$room'";
		 if($renovation) $condition .= " AND FIND_IN_SET(".$renovation.",`zhuanxiu`)" ;
	     if($type) $condition .= " AND FIND_IN_SET(".$type.",`catid`)" ;
		 if(isset($acreage) &&!empty($acreage))$condition .=$this->getsearchap($acreage,'houseearm',$AJ['rentarea']); 
		 if(isset($price) &&!empty($price))$condition .=$this->getsearchap($price,'price',$AJ['rentprice']); 
		 $ARE = get_area($city);
         if($city) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$city";


		 if($sort)
	{
		
		if($sort=='1')
		{
		    $order = " order by edittime desc";
		
		}
		if($sort=='2')
		{
		    $order = " order by houseearm desc";
			$order_name = "建面从大到小";
		}
		elseif($sort=='3')
		{
				$order = " order by houseearm ASC";
			$order_name = "建面从小到大";
		}
		
		elseif($sort=='6')
		{
				$order = " order by (price+0) desc";
			$order_name = "租金从高到低";
		}
		elseif($sort=='7')
		{
				$order = " order by (price+0) ASC";
			$order_name = "租金从低到高";
		}
		
		
		
	}
	else
	{
		$order = " ORDER BY itemid DESC";
	
	}
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
  
		$result = $db->query("SELECT * FROM $table WHERE  $condition  {$order} LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$r['thumb']=str_replace("..",$MODULE[1]['linkurl'],$r['thumb']);
				$r['thumb']  = $r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['id'] =$r['itemid'];
			if($r['floor1']<=7) {$t['floor1']='低层';}
			elseif($r['floor1']<=17 && $r['floor1']>7) {$t['floor1']='中层';}
			elseif($r['floor1']>17) {$t['floor1']='高层';}
			
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	
	//租房详情
	
	public function getrent(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id'];
		 
		 $table="{$db->pre}rent_7";
		
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
		
		$map=  $data['map'];
	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
	if($data['floor1']<=7) {$data['floor1']='低层';}
			elseif($data['floor1']<=17 && $data['floor1']>7) {$data['floor1']='中层';}
			elseif($data['floor1']>17) {$data['floor1']='高层';}
		$data['sale_status'] = $TYPE[$data['typeid']];
		$data['areaname'] =area_pos($data['areaid'], '');
		$data['create_time'] =timetodate($data['addtime'], 5);
		$data['orientations']=getbox_diaoval('toward','checkbox',$data['toward'],'rent_7');
		$data['renovation']=getbox_diaoval('zhuanxiu','checkbox',$data['zhuanxiu'],'rent_7');
		$data['id'] =$data['itemid'];
if($map){
$map_mid = $map;
}else{
$map_mid=$AJ['map_mid'] ;}
$map_mid=$this->baiduttx($map_mid);

$map=explode(",",$map_mid);
		foreach($map as $key =>$value){
		  $x =$map['1'];
		   $y=$map['0']; 
		}
		$t = $db->get_one("SELECT content FROM {$db->pre}rent_data_7 WHERE itemid=$itemid");
       $data['info'] =$t['content'];
	//房源图片
$photolist=array();
       $photolist = get_albums($data);
		 $data['photo_total'] =count($photolist);
		foreach($photolist as $key=>$v) {
  $photo['id'] =$key;	
$photo['thumb'] =$v;
$photolist[$key]= $photo;	
}		
	 $data['file'] = $photolist;
		$data['latitude'] =$x;
		  $data['longitude'] =$y;	
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	 
	   
    }
	//
	//租房条件筛选
	public function rent_attr(){
		global $db, $AJ;
	 $result =$db->query("SELECT * FROM {$db->pre}area where  parentid=0  ORDER BY areaid DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
			$r['pid'] =$r['parentid'];
			$results = $db->query("SELECT * FROM {$db->pre}area WHERE parentid=$areaid ORDER BY areaid DESC");
			$childlist=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				$cr['pid'] =$cr['parentid'];
				$cr['name'] =$cr['areaname'];	
			  $childlist[$cr['areaid']] = $cr;
			  		
			}
			
			if($r['child']) $r['_child'] =$childlist;	
		    $city[$areaid]= $r;	
		   }
	
		$saleprice=array();
		$saleprice = explode(',', trim('0,'.$AJ['rentprice']));
	
		foreach($saleprice as $key=>$v) {
  $key++;
 
  if($key==1) {
	  $name=$saleprice[$key].'元以下';
	  }
  elseif($key==count($saleprice))
  {
	  $name=$v.'元以上';
  }
  else
  {$name=$v.'-'.$saleprice[$key].'元';}
   $price.= '{"id":'.$key.',"name":"'.$name.'"},';

}

   $price = rtrim($price, ','); 
  
$str = '{ "result": ['.$price.'],
  "content_type": "application/json"
}';
$res = json_decode($str,true);
$saleprice = $res['result'];

//建面条件筛选
$salearea=array();

		$salearea = explode(',', trim('0,'.$AJ['rentarea']));
	
		foreach($salearea as $key=>$v) {
  $key++;
 
  if($key==1) {
	  $name=$salearea[$key].'平以下';
	  }
  elseif($key==count($salearea))
  {
	  $name=$v.'平以上';
  }
  else
  {$name=$v.'-'.$salearea[$key].'平';}
   $salemj.= '{"id":'.$key.',"name":"'.$name.'"},';

}

   $salemj = rtrim($salemj, ','); 
  
$salemj = '{ "result": ['.$salemj.'],
  "content_type": "application/json"
}';
$res = json_decode($salemj,true);
$salearea = $res['result'];
//户型条件筛选
$huxing=array();
	
		$huxing = array('不限','一室', '二室', '三室', '四室', '五室以上');
		foreach($huxing as $key=>$v) {
  $room['id'] =$key;	
$room['name'] =$v;
$huxing[$key]= $room;	
}
//装修条件筛选
$zhuangxiu=array();
	
		$zhuangxiu = getbox_name('zhuanxiu','rent_7');
		foreach($zhuangxiu as $key=>$v) {
  $fix['id'] =$key;	
$fix['name'] =$v;
$zhuangxiu[$key]= $fix;	
}
	
//排序条件筛选
$paixu=array();
	
		$paixu = array('默认', '更新时间排序', '建面从大到小', '建面从小到大', '租金从高到低', '租金从低到高');
		
		foreach($paixu as $key=>$v) {
  $sort['id'] =$key;	
$sort['name'] =$v;
$paixu[$key]= $sort;	
}
   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=7 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'price'=>$saleprice,'type'=>$category,'renovation'=>$zhuangxiu,'acreage'=>$salearea,'room'=>$huxing,'sort'=>$paixu);
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }


//求购求租条件筛选
	public function buy_attr(){
		global $db, $AJ;
	 $result =$db->query("SELECT * FROM {$db->pre}area where  parentid=0  ORDER BY areaid DESC");
		while($r = $db->fetch_array($result)) {
			$areaid= $r['areaid'] ;
			$r['name'] =$r['areaname'];	
			$r['id'] =$r['areaid'];	
			$r['pid'] =$r['parentid'];
			$results = $db->query("SELECT * FROM {$db->pre}area WHERE parentid=$areaid ORDER BY areaid DESC");
			$childlist=array();
			while($cr = $db->fetch_array($results)) {
				$cr['id'] =$cr['areaid'];	
				$cr['pid'] =$cr['parentid'];
				$cr['name'] =$cr['areaname'];	
			  $childlist[$cr['areaid']] = $cr;
			  		
			}
			
			if($r['child']) $r['_child'] =$childlist;	
		    $city[$areaid]= $r;	
		   }
	

//建面条件筛选
$salearea=array();

		$salearea = explode(',', trim('0,'.$AJ['rentarea']));
	
		foreach($salearea as $key=>$v) {
  $key++;
 
  if($key==1) {
	  $name=$salearea[$key].'平以下';
	  }
  elseif($key==count($salearea))
  {
	  $name=$v.'平以上';
  }
  else
  {$name=$v.'-'.$salearea[$key].'平';}
   $salemj.= '{"id":'.$key.',"name":"'.$name.'"},';

}

   $salemj = rtrim($salemj, ','); 
  
$salemj = '{ "result": ['.$salemj.'],
  "content_type": "application/json"
}';
$res = json_decode($salemj,true);
$salearea = $res['result'];

//来源
$laiyuan=array();
	
		$laiyuan = array('求购', '求租');
		foreach($laiyuan as $key=>$v) {
  $room['id'] =$key;	
$room['name'] =$v;
$laiyuan[$key]= $room;	
}
   
//类型
 $result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=7 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[$r['catid']]= $r;	
		}
		
     $errno = $houselist ? 200 : 200;
		 $data = array('city'=>$city,'price'=>$saleprice,'type'=>$category,'renovation'=>$zhuangxiu,'acreage'=>$salearea,'laiyuan'=>$laiyuan,'sort'=>$paixu);
		 $list = array('code' => 200,'data'=>$data);
			return $this->result($list);
      
    }
	
		//租房
	public function buylist(){
			global $db, $AJ;
	    $pagesize = 10;
		
		  $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		     $buy = $_GET['buy'];
			
			 $acreage = $_GET['acreage'];
			 $sort = $_GET['sort'];
			 $city = $_GET['city'];
			 $type = $_GET['type'];
			 $renovation = $_GET['renovation'];
		 $table="{$db->pre}buy_16";
		 $condition="status=3";
		 if($keyword) $condition .= " AND keyword LIKE '%$keyword%'";
		 if (isset($buy))$condition.=" and `typeid` = '$buy'";
	     if($type) $condition .= " AND FIND_IN_SET(".$type.",`catid`)" ;
		 if(isset($acreage) &&!empty($acreage))$condition .=$this->getsearchap($acreage,'houseearm',$AJ['rentarea']); 
		 $ARE = get_area($city);
         if($city) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$city";
        $order = " ORDER BY itemid DESC";
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
	 
      $total = ceil($items/$pagesize);
	$houselist = array();
  
		$result = $db->query("SELECT * FROM $table WHERE  $condition  {$order} LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$r['addtime'] =timetodate($r['addtime'], 5);
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['catname'] = search_cats($r['catid'],16);
			$r['danwei']  = $r['typeid'] ? '元/月' : '万元';
			$r['id'] =$r['itemid'];
			
			
	$houselist[] = $r;
		}
     $errno = $houselist ? 200 : 1;
		
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$houselist);
		
			return $this->result($list);
       
	 
	   
    }
	
	//求购详情
	
	public function getbuy(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id'];
		 
		 $table="{$db->pre}buy_16";

        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
	     $data['danwei']  = $data['typeid'] ? '元/月' : '万元';
		  $data['sale_status']  = $data['typeid'] ? '求租' : '求购';
		//$data['sale_status'] = $TYPE[$data['typeid']];
		$data['areaname'] =area_pos($data['areaid'], '');
		$data['create_time'] =timetodate($data['addtime'], 5);
		$data['id'] =$data['itemid'];
		$t = $db->get_one("SELECT content FROM {$db->pre}buy_data_16 WHERE itemid=$itemid");
       $data['info'] =$t['content'];
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	 
	   
    }
	
	 //家装列表
    public function homelist(){
		global $db, $AJ;
	    $pagesize = 10;
		 $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		   $catid = $_GET['cate'];
		 $table="{$db->pre}info_13";
		 $condition="status=3  ";
		 if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		 if($keywords) $condition .= " AND keyword LIKE '%$keyword%'";
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
      $total = ceil($items/$pagesize);
	$articlelist = array();

		$result = $db->query("SELECT * FROM {$db->pre}info_13 WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$r['catname'] = search_cats($r['catid'],13);
			$r['thumb']  = !empty($r['thumb']) ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$articlelist[] = $r;
		}
     $errno = $articlelist ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$articlelist);
		
			return $this->result($list);
       
	 
	   
    }
	 //资讯分类
    public function homecata(){
		global $db, $AJ;
	    
	$articlelist = array();

	$result =$db->query("SELECT catid,catname,child FROM {$db->pre}category  WHERE moduleid=13 ORDER BY listorder,catid ASC");
		while($r = $db->fetch_array($result)) {
			$r['name'] =$r['catname'];	
			$r['id'] =$r['catid'];	
	     $category[]= $r;	
		}
     $errno = $category ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'data'=>$category);
		
			return $this->result($list);
       
	 
	   
    }
	//资讯详情
	
	public function homedetail(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id']; 
		 $table="{$db->pre}info_13";
        $data = $db->get_one("SELECT * FROM $table WHERE itemid=$itemid");
	$data['thumb']  = $data['thumb'] ? $data['thumb'] : AJ_SKIN.'image/nopic.gif';
		$data['id'] =$data['itemid'];
		$data['create_time'] = timetodate($data['addtime'], 5);
		$t = $db->get_one("SELECT content FROM {$db->pre}info_data_13 WHERE itemid=$itemid");
       $data['info'] =$t['content'];
       $list = array('code' => 200,'data'=>$data);
		
			return $this->result($list); 
	 
	   
    }

/*
* 百度地图BD09坐标---->中国正常GCJ02坐标
* 腾讯地图用的也是GCJ02坐标
* @param double $lat 纬度
* @param double $lng 经度
* @return array();
*/
 
public function baiduttx($map){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
		$map=explode(",",$map);
		foreach($map as $key =>$value){
		  $lng =$map['0'];
		   $lat=$map['1']; 
		}
		//echo  $x;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
		$map=$lng.','.$lat;
        return $map;
}
 	 //新房相册列表
    public function photolist(){
		global $db, $AJ;
	    $pagesize = 10;
		 $id = $_GET['id'];
		 $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		   $catid = $_GET['cate'];
		 $table="{$db->pre}newhouse_xiangce";
		 $condition="status=3 and houseid=$id"; 
		 if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
		 if($keywords) $condition .= " AND keyword LIKE '%$keyword%'";
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
      $total = ceil($items/$pagesize);
	$articlelist = array();
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_xiangce WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
			$r['catname'] = search_cats($r['catid'],12);
			$r['thumb']  = !empty($r['thumb']) ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$r['url']  = !empty($r['thumb']) ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
	$articlelist[] = $r;
		}
     $errno = $articlelist ? 200 : 1;
		 header('content-type:application/json;charset=utf-8');
		 $list = array('code' => $errno,'page'=>$page,'total_page'=>$total,'data'=>$articlelist);
		
			return $this->result($list);
       
	 
	   
    }
	
	 //新房户型列表
    public function roomlist(){
		global $db, $AJ;
	    $pagesize = 10;
		 $id = $_GET['house_id'];
		  $room_id = $_GET['room_id'];
		 $page  = ceil($_GET['page']) ? ceil($_GET['page']) : 1;
		   $keyword = $_GET['keyword'];
		   $catid = $_GET['cate'];
		 $table="{$db->pre}newhouse_huxing";
		 $condition="status=3 and houseid=$id"; 
		
       $offset = ($page-1)*$pagesize;
	   $items = $db->count($table, $condition, $CFG['db_expires']);
      $total = ceil($items/$pagesize);
	$articlelist = array();
	
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_huxing WHERE  $condition  ORDER BY itemid DESC LIMIT {$offset},{$pagesize}");
		while($r = $db->fetch_array($result)) {
		
			$r['thumb']  = !empty($r['thumb']) ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$r['url']  = !empty($r['thumb']) ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$r['note']  = !empty($r['note']) ? $r['note'] : '';
	$articlelist[] = $r;
		}
		
		$info = $db->get_one("SELECT * FROM {$db->pre}newhouse_huxing WHERE itemid=$room_id");
		$TYPE = explode('|', trim('售完|在售'));
		$info['sale_status'] = $TYPE[$info['xszt']];
  $errno = $articlelist ? 200 : 1;
		$huxinglist=array('data'=>$articlelist,'info'=>$info);
		 $list = array('code' => $errno,'data'=>$huxinglist);
		
			return $this->result($list);
       
	 
	   
    }
	
	//全景
	
	public function urldetail(){
		global $db, $AJ;
	   
       $url =base64_decode($_GET['url']);
	header("Location: $url");
	  
		return $url;
	 
	   
    }
	
	//预留红包提交信息
	public function subscribehb(){
		
		global $db, $AJ;
		 $table="{$db->pre}newhouse_6";
		$itemid = $_GET['id'];
        $data = $db->get_one("SELECT itemid,title,hongbao FROM $table WHERE itemid=$itemid");
		$data['id'] =$data['itemid'];
		$data['title'] =$data['title'];
		  $list = array('code' => 200,'data'=>$data,'send_sms'=>0,'token'=>'');
		
			return $this->result($list);
		
	}
	//预留红包提交信息
	public function subscribehbdata(){
		global $db, $AJ;

$phone=$_GET['mobile'];
$truename=$_GET['user_name'];
$username=$_username ? $_username : '游客';
$house=$_GET['house_id'];
$hongbao=$_GET['hongbao'];
$hname=$_GET['title'];
$addtime=time();


if(!empty($phone) && !empty($truename)){
	
 $db->query("UPDATE {$db->pre}newhouse_6 SET hbnum=hbnum+1 WHERE itemid='$house'");
  $db->query("INSERT INTO {$db->pre}hongbao (username,house,hname,money,addtime,status,mobile,truename) VALUES ('$username','$house','$hname','$hongbao','$addtime',0,'$phone','$truename')");	

}
		
	 $errno = $phone ? 200 : 0;
		 $msg = $phone ? '提交成功' : '参数错误';
		
		  $list = array('code' =>$errno,'msg'=>$msg,);
		
			return $this->result($list);
		
	}


}