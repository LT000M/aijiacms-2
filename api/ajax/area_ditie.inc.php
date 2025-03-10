<?php
defined('IN_AIJIACMS') or exit('Access Denied');
$area_ditie_title = isset($area_ditie_title) ? strip_tags($area_ditie_title) : '';
$area_ditie_extend = isset($area_ditie_extend) ? decrypt($area_ditie_extend, AJ_KEY.'ARE') : '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$area_ditie_deep = isset($area_ditie_deep) ? intval($area_ditie_deep) : 0;
$area_ditie_id = isset($area_ditie_id) ? intval($area_ditie_id) : 1;
echo get_area_ditie_select($area_ditie_title, $area_ditie_id, $area_ditie_extend, $area_ditie_deep, $area_ditie_id);
//echo $area_ditie_deep //echo $areaid
?>
