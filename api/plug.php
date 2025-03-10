<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
//S 自动生成tag
function substring($str, $lenth, $start=0) 
{ 
	$len = strlen($str); 
	$r = array(); 
	$n = 0;
	$m = 0;
	
	for($i=0;$i<$len;$i++){ 
		$x = substr($str, $i, 1); 
		$a = base_convert(ord($x), 10, 2); 
		$a = substr( '00000000 '.$a, -8);
		
		if ($n < $start){ 
            if (substr($a, 0, 1) == 0) { 
            }
            else if (substr($a, 0, 3) == 110) { 
              $i += 1; 
            }
            else if (substr($a, 0, 4) == 1110) { 
              $i += 2; 
            } 
            $n++; 
		}
		else{ 
            if (substr($a, 0, 1) == 0) { 
             	$r[] = substr($str, $i, 1); 
            }else if (substr($a, 0, 3) == 110) { 
             	$r[] = substr($str, $i, 2); 
            	$i += 1; 
            }else if (substr($a, 0, 4) == 1110) { 
            	$r[] = substr($str, $i, 3); 
             	$i += 2; 
            }else{ 
             	$r[] = ' '; 
            } 
            if (++$m >= $lenth){ 
              break; 
            } 
        }
	}
	return  join('',$r);
}
function convert_encoding($str,$nfate,$ofate){
	if ($ofate=="UTF-8"){ return $str; }
	if ($ofate=="GB2312"){ $ofate="GBK"; }
	if(function_exists("mb_convert_encoding")){
		$str=mb_convert_encoding($str,$nfate,$ofate);
	}
	else{
		$ofate.="//IGNORE";
		$str=iconv(  $nfate , $ofate ,$str);
	}
	return $str;
}
function getpage($url,$charset)
{
	$charset = strtoupper($charset);
	$content = "";
	if(!empty($url)) {
		if( function_exists('curl_init') ){
			$ch = @curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; )');
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_COOKIE, 'domain=www.baidu.com');
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$content = @curl_exec($ch);
			curl_close($ch);
		}
		else if( ini_get('allow_url_fopen')==1 ){
			$content = @file_get_contents($url);
		}
		else{
			die('当前环境不支持采集【curl 或 allow_url_fopen】，请检查php.ini配置；');
		}
		$content = convert_encoding($content,"utf-8",$charset);
	}
	return $content;
}
function gettag($title,$content){
	$data = getpage('http://keyword.discuz.com/related_kw.html?ics=utf-8&ocs=utf-8&title='.rawurlencode($title).'&content='.rawurlencode(substring($content,500)),'utf-8');
	if($data) {
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, $data, $values, $index);
		xml_parser_free($parser);
		$kws = array();
		foreach($values as $valuearray) {
			if($valuearray['tag'] == 'kw') {
				if(strlen($valuearray['value']) > 3){
					$kws[] = trim($valuearray['value']);
				}
			}elseif($valuearray['tag'] == 'ekw'){
				$kws[] = trim($valuearray['value']);
			}
		}
		return implode(' ',$kws);
	}
	return false;
}
//E 自动生成tag
/**
	 * 刷新房源
	 
	 */
	function yyrefresh($biao,$ids,$now_time='') {
	global $db, $dc, $CFG;
		if (is_array($ids)) {
			$ids = implode(',',$ids);
			$where = ' itemid in (' . $ids . ')';
		} else {
			$where = ' itemid =' . intval($ids);
		}
		//分开操作，保证今天发的房源排在刷新房源前面
		$to_day = mktime(0,0,0,date('m'),date('d'),date('Y'));
                if(empty($now_time)){
                    $now_time = time();
                }

		 $db->query("update {$db->pre}$biao set editdate = ".$now_time.",edittime = ".($now_time+14400)."  where " . $where." and adddate>=".$to_day);       
		 $db->query("update  {$db->pre}$biao set editdate = ".$now_time.",edittime = ".$now_time."  where " . $where." and adddate<".$to_day);
		return true;
	}
	function yycredit_add($username, $amount) {
	global $db;
	if($username && $amount) $db->query("UPDATE {$db->pre}member SET credit=credit+{$amount} WHERE username='$username'");
}
function yycredit_record($username, $amount, $editor, $reason, $note = '') {
	global $db, $AJ_TIME, $AJ;
	if($AJ['log_credit'] && $username && $amount) {
		$r = $db->get_one("SELECT credit FROM {$db->pre}member WHERE username='$username'");
		$balance = $r['credit'];
		$reason = addslashes(stripslashes(strip_tags($reason)));
		$note = addslashes(stripslashes(strip_tags($note)));
		$db->query("INSERT INTO {$db->pre}finance_credit (username,amount,balance,addtime,reason,note,editor) VALUES ('$username','$amount','$balance','$AJ_TIME','$reason','$note','$editor')");
	}
}
//统计积分
function get_jfen($username) {
	global $db;
	$buynum = $db->get_one("SELECT credit FROM {$db->pre}member WHERE username='$username'");
	$buynum = $buynum['credit'];
	return $buynum;
}
//统计分类数量
function get_xiangcenum($itemid,$catid) {
	global $db,$conditions;


$CAT=get_cat($catid);

if($catid) $conditions = $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";	
 
     $r = $db->get_one("SELECT COUNT(*) AS num FROM {$db->pre}newhouse_xiangce    where houseid=$itemid {$conditions} ");
	$categorynum = $r['num'];
	return $categorynum;
}
//统计分类数量
function get_huxingnum($itemid,$catid) {
	global $db,$conditions;


$CAT=get_cat($catid);

if($catid) $conditions = $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";	 
     $r = $db->get_one("SELECT COUNT(*) AS num FROM {$db->pre}newhouse_huxing    where houseid=$itemid {$conditions} ");
	$categorynum = $r['num'];
	return $categorynum;
}
//统计分类数量
function get_xccategory($itemid,$catid) {
	global $db,$conditions;


$CAT=get_cat($catid);

if($catid) $conditions = $CAT['child'] ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";	 
     $r = $db->get_one("SELECT COUNT(*) AS num FROM {$db->pre}newhouse_xiangce    where houseid=$itemid {$conditions} ");
	
	$categorynum = $r['num'];
	return $categorynum;
}
	//housepage
