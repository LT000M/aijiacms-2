<?php
/**
 * 沙盘接口定义
 *

 * @url 
 */


require '../../common.inc.php';
class Response{
	public function result($list) {
		header('content-type:application/json;charset=utf-8');
		exit(json_encode($list));
	}
	
	
	 //增加楼栋
   
	  	
    public function save_addhouse(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		 $house_id=$_POST["house_id"];
		
        	$fields = array(
				'title' => $title,
				);
			
			$fields['title'] = $_POST['title'];
			$fields['unit'] = $_POST['unit'];
			$fields['elevator'] = $_POST['elevator'];
			$fields['floor_num'] = $_POST['floor_num'];
			$fields['house_id'] = $_POST['house_id'];
			$fields['room_num'] = $_POST['room_num'];
			$fields['open_time'] = strtotime($_POST['open_time']);
			$fields['complate_time'] = strtotime($_POST['complate_time']);
			$fields['sale_status'] = $_POST['sale_status'];
			$fields['huxing_id'] = implode(',',$_POST['huxing_id']);
			$fields['add_time'] = AJ_TIME;
		   
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			
			if($fields['title']){
			$db->query("INSERT INTO {$db->pre}newhouse_sand ($sqlk) VALUES ($sqlv)");
			
			}
			
			
	    if($db->insert_id())
	   {
		  
		   $list = array('code' => 1,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
			return $this->result($list);
       
	 
	   
    }
	//编辑沙盘
	 public function save_edithouse(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		 $id=$_POST["id"];
		
        	$fields = array(
				'title' => $title,
				);
			
			$fields['title'] = $_POST['title'];
			$fields['unit'] = $_POST['unit'];
			$fields['elevator'] = $_POST['elevator'];
			$fields['floor_num'] = $_POST['floor_num'];
			
			$fields['room_num'] = $_POST['room_num'];
			$fields['open_time'] = strtotime($_POST['open_time']);
			$fields['complate_time'] = strtotime($_POST['complate_time']);
			$fields['sale_status'] = $_POST['sale_status'];
			$fields['huxing_id'] = implode(',',$_POST['huxing_id']);
			$fields['update_time'] = AJ_TIME;
			$sql = '';
		foreach($fields as $k=>$v) {
			 $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
		
			
			  DB::query("UPDATE {$db->pre}newhouse_sand SET $sql WHERE id=$id");	
	
		   $list = array('code' => 1,'msg'=>'成功');
	  
			return $this->result($list);
       
	 
	   
    }
	
	//删除楼栋
	 public function deletehouse(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		  $id = $_GET['id'];
		DB::query("DELETE FROM {$AJ_PRE}newhouse_sand WHERE id=$id");
		
		   $list = array('code' => 1,'msg'=>'删除成功');
			return $this->result($list);
       
	 
	   
    }
	
	//删除沙盘
	 public function deletesand(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		  $id = $_GET['id'];
		DB::query("DELETE FROM {$AJ_PRE}newhouse_sand_pic WHERE id=$id");
		
		   $list = array('code' => 1,'msg'=>'删除成功');
			return $this->result($list);
       
	 
	   
    }
	 //保存沙盘
   
	  	
    public function savesand(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
		
        	$fields = array(
				'img' => $img,
				);
			
		
			
			$fields['house_id'] = $_POST["house_id"];
			$fields['img'] = $_POST["img"];
			$fields['data'] = json_encode($_POST['data'],JSON_UNESCAPED_UNICODE);
			$fields['add_time'] = AJ_TIME;
		     $house_id = $_POST['house_id'];
			 
		 $info = $db->get_one("SELECT * FROM {$db->pre}newhouse_sand_pic WHERE  house_id=$house_id");
		 if( $info){
			 	$sql = '';
		foreach($fields as $k=>$v) {
			 $sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
		 $id = $info['id'];
			
			  DB::query("UPDATE {$db->pre}newhouse_sand_pic SET $sql WHERE id=$id");	
	
		   $list = array('code' => 1,'msg'=>'成功');
		 }
		 else
		 {
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			
			if($fields['img']){
			$db->query("INSERT INTO {$db->pre}newhouse_sand_pic ($sqlk) VALUES ($sqlv)");
			
			}
			
			
	    if($db->insert_id())
	   {
		  
		   $list = array('code' => 1,'msg'=>'成功');}
	   else
	   { $list = array('code' => 0,'msg'=>"失败");
		  
	   }
		 }
			return $this->result($list);
       
	 
	   
    }
	
	 //沙盘详情
	 public function getbaninfobyid(){
		global $db, $AJ;
	   
		  $itemid = $_GET['id'];
		 $ban_info = array(); 
	    $ban_info = $db->get_one("SELECT * FROM {$db->pre}newhouse_sand WHERE  id=$itemid");
		$ban_info['open_time']=timetodate($ban_info['open_time'],3);
		$ban_info['complate_time']=timetodate($ban_info['complate_time'],3);
	if(empty($ban_info))$ban_info = array(); 
	

	
	  $houseid = $ban_info['house_id'];
	   $huxingid = $ban_info['huxing_id'];

	  //关联户型
	 $type_lists = array();
		$result = $db->query("SELECT * FROM {$db->pre}newhouse_huxing WHERE  houseid=$houseid  and itemid in ($huxingid)   ORDER BY itemid DESC ");
		while($r = $db->fetch_array($result)) {
			 $TYPE = explode('|', trim('售罄|在售|预售'));
		$r['sale_status'] = $TYPE[$r['xszt']];
		$r['url'] = 'hxinfo-'.$r['itemid'].'.html';
			$type_lists[] = $r;
			
		}	
	// $data['room'] = $huxinglist;
	 
		
		
	
	 
		 header('content-type:application/json;charset=utf-8');
		   $data = array('ban_info'=>$ban_info,'type_lists'=>$type_lists,);
		  $list = array('code' => 1,'data'=>$data,);
		
			return $this->result($list);
			
       
	 
	   
    }
	
	  




}