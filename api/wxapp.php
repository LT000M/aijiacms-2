<?php
/**
 * 企业小程序模块小程序接口定义
 *

 * @url 
 */
//defined('IN_AIJIACMS') or exit('Access Denied');

require '../common.inc.php';
class Response{
	public function result($errno, $message = '', $data = '') {
		exit(json_encode(array(
			'errno' => $errno,
			'message' => $message,
			'data' => $data,
		)));
	}
	
    public function houselist(){
		global $db, $_W;
	
		
	
		$result = $db->query("SELECT * FROM aijiacms_newhouse_6 WHERE status=3 and isnew=1 ORDER BY itemid DESC");
		while($r = $db->fetch_array($result)) {
	$houselist[] = $r;
		}
		//$houselist = $db->fetch_array($result);
		
	
		
		$housetypeinfo= array(1=>'住宅',2=>'别墅',3=>'公寓',4=>'商铺',5=>'写字楼',6=>'酒店',7=>'厂房');
		
       $this->result(0, 'success', $houselist);
	 
	   
    }
	public function getinitinfo($code,$message,$data){
		global $db, $_W;
	
		
	
		
		$result =$db->query("SELECT * FROM aijiacms_area  ORDER BY areaid DESC");
		while($r = $db->fetch_array($result)) {
	$arealist[] = $r;
		}
		//$housepricelist = $db->fetch_array($db->query("SELECT * FROM aijiacms_newhouse_6 WHERE status=3 ORDER BY itemid DESC"));
		$housepricelist = getbox_name('range','newhouse_6');
		

		return $this->result(0, 'success', array('arealist'=>$arealist,'housepricelist'=>$housepricelist));
		
	 
	   
    }
	
		public function doPageGetarticle()
		{
			global $_GPC, $_W;
			if($_W['attachurl']!=""){
			
				$picurl = $_W['attachurl'];
				
			}else{
				
				$picurl  = $_W['siteroot'].'attachment/';
			}
			$pid = $_GPC['pid'];
			$category_list = pdo_fetchall("SELECT * FROM " . tablename('weixinmao_house_category') ." WHERE weid=:weid ",array(":weid" => $_W['uniacid']));
			
			$content  = pdo_fetchall("SELECT * FROM " . tablename('weixinmao_house_content') ." WHERE  uniacid=:uniacid AND pid=".$category_list[0]['id']."  ORDER BY createtime DESC",array(":uniacid" => $_W['uniacid']));
			if($content)
			{
				foreach($content as $k=>$v)
				{
					$content[$k]['createtime'] = date('Y-m-d',$v['createtime']);
					$content[$k]['thumb'] = $picurl.$v['thumb'];
					
				}
			}
			$list = array('category'=>$category_list,'article'=>$content,'activeCategoryId'=>$category_list[0]['id']);
			return $this->result(0, 'success', $list);
			
		}
}