function mobilepages( $total, $page = 1 ,$moduleid,$lst, $perpage = 20) {
	global $AJ, $MOD, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	$urlrule='m'.$moduleid.'{$lst}-g{$page}.html';
	$urlrule = str_replace('{$lst}',$lst,$urlrule);
	$findme = '{$page}';
    $replaceme = '1';
     $demo_url = str_replace($findme,$replaceme,$urlrule);

	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);
    $demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
    $url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
   if($page >1)$pages .= '<a class="prev" href="'.$url.'"><i>&lt;</i>'.$L['prev_page'].'</a> ';
         if($total <= 5) { $min=1; $max=$total; }
		 if($total >6) {
		if($page < 5) {$min = 1; $max = 6;}
		if($page >= 5)  { $min=$page-3; $max=$page+3; }
		if($page >= $total-3)  { $min=$total-6; $max=$total; }
		}
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
			$pages .= $page == $_page ? '<span>'.$_page.'</span>' : ' <a href="'.$url.'">'.$_page.'</a>  ';
		}

$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
if($page<>$total)$pages .= '<a  class="next" href="'.$url.'">'.$L['next_page'].'<i>&gt;</i></a>';

	return $pages;
}
function housedpages( $total, $page = 1 ,$lst, $perpage = 20) {
	global $AJ, $MOD, $L;
	if($total <= $perpage) return '';
	$items = $total;
	$total = ceil($total/$perpage);
	if($page < 1 || $page > $total) $page = 1;
	$urlrule='{$lst}-g{$page}.html';
	$urlrule = str_replace('{$lst}',$lst,$urlrule);
	$findme = '{$page}';
    $replaceme = '1';
     $demo_url = str_replace($findme,$replaceme,$urlrule);

	$pages = '';
	$_page = $page <= 1 ? $total : ($page - 1);
    $demo_url = str_replace(array('%7B', '%7D'), array('{', '}'), $demo_url);
    $url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
    if($page >1)$pages .= '<a class="prev" href="'.$url.'"><i>&lt;</i>'.$L['prev_page'].'</a> ';
         if($total <= 7) { $min=1; $max=$total; }
		 if($total >7) {
		if($page < 5) {$min = 1; $max = 7;}
		if($page >= 5)  { $min=$page-3; $max=$page+3; }
		if($page >= $total-3)  { $min=$total-6; $max=$total; }
		}
		for($_page = $min; $_page <= $max; $_page++) {
			$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
			$pages .= $page == $_page ? '<span>'.$_page.'</span>' : ' <a href="'.$url.'">'.$_page.'</a>  ';
		}

$_page = $page >= $total ? 1 : $page + 1;
$url = $_page == 1 ? $demo_url : str_replace('{$page}', $_page, $urlrule);
if($page<>$total)$pages .= '<a  class="next" href="'.$url.'">'.$L['next_page'].'<i>&gt;</i></a>';

	return $pages;
}
function seo_cats($catid,  $moduleid = 1) {
	global $MODULE, $db,$html;
	$condition = "moduleid=$moduleid AND parentid=0 AND catid IN ($catid)";
	$result = $db->query("SELECT catid,moduleid,catname FROM {$db->pre}category where $condition");
	
	while($c = $db->fetch_array($result)) {
		    
			 $html .= $c['catname'] . "";
			
		
		}
       $html = rtrim($html, ','); 
	return $html;
}

