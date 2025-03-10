<?php
defined('AJ_ADMIN') or exit('Access Denied');

	switch($action) {
	case 'addhouse':
		$houselist = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}newhouse_huxing WHERE houseid=$house_id ORDER BY itemid desc ");
		while($r = $db->fetch_array($result)) {
			
			$houselist[] = $r;
		}
			include tpl('addhouse', $module);
		
	break;
   case 'edithouse':
		$house_sand= $db->get_one("SELECT * FROM {$AJ_PRE}newhouse_sand WHERE id=$id");
		$house_sand['huxing_id'] = !empty($house_sand['huxing_id']) ? explode(',',$house_sand['huxing_id']) : '';
		$houselist = array();
		$result = $db->query("SELECT * FROM {$AJ_PRE}newhouse_huxing WHERE houseid=$house_id ORDER BY itemid desc ");
		while($r = $db->fetch_array($result)) {
			 
			$houselist[] = $r;
		}
		
			include tpl('edithouse', $module);
		
	break;
	
	default:
	$sanpan = $db->get_one("SELECT * FROM {$db->pre}newhouse_sand_pic WHERE  house_id=$houseid");
	  if($sanpan)
        {
            if($sanpan['data'])
            {
                $data = json_decode($sanpan['data'],true);
                foreach($data as $v)
                {
                   $id_arr[$v['id']] = $v['point'];

                }
            }
        }
		$select_points =array_keys($id_arr);
	
		
		$init_points = $id_arr;
		$points = $sanpan;
		$shapanlist = array();
		$dstatus = array('在售', '预售', '售完');
		$result = $db->query("SELECT * FROM {$AJ_PRE}newhouse_sand WHERE house_id=$houseid ORDER BY id desc ");
		while($r = $db->fetch_array($result)) {
			$r['sale_status'] = $dstatus[$r['sale_status']-30];
			
			$shapanlist[] = $r;
		}
		include tpl('shapan', $module);
	break;
}

		

?>