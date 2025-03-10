<?php
/**
 * 客源接口定义
 *

 * @url 
 */


require '../../common.inc.php';
class Response{
	public function result($list) {
		header('content-type:application/json;charset=utf-8');
		exit(json_encode($list));
	}
	

	 //关联用户详情
	 public function getmember(){
		   global $db, $AJ;
		   $q = $_GET['txt'];
		   $memberlist=array();
	       $result = $db->query("SELECT * FROM {$db->pre}company WHERE   (company like '%".$q."%' or letter like '%".$q."%') ");
		   while($r = $db->fetch_array($result)) {	
		   $r['txuid'] = $r['userid'];	
	            $memberlist[] = $r;
		        }
		   $list = array('status' => 1,'district'=>$memberlist,);
			return $this->result($list);
	   
             }
			 
		 //关联编号详情
	 public function fybianhao(){
		   global $db, $AJ;
		   $q = $_GET['txt'];
		   $fybianhaolist=array();
	       $result = $db->query("SELECT itemid,title FROM {$db->pre}sale_5 WHERE    itemid like '%".$q."%'  or title like '%".$q."%'");
		
		   while($r = $db->fetch_array($result)) {	
		  
	            $fybianhaolist[] = $r;
		        }
		   $list = array('status' => 1,'lists'=>$fybianhaolist,);
			return $this->result($list);
	   
             }
	
	   //增加提醒
    public function save_tingxing(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
			$fields['kybh'] = $_POST['kybh'];
			$fields['kyid'] = $_POST['kyid'];
			$fields['txuid'] = $_POST['txuid'];
			$txshijian = $_POST['txshijian'];
			$fields['txshijian']=strtotime($txshijian); 
            $fields['time']=time();
            $fields['adduid']=$_POST['userid'];
			$fields['txneirong'] = $_POST['txneirong'];
		
		   
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			
			
			$db->query("INSERT INTO {$db->pre}kytixing ($sqlk) VALUES ($sqlv)");
			
		
			
	    if($_POST['kybh'])
	   {
		  
		   $list = array('status' => 1,'info'=>'添加成功');}
	   else
	   { $list = array('status' => 0,'info'=>"失败");
		  
	   }
			return $this->result($list);
  
            }

