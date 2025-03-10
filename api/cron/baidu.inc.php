    <?php 
    	//引入全局变量函数
    	defined('IN_AIJIACMS') or exit('Access Denied');
    	$bdsite =  $AJ['baidu_site']; //获取后台百度pcsite参数值
    	$bdtoken = $AJ['baidu_token']; //获取后台百度token参数值
    	$time = $today_endtime - 30*86400;
    	$time = time();
    	$starttime = $time - 72*3600;//24小时
    	$condition = "status=3"; //正常通过审核的信息
    	$limitList = 10; //限制只推送的条数
    	$query = "SELECT linkurl FROM {$AJ_PRE}article_8 WHERE $condition ORDER BY addtime DESC LIMIT $limitList";  //获取本模块推送的网址URL
    	//$query = "SELECT linkurl FROM {$AJ_PRE}article_21 WHERE addtime > $starttime ORDER BY itemid ASC LIMIT $limitList";  //查询当天的数据URL
    	//$query = "SELECT linkurl FROM {$AJ_PRE}article_21 WHERE addtime > $starttime AND thumb<>'' ORDER BY itemid ASC LIMIT $limitList";  //查询当天出图的数据URL
    	 
    	//开始全部推送
    	$result = $db->query($query);
    	$urls = "";
    	
        $domain = $MODULE[8][linkurl].$r['linkurl'];
    	while ($r = $db->fetch_array(($result))){ 
    		$linkurl = $r['linkurl'];
    		$urls .= $domain.$linkurl.",";   //获取详情网址
    		$tsurls .= $domain.$linkurl."\r\n";
    		$tsurl = $tsurls;
    	}
    	$urls = substr($urls,0,-1);
    	$urls = explode(",",$urls);
    	 
    	//百度熊掌推送
    	$api = 'http://data.zz.baidu.com/urls?site='.$bdsite.'&token='.$bdtoken;
    	$ch = curl_init();
    	$options =  array(
    	    CURLOPT_URL => $api,
    	    CURLOPT_POST => true,
    	    CURLOPT_RETURNTRANSFER => true,
    	    CURLOPT_POSTFIELDS => implode("\n", $urls),
    	    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    	);
    	curl_setopt_array($ch, $options);
    	$result = curl_exec($ch);
    	$result = json_decode($result, true);
        $jgtime = "百度主动推送反馈结果：\r\n记录时间：".date('Y-m-d H:i:s',time());
     
        $jieguo = $jgtime."\r\n\r\n教程信息PC链接已完成百度普通推送。\r\n已成功推送：".$result['success']."条！\r\n今天剩余可推送：".$result['remain']."条！\r\n推送的网址列表：\r\n".$tsurl."\r\n";
    	//echo $result;
    	//$jieguo = date('Y-m-d H:i:s',time())."返回结果(remain表示剩余条数,success表示成功推送条数)：".$result."\r\n";
    	$file = file_put_contents('file/cache/baidu/baidupc_'.date('Y-m-d H:i:s',time()).'.txt', $jieguo); //执行记录
    ?>