<?php
require '../common.inc.php';
 header('content-type:application/json;charset=utf-8');
 $base_rate=$AJ['base_rate'];
  $list = array('base_rate' => $AJ['base_rate'],'lpr_rate'=>$AJ['lpr_rate'],'fund_rate'=>$AJ['fund_rate']);
 
		  echo json_encode($list);


?>