       //增加带看
    public function save_daikan(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$MODULE;
			
			$dkfangyuan = $_POST['dkfangyuan'];
			
		
		      $newstr = substr($dkfangyuan,0,strlen($str)-1);
                $aaa=array_unique(array_filter(explode(";",$newstr)));
                $s=count($aaa);
                for ($i=0; $i < $s; $i++) {
					$fyid= $db->get_one("SELECT * FROM ".AJ_PRE."sale_5 WHERE itemid='$aaa[$i]'");
                   
                    if (!$fyid) {
                        $this->error('未找到房源'.$aaa[$i].'！');
                    }
                }
                for ($i=0; $i < $s; $i++) {
                   
					$fyid= $db->get_one("SELECT itemid,username FROM ".AJ_PRE."sale_5 WHERE itemid='$aaa[$i]'");
                    $data['kyid']=$_POST['kyid'];
                    $data['fyid']=$fyid['itemid'];
                    $data['fybh']=$aaa[$i];
                    $data['kybh']=$_POST['kybh'];
                    $data['kehupj']=$_POST['kehupj'];
                    $data['peikanid']=$_POST['peikanid'];
                    $data['time']=time();
                    $data['dkuid']=$_POST['userid'];
					$txshijian = $_POST['dkshijian'];
                    $data['dkshijian']=strtotime($txshijian);
                 
                
		
		
		   
			$sqlk = $sqlv = '';
			foreach($data as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			
			
			$db->query("INSERT INTO {$db->pre}kydaikan ($sqlk) VALUES ($sqlv)");
			
		}
			
	    if($db->insert_id())
	   {
		  
		   $list = array('status' => 1,'info'=>'添加成功');}
	   else
	   { $list = array('status' => 0,'info'=>"失败");
		  
	   }
			return $this->result($list);
	   
        }
		 //增加跟进
    public function genjin(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		
		
			$fields['kybh'] = $_POST['kybh'];
			$fields['kyid'] = $_POST['kyid'];
			$fields['genjinfs'] = $_POST['genjinfs'];
			$gjshijian = $_POST['gjshijian'];
			$fields['gjshijian']=strtotime($gjshijian); 
            $fields['time']=time();
            $fields['gjuid']=$_POST['gjid'];
			$fields['gjneirong'] = $_POST['gjneirong'];
		
		   
			$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
			
			
			$db->query("INSERT INTO {$db->pre}kygenjin ($sqlk) VALUES ($sqlv)");
			
		
			
	    if($_POST['kybh'])
	   {
		  
		   $list = array('status' => 1,'info'=>'添加成功');}
	   else
	   { $list = array('status' => 0,'info'=>"失败");
		  
	   }
			return $this->result($list);
  
            }
			 //变更状态
    public function bgkyzt(){
		global $db;
		
		
			$zhuangtai = $_POST['zhuangtai'];
			$kyid = $_POST['kyid'];	
	   $db->query("UPDATE {$db->pre}keyuan SET zhuangtai=$zhuangtai WHERE id=$kyid");

	    if($_POST['zhuangtai'])
	   {
		  
		   $list = array('status' => 1,'info'=>'变更成功');}
	   else
	   { $list = array('status' => 0,'info'=>"失败");
		  
	   }
			return $this->result($list);
  
            }
        //变更状态
    public function bgwhr(){
		global $db;
		
		 $xiugaisj=time();
			$weihuren = $_POST['username'];
			$kyid = $_POST['kyid'];	
	    $db->query("UPDATE {$db->pre}keyuan SET weihuren=$weihuren,xiugaisj=$xiugaisj WHERE id=$kyid");
	
		  
		   $list = array('status' => 1,'info'=>'变更成功');
	
			return $this->result($list);
  
            }
			
		 //编辑客源
    public function edit_keyuan(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$AJ_TIME,$_truename,$_userid;
		
			$id = $_POST['id'];	
			$fields['weihuren'] =$_truename;
		$fields['weihurenid'] =$_userid;
		$fields['lururenid'] =$_userid;
	    $fields['chaoxiang']=implode(',',$_POST['chaoxiang']);
		$fields['zhuangxiu']=implode(',',$_POST['zhuangxiu']);
		$fields['peitao']=implode(',',$_POST['peitao']);
		$fields['xiugaisj'] = $AJ_TIME;
		$fields['khxingming'] = $_POST['khxingming'];
		$fields['kehulx'] = $_POST['kehulx'];
		$fields['dianhua'] = $_POST['dianhua'];
		$fields['xqhuxing1'] = $_POST['xqhuxing1'];
		$fields['xqhuxing2'] = $_POST['xqhuxing2'];
		$fields['xqjiage1'] = $_POST['xqjiage1'];
		$fields['xqjiage2'] = $_POST['xqjiage2'];
		$fields['xqmianji1'] = $_POST['xqmianji1'];
		$fields['xqmianji2'] = $_POST['xqmianji2'];
		$fields['xqyongtu'] = $_POST['xqyongtu'];
		$fields['khlaiyuan'] = $_POST['khlaiyuan'];
		$fields['xqquyu'] = $_POST['xqquyu'];
		$fields['xqxiaoqu'] = $_POST['xqxiaoqu'];
		$fields['xqyuanyin'] = $_POST['xqyuanyin'];
		$fields['louceng1'] = $_POST['louceng1'];
		$fields['louceng2'] = $_POST['louceng2'];
		$fields['fangling1'] = $_POST['fangling1'];
		$fields['fangling2'] = $_POST['fangling2'];
		$fields['fukuan'] = $_POST['fukuan'];
		$fields['gtjieduan'] = $_POST['gtjieduan'];
		$fields['guoji'] = $_POST['guoji'];
		$fields['minzu'] = $_POST['minzu'];
		$fields['xflinian'] = $_POST['xflinian'];
		$fields['kydengji'] = $_POST['kydengji'];
		$fields['sfzheng'] = $_POST['sfzheng'];
		$fields['qqhao'] = $_POST['qqhao'];
		$fields['youxiang'] = $_POST['youxiang'];
		$fields['weixin'] = $_POST['weixin'];
		$fields['jtgongju'] = $_POST['jtgongju'];
		$fields['chexing'] = $_POST['chexing'];
		$fields['beizhu'] = $_POST['beizhu'];
		//$fields['xqbianhao'] = $_POST['xqbianhao'];
		
			
		     
		   	$sql = '';
		foreach($fields as $k=>$v) {
		$sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
			 DB::query("UPDATE {$db->pre}keyuan SET $sql WHERE id=$id");
			 
	
			
		
			
	    if($_POST['id'])
	   {
		  
		   $list = array('status' => 1,'info'=>'修改成功');}
	   else
	   { $list = array('status' => 0,'info'=>"失败");
		  
	   }
			return $this->result($list);
  
            }	
		
		//添加客源
    public function save_keyuan(){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT,$AJ_TIME,$_truename,$_userid;
		
			
			$fields['weihuren'] =$_truename;
		$fields['weihurenid'] =$_userid;
		$fields['lururenid'] =$_userid;
	    $fields['chaoxiang']=implode(',',$_POST['chaoxiang']);
		$fields['zhuangxiu']=implode(',',$_POST['zhuangxiu']);
		$fields['peitao']=implode(',',$_POST['peitao']);
		$fields['lurusj'] = $AJ_TIME;
		$fields['khxingming'] = $_POST['khxingming'];
		$fields['kehulx'] = $_POST['kehulx'];
		$fields['dianhua'] = $_POST['dianhua'];
		$fields['xqhuxing1'] = $_POST['xqhuxing1'];
		$fields['xqhuxing2'] = $_POST['xqhuxing2'];
		$fields['xqjiage1'] = $_POST['xqjiage1'];
		$fields['xqjiage2'] = $_POST['xqjiage2'];
		$fields['xqmianji1'] = $_POST['xqmianji1'];
		$fields['xqmianji2'] = $_POST['xqmianji2'];
		$fields['xqyongtu'] = $_POST['xqyongtu'];
		$fields['khlaiyuan'] = $_POST['khlaiyuan'];
		$fields['xqquyu'] = $_POST['xqquyu'];
		$fields['xqxiaoqu'] = $_POST['xqxiaoqu'];
		$fields['xqyuanyin'] = $_POST['xqyuanyin'];
		$fields['louceng1'] = $_POST['louceng1'];
		$fields['louceng2'] = $_POST['louceng2'];
		$fields['fangling1'] = $_POST['fangling1'];
		$fields['fangling2'] = $_POST['fangling2'];
		$fields['fukuan'] = $_POST['fukuan'];
		$fields['gtjieduan'] = $_POST['gtjieduan'];
		$fields['guoji'] = $_POST['guoji'];
		$fields['minzu'] = $_POST['minzu'];
		$fields['xflinian'] = $_POST['xflinian'];
		$fields['kydengji'] = $_POST['kydengji'];
		$fields['sfzheng'] = $_POST['sfzheng'];
		$fields['qqhao'] = $_POST['qqhao'];
		$fields['youxiang'] = $_POST['youxiang'];
		$fields['weixin'] = $_POST['weixin'];
		$fields['jtgongju'] = $_POST['jtgongju'];
		$fields['chexing'] = $_POST['chexing'];
		$fields['beizhu'] = $_POST['beizhu'];
		$fields['xqbianhao'] = $_POST['xqbianhao'];
		$sqlk = $sqlv = '';
			foreach($fields as $k=>$v) {
				$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
		 if($_POST['khxingming'])
		 {
			$sqlk = substr($sqlk, 1); $sqlv = substr($sqlv, 1);
		$db->query("INSERT INTO {$db->pre}keyuan ($sqlk) VALUES ($sqlv)");
		
			$id = $db->insert_id();
		$xqbianhao='MK'.$id;
		  DB::query("UPDATE {$db->pre}keyuan SET xqbianhao='$xqbianhao' WHERE id=$id");
	     }
	    if($id)
	   {
		  
		   $list = array('status' => 1,'info'=>'添加成功');}
	   else
	   { $list = array('status' => 0,'info'=>"失败");
		  
	   }
			return $this->result($list);
  
            }	
			


}