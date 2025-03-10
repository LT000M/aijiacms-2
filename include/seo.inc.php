<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
$seo_modulename = $MOD['name'];
$seo_sitename = $city_sitename ? $city_sitename : $AJ['sitename'];
$seo_sitetitle = $AJ['seo_title'];
$seo_sitekeywords = $AJ['seo_keywords'];
$seo_sitedescription = $AJ['seo_description'];
$seo_delimiter = $AJ['seo_delimiter'];
$seo_page = $page > 1 ? lang($L['seo_page'], array($page)).$seo_delimiter : '';
$seo_catname = $seo_cattitle = $seo_parentname = $seo_catkeywords = $seo_catdescription = '';
$catid = returnsx("t") > 0 ? returnsx("t") : $catid;

if($catid) {
	if($moduleid==6)$CAT['catname']=seo_cats($catid, '6');
	if($moduleid==18)$CAT['catname']=seo_cats($catid, '18');
	//$CAT['catname']=seo_cats($catid, $moduleid);
	if($CAT['parentid']) {
		$seo_catname = '';
		$tmp = strip_tags(cat_pos($CAT, 'AIJIACMS'));
		$tmp = explode('AIJIACMS', $tmp);
		$tmp = array_reverse($tmp);
		foreach($tmp as $k=>$v) {
			$seo_catname .= $v.$seo_delimiter;
		}
	} else {
		$seo_catname = $CAT['catname'].$seo_delimiter;
	}
	$seo_cattitle = $CAT['seo_title'] ? $CAT['seo_title'].$seo_delimiter : $seo_catname;
	$seo_catkeywords = $CAT['seo_keywords'] ? $CAT['seo_keywords'] : '';
	$seo_catdescription = $CAT['seo_description'] ? $CAT['seo_description'] : '';
}
if($moduleid==6)
{ $danwei='元';
$fix_arr = getbox_name('fitment','newhouse_6');
$buildtype_arr = getbox_name('buildtype','newhouse_6');
$lpts_arr = getbox_name('lpts','newhouse_6');
}
elseif($moduleid==5)
{ $fix_arr = getbox_name('fix','sale_5');
$toward_arr = getbox_name('toward','sale_5');

$danwei='万元';}
else
{$fix_arr = getbox_name('zhuanxiu','rent_7');
$toward_arr = getbox_name('toward','rent_7');
	
	$danwei='元/月';}

$catid = returnsx("t") > 0 ? returnsx("t") : $catid;
$catid = returnsx("t") > 0 ? returnsx("t") : $catid;

//$seo_areaname = (isset(returnsx("a")) && returnsx("a")) ? area_pos(returnsx("a"), $seo_delimiter).$seo_delimiter : '';
$seo_areaname = area_pos(returnsx("a"), $seo_delimiter);
//$seo_areaname = (isset($areaid) && $areaid) ? area_pos($areaid, $seo_delimiter).$seo_delimiter : '';
$seo_twoareaname = area_poss(returnsx("d"), $seo_delimiter);

