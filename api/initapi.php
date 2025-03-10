<?php
/**
 * 后台菜单接口定义
 *

 * @url 
 */


require '../common.inc.php';
class Response{
	public function result($list) {
		header('content-type:application/json;charset=utf-8');
		exit(json_encode($list));
	}

	
	//
	
	public function initapi($userid,$admin){
		global $db, $AJ;
		if($admin >1){
		$result = DB::query("SELECT * FROM ".AJ_PRE."navmenu,".AJ_PRE."admin WHERE ".AJ_PRE."admin.userid=$userid AND ".AJ_PRE."navmenu.title=".AJ_PRE."admin.title and ".AJ_PRE."navmenu.parentid=0 and ".AJ_PRE."navmenu.status=1  ORDER BY ".AJ_PRE."navmenu.listorder,".AJ_PRE."navmenu.navid DESC");
		
		}
		else
		{$result =$db->query("SELECT navid,name,title,icon,child  FROM {$db->pre}navmenu where  parentid=0 and status=1  ORDER BY listorder,navid DESC");}
	
		while($r = $db->fetch_array($result)) {
			$navid= $r['navid'] ;
			$r['icon']='fa '.$r['icon'];
			
			$results = $db->query("SELECT title,href,icon,target,navid,child FROM {$db->pre}navmenu WHERE parentid=$navid and status=1 ORDER BY listorder,navid DESC");
			$childlist=array();
			while($cr = $db->fetch_array($results)) {	
			$navids=$cr['navid'];
			  $cr['icon']='fa '.$cr['icon'];
				$cr['target']=$cr['target'] ? '_self' : '';
			 $resultsm = $db->query("SELECT title,href,icon,target,parentid FROM {$db->pre}navmenu WHERE parentid=$navids and status=1 ORDER BY listorder,navid DESC");
$childlistsm=array();
			  while($crm = $db->fetch_array($resultsm)) {
				$crm['icon']='fa '.$crm['icon'];
				$crm['target']=$crm['target'] ? '_self' : '';
			 $childlistsm[]= $crm;
			
			
			  }
			   $cr['child']=$cr['child'] ? $childlistsm : '';
			$childlist[]= $cr;
			}
			
			if($r['child']) $r['child'] =$childlist;	
		   // $childlists[$navid]= $r;	
		   
			
			
			
			
			
		    $menuInfo[$r['name']]= $r;	
		  }
	

        $clearInfo=array();
	    $clearInfo = array("clearUrl"=>"admin/layui/api/clear.json");
		$homeInfo=array();
		$homeInfo = array("title"=>"首页","icon"=>"fa fa-home","href"=>"?action=main");
		$logoInfo=array();
		$logoInfo = array("title"=>$AJ['sitename'],"image"=>"admin/layui/images/logo.png","href"=>"");

		 $data = array('clearInfo'=>$clearInfo,'homeInfo'=>$homeInfo,'logoInfo'=>$logoInfo,'menuInfo'=>$menuInfo);
		
			return $this->result($data);
      
    }
	
	
	


}