//表单
function getsearchstr($str1,$str2,$class,$danwei,$name,$getstr,$css) {
	global $db,$AJ;
	 $i=0;$a=preg_split("/,/",$name);
	 for($j=0;$j<=count($a);$j++){
  if(0==$i){$str=$a[0].$danwei."以下";$m1=0;$m2=$a[0];}
  elseif(count($a)==$i){$str=$a[count($a)-1].$danwei."以上";$m1=$a[count($a)-1];$m2=999999;}
  else{$str=$a[$j-1]."-".$a[$j].$danwei;$m1=$a[$j-1];$m2=$a[$j];}
  if(check_in("_".$str1.$m1."v",$getstr) && check_in("_".$str2.$m2."v",$getstr)){
	   $str = '<'.$class.'><a href="'.rentser($str1,$m1,$str2,$m2,'','p').'"'.$target.'  class='. $css.'>'.$str.'</a></'.$class.'>';}
	   else
	   { $str = '<'.$class.'><a href="'.rentser($str1,$m1,$str2,$m2,'','p').'"'.$target.' >'.$str.'</a></'.$class.'>';}
  
 echo $str;
   $i++;
   }

	//return $str ;
}
//筛选数组
//表单

//小区二手房
function getxqsearchstr($str1,$str2,$class,$danwei,$name,$getstr,$css,$moduname,$linkurl) {
	global $db,$AJ;
	 $i=0;$a=preg_split("/,/",$name);
	 for($j=0;$j<=count($a);$j++){
  if(0==$i){$str=$a[0].$danwei."以下";$m1=0;$m2=$a[0];}
  elseif(count($a)==$i){$str=$a[count($a)-1].$danwei."以上";$m1=$a[count($a)-1];$m2=999999;}
  else{$str=$a[$j-1]."-".$a[$j].$danwei;$m1=$a[$j-1];$m2=$a[$j];}
  if(check_in("_".$str1.$m1."v",$getstr) && check_in("_".$str2.$m2."v",$getstr)){
	   $str = '<'.$class.'><a href="'.$linkurl.$moduname.'/'.rentser($str1,$m1,$str2,$m2,'','p').'"'.$target.'  class='. $css.'>'.$str.'</a></'.$class.'>';}
	   else
	   { $str = '<'.$class.'><a href="'.$linkurl.$moduname.'/'.rentser($str1,$m1,$str2,$m2,'','p').'"'.$target.' >'.$str.'</a></'.$class.'>';}
  
 echo $str;
   $i++;
   }

	//return $str ;
}
function getcomsearch($danwei,$name,$username,$file) {
	global $db,$AJ;
	 $i=0;$a=preg_split("/,/",$name);
	 for($j=0;$j<=count($a);$j++){
  if(0==$i){$str=$a[0].$danwei."以下";$m1=0;$m2=$a[0];}
  elseif(count($a)==$i){$str=$a[count($a)-1].$danwei."以上";$m1=$a[count($a)-1];$m2=999999;}
  else{$str=$a[$j-1]."-".$a[$j].$danwei;$m1=$a[$j-1];$m2=$a[$j];}
  $linkurl=AJ_PATH.'index.php?homepage='.$username.'&file='.$file.'&r='.$_GET['r'].'&g='.$_GET['g'].'&h='.$_GET['h'].'&b='.$m1.'&c='.$m2;
 
  $str = '<dt><a href="'. $linkurl.'"'.$target.' >'.$str.'</a></dt>';
  
  
  
 echo $str;
   $i++;
   }

	//return $str ;
}
function getcomsearchearm($danwei,$name,$username,$file) {
	global $db,$AJ;
	 $i=0;$a=preg_split("/,/",$name);
	 for($j=0;$j<=count($a);$j++){
  if(0==$i){$str=$a[0].$danwei."以下";$m1=0;$m2=$a[0];}
  elseif(count($a)==$i){$str=$a[count($a)-1].$danwei."以上";$m1=$a[count($a)-1];$m2=999999;}
  else{$str=$a[$j-1]."-".$a[$j].$danwei;$m1=$a[$j-1];$m2=$a[$j];}
  $linkurl=AJ_PATH.'index.php?homepage='.$username.'&file='.$file.'&r='.$_GET['r'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&g='.$m1.'&h='.$m2;
 
  $str = '<dt><a href="'. $linkurl.'"'.$target.' >'.$str.'</a></dt>';
  
  
  
 echo $str;
   $i++;
   }

	//return $str ;
}

function rentser($x= null,$xv= null,$y= null,$yv= null,$nq="list",$z='',$zv=''){
if(empty($nq)){$nq="list";}
$nstr=$_GET[str];
if(!check_in("_".$x.$xv."v",$nstr)){
if(check_in("_".$x,$nstr)){
 $a=preg_split("/_".$x."/",$nstr);
 $re3=preg_split("/_/",$a[1]);
 $b=preg_split("/v/",$re3[0]);
 $ssr="";for($ri=0;$ri<count($b);$ri++){$ssr=$ssr.$b[$ri];if($ri<(count($b)-2)){$ssr=$ssr."v";}}
 $d=preg_split("/_".$x.$ssr."v/",$nstr);
 $nstr=$a[0]."_".$x.$xv."v".$d[1];
}else{
 $nstr=$nstr."_".$x.$xv."v";
}
}
if($y!=""){
if(!check_in("_".$y.$yv."v",$nstr)){
if(check_in("_".$y,$nstr)){
 $a=preg_split("/_".$y."/",$nstr);
 $re3=preg_split("/_/",$a[1]);
 $b=preg_split("/v/",$re3[0]);
 $ssr="";for($ri=0;$ri<count($b);$ri++){$ssr=$ssr.$b[$ri];if($ri<(count($b)-2)){$ssr=$ssr."v";}}
 $d=preg_split("/_".$y.$ssr."v/",$nstr);
 $nstr=$a[0]."_".$y.$yv."v".$d[1];
}else{
 $nstr=$nstr."_".$y.$yv."v";
}
}
}
if($z!=""){
if(!check_in("_".$z.$zv."v",$nstr)){
if(check_in("_".$z,$nstr)){
 $a=preg_split("/_".$z."/",$nstr);
 $re3=preg_split("/_/",$a[1]);
 $b=preg_split("/v/",$re3[0]);
 $ssr="";for($ri=0;$ri<count($b);$ri++){$ssr=$ssr.$b[$ri];if($ri<(count($b)-2)){$ssr=$ssr."v";}}
 $d=preg_split("/_".$z.$ssr."v/",$nstr);
 $nstr=$a[0]."_".$z.$zv."v".$d[1];
}else{
 $nstr=$nstr."_".$z.$zv."v";
}
}
}
if($xv==""){$nstr=str_replace("_".$x."v","",$nstr);}
if($yv==""){$nstr=str_replace("_".$y."v","",$nstr);}
if($zv==""){$nstr=str_replace("_".$z."v","",$nstr);}
return ($nq.$nstr).".html";
}

function returnsx($x){
	//$str  = isset(str) ? intval($str ) : 0;
 $nstr=$_GET['str'];
 if(check_in("_".$x,$nstr)){
 $re1=preg_split("/_".$x."/",$nstr);
 $re3=preg_split("/_/",$re1[1]);
 $re2=preg_split("/v/",$re3[0]); 
 $ssr="";
 for($ri=0;$ri<count($re2);$ri++){$ssr=$ssr.$re2[$ri];if($ri<(count($re2)-2)){$ssr=$ssr."v";}}
 if($ssr==""){$nr=-1;}else{$nr=$ssr;}
 return $nr;
 }else{
 return -1;
 }
}

function check_in($arr, $text){
$keys = explode(',',$arr);
$result = 0;
if($keys){
 foreach($keys as $key){
 if(strstr($text,$key)!=''){$result = 1;break;}
 }
}
return $result;
}
 //新房房价走势月份
function get_houseyue($pid) {
	 
	$result = DB::query("select price,addtime from ".AJ_PRE."newhouse_price  where status=3 and pid =$pid ORDER BY addtime ASC LIMIT 0,6");
	while($r = DB::fetch_array($result)) {
	      $r['adddate'] = timetodate($r['addtime'], 'Y-m');
		  $date.=$r['adddate'].','; 
		  $linedate = substr($date,0,strlen($date)-1); 
		 

	}
	//$lineprice="[".$linedate."],[".$lineprice."]";
	return $linedate;
}
 //新房房价走势价格
function get_housejia($pid) {
	 
	$result = DB::query("select price,addtime from ".AJ_PRE."newhouse_price  where status=3 and pid =$pid ORDER BY addtime ASC LIMIT 0,6");
	while($r = DB::fetch_array($result)) {
	      $r['adddate'] = timetodate($r['addtime'], 3);
		  $avg_price.= $r['price'].',';  
		  $lineprice = substr($avg_price,0,strlen($avg_price)-1); 

	}
	//$lineprice="[".$linedate."],[".$lineprice."]";
	return $lineprice;
}
function get_oldpic($thumb, $type = 0) {
	$imgs = '';
	if($thumb && !preg_match("/^[a-z0-9\-\.\:\/]{50,}$/i", $thumb)) $thumb = '';
	if($type == 0) {
		$nopic = AJ_SKIN.'image/nopic60.gif';
		$imgs = $thumb ? $thumb : $nopic;
	} else if($type == 1) {
		$nopic = AJ_SKIN.'image/nopic240.gif';
		$imgs = $thumb ? str_replace('.thumb.', '.middle.', $thumb) : $nopic;
	}
	else if($type == 2) {
		$nopic = AJ_SKIN.'image/nopic240.gif';
		if(strstr($thumb, '.thumb'))
		{$imgs = $thumb ?  str_before($thumb, '.thumb') : $nopic;}
		else
		$imgs = $thumb ? $thumb : $nopic;
		
	}
	
	return $imgs;
}
function str_before($subject, $needle)
{
    $p = strpos($subject, $needle);
    return substr($subject, 0, $p);
}
 //用户登录
    function bbsregister($uc_username,$password){
		global $db, $AJ, $AJ_PRE,$AJ_ROOT;
		require AJ_ROOT.'/include/post.func.php';
		
		$this->table_member = AJ_PRE.'member';
		$this->table_member_misc = AJ_PRE.'member_misc';
		$this->table_member_check = AJ_PRE.'member_check';
		$this->table_company = AJ_PRE.'company';
		$this->table_company_data = AJ_PRE.'company_data';
	
		$member['username'] = $uc_username;
		$member['passport'] = $uc_username;
        $member['linkurl'] = userurl($member['username']);
		$member['groupid'] =5;
		$member['regid'] = 5;
		$member['passsalt'] = random(8);
		$member['paysalt'] = random(8);
		$member['password'] = dpassword($password, $member['passsalt']);
		$member['payword'] = dpassword($password, $member['paysalt']);
		$member['sound'] = 1;
		$member['letter'] = GetPinyin($member['company']);
		$member_fields = array('username','company','passport', 'password','payword','email','sound','gender','truename','mobile','qq','wx','wxqr','ali','skype','department','career','groupid','regid','areaid','edittime','inviter','passsalt', 'paysalt','companyid','oppid');
		$misc_fields = array('username','bank','banktype','branch','account','reply','black', 'send');
		$company_fields = array('username','groupid','company','type','catid','catids','areaid', 'mode','capital','regunit','size','regyear','sell','buy','business','telephone','fax','mail','gzh','gzhqr','address','postcode','homepage','introduce','thumb','keyword','linkurl','letter');
		$member_sqlk = $member_sqlv = $misc_sqlk = $misc_sqlv = $company_sqlk = $company_sqlv = '';
		foreach($member as $k=>$v) {
			if(in_array($k, $member_fields)) {$member_sqlk .= ','.$k; $member_sqlv .= ",'$v'";}
			if(in_array($k, $company_fields)) {$company_sqlk .= ','.$k; $company_sqlv .= ",'$v'";}
			if(in_array($k, $misc_fields)) {$misc_sqlk .= ','.$k; $misc_sqlv .= ",'$v'";}
		}
        $member_sqlk = substr($member_sqlk, 1);
		
        $member_sqlv = substr($member_sqlv, 1);
        $misc_sqlk = substr($misc_sqlk, 1);
        $misc_sqlv = substr($misc_sqlv, 1);
        $company_sqlk = substr($company_sqlk, 1);
        $company_sqlv = substr($company_sqlv, 1);
	if($ismobile) {
		$list = array('code' => 0,'msg'=>"手机号已注册") ;}
	else
	{
		
		DB::query("INSERT INTO {$this->table_member} ($member_sqlk,regip,regtime,loginip,logintime)  VALUES ($member_sqlv,'".AJ_IP."','".AJ_TIME."','".AJ_IP."','".AJ_TIME."')");
		$this->userid = DB::insert_id();
		if(!$this->userid) return 0;
		$member['userid'] = $this->userid;
		$this->username = $member['username'];
	    DB::query("INSERT INTO {$this->table_member_misc} (userid, $misc_sqlk) VALUES ('$this->userid', $misc_sqlv)");
	    DB::query("INSERT INTO {$this->table_company} (userid, $company_sqlk) VALUES ('$this->userid', $company_sqlv)");
		$content_table = content_table(4, $this->userid, is_file(AJ_CACHE.'/4.part'), $this->table_company_data);
	    DB::query("INSERT INTO {$content_table} (userid, content) VALUES ('$this->userid', '$member[content]')");
	
	
	   }
		return $this->userid;
       
	 
	   
    }
	 function cuts($begin,$end,$str){
    $b = mb_strpos($str,$begin) + mb_strlen($begin);
    $e = mb_strpos($str,$end) - $b;
    return mb_substr($str,$b,$e);
}
function checkStr($str,$target)
{
  $tmpArr = explode($str,$target);
  //print_r($tmpArr);
  if(count($tmpArr)>1)return true;
  else return false;
}
?>