if(returnsx("c")>0)$seo_price =  returnsx("b").'-'.returnsx("c").$danwei;
if(returnsx("r")>0)$seo_room =  returnsx("r").'室';
if(returnsx("g")>0)$seo_housearea =  returnsx("g").'-'.returnsx("h").'平米';
if(returnsx("y")>0)$seo_houseyear =  returnsx("y").'-'.returnsx("w").'年';
if(returnsx("l")>0)$seo_floor =  returnsx("l").'-'.returnsx("e").'层';
$seo_leibie = returnsx("r") ==1 ? '出租' : '出售';
$seo_buyleibie = returnsx("u") ==1 ? '出租' : '出售';
$seo_fix =  $fix_arr[returnsx("f")];
$seo_toward =  $toward_arr[returnsx("t")];
$seo_buildtype =  $buildtype_arr[returnsx("j")];
$seo_lpts =  $lpts_arr[returnsx("l")];
$seo_showtitle = isset($title) ? $title.$head_title : '';
$seo_showintroduce = isset($introduce) ? $introduce : '';
switch($seo_file) {
	case 'index':
		if($MOD['title_index']) {
			eval("\$seo_title = \"$MOD[title_index]\";");
		} else {
			$seo_title = $seo_modulename.$seo_delimiter.$seo_sitename;
		}
		if($MOD['keywords_index']) eval("\$head_keywords = \"$MOD[keywords_index]\";");
		if($MOD['description_index']) eval("\$head_description = \"$MOD[description_index]\";");
	break;
	case 'list':
		if($CAT['seo_title']) {
			$seo_title = $CAT['seo_title'];
		} else if($MOD['title_list']) {
			eval("\$seo_title = \"$MOD[title_list]\";");
		} else {
			$seo_title = $seo_cattitle.$seo_page.$seo_modulename.$seo_delimiter.$seo_sitename;
		}
		$_seo_catname = $seo_catname;
		$_seo_areaname = $seo_areaname;
		if($CAT['seo_keywords']) {
			$head_keywords = $CAT['seo_keywords'];
		} else if($MOD['keywords_list']) {
			if($_seo_catname) $seo_catname = str_replace($seo_delimiter, ',', $_seo_catname);
			if($_seo_areaname) $seo_areaname = str_replace($seo_delimiter, ',', $_seo_areaname);
			eval("\$head_keywords = \"$MOD[keywords_list]\";");
		}
		if($CAT['seo_description']) {
			$head_description = $CAT['seo_description'];
		} else if($MOD['description_list']) {
			if($_seo_catname) $seo_catname = str_replace($seo_delimiter, ' ', $_seo_catname);
			if($_seo_areaname) $seo_areaname = str_replace($seo_delimiter, ' ', $_seo_areaname);
			eval("\$head_description = \"$MOD[description_list]\";");
		}
	break;
	case 'show':
		if($MOD['title_show']) {
			eval("\$seo_title = \"$MOD[title_show]\";");
		} else {
			$seo_title = $seo_showtitle.$seo_delimiter.$seo_catname.$seo_modulename.$seo_delimiter.$seo_sitename;
		}
		$_seo_catname = $seo_catname;
		$_seo_areaname = $seo_areaname;
		if($MOD['keywords_show']) {
			if($_seo_catname) $seo_catname = str_replace($seo_delimiter, ',', $_seo_catname);
			if($_seo_areaname) $seo_areaname = str_replace($seo_delimiter, ',', $_seo_areaname);
			eval("\$head_keywords = \"$MOD[keywords_show]\";");
		} else {
			$head_keywords = $keyword;
		}
		if($MOD['description_show']) {
			if($_seo_catname) $seo_catname = str_replace($seo_delimiter, ' ', $_seo_catname);
			if($_seo_areaname) $seo_areaname = str_replace($seo_delimiter, ' ', $_seo_areaname);
			eval("\$head_description = \"$MOD[description_show]\";");
		} else {
			$head_description = $introduce ? $introduce : $title;
		}
	break;
	case 'search':
		if($MOD['title_search']) {
			$seo_kw = $kw ? $kw.$seo_delimiter : '';
			eval("\$seo_title = \"$MOD[title_search]\";");
		} else {
			$seo_title = $seo_modulename.$L['search'].$seo_delimiter.$seo_page.$seo_sitename;
			if($catid) $seo_title = $seo_catname.$seo_title;
			if($areaid) $seo_title = $seo_areaname.$seo_title;
			if($kw) $seo_title = $kw.$seo_delimiter.$seo_title;
		}
		$_seo_catname = $seo_catname;
		$_seo_areaname = $seo_areaname;
		if($MOD['keywords_search']) {
			if($_seo_catname) $seo_catname = str_replace($seo_delimiter, ',', $_seo_catname);
			if($_seo_areaname) $seo_areaname = str_replace($seo_delimiter, ',', $_seo_areaname);
			$seo_kw = $kw ? $kw.',' : '';
			eval("\$head_keywords = \"$MOD[keywords_search]\";");
		}
		if($MOD['description_search']) {
			if($_seo_catname) $seo_catname = str_replace($seo_delimiter, ' ', $_seo_catname);
			if($_seo_areaname) $seo_areaname = str_replace($seo_delimiter, ' ', $_seo_areaname);
			$seo_kw = $kw ? $kw : '';
			eval("\$head_description = \"$MOD[description_search]\";");
		}
	break;
	default:
	break;
}
?>