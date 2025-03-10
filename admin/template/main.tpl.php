<!DOCTYPE html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="keywords" content="LightYear,LightYearAdmin,光年,后台模板,后台管理系统,光年HTML模板">
<meta name="description" content="Light Year Admin V5是一个基于Bootstrap v5.1.3的后台管理系统的HTML模板。">
<title>首页 - 光年(Light Year Admin V4)后台管理系统模板</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="admin/bootstrap/css/style.min.css">
</head>
  
<body>
<div class="container-fluid">

  <div class="row">

    <div class="col-md-6 col-xl-3">
      <div class="card bg-primary text-white">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <span class="avatar-md rounded-circle bg-white bg-opacity-25 avatar-box">
              <i class="mdi mdi-account fs-4"></i>
            </span>
            <span class="fs-4"><?php echo $db->count($AJ_PRE.'member', 'regtime>('.$today_endtime.'-86400) '.$condition.'', 1);?></span>
          </div>
          <div class="text-end">今日新增用户</div>
        </div>
      </div>
    </div>

  	<div class="col-md-6 col-xl-3">
  	  <div class="card bg-danger text-white">
  	    <div class="card-body">
  	      <div class="d-flex justify-content-between">
  	        <span class="avatar-md rounded-circle bg-white bg-opacity-25 avatar-box">
              <i class="mdi mdi-greenhouse fs-4"></i>
            </span>
  	        <span class="fs-4"><?php echo $db->count($AJ_PRE.'newhouse_6', 'status=3 and isnew=1 '.$condition.' and TO_DAYS(now())=TO_DAYS(adddate)', 1);?></span>
  	      </div>
  	      <div class="text-end">今日新增新房</div>
  	    </div>
  	  </div>
  	</div>

  	<div class="col-md-6 col-xl-3">
  	  <div class="card bg-success text-white">
  	    <div class="card-body">
  	      <div class="d-flex justify-content-between">
  	        <span class="avatar-md rounded-circle bg-white bg-opacity-25 avatar-box">
              <i class="mdi mdi-point-of-sale fs-4"></i>
            </span>
  	        <span class="fs-4"><?php echo $db->count($AJ_PRE.'sale_5', 'status=3  '.$condition.' and TO_DAYS(now())=TO_DAYS(adddate)', 1);?></span>
  	      </div>
  	      <div class="text-end">今日新增二手房</div>
  	    </div>
  	  </div>
  	</div>

  	<div class="col-md-6 col-xl-3">
  	  <div class="card bg-purple text-white">
  	    <div class="card-body">
  	      <div class="d-flex justify-content-between">
  	        <span class="avatar-md rounded-circle bg-white bg-opacity-25 avatar-box">
              <i class="mdi mdi-cellphone fs-4"></i>
            </span>
  	        <span class="fs-4"><?php echo $db->count($AJ_PRE.'rent_7', 'status=3  '.$condition.' and TO_DAYS(now())=TO_DAYS(adddate)', 1);?></span>
  	      </div>
  	      <div class="text-end">今日新增租房</div>
  	    </div>
  	  </div>
  	</div>

  </div>

  <div class="row">

  	<div class="col-md-6">
  	  <div class="card">
  	    <div class="card-header">
  	      <div class="card-title">流量趋势</div>
  	    </div>
  	    <div class="card-body">
  	      <canvas class="js-chartjs-bars"></canvas>
  	    </div>
  	  </div>
  	</div>

  	<div class="col-md-6">
  	  <div class="card">
  	    <div class="card-header">
          <div class="card-title">UV趋势</div>
  	    </div>
  	    <div class="card-body">
  	      <canvas class="js-chartjs-lines"></canvas>
  	    </div>
  	  </div>
  	</div>

  </div>

  <div class="row">

  	<div class="col-lg-12">
  	  <div class="card">
  	    <header class="card-header">
  	      <div class="card-title">预约记录</div>
  	    </header>
  		<div class="card-body">
  		  <div class="table-responsive">
  		    <table class="table table-hover">
  		      <thead>
  		       <tr>
                                <th>联系人</th>
                                <th>联系电话</th>
                                <th>楼盘</th>
                                <th>内容</th>
                                <th>提交时间</th>
                                <th>状态</th>
                              
                            </tr>
  		      </thead>
  			  <tbody>
  			   	<?php foreach($subscribes as $k=>$v) {?>
                            <tr>
                                
								<td><?php echo $v['fromuser'] ? $v['fromuser'] : '游客';?></td>
                                <td> <?php echo $v['telephone']?></td>
                                <td><?php echo $v['title']?></td>
                                <td><?php echo $v['content']?></td>
                                <td><?php echo timetodate($v['addtime'], 6);?></td>
								<td><?php echo $v['status'] ? '待联系' : '已联系';?></td>
                             
                            </tr>
                           <?php } ?>
  			  </tbody>
            </table>
  	      </div>
  	    </div>
  	  </div>
    </div>
	
	 <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header ">
                    版本信息
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <tbody>
                            <tr>
                                <th>当前版本</th>
                                <td>AIJIACMS Version <?php echo AJ_VERSION;?>  <?php echo AJ_RELEASE;?> <?php echo AJ_CHARSET;?> <?php echo strtoupper(AJ_LANG);?></td>
                            </tr>
                          
                            <tr>
                                <th>安装时间</th>
                                <td><?php echo $install;?></td>
                            </tr>
                            <tr>
                                <th>官方网站</th>
                                <td>
								<a class="btn " href="http://www.aijiacms.com" target="_blank">http://www.aijiacms.com</a>
                                   
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

  </div>

</div>

<script type="text/javascript" src="admin/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="admin/bootstrap/js/chart.min.js"></script>
<!--引入chart插件js-->
<script type="text/javascript" src="admin/bootstrap/js/main.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	var $dashChartBarsCnt = jQuery('.js-chartjs-bars')[0].getContext('2d'),
		$dashChartLinesCnt = jQuery('.js-chartjs-lines')[0].getContext('2d');

	var $dashChartBarsData = {
		labels: [<?php echo $data;?>],
		datasets: [{
			label: 'pv值',
			borderWidth: 1,
			borderColor: 'rgba(0, 0, 0, 0)',
			backgroundColor: 'rgba(0, 123, 255,0.5)',
			hoverBackgroundColor: "rgba(0, 123, 255, 0.7)",
			hoverBorderColor: "rgba(0, 0, 0, 0)",
			data: [<?php echo $pv;?>]
		}]
	};
	var $dashChartLinesData = {
		labels: [<?php echo $data;?>
		],
		datasets: [{
			label: '总UV',
			data: [<?php echo $uv;?>],
			borderColor: '#007bff',
			backgroundColor: 'rgba(0, 123, 255, 0.175)',
			borderWidth: 1,
			fill: false,
			lineTension: 0.5
		}]
	};

	new Chart($dashChartBarsCnt, {
		type: 'bar',
		data: $dashChartBarsData
	});

	var myLineChart = new Chart($dashChartLinesCnt, {
		type: 'line',
		data: $dashChartLinesData,
	});
});
</script>
</body>
</html>