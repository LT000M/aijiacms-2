<?php
require '../../common.inc.php';
class indexclass
{
   
   //网站首页
	 public function index(){
		global $db, $EXT;
	//幻灯片
	$pid = intval($EXT['xiaocx_pid']);
	   $slides = array();
		$result = $db->query("SELECT image_src,image_url,note FROM {$db->pre}ad WHERE  pid=$pid  ORDER BY listorder ASC,addtime ASC LIMIT 0,10  ");
		
		while($r = $db->fetch_array($result)) {
			$slides[] = $r;
			
		}	
	 
	 //关联资讯
	 $news = array();
		$result = $db->query("SELECT * FROM {$db->pre}article_8 WHERE  status=3 and level>2 ORDER BY itemid DESC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
				
			$news[] = $r;
			
		}	
	 
	  //关联菜单
	 $navigation = array();
		$result = $db->query("SELECT * FROM {$db->pre}app_nav WHERE  is_enable=1 ORDER BY listorder ASC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
				
			$navigation[] = $r;
			
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
		$result = $db->query("SELECT itemid,thumb,title,areaid,housename,price,room,hall,houseearm FROM {$db->pre}sale_5 WHERE status=3  ORDER BY addtime DESC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$sale[] = $r;
			
		}	
			 //租房
	 $rent = array();
		$result = $db->query("SELECT itemid,thumb,title,areaid,housename,price,room,hall,houseearm FROM {$db->pre}rent_7 WHERE status=3  ORDER BY addtime DESC LIMIT 0,10 ");
		while($r = $db->fetch_array($result)) {
			$r['areaname'] =area_pos($r['areaid'], '');
			$r['thumb']  =$r['thumb'] ? $r['thumb'] : AJ_SKIN.'image/nopic.gif';
			$rent[] = $r;
			
		}		
	
	 
		   $data = array('navigation'=>$navigation,'banner_list' => $slides,'news_list'=>$news,'house_list'=>$house,'sale_list'=>$sale,'rent_list'=>$rent);
			  return self::DataReturn('success', 0, $data);
       
	 
	   
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
        $result['msg'] = '操作失败';
    }
  
    return $result;
}


}
?>