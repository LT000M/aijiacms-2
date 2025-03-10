<?php
require('path.inc.php');
$page->name = 'index'; //页面名字,和文件名相同
$page->title = iconv('gb2312','utf-8',$page->title);
$page->titlec = iconv('gb2312','utf-8',$page->titlec);
$page->city = iconv('gb2312','utf-8',$page->city);
$page->mapkeyword = iconv('gb2312','utf-8',$page->mapkeyword);
$page->mapdescription = iconv('gb2312','utf-8',$page->mapdescription);
$page->googlekey = iconv('gb2312','utf-8',$page->googlekey);

$realname = iconv('gb2312','utf-8',$realname);
$page->tpl->assign('username',$realname);


//区域字典
$cmap = new CityareaMap($query);
$cmap_option = $cmap->getList('*','','');
foreach ($cmap_option as $key=> $item){
		$cmap_option[$key]['cityarea_name'] = iconv('gb2312','utf-8', $item['cityarea_name']);
	}
$page->tpl->assign('cmap_option', $cmap_option);


//售价
$house_price_option = array(
	'1-40'=>'40万以下',
	'40-60'=>'40-60万',
	'60-80'=>'60-80万',
	'80-100'=>'80-100万',
	'100-120'=>'100-120万',
	'120-150'=>'120-150万',
	'150-200'=>'150-200万',
	'200-250'=>'200-250万',
	'250-300'=>'250-300万',
	'300-500'=>'300-500万',
	'500-0'=>'500万以上'
);
$page->tpl->assign('house_price_option', $house_price_option);

//建面
$house_totalarea_option = array(
	'1-50'=>'50㎡以下',
	'50-70'=>'50-70㎡',
	'70-90'=>'70-90㎡',
	'90-110'=>'90-110㎡',
	'110-130'=>'110-130㎡',
	'130-150'=>'130-150㎡',
	'150-200'=>'150-200㎡',
	'200-250'=>'200-250㎡',
	'250-300'=>'250-300㎡',
	'300-500'=>'300-500㎡',
	'500-0'=>'500㎡以上'
);
$page->tpl->assign('house_totalarea_option', $house_totalarea_option);

//房屋类型
$house_type_option = array(
	'1'=>'住宅',
	'2'=>'别墅',
	'5'=>'写字楼',
	'3'=>'沿街店面',
	'8'=>'商铺',
	'7'=>'自建房',
	'4'=>'厂房/仓库',
	'6'=>'车库',
);
$page->tpl->assign('house_type_option', $house_type_option);
$page->show();
?>